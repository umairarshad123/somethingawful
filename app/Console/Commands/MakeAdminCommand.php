<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdminCommand extends Command
{
    /**
     * Quick way to grant admin role from the CLI without touching the DB
     * directly. Used during initial setup and on the production cPanel.
     */
    protected $signature = 'admin:make {email} {--password= : Optional new password to set} {--first= : First name when creating} {--last= : Last name when creating}';
    protected $description = 'Promote an existing user to admin (or create one if missing)';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user  = User::where('email', $email)->first();

        if (! $user) {
            $password = $this->option('password') ?? 'admin1234!';
            $user = User::create([
                'first_name' => $this->option('first') ?? 'Admin',
                'last_name'  => $this->option('last') ?? 'User',
                'email'      => $email,
                'password'   => $password, // hashed via cast
                'role'       => 'admin',
                'status'     => 'active',
                'email_verified_at' => now(),
                'signup_source'     => 'cli',
            ]);
            $this->info("Created admin user {$email} with password '{$password}'.");
            $this->warn('Change the password on first sign-in.');
            return self::SUCCESS;
        }

        $user->forceFill(['role' => 'admin', 'status' => 'active'])->save();

        if ($pw = $this->option('password')) {
            $user->forceFill(['password' => Hash::make($pw)])->save();
            $this->info("Reset password for {$email}.");
        }

        $this->info("Promoted {$email} to admin.");
        return self::SUCCESS;
    }
}
