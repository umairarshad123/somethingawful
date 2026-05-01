<?php

namespace App\Console\Commands;

use App\Http\Controllers\StripeWebhookController;
use App\Models\Order;
use Illuminate\Console\Command;

/**
 * Walks every paid order and runs the client sync against it. Use after
 * deploying the syncClientFromPaidOrder change to seed the clients table
 * from history that predated the auto-sync, or any time a webhook
 * signature mismatch left orders paid but unmirrored.
 *
 *   php artisan clients:backfill
 *   php artisan clients:backfill --dry-run
 *   php artisan clients:backfill --email=ubaidzafar285@gmail.com
 */
class BackfillClientsCommand extends Command
{
    protected $signature = 'clients:backfill
                            {--dry-run : Preview without writing}
                            {--email= : Limit to a single email}';

    protected $description = 'Sync the clients table from every paid order. Idempotent.';

    public function handle(StripeWebhookController $webhook): int
    {
        $query = Order::query()->where('payment_status', 'paid');
        if ($email = (string) $this->option('email')) {
            $query->where('email', $email);
        }

        $total = $query->count();
        if ($total === 0) {
            $this->info('No paid orders found' . ($email ? " for {$email}." : '.'));
            return self::SUCCESS;
        }

        $this->info("Backfilling clients from {$total} paid order(s)" . ($this->option('dry-run') ? ' [DRY RUN]' : '') . '...');

        $created = 0;
        $updated = 0;
        $skipped = 0;

        $query->orderBy('id')->chunkById(100, function ($orders) use ($webhook, &$created, &$updated, &$skipped) {
            foreach ($orders as $order) {
                $existing = \App\Models\Client::query()
                    ->when($order->user_id, fn ($q) => $q->where('user_id', $order->user_id))
                    ->orWhere('email', $order->email)
                    ->orWhere(fn ($q) => $order->stripe_customer_id
                        ? $q->where('stripe_customer_id', $order->stripe_customer_id)
                        : $q->whereRaw('0=1')
                    )
                    ->first();

                if ($this->option('dry-run')) {
                    $this->line(sprintf(
                        '  %s %s · %s · %s',
                        $existing ? 'UPDATE' : 'CREATE',
                        $order->order_number,
                        $order->email,
                        $order->service_name,
                    ));
                    $existing ? $updated++ : $created++;
                    continue;
                }

                $client = $webhook->syncClientFromPaidOrder($order);
                if (! $client) {
                    $skipped++;
                    continue;
                }
                $existing ? $updated++ : $created++;
            }
        });

        $this->newLine();
        $this->info("Done. created={$created}  updated={$updated}  skipped={$skipped}");
        return self::SUCCESS;
    }
}
