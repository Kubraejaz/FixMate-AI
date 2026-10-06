<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profession;

class FixProfessionsSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = Profession::where('slug', 'teacher')->first() ?? Profession::find(8);
        if ($teacher) {
            $teacher->update([
                'name' => 'Solar & UPS Inverter',
                'slug' => 'solar-ups',
                'icon' => 'sun',
                'headline' => 'Solar & Backup Power',
                'description' => 'Solar panel inspection, inverter troubleshooting, battery bank testing & home backup wiring',
                'base_price' => 1200,
                'price_unit' => 'service',
                'estimated_duration' => '45 – 90 mins',
                'feature_points' => [
                    'Solar panel efficiency & inverter repair',
                    'UPS wiring & dry/tubular battery health check',
                    'Automatic changeover switch installation',
                ],
                'included_items' => [
                    'Full system voltage & load current multimeter test',
                    'Inverter PCB cleaning and terminal tightening',
                    'Battery water level and specific gravity testing',
                ],
                'excluded_items' => [
                    'New solar panel or inverter unit hardware cost',
                    'Replacement battery cost',
                ],
                'is_active' => true,
            ]);
        }

        // Also ensure Handyman / Home Repair is present
        Profession::firstOrCreate(
            ['slug' => 'handyman-masonry'],
            [
                'name' => 'Handyman & Home Repair',
                'icon' => 'tool',
                'headline' => 'Home Fixtures & Masonry',
                'description' => 'Curtain rod installation, shelf mounting, tile repair, wall drilling & general handyman jobs',
                'base_price' => 750,
                'price_unit' => 'job',
                'estimated_duration' => '30 – 60 mins',
                'feature_points' => [
                    'Wall drilling, frame & TV mounting',
                    'Curtain rods, mirrors & shelf fitting',
                    'Tile crack repairs & grouting',
                ],
                'included_items' => [
                    'Standard drilling and mounting labor',
                    'Rawal plugs & screws for wall mounting',
                    'Clean work area dust wiping',
                ],
                'excluded_items' => [
                    'Heavy wall brackets or custom shelving hardware',
                ],
                'is_active' => true,
            ]
        );

        // Also ensure Pest Control & Fumigation is present
        Profession::firstOrCreate(
            ['slug' => 'pest-control'],
            [
                'name' => 'Pest Control & Fumigation',
                'icon' => 'shield',
                'headline' => 'Fumigation & Pest Defense',
                'description' => 'Termite proofing, cockroach gel treatment, bed bug fumigation & general pest defense',
                'base_price' => 2500,
                'price_unit' => 'home treatment',
                'estimated_duration' => '60 – 120 mins',
                'feature_points' => [
                    'Odorless cockroach gel baiting',
                    'Deep fumigation spray for crawling insects',
                    'Termite pre-drilling and barrier treatment',
                ],
                'included_items' => [
                    'Certified safe chemical application',
                    'Complete perimeter and drain treatment',
                    '30-day efficacy follow-up warranty',
                ],
                'excluded_items' => [
                    'Structural timber replacement if termite damaged',
                ],
                'is_active' => true,
            ]
        );
    }
}
