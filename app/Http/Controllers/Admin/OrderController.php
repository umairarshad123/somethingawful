<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StripeWebhookController;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::query()->with('client');

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('order_number', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('first_name', 'like', "%{$q}%")
                  ->orWhere('last_name', 'like', "%{$q}%")
                  ->orWhere('service_name', 'like', "%{$q}%");
            });
        }
        foreach (['payment_status', 'order_status', 'billing_cycle'] as $f) {
            if ($v = $request->query($f)) $query->where($f, $v);
        }

        $orders = $query->latest()->paginate(25)->withQueryString();

        return view('admin.orders.index', [
            'orders'  => $orders,
            'filters' => $request->only(['q', 'payment_status', 'order_status', 'billing_cycle']),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load(['client', 'subscription', 'user']);
        return view('admin.orders.show', ['order' => $order]);
    }

    /**
     * Recovery: fetch the Checkout Session from Stripe and run the same
     * code path the webhook would. Use when the webhook signature is
     * mismatched and orders are stuck in 'pending'.
     */
    public function syncFromStripe(Request $request, Order $order, StripeService $stripe, StripeWebhookController $webhook): RedirectResponse
    {
        if (! $order->stripe_session_id) {
            return back()->withErrors(['sync' => 'This order has no Stripe session id. Was the checkout submitted?']);
        }

        try {
            $session = $stripe->client()->checkout->sessions->retrieve($order->stripe_session_id, [
                'expand' => ['payment_intent', 'customer'],
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['sync' => 'Stripe API error: ' . $e->getMessage()]);
        }

        $updated = $webhook->processCheckoutSession($session);

        if (! $updated) {
            return back()->withErrors(['sync' => 'Stripe returned the session but the order could not be located. Check storage/logs/laravel.log.']);
        }

        return back()->with('flash', "Synced from Stripe. Status: {$updated->payment_status}.");
    }

    public function refund(Request $request, Order $order, StripeService $stripe): RedirectResponse
    {
        if ($order->payment_status !== 'paid' || $order->isRecurring()) {
            return back()->withErrors(['refund' => 'Only successful one-time payments can be refunded from here.']);
        }
        if (! $order->stripe_payment_intent_id) {
            return back()->withErrors(['refund' => 'No payment intent on file for this order.']);
        }

        try {
            $stripe->refund($order->stripe_payment_intent_id);
        } catch (\Throwable $e) {
            return back()->withErrors(['refund' => 'Stripe refund failed: ' . $e->getMessage()]);
        }

        $order->forceFill([
            'payment_status' => 'refunded',
            'order_status'   => 'cancelled',
        ])->save();

        ActivityLog::record(
            event: 'order.refunded',
            label: "{$order->order_number} refunded by " . ($request->user()?->email ?? 'admin'),
            subject: $order,
            userId: $order->user_id,
            request: $request,
        );

        return back()->with('flash', 'Refund issued.');
    }
}
