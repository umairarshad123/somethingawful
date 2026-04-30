<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            // Linked records
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();

            // Stripe identifiers
            $table->string('stripe_subscription_id')->unique();
            $table->string('stripe_customer_id')->index();
            $table->string('stripe_price_id')->nullable();

            // What it's for + state
            $table->string('service_slug');
            $table->string('billing_cycle', 20); // mo | week
            $table->unsignedInteger('amount');
            $table->string('currency', 3)->default('usd');

            $table->enum('status', [
                'incomplete', 'incomplete_expired', 'trialing',
                'active', 'past_due', 'canceled', 'unpaid', 'paused',
            ])->default('incomplete')->index();

            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->boolean('cancel_at_period_end')->default(false);
            $table->timestamp('canceled_at')->nullable();

            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
