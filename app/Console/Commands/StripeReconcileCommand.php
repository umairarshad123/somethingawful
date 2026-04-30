<?php

namespace App\Console\Commands;

use App\Http\Controllers\StripeWebhookController;
use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Console\Command;

/**
 * Recovery tool: when a Stripe Checkout Session's webhook never landed
 * (signature mismatch, network blip, etc.), call this to fetch the session
 * from Stripe's API and run the exact same code path the webhook would.
 *
 *   php artisan stripe:reconcile cs_test_xxx
 *   php artisan stripe:reconcile DR-POQA3SDWZO     # by order number
 *   php artisan stripe:reconcile 5                 # by local order id
 */
class StripeReconcileCommand extends Command
{
    protected $signature = 'stripe:reconcile {ref : Stripe session id, local order number, or local order id}';
    protected $description = 'Pull a Checkout Session from Stripe and run the order/client update locally';

    public function handle(StripeService $stripe, StripeWebhookController $webhook): int
    {
        $ref = (string) $this->argument('ref');

        // Resolve a Stripe session id from the input.
        $sessionId = null;
        if (str_starts_with($ref, 'cs_')) {
            $sessionId = $ref;
        } elseif (preg_match('/^\d+$/', $ref)) {
            $order = Order::find((int) $ref);
            $sessionId = $order?->stripe_session_id;
        } else {
            $order = Order::where('order_number', $ref)->first();
            $sessionId = $order?->stripe_session_id;
        }

        if (! $sessionId) {
            $this->error("Couldn't resolve a Stripe session id from '{$ref}'.");
            $this->line("Pass either: cs_test_..., a local order number (DR-...), or a numeric order id.");
            return self::FAILURE;
        }

        $this->info("Fetching session: {$sessionId}");
        try {
            $session = $stripe->client()->checkout->sessions->retrieve($sessionId, [
                'expand' => ['payment_intent', 'customer'],
            ]);
        } catch (\Throwable $e) {
            $this->error('Stripe API error: ' . $e->getMessage());
            return self::FAILURE;
        }

        $this->line("session.payment_status: {$session->payment_status}");
        $this->line("session.status:         {$session->status}");
        $this->line("session.metadata:       " . json_encode($session->metadata?->toArray() ?? []));

        $order = $webhook->processCheckoutSession($session);

        if (! $order) {
            $this->error('Order not found for that session. Check the metadata above.');
            return self::FAILURE;
        }

        $this->info("Reconciled order #{$order->id} ({$order->order_number}) — payment_status={$order->payment_status}, order_status={$order->order_status}");
        return self::SUCCESS;
    }
}
