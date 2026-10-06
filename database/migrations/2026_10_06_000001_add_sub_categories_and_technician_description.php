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
        // 1. Add sub_categories to professions table
        if (Schema::hasTable('professions') && ! Schema::hasColumn('professions', 'sub_categories')) {
            Schema::table('professions', function (Blueprint $table) {
                $table->json('sub_categories')->nullable()->after('description');
            });
        }

        // 2. Add description to users table for technician bio/description
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'description')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('description')->nullable()->after('experience');
            });
        }

        // 3. Add description & sub_categories to professionals table
        if (Schema::hasTable('professionals')) {
            Schema::table('professionals', function (Blueprint $table) {
                if (! Schema::hasColumn('professionals', 'description')) {
                    $table->text('description')->nullable()->after('experience');
                }
                if (! Schema::hasColumn('professionals', 'sub_categories')) {
                    $table->json('sub_categories')->nullable()->after('description');
                }
            });
        }

        // 4. Seed rich sub-categories for all standard professions
        $subCategoriesMap = [
            'plumber' => [
                'Pipe Leakage & Water Pressure Diagnostics',
                'Tap, Mixer & Shower Repair / Replacement',
                'Electric & Gas Geyser Heating & Valve Repair',
                'Water Motor & Suction Pump Overhaul',
                'Toilet, Commode & Flush Tank Repair',
                'Drain Unblocking & Sewerage Siphon Cleaning',
            ],
            'electrician' => [
                'Short Circuit & Breaker Tripping Repair',
                'UPS, Inverter & Solar Wiring Balancing',
                'Ceiling Fan, Exhaust & Chandelier Installation',
                'DB Box & Main Distribution Circuit Rewiring',
                'SMD & Spot Decorative Lighting Setup',
                'Switch Board, 3-Pin Socket & Dimmer Replacement',
            ],
            'ac-refrigeration' => [
                'Split AC High-Pressure Chemical Foam Jet Wash',
                'R410a / R32 Genuine Gas Refill & Leak Fixing',
                'Inverter AC PCB Circuit Board Diagnostics',
                'AC Indoor & Outdoor Dismantling / Installation',
                'Compressor Capacitor & Blower Fan Motor Repair',
                'Refrigerator Cooling Coil & Thermostat Overhaul',
            ],
            'carpenter' => [
                'Door Lock, Handle & Deadbolt Installation',
                'Sliding Wardrobe Channel & Roller Repair',
                'Hydraulic Soft-Close Cabinet Hinge Replacement',
                'Custom Furniture Assembly & Wood Polishing',
                'Kitchen Cabinet & Drawer Track Repair',
                'Wooden Bed, Sofa Frame & Chair Structure Fix',
            ],
            'painter' => [
                'Interior Wall Putty, Primer & Emulsion Painting',
                'Exterior Weather-Shield & Texture Paint',
                'Wall Seepage & Dampness Chemical Treatment',
                'Roof Elastomeric Heat & Water Leak Coating',
                'Wooden Door Deco Paint & Lacquer Polish',
                'Metal Gate & Grille Anti-Rust Enamel Painting',
            ],
            'deep-cleaning' => [
                'Full Home Post-Construction Deep Cleaning',
                'Fabric Sofa & Carpet Steam Extraction Wash',
                'Kitchen Chimney, Stove & Cabinet Degreasing',
                'Bathroom Tile Grout & Hard Scale Removal',
                'Water Tank Ultrasonic Cleaning & Chlorination',
                'Mattress Sanitization & Allergen Treatment',
            ],
            'home-appliances' => [
                'Automatic Washing Machine Drum & Motor Repair',
                'Microwave Oven Heating Magnetron Fix',
                'Kitchen Hood & Cooking Range Repair',
                'Instant Gas Geyser Diaphragm & Ignition Repair',
                'Water Dispenser Cooling Compressor Fix',
                'Dishwasher & Iron Appliance Troubleshooting',
            ],
            'solar-ups' => [
                'Solar Panel Array Output & Efficiency Audit',
                'Hybrid Inverter MPPT Calibration & Setup',
                'Tubular Deep-Cycle Battery Acid Gravity Service',
                'DC Breaker, Surge Protection & Grounding Rod',
                'Net Metering Compliance & Load Distribution',
                'UPS Overheating & Transformer Repair',
            ],
            'cctv-smart-security' => [
                'HD IP & Analog Security Camera Installation',
                'DVR / NVR Hard Drive Recording & Cloud Setup',
                'Mobile Phone Remote View App Configuration',
                'Video Intercom & Doorbell Integration',
                'Smart Door Deadbolt & Magnetic Lock Wiring',
                'Cat6 Network Cabling & PoE Switch Setup',
            ],
            'handyman-masonry' => [
                'Broken Tile Replacement & Grouting',
                'Wall Drilling, Picture Hanging & Curtain Rods',
                'Concrete Wall Plaster & Crack Filling',
                'Door Stopper & Window Latch Installation',
                'Gypsum False Ceiling Board Patch Repair',
                'TV Wall Mount Bracket Installation',
            ],
            'pest-control' => [
                'Pre & Post Construction Termite Chemical Barrier',
                'Odorless Cockroach Gel & Crack Treatment',
                'Bedbug High-Heat Steam Extermination',
                'Rodent & Rat Baiting Traps Setup',
                'Mosquito & Fly Fogging Fumigation',
                'General Crawling Insect Barrier Spray',
            ],
        ];

        foreach ($subCategoriesMap as $slug => $subs) {
            DB::table('professions')
                ->where('slug', $slug)
                ->orWhere('slug', 'like', "%{$slug}%")
                ->update([
                    'sub_categories' => json_encode($subs),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('professions') && Schema::hasColumn('professions', 'sub_categories')) {
            Schema::table('professions', function (Blueprint $table) {
                $table->dropColumn('sub_categories');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'description')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }

        if (Schema::hasTable('professionals')) {
            Schema::table('professionals', function (Blueprint $table) {
                if (Schema::hasColumn('professionals', 'description')) {
                    $table->dropColumn('description');
                }
                if (Schema::hasColumn('professionals', 'sub_categories')) {
                    $table->dropColumn('sub_categories');
                }
            });
        }
    }
};
