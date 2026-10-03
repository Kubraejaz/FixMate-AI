<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('professions', function (Blueprint $table) {
            $table->unsignedInteger('base_price')->default(650)->after('icon');
            $table->string('price_unit', 50)->default('base')->after('base_price');
            $table->string('estimated_duration', 100)->default('30 – 60 mins')->after('price_unit');
            $table->string('headline', 255)->nullable()->after('estimated_duration');
            $table->string('image', 255)->nullable()->after('headline');
            $table->string('warranty_text', 100)->default('60-Day Re-work Free')->after('image');
            $table->json('feature_points')->nullable()->after('warranty_text');
            $table->json('included_items')->nullable()->after('feature_points');
            $table->json('excluded_items')->nullable()->after('included_items');
        });

        // Seed rich defaults for standard existing professions
        $seedData = [
            'plumber' => [
                'icon' => '💧',
                'base_price' => 650,
                'price_unit' => 'base',
                'estimated_duration' => '30 – 50 mins',
                'headline' => 'Kitchen Sink, Mixer Faucets & Water Pipe Leak Repair',
                'image' => 'assets/images/image_3.png',
                'warranty_text' => '60-Day Re-work Free',
                'feature_points' => [
                    'Pipe leak repair & Teflon sealing',
                    'Electric/Gas geyser heating element & thermostat',
                    'Water pressure motor & suction pump overhaul',
                ],
                'included_items' => [
                    'Full ultrasonic & joint leak pressure inspection',
                    'Slip-joint washer and Teflon thread seal replacement',
                    'Sanitary pipe tightening and valve calibration',
                    'Drain siphon flow test & 60-day rework guarantee',
                ],
                'excluded_items' => [
                    'New brass mixer units or replacement pipes (billed at receipt)',
                    'Excavation beyond 2 feet of concrete slab',
                ],
            ],
            'electrician' => [
                'icon' => '⚡',
                'base_price' => 700,
                'price_unit' => 'base',
                'estimated_duration' => '40 – 60 mins',
                'headline' => 'Circuit Breaker Tripping, DB Box & UPS Wiring Diagnosis',
                'image' => 'assets/images/image_2.png',
                'warranty_text' => '60-Day Re-work Free',
                'feature_points' => [
                    'Short circuit detection & breaker trip repair',
                    'UPS/Inverter wiring & battery maintenance',
                    'SMD light & modern chandelier installations',
                ],
                'included_items' => [
                    'Digital multimeter voltage & phase grounding audit',
                    'Main DB circuit breaker diagnostic & replacement labor',
                    'Heat-resistant sleeve wiring and terminal tightening',
                    'Post-repair load test across all phases',
                ],
                'excluded_items' => [
                    'Replacement Schneider/Terasaki circuit breakers',
                    'UPS batteries or solar inverter equipment',
                ],
            ],
            'ac-refrigeration' => [
                'icon' => '❄️',
                'base_price' => 1499,
                'price_unit' => 'service',
                'estimated_duration' => '60 – 75 mins',
                'headline' => 'High-Pressure Chemical Coil Wash & R410a Gas Charging',
                'image' => 'assets/images/image_1.png',
                'warranty_text' => '30-Day Cooling Warranty',
                'feature_points' => [
                    'High-pressure foam deep wash indoor & outdoor',
                    'Genuine DuPont / Honeywell R410a / R32 gas refill',
                    'Inverter PCB board sensor diagnosis & repair',
                ],
                'included_items' => [
                    'Waterproof wall protection jacket installation',
                    'High-pressure chemical jet wash indoor cooling coils',
                    'Outdoor condenser fin hydro-descaling',
                    'Operating amp current & gas pressure verification',
                ],
                'excluded_items' => [
                    'Pure R410a/R32 gas top-up (billed if pressure low)',
                    'PCB motherboard capacitor replacements',
                ],
            ],
            'deep-cleaning' => [
                'icon' => '🧹',
                'base_price' => 2499,
                'price_unit' => 'package',
                'estimated_duration' => '2 – 3 hours',
                'headline' => 'Hospital-Grade Chemical Sanitization, Sofa & Floor Descaling',
                'image' => 'assets/images/image_4.png',
                'warranty_text' => '100% Satisfaction Re-clean',
                'feature_points' => [
                    'Hospital-grade eco-friendly disinfectant wash',
                    'Industrial vacuum upholstery steam cleaning',
                    'Post-construction deep residue stripping',
                ],
                'included_items' => [
                    'Industrial wet/dry suction extraction equipment',
                    'Tile grout chemical descaling and stain lift',
                    'Kitchen grease de-greaser on chimney and cabinets',
                    'Hospital-grade antibacterial room misting',
                ],
                'excluded_items' => [
                    'Exterior glass cleaning above 2nd floor height',
                    'Disposal of construction rubble',
                ],
            ],
            'painter' => [
                'icon' => '🖌️',
                'base_price' => 25,
                'price_unit' => '/ sq.ft',
                'estimated_duration' => '1 – 2 days',
                'headline' => 'Seepage Chemical Treatment & Premium Wall Finish',
                'image' => 'assets/images/image_2.png',
                'warranty_text' => '90-Day Seepage Escrow',
                'feature_points' => [
                    'Roof chemical elastomeric waterproofing',
                    'Wall putty smooth finish & anti-fungal paint',
                    'Wood door lacquer & deco paint finish',
                ],
                'included_items' => [
                    'Floor masking and furniture protective plastic covering',
                    'Chemical dampness treatment and anti-salt scraper',
                    'Two coats of ultra-smooth wall putty filling',
                    'Application of Berger / ICI Dulux paint with rollers',
                ],
                'excluded_items' => [
                    'Paint gallons and primer buckets (client choice)',
                    'Scaffolding for 3+ story building exteriors',
                ],
            ],
            'carpenter' => [
                'icon' => '🔨',
                'base_price' => 800,
                'price_unit' => 'base',
                'estimated_duration' => '45 – 70 mins',
                'headline' => 'Smart Lock Fitting, Cabinet Hydraulic Hinges & Repairs',
                'image' => 'assets/images/image_3.png',
                'warranty_text' => '60-Day Re-work Free',
                'feature_points' => [
                    'Main door smart lock & deadbolt fittings',
                    'Kitchen cabinet hydraulic hinges & runners',
                    'Wooden bed frame & sofa structure repair',
                ],
                'included_items' => [
                    'Precision mortise cut and strike plate alignment',
                    'Hydraulic soft-close hinge calibration',
                    'Wood swelling planing and clear latch clearance',
                    'Screw anchor reinforcement into solid brick/wood',
                ],
                'excluded_items' => [
                    'Smart lock electronic hardware or new wooden doors',
                    'Lacquering / French polish materials',
                ],
            ],
            'home-appliances' => [
                'icon' => '🧺',
                'base_price' => 950,
                'price_unit' => 'diagnosis',
                'estimated_duration' => '45 – 60 mins',
                'headline' => 'Washing Machine, Microwave & Kitchen Appliances Repair',
                'image' => 'assets/images/image_1.png',
                'warranty_text' => '60-Day Re-work Free',
                'feature_points' => [
                    'Washing machine spin/drain motor repair',
                    'Microwave magnetron & heating fault fix',
                    'Refrigerator cooling compressor testing',
                ],
                'included_items' => [
                    'Full electrical multimeter amp & circuit diagnosis',
                    'Internal drum/pump clearing & seal lubrication',
                    'Component replacement labor & voltage calibration',
                    'Post-repair 30-minute stress test',
                ],
                'excluded_items' => [
                    'New motor, pump, or capacitor parts cost',
                    'Transportation if workshop repair required',
                ],
            ],
        ];

        foreach ($seedData as $slug => $data) {
            DB::table('professions')
                ->where('slug', $slug)
                ->update([
                    'icon' => $data['icon'],
                    'base_price' => $data['base_price'],
                    'price_unit' => $data['price_unit'],
                    'estimated_duration' => $data['estimated_duration'],
                    'headline' => $data['headline'],
                    'image' => $data['image'],
                    'warranty_text' => $data['warranty_text'],
                    'feature_points' => json_encode($data['feature_points']),
                    'included_items' => json_encode($data['included_items']),
                    'excluded_items' => json_encode($data['excluded_items']),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professions', function (Blueprint $table) {
            $table->dropColumn([
                'base_price',
                'price_unit',
                'estimated_duration',
                'headline',
                'image',
                'warranty_text',
                'feature_points',
                'included_items',
                'excluded_items',
            ]);
        });
    }
};
