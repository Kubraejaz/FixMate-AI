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
        Schema::create('technician_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('profession_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('cnic_number');
            $table->string('city')->default('Karachi');
            $table->integer('experience_years')->default(1);
            $table->string('workshop_type')->default('freelancer'); // freelancer, independent_workshop, company_employed
            $table->string('tools_available')->default('has_own_tools'); // has_own_tools, basic_tools, needs_tool_support
            $table->string('documents_list')->default('CNIC, Police Certificate');
            $table->string('status')->default('pending'); // pending, under_review, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_applications');
    }
};
