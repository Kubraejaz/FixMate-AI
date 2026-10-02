<?php

namespace Database\Seeders;

use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Database\Seeder;

class DemoAccountsSeeder extends Seeder
{
    /**
     * Seed realistic customers and technicians so all portal roles
     * and admin management pages display rich dynamic data.
     */
    public function run(): void
    {
        // 1. Primary demo accounts
        $customer = User::updateOrCreate(
            ['email' => 'customer@fixmate.ai'],
            [
                'name' => 'Ayesha Khan',
                'password' => 'password123',
                'phone' => OtpService::normalizePhone('03001234567'),
                'city' => 'Karachi — DHA, Clifton, Gulshan, Nazimabad',
                'user_type' => User::TYPE_CUSTOMER,
                'is_active' => true,
                'contact_verified_at' => now(),
            ]
        );

        // Additional demo customers
        $customersData = [
            [
                'name' => 'Sara Ahmed',
                'email' => 'sara@example.com',
                'phone' => OtpService::normalizePhone('03214455667'),
                'city' => 'Karachi',
                'area' => 'Clifton Block 4',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Kamran Malik',
                'email' => 'kamran@example.com',
                'phone' => OtpService::normalizePhone('03337788990'),
                'city' => 'Islamabad',
                'area' => 'Sector F-7/2',
                'is_active' => true,
            ],
            [
                'name' => 'Bilal Tariq',
                'email' => 'bilal@example.com',
                'phone' => OtpService::normalizePhone('03451122334'),
                'city' => 'Lahore',
                'area' => 'Gulberg III',
                'is_active' => false,
            ],
            [
                'name' => 'Zainab Qureshi',
                'email' => 'zainab@example.com',
                'phone' => OtpService::normalizePhone('03129988776'),
                'city' => 'Rawalpindi',
                'area' => 'Saddar Cantt',
                'is_active' => true,
            ],
        ];

        foreach ($customersData as $c) {
            User::updateOrCreate(
                ['phone' => $c['phone']],
                [
                    'name' => $c['name'],
                    'email' => $c['email'],
                    'password' => 'password123',
                    'city' => $c['city'],
                    'area' => $c['area'],
                    'user_type' => User::TYPE_CUSTOMER,
                    'is_active' => $c['is_active'],
                    'contact_verified_at' => now(),
                ]
            );
        }

        // 2. Technicians
        $plumber = Profession::where('slug', 'plumber')->first();
        $electrician = Profession::where('slug', 'electrician')->first();
        $ac = Profession::where('slug', 'ac-refrigeration')->first();
        $carpenter = Profession::where('slug', 'carpenter')->first();

        $techsData = [
            [
                'name' => 'Ali Khan',
                'email' => 'technician@fixmate.ai',
                'phone' => OtpService::normalizePhone('03441234567'),
                'profession_id' => $plumber?->id,
                'experience' => '8 Years',
                'city' => 'Karachi',
                'area' => 'DHA Phase 5',
                'is_verified' => true,
            ],
            [
                'name' => 'Riaz Ahmed',
                'email' => 'riaz.electric@example.com',
                'phone' => OtpService::normalizePhone('03135556677'),
                'profession_id' => $electrician?->id,
                'experience' => '6 Years',
                'city' => 'Karachi',
                'area' => 'Clifton',
                'is_verified' => true,
            ],
            [
                'name' => 'Imran Shah',
                'email' => 'imran.hvac@example.com',
                'phone' => OtpService::normalizePhone('03223334455'),
                'profession_id' => $ac?->id,
                'experience' => '7 Years',
                'city' => 'Lahore',
                'area' => 'Gulberg',
                'is_verified' => true,
            ],
            [
                'name' => 'Umar Tariq',
                'email' => 'umar.carpenter@example.com',
                'phone' => OtpService::normalizePhone('03017778899'),
                'profession_id' => $carpenter?->id,
                'experience' => '5 Years',
                'city' => 'Islamabad',
                'area' => 'G-9 Markaz',
                'is_verified' => false,
            ],
        ];

        foreach ($techsData as $t) {
            $user = User::updateOrCreate(
                ['phone' => $t['phone']],
                [
                    'name' => $t['name'],
                    'email' => $t['email'],
                    'password' => 'password123',
                    'user_type' => User::TYPE_TECHNICIAN,
                    'profession_id' => $t['profession_id'],
                    'experience' => $t['experience'],
                    'city' => $t['city'],
                    'area' => $t['area'],
                    'is_verified' => $t['is_verified'],
                    'is_active' => true,
                    'contact_verified_at' => now(),
                ]
            );

            // Keep Professional model in sync
            Professional::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profession_id' => $t['profession_id'],
                    'name' => $t['name'],
                    'email' => $t['email'],
                    'phone' => $t['phone'],
                    'experience' => $t['experience'],
                    'is_verified' => $t['is_verified'],
                ]
            );
        }

        $this->command->info('Demo customers and technicians seeded successfully.');
    }
}