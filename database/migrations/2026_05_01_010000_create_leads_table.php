<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // The submitter
            $table->string('name');
            $table->string('email')->index();
            $table->string('phone', 60)->nullable();
            $table->string('company')->nullable();

            // What they asked about
            $table->string('service')->nullable();
            $table->text('message')->nullable();

            // Where it came from. Drives the admin "Leads / Contact /
            // Pricing requests" filters; one of: hero, popup, contact, manual.
            $table->string('source', 30)->default('hero')->index();
            $table->string('page')->nullable();

            // CRM state
            $table->enum('status', ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost'])
                ->default('new')->index();
            $table->string('assigned_label')->nullable();
            $table->text('internal_notes')->nullable();

            // Trace
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 240)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Activity
            $table->timestamp('last_activity_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
