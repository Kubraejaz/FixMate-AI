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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'subscription_plan')) {
                $table->string('subscription_plan', 50)->default('free')->after('is_active');
            }
            if (! Schema::hasColumn('users', 'subscribed_until')) {
                $table->dateTime('subscribed_until')->nullable()->after('subscription_plan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'subscription_plan')) {
                $table->dropColumn(['subscription_plan', 'subscribed_until']);
            }
        });
    }
};
