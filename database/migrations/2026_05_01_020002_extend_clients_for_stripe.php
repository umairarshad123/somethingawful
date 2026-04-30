<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the per-customer Stripe metadata to the existing clients table.
     * Webhook handlers fill these in once a payment is confirmed.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('website')->nullable()->after('company');
            $table->string('billing_cycle', 20)->nullable()->after('service');
            $table->string('payment_status', 30)->nullable()->after('status');
            $table->string('stripe_customer_id')->nullable()->index()->after('payment_status');
            $table->string('stripe_subscription_id')->nullable()->index()->after('stripe_customer_id');
            $table->timestamp('last_payment_at')->nullable()->after('stripe_subscription_id');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'website',
                'billing_cycle', 'payment_status',
                'stripe_customer_id', 'stripe_subscription_id',
                'last_payment_at',
            ]);
        });
    }
};
