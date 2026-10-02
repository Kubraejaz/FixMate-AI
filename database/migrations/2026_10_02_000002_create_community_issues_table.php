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
        Schema::create('community_issues', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reporter_name');
            $table->string('reporter_role')->default('Resident');
            $table->string('reporter_phone')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('category')->default('general');
            $table->string('city')->default('Karachi');
            $table->string('location');
            $table->string('status')->default('reported'); // reported, in_progress, alert_active, scheduled, resolved
            $table->string('status_update')->nullable(); // e.g. "Rapid Response Squad Dispatched"
            $table->string('priority')->default('normal'); // normal, high, critical
            $table->unsignedInteger('upvotes_count')->default(0);
            $table->boolean('is_approved')->default(true);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('community_issue_upvotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_issue_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45);
            $table->timestamps();

            $table->unique(['community_issue_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_issue_upvotes');
        Schema::dropIfExists('community_issues');
    }
};
