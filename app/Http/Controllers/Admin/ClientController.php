<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StripeWebhookController;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('email', 'like', "%{$q}%")
                  ->orWhere('name', 'like', "%{$q}%")
                  ->orWhere('company', 'like', "%{$q}%");
            });
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $clients = $query->latest()->paginate(25)->withQueryString();

        return view('admin.clients.index', [
            'clients'  => $clients,
            'filters'  => $request->only(['q', 'status']),
            'statuses' => Client::STATUSES,
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'status'    => 'nullable|in:' . implode(',', Client::STATUSES),
            'notes'     => 'nullable|string|max:5000',
            'service'   => 'nullable|string|max:160',
            'start_date'=> 'nullable|date',
            'end_date'  => 'nullable|date',
        ]);

        $client->fill(array_filter($data, fn ($v) => $v !== null))->save();

        return back()->with('flash', 'Client updated.');
    }

    /**
     * Mirror every paid order into the clients table. Same code path as
     * the Stripe webhook, just driven from the existing local Order rows.
     * Idempotent: safe to re-run.
     */
    public function backfill(Request $request, StripeWebhookController $webhook)
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;

        Order::where('payment_status', 'paid')
            ->orderBy('id')
            ->chunkById(100, function ($orders) use ($webhook, &$created, &$updated, &$skipped) {
                foreach ($orders as $order) {
                    $existing = Client::query()
                        ->when($order->user_id,
                            fn ($q) => $q->where('user_id', $order->user_id))
                        ->orWhere('email', $order->email)
                        ->when($order->stripe_customer_id,
                            fn ($q) => $q->orWhere('stripe_customer_id', $order->stripe_customer_id))
                        ->first();

                    try {
                        $client = $webhook->syncClientFromPaidOrder($order);
                    } catch (\Throwable $e) {
                        Log::error('[clients-backfill] sync failed', [
                            'order_id' => $order->id,
                            'err'      => $e->getMessage(),
                        ]);
                        $skipped++;
                        continue;
                    }

                    if (! $client) {
                        $skipped++;
                        continue;
                    }
                    $existing ? $updated++ : $created++;
                }
            });

        return back()->with(
            'flash',
            "Synced clients from paid orders. created={$created} updated={$updated} skipped={$skipped}"
        );
    }
}
