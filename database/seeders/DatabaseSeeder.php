<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Test customer login
        User::updateOrCreate(
            ['email' => 'customer@digirisers.test'],
            [
                'first_name' => 'Casey',
                'last_name'  => 'Customer',
                'phone'      => '+1 555 010 1010',
                'company'    => 'Demo Co.',
                'password'   => 'password123',          // hashed via cast
                'role'       => 'customer',
            ]
        );

        // Admin login
        User::updateOrCreate(
            ['email' => 'admin@digirisers.test'],
            [
                'first_name' => 'Avery',
                'last_name'  => 'Admin',
                'phone'      => '+1 555 020 2020',
                'company'    => 'Digirisers HQ',
                'password'   => 'admin123',             // hashed via cast
                'role'       => 'admin',
            ]
        );
    }
}
