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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('technician_latitude', 10, 7)->nullable()->after('city');
            $table->decimal('technician_longitude', 10, 7)->nullable()->after('technician_latitude');
            $table->decimal('destination_latitude', 10, 7)->nullable()->after('technician_longitude');
            $table->decimal('destination_longitude', 10, 7)->nullable()->after('destination_latitude');
            $table->unsignedInteger('tracking_eta_minutes')->nullable()->after('destination_longitude');
            $table->timestamp('location_updated_at')->nullable()->after('tracking_eta_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'technician_latitude',
                'technician_longitude',
                'destination_latitude',
                'destination_longitude',
                'tracking_eta_minutes',
                'location_updated_at',
            ]);
        });
    }
};
