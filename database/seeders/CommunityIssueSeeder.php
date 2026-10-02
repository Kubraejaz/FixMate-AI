<?php

namespace Database\Seeders;

use App\Models\CommunityIssue;
use Illuminate\Database\Seeder;

class CommunityIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $issues = [
            [
                'reference_no' => 'FM-CIV-1001',
                'reporter_name' => 'Ahmed R.',
                'reporter_role' => 'Resident',
                'reporter_phone' => '0300-1234567',
                'title' => 'Main line water leak overflowing into neighborhood park gate',
                'description' => 'Fresh drinking water overflowing into lane 3 since 7 AM. Pressure severely dropped in adjacent 12 homes.',
                'category' => 'water_supply',
                'city' => 'Karachi',
                'location' => 'DHA Phase 6, Lane 3, Karachi',
                'status' => 'in_progress',
                'status_update' => 'Rapid Response Squad Dispatched',
                'priority' => 'high',
                'upvotes_count' => 34,
                'is_approved' => true,
            ],
            [
                'reference_no' => 'FM-CIV-1002',
                'reporter_name' => 'Sarah M.',
                'reporter_role' => 'Resident',
                'reporter_phone' => '0321-9876543',
                'title' => 'Heavy sparking on transformer pole near primary school',
                'description' => 'Continuous arcing and electrical sparks during afternoon peak loads. Pedestrian area cordoned off.',
                'category' => 'electrical_hazard',
                'city' => 'Karachi',
                'location' => 'Gulshan-e-Iqbal Block 13D, Karachi',
                'status' => 'alert_active',
                'status_update' => 'Critical Priority Alert - Squad En Route',
                'priority' => 'critical',
                'upvotes_count' => 58,
                'is_approved' => true,
            ],
            [
                'reference_no' => 'FM-CIV-1003',
                'reporter_name' => 'Usman Ali',
                'reporter_role' => 'Resident',
                'reporter_phone' => '0333-5566778',
                'title' => 'Clogged stormwater drain causing street waterlogging',
                'description' => 'Debris blockage in roadside catch basin causing water backup during rain.',
                'category' => 'sewerage',
                'city' => 'Lahore',
                'location' => 'Johar Town Block G, Lahore',
                'status' => 'scheduled',
                'status_update' => 'Society Maintenance Notified for Clear-out',
                'priority' => 'normal',
                'upvotes_count' => 41,
                'is_approved' => true,
            ],
            [
                'reference_no' => 'FM-CIV-1004',
                'reporter_name' => 'Community Head',
                'reporter_role' => 'Area Representative',
                'reporter_phone' => '0345-4433221',
                'title' => 'Underground streetlight power cable burnt & replaced',
                'description' => 'FixMate certified electrical crew repaired 40 meters of underground armoured cable. 6 street lamps fully operational.',
                'category' => 'street_light',
                'city' => 'Islamabad',
                'location' => 'F-7/2, Street 31, Islamabad',
                'status' => 'resolved',
                'status_update' => 'Completed & Verified by Community Head',
                'priority' => 'normal',
                'upvotes_count' => 89,
                'is_approved' => true,
                'resolved_at' => now()->subDays(4),
            ],
        ];

        foreach ($issues as $issue) {
            CommunityIssue::updateOrCreate(
                ['reference_no' => $issue['reference_no']],
                $issue
            );
        }
    }
}
