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
    public function handle(Request $request, StripeService $stripe)
    {
        $payload   = $request->getContent();
        $signature = (string) $request->header('Stripe-Signature', '');

        // Note: production has LOG_LEVEL=error so Log::info / Log::warning
        // get filtered. We use Log::error for the things that actually matter
        // for diagnosing webhook failures so they show up regardless.

        // 1) Pre-flight: a missing webhook secret would make every signature
        //    fail. Log loudly and 500 so Stripe retries while you fix .env.
        if (! config('services.stripe.webhook_secret')) {
            Log::error('[stripe-webhook] STRIPE_WEBHOOK_SECRET is missing in .env — every Stripe signature will fail until this is set.');
            return response()->json(['ok' => false, 'error' => 'webhook secret not configured'], 500);
        }

        // 2) Signature verification. A bad signature is permanent (no retry helps),
        //    so we return 400 and Stripe stops retrying — exactly what we want
        //    while we fix a misconfigured key.
        try {
            $event = $stripe->constructEvent($payload, $signature);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('[stripe-webhook] signature verification failed — likely STRIPE_WEBHOOK_SECRET in .env does not match the signing secret of the endpoint registered in your Stripe dashboard', [
                'stripe_err' => $e->getMessage(),
                'sig_prefix' => substr($signature, 0, 16) . '…',
                'body_len'   => strlen($payload),
                'has_sig'    => $signature !== '',
                'secret_set' => !empty(config('services.stripe.webhook_secret')),
            ]);
            return response()->json(['ok' => false, 'error' => 'invalid signature'], 400);
        } catch (\UnexpectedValueException $e) {
            Log::error('[stripe-webhook] payload could not be parsed', [
                'err' => $e->getMessage(),
                'len' => strlen($payload),
            ]);
            return response()->json(['ok' => false, 'error' => 'invalid payload'], 400);
        } catch (\Throwable $e) {
            Log::error('[stripe-webhook] unexpected error during verify', ['err' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => 'verify error'], 500);
        }

        // 3) Per-event handler. Each one is wrapped in its own try/catch so a
        //    bug in (say) onInvoicePaid can't take down checkout.session.completed.
        //    Always return 200 once the signature is verified — DB-level transient
        //    failures get logged but Stripe gets an ack so retries don't spiral.
        Log::info('[stripe-webhook] event', [
            'id'      => $event->id,
            'type'    => $event->type,
            'created' => $event->created,
        ]);

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
                default => Log::info('[stripe-webhook] unhandled event type', ['type' => $event->type]),
            };
        } catch (\Throwable $e) {
            Log::error('[stripe-webhook] handler exploded', [
                'event' => $event->type,
                'err'   => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => substr($e->getTraceAsString(), 0, 1500),
            ]);
            // 200 prevents Stripe from retrying a coding bug forever. The
            // event is on the dashboard so you can replay it after fixing.
            return response()->json(['ok' => true, 'note' => 'handler logged error', 'event_id' => $event->id], 200);
        }

        return response()->json(['ok' => true, 'event_id' => $event->id, 'type' => $event->type], 200);
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
        $this->processCheckoutSession($session);
    }

    /**
     * The actual order/client update routine. Takes a Checkout Session
     * straight from Stripe so it can be called from:
     *   - the webhook (event-driven, normal path)
     *   - the artisan command (recovery for stuck-pending orders)
     *   - the admin "Sync from Stripe" button (one-click re-run)
     */
    public function processCheckoutSession(\Stripe\Checkout\Session $session): ?Order
    {
        Log::error('[stripe-webhook] processing checkout.session', [
            'session_id'     => $session->id,
            'customer'       => $session->customer ?? null,
            'subscription'   => $session->subscription ?? null,
            'payment_intent' => $session->payment_intent ?? null,
            'payment_status' => $session->payment_status ?? null,
            'status'         => $session->status ?? null,
            'metadata'       => $session->metadata?->toArray() ?? null,
        ]);

        $order = $this->findOrderForSession($session);

        if (! $order) {
            Log::error('[stripe-webhook] ORDER NOT FOUND FOR STRIPE WEBHOOK', [
                'session_id'         => $session->id,
                'metadata.order_id'  => $session->metadata->order_id ?? null,
                'metadata.order_num' => $session->metadata->order_number ?? null,
                'metadata.email'     => $session->metadata->customer_email ?? null,
                'session.email'      => $session->customer_details->email ?? $session->customer_email ?? null,
            ]);
            return null;
        }

        Log::error('[stripe-webhook] order found', [
            'order_id'     => $order->id,
            'order_number' => $order->order_number,
        ]);

        // Capture customer name + email from the session in case the order
        // form was incomplete (rare, but defensive).
        $emailFromSession = $session->customer_details->email ?? $session->customer_email ?? null;
        if ($emailFromSession && empty($order->email)) {
            $order->email = $emailFromSession;
        }
        $nameFromSession = $session->customer_details->name ?? null;
        if ($nameFromSession && empty(trim((string) $order->first_name . ' ' . (string) $order->last_name))) {
            $parts = explode(' ', trim($nameFromSession), 2);
            $order->first_name = $parts[0];
            $order->last_name  = $parts[1] ?? '';
        }

        $order->stripe_session_id        = $session->id;
        $order->stripe_customer_id       = $session->customer ?? $order->stripe_customer_id;
        $order->stripe_payment_intent_id = $session->payment_intent ?? $order->stripe_payment_intent_id;
        $order->stripe_subscription_id   = $session->subscription ?? $order->stripe_subscription_id;

        // payment_status on the session: 'paid' | 'unpaid' | 'no_payment_required'.
        // status: 'open' | 'complete' | 'expired'.
        $isPaid = in_array($session->payment_status ?? '', ['paid', 'no_payment_required'], true)
               || ($session->status ?? '') === 'complete';

        if ($isPaid) {
            $order->payment_status = 'paid';
            $order->order_status   = 'processing';
            $order->paid_at        = $order->paid_at ?: now();
        }
        $order->save();

        Log::error('[stripe-webhook] order marked paid', [
            'order_id'       => $order->id,
            'order_number'   => $order->order_number,
            'payment_status' => $order->payment_status,
            'order_status'   => $order->order_status,
        ]);

        // Upsert the customer record + (optionally) a user account.
        $user   = $this->upsertUser($order);
        $client = $this->upsertClient($order, $user);

        // Re-link the order to the freshly upserted records.
        $order->forceFill([
            'user_id'   => $order->user_id ?: $user?->id,
            'client_id' => $order->client_id ?: $client?->id,
        ])->save();

        Log::error('[stripe-webhook] client upserted', [
            'client_id' => $client?->id,
            'user_id'   => $user?->id,
            'email'     => $order->email,
        ]);

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

        return $order;
    }

    private function onPaymentSucceeded(Event $event): void
    {
        /** @var \Stripe\PaymentIntent $pi */
        $pi = $event->data->object;
        $order = Order::where('stripe_payment_intent_id', $pi->id)->first();
        if (! $order) return;

        // If the PaymentIntent has a customer attached but the order doesn't
        // yet, capture it so the client sync below can use it.
        if (! empty($pi->customer) && ! $order->stripe_customer_id) {
            $order->stripe_customer_id = (string) $pi->customer;
        }

        $order->forceFill([
            'payment_status' => 'paid',
            'order_status'   => $order->order_status === 'awaiting_payment' ? 'processing' : $order->order_status,
            'paid_at'        => $order->paid_at ?: now(),
            'stripe_customer_id' => $order->stripe_customer_id,
        ])->save();

        // Make sure the client record is up to date even when this event
        // arrives without a preceding checkout.session.completed.
        $user = $this->upsertUser($order);
        $this->syncClientFromPaidOrder($order, $user);
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

        // Find the linked order and run the full client sync so a recurring
        // renewal alone is enough to (re)populate the client row even if the
        // initial checkout.session.completed never landed.
        $order = Order::where('stripe_subscription_id', $inv->subscription)
            ->orWhere('stripe_customer_id', $inv->customer)
            ->latest()
            ->first();

        if ($order) {
            $user = $this->upsertUser($order);
            $this->syncClientFromPaidOrder($order, $user);
        } elseif ($sub?->client_id) {
            // Fallback: if we have a subscription→client link but no order, at
            // least bump the client's last_payment_at and active state.
            Client::where('id', $sub->client_id)->update([
                'last_payment_at' => now(),
                'payment_status'  => 'paid',
                'status'          => 'active',
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

    /**
     * Create or update the Client row for a paid order.
     *
     * Idempotent: safe to call multiple times. Only runs when the order
     * is actually paid, so leads / pending / failed records can never
     * leak into the clients table.
     *
     * Match priority (first hit wins, prevents duplicates):
     *   1. user_id   — same authenticated buyer comes back
     *   2. email     — guest checkout, then signs up later w/ same email
     *   3. stripe_customer_id — Stripe's own customer linkage
     *
     * Public so it can be invoked from the artisan backfill command and
     * from controllers running a one-shot reconciliation.
     */
    public function syncClientFromPaidOrder(Order $order, ?User $user = null): ?Client
    {
        // Hard guard: only paid orders create/update clients. Leads,
        // pending, failed, refunded — none of those are customers.
        if ($order->payment_status !== 'paid') {
            return null;
        }

        $user = $user ?: ($order->user_id ? User::find($order->user_id) : null);

        // 1) by user_id   2) by email   3) by stripe_customer_id
        $client = null;
        if ($user?->id) {
            $client = Client::where('user_id', $user->id)->first();
        }
        if (! $client && $order->email) {
            $client = Client::where('email', $order->email)->first();
        }
        if (! $client && $order->stripe_customer_id) {
            $client = Client::where('stripe_customer_id', $order->stripe_customer_id)->first();
        }

        $name = trim($order->first_name . ' ' . $order->last_name);

        $payload = [
            'name'                  => $name ?: $order->email,
            'first_name'            => $order->first_name,
            'last_name'             => $order->last_name,
            'email'                 => $order->email,
            'phone'                 => $order->phone,
            'company'               => $order->company,
            'website'               => $order->website,
            'service'               => $order->service_name,        // latest service/product
            'billing_cycle'         => $order->billing_cycle,
            'status'                => 'active',
            'payment_status'        => 'paid',
            'stripe_customer_id'    => $order->stripe_customer_id,
            'stripe_subscription_id'=> $order->stripe_subscription_id,
            'last_payment_at'       => $order->paid_at ?: now(),
            'user_id'               => $user?->id,
        ];

        if ($client) {
            // Refresh active/paid state on every paid order. For everything
            // else, only fill blanks so we don't clobber admin edits.
            foreach ($payload as $k => $v) {
                if ($v === null) continue;
                $alwaysRefresh = in_array($k, [
                    'status', 'payment_status', 'last_payment_at',
                    'service', 'billing_cycle',
                    'stripe_customer_id', 'stripe_subscription_id',
                    'user_id',
                ], true);
                if ($alwaysRefresh) {
                    $client->{$k} = $v;
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

        // Backfill the order's client_id so the relationship is solid.
        if ($client && $order->client_id !== $client->id) {
            $order->forceFill(['client_id' => $client->id])->save();
        }

        return $client;
    }

    /**
     * Backwards-compatible shim. The original webhook flow called
     * upsertClient() — keep that working so processCheckoutSession does
     * not need a separate edit.
     */
    private function upsertClient(Order $order, ?User $user): ?Client
    {
        return $this->syncClientFromPaidOrder($order, $user);
    }

    /**
     * Try every reasonable identifier in metadata + the session id itself.
     * Logs the strategy that found the order for ops visibility.
     */
    private function findOrderForSession(\Stripe\Checkout\Session $session): ?Order
    {
        $meta = (array) ($session->metadata?->toArray() ?? []);

        // 1) by stripe_session_id (set during checkout.store on every order)
        if ($order = Order::where('stripe_session_id', $session->id)->first()) {
            Log::info('[stripe-webhook] order matched by stripe_session_id', [
                'order_id' => $order->id,
            ]);
            return $order;
        }

        // 2) by metadata.order_id
        $orderId = $meta['order_id'] ?? null;
        if ($orderId && $order = Order::find((int) $orderId)) {
            Log::info('[stripe-webhook] order matched by metadata.order_id', [
                'order_id' => $order->id,
            ]);
            return $order;
        }

        // 3) by metadata.order_number
        $orderNumber = $meta['order_number'] ?? null;
        if ($orderNumber && $order = Order::where('order_number', $orderNumber)->first()) {
            Log::info('[stripe-webhook] order matched by order_number', [
                'order_id'     => $order->id,
                'order_number' => $orderNumber,
            ]);
            return $order;
        }

        // 4) fallback by metadata.customer_email + service_slug + still-pending
        //    (last resort — useful if metadata.order_id was lost)
        $email = $meta['customer_email'] ?? $session->customer_email ?? null;
        $slug  = $meta['service_slug'] ?? null;
        if ($email && $slug && $order = Order::where('email', $email)
            ->where('service_slug', $slug)
            ->where('payment_status', 'pending')
            ->latest()
            ->first()) {
            Log::warning('[stripe-webhook] order matched by email + slug fallback', [
                'order_id' => $order->id,
            ]);
            return $order;
        }

        return null;
    }

}
