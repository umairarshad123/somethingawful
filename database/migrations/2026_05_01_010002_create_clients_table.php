<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A client = a converted lead/user. Created when an admin marks a lead
     * as "won" or manually promotes a user to client.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->index();
            $table->string('phone', 60)->nullable();
            $table->string('company')->nullable();
            $table->string('service')->nullable();

            $table->enum('status', ['onboarding', 'active', 'paused', 'completed', 'churned'])
                ->default('onboarding')->index();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->text('notes')->nullable();

            // Trace back to source records
            $table->foreignId('lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
