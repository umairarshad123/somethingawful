<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * "Pricing request" / service interest signal. Recorded whenever a guest
     * or member loads a /shop/{slug} page or clicks a "View pricing" CTA.
     * Lightweight on purpose — one row per intent signal.
     */
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->index();           // catalog item slug
            $table->string('service_name')->nullable();
            $table->string('category', 60)->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('was_logged_in')->default(false);
            $table->boolean('signed_up_after')->default(false); // backfilled if guest later signs up

            $table->string('action', 30)->default('viewed'); // viewed | clicked_pricing
            $table->string('follow_up_status', 30)->default('pending'); // pending | contacted | done | ignored

            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 240)->nullable();
            $table->string('referrer')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
