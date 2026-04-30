<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable()->after('role');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            // Status mirrors role-style enum but is independent so admins
            // can suspend without changing role.
            $table->string('status', 20)->default('active')->after('last_login_ip')->index();
            $table->string('signup_source', 60)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_login_at', 'last_login_ip', 'status', 'signup_source']);
        });
    }
};
