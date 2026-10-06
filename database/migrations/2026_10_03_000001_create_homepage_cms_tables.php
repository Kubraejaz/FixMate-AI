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
        // 1. Homepage Settings Table (Single-record or key-value config)
        if (! Schema::hasTable('homepage_settings')) {
            Schema::create('homepage_settings', function (Blueprint $table) {
                $table->id();
                $table->string('hero_badge')->default('Verified On-Demand Home Service Platform');
                $table->string('hero_title_main')->default('Smart Home Services');
                $table->string('hero_title_highlight')->default('Simple');
                $table->text('hero_subtitle');
                $table->string('hero_image')->default('assets/images/image_8.png');
                $table->string('hero_script_text')->default("Your Home\nOur Priority");
                $table->string('hero_trusted_tag')->default('Trusted Professionals for Your Home');
                $table->string('guarantee_title')->default('FixMate Guarantee');
                $table->text('guarantee_subtitle');
                $table->unsignedSmallInteger('warranty_days')->default(30);
                $table->timestamps();
            });

            DB::table('homepage_settings')->insert([
                'hero_badge' => 'Verified On-Demand Home Service Platform',
                'hero_title_main' => 'Smart Home Services',
                'hero_title_highlight' => 'Simple',
                'hero_subtitle' => 'Describe your problem or upload defect photos. Let FixMate find verified technicians with transparent upfront pricing.',
                'hero_image' => 'assets/images/image_8.png',
                'hero_script_text' => "Your Home\nOur Priority",
                'hero_trusted_tag' => 'Trusted Professionals for Your Home',
                'guarantee_title' => 'FixMate Guarantee',
                'guarantee_subtitle' => 'Trusted service. Verified professionals. 30-day warranty on all completed jobs.',
                'warranty_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Testimonials Table (Full CRUD for homeowner reviews)
        if (! Schema::hasTable('testimonials')) {
            Schema::create('testimonials', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('location');
                $table->string('trade');
                $table->unsignedTinyInteger('rating')->default(5);
                $table->text('comment');
                $table->string('avatar')->nullable();
                $table->boolean('is_featured')->default(true);
                $table->unsignedInteger('display_order')->default(0);
                $table->timestamps();
            });

            DB::table('testimonials')->insert([
                [
                    'name' => 'Sara Ahmed',
                    'location' => 'Karachi — Clifton',
                    'trade' => 'Electrical Repair',
                    'rating' => 5,
                    'comment' => 'The upfront estimate quoted Rs. 1,400 for our tripping breaker. Technician arrived in 22 minutes and solved the neutral short.',
                    'avatar' => 'assets/images/image_2.png',
                    'is_featured' => true,
                    'display_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Dr. Kamran Malik',
                    'location' => 'Islamabad — F-7/2',
                    'trade' => 'Inverter AC Jet Wash',
                    'rating' => 5,
                    'comment' => 'Deep pressure jet wash fixed cooling issues in under an hour. Outstanding professional service and polite technician.',
                    'avatar' => 'assets/images/image_3.png',
                    'is_featured' => true,
                    'display_order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Bilal Farooq',
                    'location' => 'Lahore — Gulberg III',
                    'trade' => 'Plumbing Overhaul',
                    'rating' => 5,
                    'comment' => 'No overcharging or guesswork. Upfront pricing and arrival OTP made hiring a technician completely worry-free.',
                    'avatar' => 'assets/images/image_4.png',
                    'is_featured' => true,
                    'display_order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // 3. Workflow Steps Table (Full CRUD for steps)
        if (! Schema::hasTable('workflow_steps')) {
            Schema::create('workflow_steps', function (Blueprint $table) {
                $table->id();
                $table->unsignedTinyInteger('step_number');
                $table->string('icon', 30)->default('🔧');
                $table->string('title');
                $table->string('description');
                $table->string('badge_color', 20)->default('#FFC107');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            DB::table('workflow_steps')->insert([
                [
                    'step_number' => 1,
                    'icon' => '📷',
                    'title' => 'Describe Your Problem',
                    'description' => 'Share details or upload defect photos.',
                    'badge_color' => '#FFC107',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'step_number' => 2,
                    'icon' => '🏷️',
                    'title' => 'Upfront Tariff Pricing',
                    'description' => 'Instant standard labor and parts cost estimate.',
                    'badge_color' => '#FFC107',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'step_number' => 3,
                    'icon' => '🧑‍🔧',
                    'title' => 'Proximity Match',
                    'description' => 'Dispatches top nearby verified specialists.',
                    'badge_color' => '#FFC107',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'step_number' => 4,
                    'icon' => '📍',
                    'title' => 'Live Radar & Tracking',
                    'description' => 'Monitor real-time technician arrival on map.',
                    'badge_color' => '#FFC107',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'step_number' => 5,
                    'icon' => '✓',
                    'title' => 'Protected Escrow',
                    'description' => 'Approve arrival OTP & pay with 30-day warranty.',
                    'badge_color' => '#10B981',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_steps');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('homepage_settings');
    }
};
