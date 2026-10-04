<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('technician_applications', function (Blueprint $table) {
            $table->string('cnic_front_path')->nullable()->after('documents_list');
            $table->string('cnic_back_path')->nullable()->after('cnic_front_path');
            $table->string('biometric_selfie_path')->nullable()->after('cnic_back_path');
            $table->string('police_certificate_path')->nullable()->after('biometric_selfie_path');
            $table->string('trade_license_path')->nullable()->after('police_certificate_path');
            $table->string('proof_of_address_path')->nullable()->after('trade_license_path');
            $table->string('emergency_contact_name')->nullable()->after('proof_of_address_path');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->string('biometric_status')->default('pending')->after('emergency_contact_phone');
            $table->text('rejection_reason')->nullable()->after('admin_notes');
        });

        Schema::table('professionals', function (Blueprint $table) {
            $table->string('cnic_front_path')->nullable()->after('cnic_number');
            $table->string('cnic_back_path')->nullable()->after('cnic_front_path');
            $table->string('biometric_selfie_path')->nullable()->after('cnic_back_path');
            $table->string('police_certificate_path')->nullable()->after('biometric_selfie_path');
            $table->string('trade_license_path')->nullable()->after('police_certificate_path');
            $table->string('proof_of_address_path')->nullable()->after('trade_license_path');
            $table->string('emergency_contact_name')->nullable()->after('proof_of_address_path');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->string('verification_status')->default('pending')->after('is_verified');
            $table->string('biometric_status')->default('pending')->after('verification_status');
            $table->text('rejection_reason')->nullable()->after('biometric_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('technician_applications', function (Blueprint $table) {
            $table->dropColumn([
                'cnic_front_path',
                'cnic_back_path',
                'biometric_selfie_path',
                'police_certificate_path',
                'trade_license_path',
                'proof_of_address_path',
                'emergency_contact_name',
                'emergency_contact_phone',
                'biometric_status',
                'rejection_reason',
            ]);
        });

        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn([
                'cnic_front_path',
                'cnic_back_path',
                'biometric_selfie_path',
                'police_certificate_path',
                'trade_license_path',
                'proof_of_address_path',
                'emergency_contact_name',
                'emergency_contact_phone',
                'verification_status',
                'biometric_status',
                'rejection_reason',
            ]);
        });
    }
};
