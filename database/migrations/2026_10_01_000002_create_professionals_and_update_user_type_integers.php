<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 1. Creates `professionals` table with full technician details:
     *    user_id, profession_id, name, email, phone, experience, cnic_number, is_verified.
     * 2. Updates `user_type` on `users` table to numeric codes:
     *    admin == 1, customer == 2, technician == 3.
     */
    public function up(): void
    {
        // 1. Create professionals table
        if (! Schema::hasTable('professionals')) {
            Schema::create('professionals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $table->foreignId('profession_id')->nullable()->constrained('professions')->nullOnDelete();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('experience')->nullable();
                $table->text('cnic_number')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamps();
            });
        }

        // 2. Populate professionals from existing technician users (user_type = 'technician' or '3')
        $technicianUsers = DB::table('users')->where(function ($query) {
            $query->where('user_type', 'technician')
                  ->orWhere('user_type', '2') // in case of previous role mapping
                  ->orWhere('user_type', '3');
        })->get();

        foreach ($technicianUsers as $tech) {
            // Check if professional entry already exists
            $exists = DB::table('professionals')->where('user_id', $tech->id)->exists();
            if (! $exists) {
                DB::table('professionals')->insert([
                    'user_id' => $tech->id,
                    'profession_id' => $tech->profession_id,
                    'name' => $tech->name,
                    'email' => $tech->email,
                    'phone' => $tech->phone,
                    'experience' => $tech->experience,
                    'cnic_number' => $tech->cnic_number,
                    'is_verified' => (bool) $tech->is_verified,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 3. Update user_type in users table:
        // admin == 1, customer == 2, technician == 3
        DB::table('users')->where('user_type', 'admin')->update(['user_type' => '1']);
        DB::table('users')->where('user_type', 'customer')->update(['user_type' => '2']);
        DB::table('users')->where('user_type', 'technician')->update(['user_type' => '3']);

        // Change column type to unsignedTinyInteger with default 2 (customer)
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('user_type')->default(2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type', 20)->default('customer')->change();
        });

        DB::table('users')->where('user_type', '1')->update(['user_type' => 'admin']);
        DB::table('users')->where('user_type', '2')->update(['user_type' => 'customer']);
        DB::table('users')->where('user_type', '3')->update(['user_type' => 'technician']);

        Schema::dropIfExists('professionals');
    }
};
