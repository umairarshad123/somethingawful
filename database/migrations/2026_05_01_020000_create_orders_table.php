<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 40)->unique();

            // Soft links — orders can exist before a user/client row does
            // (guests buy without an account; we backfill on webhook).
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();

            // What was bought
            $table->string('service_slug')->index();
            $table->string('service_name');
            $table->string('billing_cycle', 20);   // project | mo | week | per_zap | per_script | per_asset
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('amount');     // in the smallest currency unit (cents)
            $table->string('currency', 3)->default('usd');

            // Customer details captured at checkout
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->index();
            $table->string('phone', 60)->nullable();
            $table->string('company')->nullable();
            $table->string('website')->nullable();
            $table->text('notes')->nullable();

            // Stripe linkage
            $table->string('stripe_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->string('stripe_customer_id')->nullable()->index();
            $table->string('stripe_subscription_id')->nullable()->index();

            // State
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'partially_refunded'])
                ->default('pending')->index();
            $table->enum('order_status', ['created', 'awaiting_payment', 'processing', 'fulfilled', 'cancelled'])
                ->default('created')->index();

            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
