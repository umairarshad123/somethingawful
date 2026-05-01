<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillingPortalController extends Controller
{
    /**
     * Open a Stripe Customer Portal session for the signed-in user. The
     * portal lets them update card details, view invoices, and cancel
     * subscriptions without us building any of that ourselves.
     */
    public function open(Request $request, StripeService $stripe): RedirectResponse
    {
        $user = $request->user();

        $customerId = $this->resolveCustomerId($user, $stripe);

        if (! $customerId) {
            return redirect()->route('dashboard')
                ->with('flash', "You don't have any billing history yet. Place an order first to access the billing portal.");
        }

        try {
            $session = $stripe->createPortalSession($customerId, route('dashboard'));
        } catch (\Throwable $e) {
            Log::error('[billing-portal] failed to create session', [
                'user_id'     => $user->id,
                'customer_id' => $customerId,
                'err'         => $e->getMessage(),
            ]);
            return redirect()->route('dashboard')
                ->with('flash', "We couldn't open the billing portal right now. Please try again in a moment or contact support.");
        }

        return redirect()->away($session->url);
    }

    /**
     * Find a Stripe customer ID. Prefer the cached value on the user;
     * otherwise look at their paid orders, then any order, and finally
     * fall back to retrieving a PaymentIntent so we can rescue cases
     * where the webhook saved a PI but never the customer ID.
     */
    private function resolveCustomerId($user, StripeService $stripe): ?string
    {
        if ($user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

        // Match orders by user_id OR by email (guests-then-signup case).
        $orderQuery = Order::query()
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('email', $user->email);
            });

        $customerId = (clone $orderQuery)
            ->whereNotNull('stripe_customer_id')
            ->where('payment_status', 'paid')
            ->latest()
            ->value('stripe_customer_id');

        if (! $customerId) {
            $customerId = (clone $orderQuery)
                ->whereNotNull('stripe_customer_id')
                ->latest()
                ->value('stripe_customer_id');
        }

        if (! $customerId) {
            $paymentIntentId = (clone $orderQuery)
                ->whereNotNull('stripe_payment_intent_id')
                ->where('payment_status', 'paid')
                ->latest()
                ->value('stripe_payment_intent_id');

            if ($paymentIntentId) {
                try {
                    $pi = $stripe->client()->paymentIntents->retrieve($paymentIntentId);
                    if (! empty($pi->customer)) {
                        $customerId = (string) $pi->customer;
                    }
                } catch (\Throwable $e) {
                    Log::warning('[billing-portal] PI customer lookup failed', [
                        'user_id' => $user->id,
                        'pi'      => $paymentIntentId,
                        'err'     => $e->getMessage(),
                    ]);
                }
            }
        }

        if ($customerId && $user->stripe_customer_id !== $customerId) {
            $user->forceFill(['stripe_customer_id' => $customerId])->save();
        }

        return $customerId ?: null;
    }
}
