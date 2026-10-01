<?php

namespace Database\Seeders;

use App\Models\Profession;
use App\Models\User;
use App\Services\OtpService;
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
                'phone' => OtpService::normalizePhone('03001234567'),
                'city' => 'Karachi — DHA, Clifton, Gulshan, Nazimabad',
                'user_type' => User::TYPE_CUSTOMER,
                'is_active' => true,
                'contact_verified_at' => now(),
            ]
        );

        $this->command->info('Demo customer: customer@fixmate.ai / password123');

        $plumberProfession = Profession::where('slug', 'plumber')->first();

        $technician = User::updateOrCreate(
            ['phone' => OtpService::normalizePhone('03441234567')],
            [
                'name' => 'Ali Khan',
                'email' => 'technician@fixmate.ai',
                'password' => 'password123',
                'user_type' => User::TYPE_TECHNICIAN,
                'profession_id' => $plumberProfession?->id,
                'experience' => '5 - 8 Years',
                'is_verified' => true,
                'is_active' => true,
                'contact_verified_at' => now(),
            ]
        );

        $this->command->info('Demo technician: technician@fixmate.ai or 0344-1234567 / password123');
    }
}