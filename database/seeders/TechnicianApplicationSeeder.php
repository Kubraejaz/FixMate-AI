<?php

namespace Database\Seeders;

use App\Models\Profession;
use App\Models\TechnicianApplication;
use Illuminate\Database\Seeder;

class TechnicianApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plumber = Profession::where('slug', 'like', '%plumb%')->first() ?? Profession::first();
        $electrician = Profession::where('slug', 'like', '%electr%')->first() ?? Profession::first();
        $hvac = Profession::where('slug', 'like', '%ac%')->orWhere('slug', 'like', '%hvac%')->first() ?? Profession::first();

        if (! $plumber) {
            return;
        }

        $applications = [
            [
                'reference_no' => 'FM-APP-1001',
                'profession_id' => $plumber->id,
                'name' => 'Ali Khan',
                'phone' => '0300-1234567',
                'email' => 'ali.khan@example.com',
                'cnic_number' => '42201-1234567-1',
                'city' => 'Karachi',
                'experience_years' => 8,
                'workshop_type' => 'independent_workshop',
                'tools_available' => 'has_own_tools',
                'documents_list' => 'CNIC, Trade Diploma, Police Clearance',
                'status' => 'pending',
                'admin_notes' => null,
            ],
            [
                'reference_no' => 'FM-APP-1002',
                'profession_id' => $electrician ? $electrician->id : $plumber->id,
                'name' => 'Riaz Ahmed',
                'phone' => '0321-9876543',
                'email' => 'riaz.ahmed@example.com',
                'cnic_number' => '42301-7654321-3',
                'city' => 'Karachi',
                'experience_years' => 6,
                'workshop_type' => 'freelancer',
                'tools_available' => 'has_own_tools',
                'documents_list' => 'CNIC, Electrical License',
                'status' => 'approved',
                'admin_notes' => 'Verified through NADRA portal on Sept 28.',
                'reviewed_at' => now()->subDays(3),
            ],
            [
                'reference_no' => 'FM-APP-1003',
                'profession_id' => $hvac ? $hvac->id : $plumber->id,
                'name' => 'Imran Shah',
                'phone' => '0333-5551234',
                'email' => 'imran.shah@example.com',
                'cnic_number' => '42101-9988776-5',
                'city' => 'Lahore',
                'experience_years' => 7,
                'workshop_type' => 'freelancer',
                'tools_available' => 'has_own_tools',
                'documents_list' => 'CNIC, HVAC Cert',
                'status' => 'approved',
                'admin_notes' => 'Passed practical manifold gauge testing.',
                'reviewed_at' => now()->subDays(1),
            ],
        ];

        foreach ($applications as $app) {
            TechnicianApplication::updateOrCreate(
                ['reference_no' => $app['reference_no']],
                $app
            );
        }
    }
}
