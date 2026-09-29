<?php

namespace Database\Seeders;

use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoAccountsSeeder extends Seeder
{
    /**
     * Seed one demo customer and one demo technician so all three
     * portal roles can be signed into during development.
     */
    public function run(): void
    {
        $customer = User::updateOrCreate(
            ['email' => 'customer@fixmate.ai'],
            [
                'name' => 'Ayesha Khan',
                'password' => 'password123',
                'phone' => '03001234567',
                'city' => 'Karachi — DHA, Clifton, Gulshan, Nazimabad',
                'role' => User::ROLE_CUSTOMER,
                'is_active' => true,
                'contact_verified_at' => now(),
            ]
        );

        $this->command->info('Demo customer: customer@fixmate.ai / password123');

        $technician = User::updateOrCreate(
            ['phone' => '03441234567'],
            [
                'name' => 'Ali Khan',
                'password' => 'password123',
                'role' => User::ROLE_TECHNICIAN,
                'is_active' => true,
                'contact_verified_at' => now(),
            ]
        );

        Technician::updateOrCreate(
            ['user_id' => $technician->id],
            [
                'trade' => 'Plumbing — Pipes, Sanitary, Sinks, Motors',
                'experience' => '5 - 8 Years',
                'is_verified' => false,
            ]
        );

        $this->command->info('Demo technician: 03441234567 / password123');
    }
}