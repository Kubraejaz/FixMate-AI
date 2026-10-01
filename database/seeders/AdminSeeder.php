<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Create the single application administrator.
     *
     * Credentials come from the environment (ADMIN_EMAIL / ADMIN_PASSWORD).
     * There is no public registration path for admin accounts.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@fixmate.ai');
        $password = env('ADMIN_PASSWORD');

        if (! $password) {
            $password = bin2hex(random_bytes(10));
        }

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'FixMate Administrator',
                'password' => $password,
                'user_type' => User::TYPE_ADMIN,
                'is_active' => true,
                'contact_verified_at' => now(),
            ]
        );

        $this->command->info('Admin account ready:');
        $this->command->info("  Email:    {$admin->email}");
        $this->command->info("  Password: {$password}");
    }
}