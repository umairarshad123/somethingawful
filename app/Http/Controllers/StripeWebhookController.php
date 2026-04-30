<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Event;

/**
 * Stripe webhook handler.
 *
 * Stripe sends raw POST bodies signed with our shared secret. Every event
 * is signature-verified before any DB write. The seven events listed in
 * the brief are handled; everything else is acknowledged with 204 so
 * Stripe doesn't retry forever.
 *
 * The DB is the source of truth for "is this paid?". The browser success
 * page only reflects what the webhook has already written.
 */
class StripeWebhookController extends Controller
{
    public function handle(Request $request, StripeService $stripe): Response
    {
        $payload   = $request->getContent();
        $signature = (string) $request->header('Stripe-Signature', '');

        try {
            $event = $stripe->constructEvent($payload, $signature);
        } catch (\Throwable $e) {
            Log::warning('[stripe-webhook] signature verification failed', [
                'err'    => $e->getMessage(),
                'sig'    => substr($signature, 0, 12) . '…',
                'len'    => strlen($payload),
            ]);
            return response('invalid signature', 400);
        }

        try {
            match ($event->type) {
                'checkout.session.completed'     => $this->onCheckoutCompleted($event),
                'payment_intent.succeeded'       => $this->onPaymentSucceeded($event),
                'payment_intent.payment_failed'  => $this->onPaymentFailed($event),
                'invoice.payment_succeeded'      => $this->onInvoicePaid($event),
                'invoice.payment_failed'         => $this->onInvoiceFailed($event),
                'customer.subscription.created',
                'customer.subscription.updated'  => $this->onSubscriptionUpserted($event),
                'customer.subscription.deleted'  => $this->onSubscriptionDeleted($event),
                default => null,
            };
        } catch (\Throwable $e) {
            // 500 forces Stripe to retry. We want that for transient DB issues
            // but log loudly so we know something's wrong.
            Log::error('[stripe-webhook] handler exploded', [
                'event' => $event->type,
                'err'   => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);
            return response('handler error', 500);
        }

        return response('ok', 200);
    }

    // -- Event handlers --------------------------------------------------

    /**
     * Primary "payment confirmed" handler. Triggers on both one-time and
     * subscription successful checkouts. This is where we mark the order
     * paid AND auto-create / update the Client record.
     */
    private function onCheckoutCompleted(Event $event): void
    {
        /** @var \Stripe\Checkout\Session $session */
        $session = $event->data->object;

        $order = $this->findOrderForSession($session);
        if (! $order) {
            Log::warning('[stripe-webhook] checkout.session.completed for unknown order', [
                'session_id' => $session->id,
            ]);
            return;
        }

        $order->stripe_customer_id      = $session->customer ?? $order->stripe_customer_id;
        $order->stripe_payment_intent_id= $session->payment_intent ?? $order->stripe_payment_intent_id;
        $order->stripe_subscription_id  = $session->subscription ?? $order->stripe_subscription_id;

        // payment_status on the session: 'paid' | 'unpaid' | 'no_payment_required'.
        // For subscriptions where the trial is free and no upfront charge is taken,
        // this can read 'no_payment_required' but the subscription is still active.
        $isPaid = in_array($session->payment_status ?? '', ['paid', 'no_payment_required'], true);

        if ($isPaid) {
            $order->payment_status = 'paid';
            $order->order_status   = 'processing';
            $order->paid_at        = $order->paid_at ?: now();
        }
        $order->save();

        // Upsert the customer record + (optionally) a user account.
        $user   = $this->upsertUser($order);
        $client = $this->upsertClient($order, $user);

        // Re-link the order to the freshly upserted records.
        $order->forceFill([
            'user_id'   => $order->user_id ?: $user?->id,
            'client_id' => $order->client_id ?: $client?->id,
        ])->save();

        ActivityLog::record(
            event: 'order.paid',
            label: "{$order->order_number} paid · {$order->email} · {$order->service_name}",
            subject: $order,
            userId: $user?->id,
            payload: [
                'amount'   => $order->amount,
                'currency' => $order->currency,
                'session'  => $session->id,
            ],
        );
    }

    private function onPaymentSucceeded(Event $event): void
    {
        /** @var \Stripe\PaymentIntent $pi */
        $pi = $event->data->object;
        $order = Order::where('stripe_payment_intent_id', $pi->id)->first();
        if (! $order) return;

        $order->forceFill([
            'payment_status' => 'paid',
            'order_status'   => $order->order_status === 'awaiting_payment' ? 'processing' : $order->order_status,
            'paid_at'        => $order->paid_at ?: now(),
        ])->save();
    }

    private function onPaymentFailed(Event $event): void
    {
        /** @var \Stripe\PaymentIntent $pi */
        $pi = $event->data->object;
        $order = Order::where('stripe_payment_intent_id', $pi->id)->first();
        if (! $order) return;

        $order->forceFill(['payment_status' => 'failed'])->save();

        ActivityLog::record(
            event: 'order.payment_failed',
            label: "{$order->order_number} payment failed · {$order->email}",
            subject: $order,
            userId: $order->user_id,
            payload: ['reason' => $pi->last_payment_error->message ?? null],
        );
    }

    private function onInvoicePaid(Event $event): void
    {
        /** @var \Stripe\Invoice $inv */
        $inv = $event->data->object;
        if (! $inv->subscription) return;

        $sub = Subscription::where('stripe_subscription_id', $inv->subscription)->first();
        if ($sub) {
            $sub->forceFill([
                'status'               => 'active',
                'current_period_start' => $inv->period_start ? now()->createFromTimestamp($inv->period_start) : null,
                'current_period_end'   => $inv->period_end ? now()->createFromTimestamp($inv->period_end) : null,
            ])->save();
        }

        // Bump the linked client's last_payment_at.
        if ($sub?->client_id) {
            Client::where('id', $sub->client_id)->update([
                'last_payment_at' => now(),
                'payment_status'  => 'paid',
                'status'          => Client::STATUSES[1] ?? 'active', // 'active'
            ]);
        }
    }

    private function onInvoiceFailed(Event $event): void
    {
        /** @var \Stripe\Invoice $inv */
        $inv = $event->data->object;
        if (! $inv->subscription) return;

        $sub = Subscription::where('stripe_subscription_id', $inv->subscription)->first();
        if (! $sub) return;

        $sub->forceFill(['status' => 'past_due'])->save();

        if ($sub->client_id) {
            Client::where('id', $sub->client_id)->update(['payment_status' => 'past_due']);
        }
    }

    private function onSubscriptionUpserted(Event $event): void
    {
        /** @var \Stripe\Subscription $stripeSub */
        $stripeSub = $event->data->object;

        $order = Order::where('stripe_subscription_id', $stripeSub->id)
            ->orWhere(function ($q) use ($stripeSub) {
                $q->whereNull('stripe_subscription_id')
                  ->where('stripe_customer_id', $stripeSub->customer);
            })->first();

        $priceId = $stripeSub->items->data[0]->price->id ?? null;

        Subscription::updateOrCreate(
            ['stripe_subscription_id' => $stripeSub->id],
            [
                'stripe_customer_id'   => $stripeSub->customer,
                'stripe_price_id'      => $priceId,
                'order_id'             => $order?->id,
                'user_id'              => $order?->user_id,
                'client_id'            => $order?->client_id,
                'service_slug'         => $order?->service_slug ?? '',
                'billing_cycle'        => $order?->billing_cycle ?? 'mo',
                'amount'               => $order?->amount ?? 0,
                'currency'             => $order?->currency ?? 'usd',
                'status'               => $stripeSub->status,
                'current_period_start' => $stripeSub->current_period_start ? now()->createFromTimestamp($stripeSub->current_period_start) : null,
                'current_period_end'   => $stripeSub->current_period_end ? now()->createFromTimestamp($stripeSub->current_period_end) : null,
                'cancel_at_period_end' => (bool) ($stripeSub->cancel_at_period_end ?? false),
                'canceled_at'          => $stripeSub->canceled_at ? now()->createFromTimestamp($stripeSub->canceled_at) : null,
            ],
        );
    }

    private function onSubscriptionDeleted(Event $event): void
    {
        /** @var \Stripe\Subscription $stripeSub */
        $stripeSub = $event->data->object;

        $sub = Subscription::where('stripe_subscription_id', $stripeSub->id)->first();
        if (! $sub) return;

        $sub->forceFill([
            'status'      => 'canceled',
            'canceled_at' => now(),
        ])->save();

        if ($sub->client_id) {
            Client::where('id', $sub->client_id)->update([
                'status' => 'churned',
                'end_date' => now()->toDateString(),
            ]);
        }
    }

    // -- Upserts ---------------------------------------------------------

    private function upsertUser(Order $order): ?User
    {
        // Don't create a brand-new user account silently for guest checkouts —
        // we don't want to confuse customers with surprise password emails.
        // Instead: if the email matches an existing user, link to it. The
        // customer can sign up later using the same email and we'll connect
        // their orders automatically via the email column.
        $user = User::where('email', $order->email)->first();

        if ($user) {
            // Backfill any blanks Stripe just gave us.
            $patch = [];
            if (! $user->stripe_customer_id && $order->stripe_customer_id) {
                $patch['stripe_customer_id'] = $order->stripe_customer_id;
            }
            if (! $user->phone && $order->phone) $patch['phone'] = $order->phone;
            if (! $user->company && $order->company) $patch['company'] = $order->company;
            if ($patch) $user->forceFill($patch)->save();
        }

        return $user;
    }

    private function upsertClient(Order $order, ?User $user): Client
    {
        $client = Client::where('email', $order->email)->first();

        $name = trim($order->first_name . ' ' . $order->last_name);

        $payload = [
            'name'                  => $name ?: $order->email,
            'first_name'            => $order->first_name,
            'last_name'             => $order->last_name,
            'phone'                 => $order->phone,
            'company'               => $order->company,
            'website'               => $order->website,
            'service'               => $order->service_name,
            'billing_cycle'         => $order->billing_cycle,
            'status'                => 'active',
            'payment_status'        => 'paid',
            'stripe_customer_id'    => $order->stripe_customer_id,
            'stripe_subscription_id'=> $order->stripe_subscription_id,
            'last_payment_at'       => now(),
            'user_id'               => $user?->id,
        ];

        if ($client) {
            // Don't downgrade an active customer; only fill blanks.
            foreach ($payload as $k => $v) {
                if ($v === null) continue;
                if (in_array($k, ['status', 'payment_status', 'last_payment_at'], true)) {
                    $client->{$k} = $v; // always refreshed by a paid order
                    continue;
                }
                if (empty($client->{$k})) {
                    $client->{$k} = $v;
                }
            }
            $client->save();
        } else {
            $payload['start_date'] = now()->toDateString();
            $client = Client::create($payload);
        }

        return $client;
    }

    private function findOrderForSession(\Stripe\Checkout\Session $session): ?Order
    {
        if ($order = Order::where('stripe_session_id', $session->id)->first()) {
            return $order;
        }
        $orderId = $session->metadata->order_id ?? null;
        if ($orderId) {
            return Order::find((int) $orderId);
        }
        return null;
    }
}
