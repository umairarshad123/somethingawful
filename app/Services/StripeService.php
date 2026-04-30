<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Checkout\Session;
use Stripe\StripeClient;

/**
 * Thin wrapper around the Stripe SDK so controllers stay readable.
 * Always reads keys via config() — never hard-codes.
 */
class StripeService
{
    private StripeClient $client;

    public function __construct()
    {
        $secret = config('services.stripe.secret');
        if (! $secret) {
            throw new \RuntimeException('STRIPE_SECRET is not configured.');
        }
        $this->client = new StripeClient([
            'api_key'       => $secret,
            'stripe_version'=> '2024-06-20',
        ]);
    }

    public function client(): StripeClient
    {
        return $this->client;
    }

    /**
     * Create a Checkout Session for a local Order.
     * One-time orders get mode=payment with price_data inline.
     * Recurring orders get mode=subscription with a one-shot Price (interval mo|week).
     */
    public function createCheckoutSession(Order $order, string $successUrl, string $cancelUrl): Session
    {
        $currency = strtolower($order->currency ?: 'usd');

        $lineItem = [
            'quantity' => max(1, (int) ($order->quantity ?: 1)),
            'price_data' => [
                'currency'    => $currency,
                'unit_amount' => (int) $order->amount,
                'product_data' => [
                    'name'        => $order->service_name,
                    'description' => $this->productDescription($order),
                    'metadata'    => [
                        'service_slug'  => $order->service_slug,
                        'billing_cycle' => $order->billing_cycle,
                    ],
                ],
            ],
        ];

        $isRecurring = $order->isRecurring();
        if ($isRecurring) {
            // Stripe wants the recurring block on the price.
            $lineItem['price_data']['recurring'] = [
                'interval' => $order->billing_cycle === 'mo' ? 'month' : 'week',
            ];
        }

        $params = [
            'mode'                => $isRecurring ? 'subscription' : 'payment',
            'line_items'          => [$lineItem],
            'success_url'         => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'          => $cancelUrl,
            'customer_email'      => $order->email,
            'allow_promotion_codes' => true,
            'billing_address_collection' => 'auto',
            // Carry the local order's identifiers so the webhook can find it.
            'metadata' => [
                'order_id'       => (string) $order->id,
                'order_number'   => $order->order_number,
                'service_slug'   => $order->service_slug,
                'billing_cycle'  => $order->billing_cycle,
                'customer_email' => $order->email,
                'local_user_id'  => (string) ($order->user_id ?? ''),
            ],
        ];

        // Stripe requires that subscription metadata be on the subscription_data
        // node so it surfaces on the resulting Subscription object.
        if ($isRecurring) {
            $params['subscription_data'] = [
                'metadata' => $params['metadata'],
            ];
        } else {
            $params['payment_intent_data'] = [
                'metadata' => $params['metadata'],
            ];
        }

        return $this->client->checkout->sessions->create($params);
    }

    /**
     * Verify the webhook signature and return the parsed Stripe Event.
     * Throws SignatureVerificationException on tampered payloads.
     */
    public function constructEvent(string $payload, string $signature): \Stripe\Event
    {
        $secret = config('services.stripe.webhook_secret');
        if (! $secret) {
            throw new \RuntimeException('STRIPE_WEBHOOK_SECRET is not configured.');
        }
        return \Stripe\Webhook::constructEvent($payload, $signature, $secret);
    }

    /**
     * Open a Stripe Customer Portal session so the customer can manage
     * their cards, invoices, and subscription cancellation.
     */
    public function createPortalSession(string $stripeCustomerId, string $returnUrl): \Stripe\BillingPortal\Session
    {
        return $this->client->billingPortal->sessions->create([
            'customer'   => $stripeCustomerId,
            'return_url' => $returnUrl,
        ]);
    }

    public function refund(string $paymentIntentId, ?int $amountInCents = null): \Stripe\Refund
    {
        $params = ['payment_intent' => $paymentIntentId];
        if ($amountInCents !== null) {
            $params['amount'] = $amountInCents;
        }
        return $this->client->refunds->create($params);
    }

    private function productDescription(Order $order): string
    {
        $cycle = match ($order->billing_cycle) {
            'project'    => 'one-time payment',
            'mo'         => 'monthly subscription',
            'week'       => 'weekly subscription',
            'per_zap'    => 'per Zap',
            'per_script' => 'per script',
            'per_asset'  => 'per asset',
            default      => $order->billing_cycle,
        };
        return "Digirisers · {$order->service_name} · {$cycle}";
    }
}
