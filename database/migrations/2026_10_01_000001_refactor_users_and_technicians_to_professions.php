<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Refactors the schema according to normalization guidelines:
     * 1. Creates `professions` master table.
     * 2. Adds `user_type` ('customer', 'technician', 'admin') to `users`.
     * 3. Merges technician details (profession_id, experience, cnic_number, is_verified) into `users`.
     * 4. Drops the old `role` integer column from `users`.
     * 5. Drops the redundant `technicians` table.
     */
    public function up(): void
    {
        // 1. Create professions master table
        Schema::create('professions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed initial professions
        $professions = [
            [
                'name' => 'Plumber',
                'slug' => 'plumber',
                'icon' => 'wrench',
                'description' => 'Pipes, Sanitary, Sinks, Motors & Leakage solutions',
            ],
            [
                'name' => 'Electrician',
                'slug' => 'electrician',
                'icon' => 'zap',
                'description' => 'Wiring, Breakers, DB Boxes, Fans & Lighting',
            ],
            [
                'name' => 'AC & Refrigeration',
                'slug' => 'ac-refrigeration',
                'icon' => 'wind',
                'description' => 'Inverter, Gas Refill, General Service & Repairs',
            ],
            [
                'name' => 'Carpenter',
                'slug' => 'carpenter',
                'icon' => 'hammer',
                'description' => 'Furniture, Doors, Locks & Woodwork',
            ],
            [
                'name' => 'Painter',
                'slug' => 'painter',
                'icon' => 'paint-brush',
                'description' => 'Interior, Exterior, Waterproofing & Polish',
            ],
            [
                'name' => 'Deep Cleaning',
                'slug' => 'deep-cleaning',
                'icon' => 'sparkles',
                'description' => 'Sofa, Carpet, Water Tank & Full Home Sanitation',
            ],
            [
                'name' => 'Home Appliances',
                'slug' => 'home-appliances',
                'icon' => 'cpu',
                'description' => 'Washing Machine, Microwave, Oven & Geyser repair',
            ],
        ];

        foreach ($professions as $profession) {
            DB::table('professions')->insert(array_merge($profession, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 2. Add new columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type', 20)->default('customer')->after('password');
            $table->foreignId('profession_id')->nullable()->after('user_type')->constrained('professions')->nullOnDelete();
            $table->string('experience')->nullable()->after('profession_id');
            $table->text('cnic_number')->nullable()->after('experience');
            $table->boolean('is_verified')->default(false)->after('cnic_number');
        });

        // 3. Migrate existing user roles to user_type strings
        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')->where('role', 1)->update(['user_type' => 'admin']);
            DB::table('users')->where('role', 2)->update(['user_type' => 'technician']);
            DB::table('users')->where('role', 3)->update(['user_type' => 'customer']);
        }

        // 4. Migrate existing data from technicians table to users table
        if (Schema::hasTable('technicians')) {
            $plumberId = DB::table('professions')->where('slug', 'plumber')->value('id');
            $electricianId = DB::table('professions')->where('slug', 'electrician')->value('id');
            $cleaningId = DB::table('professions')->where('slug', 'deep-cleaning')->value('id');

            $technicians = DB::table('technicians')->get();
            foreach ($technicians as $tech) {
                $professionId = null;
                $tradeLower = strtolower($tech->trade ?? '');

                if (str_contains($tradeLower, 'plumb')) {
                    $professionId = $plumberId;
                } elseif (str_contains($tradeLower, 'electr')) {
                    $professionId = $electricianId;
                } elseif (str_contains($tradeLower, 'clean')) {
                    $professionId = $cleaningId;
                }

                DB::table('users')->where('id', $tech->user_id)->update([
                    'user_type' => 'technician',
                    'profession_id' => $professionId,
                    'experience' => $tech->experience,
                    'cnic_number' => $tech->cnic_number,
                    'is_verified' => (bool) $tech->is_verified,
                ]);
            }

            // Drop technicians table
            Schema::dropIfExists('technicians');
        }

        // 5. Drop old role column from users table
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-create technicians table
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('trade')->nullable();
            $table->string('experience')->nullable();
            $table->text('cnic_number')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });

        // Re-add role column
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('role')->default(3);
        });

        // Restore role values
        DB::table('users')->where('user_type', 'admin')->update(['role' => 1]);
        DB::table('users')->where('user_type', 'technician')->update(['role' => 2]);
        DB::table('users')->where('user_type', 'customer')->update(['role' => 3]);

        // Copy back technician data
        $techUsers = DB::table('users')->where('user_type', 'technician')->get();
        foreach ($techUsers as $user) {
            $professionName = DB::table('professions')->where('id', $user->profession_id)->value('name');
            DB::table('technicians')->insert([
                'user_id' => $user->id,
                'trade' => $professionName,
                'experience' => $user->experience,
                'cnic_number' => $user->cnic_number,
                'is_verified' => $user->is_verified,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Drop new user columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profession_id']);
            $table->dropColumn([
                'user_type',
                'profession_id',
                'experience',
                'cnic_number',
                'is_verified',
            ]);
        });

        // Drop professions table
        Schema::dropIfExists('professions');
    }
};
