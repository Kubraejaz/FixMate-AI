<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add role-based authentication fields to the users table.
     * Roles: 1 = admin, 2 = technician, 3 = customer.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('role')->default(3);
            $table->boolean('is_active')->default(true);
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('otp_code')->nullable();
            $table->string('otp_purpose')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->unsignedTinyInteger('otp_attempts')->default(0);
            $table->timestamp('contact_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->unique('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
            $table->dropColumn([
                'role',
                'is_active',
                'phone',
                'city',
                'area',
                'otp_code',
                'otp_purpose',
                'otp_expires_at',
                'otp_attempts',
                'contact_verified_at',
                'last_login_at',
            ]);
        });
    }
};