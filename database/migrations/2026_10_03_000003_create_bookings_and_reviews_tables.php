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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 50)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professional_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('profession_id')->constrained()->cascadeOnDelete();
            $table->string('service_title');
            $table->text('problem_description')->nullable();
            $table->string('problem_image')->nullable();
            $table->date('service_date');
            $table->string('service_time_slot', 100);
            $table->string('service_address');
            $table->string('city', 100);
            $table->string('status', 50)->default('pending'); // pending, confirmed, en_route, in_progress, completed, cancelled
            $table->string('arrival_otp', 10);
            $table->unsignedInteger('base_price')->default(650);
            $table->unsignedInteger('total_price')->default(650);
            $table->string('payment_status', 50)->default('escrow_held'); // pending, escrow_held, released, refunded
            $table->string('payment_method', 50)->default('escrow');
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professional_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('bookings');
    }
};
