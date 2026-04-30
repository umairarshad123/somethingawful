<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Generic event log for the admin "Activity" timeline. Free-form payload
     * column lets us add new event types without further migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Type vocabulary: account.created, account.signed_in,
            // account.profile_updated, lead.created, lead.status_changed,
            // contact.submitted, popup.submitted, pricing.viewed,
            // service.viewed, admin.action.
            $table->string('event', 60)->index();

            $table->string('subject_label')->nullable();   // human-readable "what happened"
            $table->string('subject_type', 60)->nullable();// e.g. lead, user, service_request
            $table->unsignedBigInteger('subject_id')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete(); // admin acting on behalf

            $table->json('payload')->nullable();

            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 240)->nullable();

            $table->timestamps();
            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
