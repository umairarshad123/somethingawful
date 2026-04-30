<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show the branded checkout form for a single catalog item.
     */
    public function show(string $slug): View
    {
        [$item, $cat] = $this->findCatalogItem($slug);
        return view('checkout.show', [
            'item'         => $item,
            'cat'          => $cat,
            'cycleLabel'   => $this->cycleLabel($item['cycle']),
            'isRecurring'  => $this->isRecurringCycle($item['cycle']),
            'currencyCode' => strtoupper(config('services.stripe.currency', 'usd')),
        ]);
    }

    /**
     * Validate the customer form, create a local Order, and create a
     * Stripe Checkout Session. Redirects the customer to Stripe.
     */
    public function store(Request $request, string $slug, StripeService $stripe): RedirectResponse
    {
        [$item, $cat] = $this->findCatalogItem($slug);

        $data = $request->validate([
            'first_name' => 'required|string|max:80',
            'last_name'  => 'required|string|max:80',
            'email'      => 'required|email:rfc|max:200',
            'phone'      => 'required|string|max:60',
            'company'    => 'nullable|string|max:200',
            'website'    => 'nullable|url|max:200',
            'notes'      => 'nullable|string|max:5000',
            'quantity'   => 'nullable|integer|min:1|max:100',
        ]);

        $cycle = $this->normalizeCycle($item['cycle']);
        $quantity = (int) ($data['quantity'] ?? 1);
        $unitAmount = (int) round(((float) $item['price']) * 100);   // catalog price is dollars

        $order = Order::create([
            'order_number'  => Order::generateOrderNumber(),
            'user_id'       => auth()->id(),
            'service_slug'  => $item['slug'],
            'service_name'  => $item['name'],
            'billing_cycle' => $cycle,
            'quantity'      => $quantity,
            'amount'        => $unitAmount,           // unit; line total in Stripe = unit * quantity
            'currency'      => strtolower(config('services.stripe.currency', 'usd')),
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'company'       => $data['company'] ?? null,
            'website'       => $data['website'] ?? null,
            'notes'         => $data['notes'] ?? null,
            'payment_status'=> 'pending',
            'order_status'  => 'awaiting_payment',
            'metadata'      => [
                'category'     => $cat['id'] ?? null,
                'page'         => $request->headers->get('referer'),
            ],
        ]);

        try {
            $session = $stripe->createCheckoutSession(
                order:      $order,
                successUrl: route('checkout.success'),
                cancelUrl:  route('checkout.cancel'),
            );
        } catch (\Throwable $e) {
            Log::error('[stripe] Checkout Session creation failed', [
                'err'      => $e->getMessage(),
                'order_id' => $order->id,
            ]);
            $order->update(['order_status' => 'cancelled']);
            return back()
                ->withInput()
                ->withErrors(['email' => 'Could not start the secure checkout. Please try again or contact us.']);
        }

        $order->update(['stripe_session_id' => $session->id]);

        ActivityLog::record(
            event: 'checkout.session_created',
            label: "{$order->order_number} · {$order->email} · {$order->service_name}",
            subject: $order,
            userId: auth()->id(),
            request: $request,
        );

        return redirect()->away($session->url);
    }

    /**
     * Stripe redirects the customer here after a successful payment. The DB
     * status is the source of truth (set by the webhook), so we look up the
     * order by session_id and surface its current state. If the webhook hasn't
     * fired yet, the page shows a "Confirming..." state and the JS polls.
     */
    public function success(Request $request): View
    {
        $sessionId = (string) $request->query('session_id', '');
        $order = $sessionId ? Order::where('stripe_session_id', $sessionId)->first() : null;

        return view('checkout.success', [
            'order'      => $order,
            'sessionId'  => $sessionId,
        ]);
    }

    /** Customer hit the "Back" button on Stripe's hosted checkout. */
    public function cancel(Request $request): View
    {
        $sessionId = (string) $request->query('session_id', '');
        $order = $sessionId ? Order::where('stripe_session_id', $sessionId)->first() : null;

        if ($order && $order->payment_status === 'pending') {
            $order->update(['order_status' => 'cancelled']);
        }

        return view('checkout.cancel', ['order' => $order]);
    }

    /**
     * AJAX endpoint hit by the success page to poll for the webhook
     * having confirmed the payment.
     */
    public function status(Request $request)
    {
        $sessionId = (string) $request->query('session_id', '');
        $order = $sessionId ? Order::where('stripe_session_id', $sessionId)->first() : null;

        if (! $order) {
            return response()->json(['status' => 'unknown'], 404);
        }

        return response()->json([
            'status'         => $order->payment_status,
            'order_status'   => $order->order_status,
            'order_number'   => $order->order_number,
            'paid_at'        => optional($order->paid_at)->toIso8601String(),
            'is_authed'      => auth()->check(),
            'redirect_to'    => $order->payment_status === 'paid' ? route('dashboard') : null,
        ]);
    }

    // ---- helpers --------------------------------------------------------

    private function findCatalogItem(string $slug): array
    {
        foreach (config('catalog.categories', []) as $cat) {
            foreach ($cat['items'] as $item) {
                if (($item['slug'] ?? null) === $slug) {
                    return [$item, $cat];
                }
            }
        }
        abort(404);
    }

    /** Convert catalog-style cycle ('per Zap') to DB-safe ('per_zap'). */
    private function normalizeCycle(string $cycle): string
    {
        return match ($cycle) {
            'project', 'mo', 'week' => $cycle,
            'per Zap'    => 'per_zap',
            'per script' => 'per_script',
            'per asset'  => 'per_asset',
            default      => $cycle,
        };
    }

    private function cycleLabel(string $cycle): string
    {
        return match ($cycle) {
            'project'    => 'one-time payment',
            'mo'         => 'monthly · cancel anytime',
            'week'       => 'weekly · cancel anytime',
            'per Zap'    => 'per Zap',
            'per script' => 'per script',
            'per asset'  => 'per asset',
            default      => $cycle,
        };
    }

    private function isRecurringCycle(string $cycle): bool
    {
        return in_array($cycle, ['mo', 'week'], true);
    }
}
