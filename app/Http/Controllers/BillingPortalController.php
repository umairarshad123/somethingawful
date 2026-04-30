<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        // Find a Stripe customer ID — first on the user record, then on any
        // order they previously placed under this email.
        $customerId = $user->stripe_customer_id;
        if (! $customerId) {
            $customerId = Order::where('email', $user->email)
                ->whereNotNull('stripe_customer_id')
                ->latest()
                ->value('stripe_customer_id');
            if ($customerId) {
                $user->forceFill(['stripe_customer_id' => $customerId])->save();
            }
        }

        if (! $customerId) {
            return redirect()->route('dashboard')
                ->with('flash', "You don't have any billing history yet. Place an order first to access the billing portal.");
        }

        $session = $stripe->createPortalSession($customerId, route('dashboard'));
        return redirect()->away($session->url);
    }
}
