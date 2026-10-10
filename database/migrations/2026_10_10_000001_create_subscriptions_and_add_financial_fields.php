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
        Schema::table('professionals', function (Blueprint $table) {
            if (! Schema::hasColumn('professionals', 'subscription_plan')) {
                $table->string('subscription_plan', 50)->default('free')->after('is_verified');
            }
            if (! Schema::hasColumn('professionals', 'subscribed_until')) {
                $table->dateTime('subscribed_until')->nullable()->after('subscription_plan');
            }
            if (! Schema::hasColumn('professionals', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('subscribed_until');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('bookings', 'platform_fee')) {
                $table->unsignedInteger('platform_fee')->default(0)->after('total_price');
            }
            if (! Schema::hasColumn('bookings', 'technician_payout')) {
                $table->unsignedInteger('technician_payout')->default(0)->after('platform_fee');
            }
            if (! Schema::hasColumn('bookings', 'commission_rate')) {
                $table->decimal('commission_rate', 5, 2)->default(10.00)->after('technician_payout');
            }
        });

        if (! Schema::hasTable('technician_subscriptions')) {
            Schema::create('technician_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('professional_id')->constrained('professionals')->cascadeOnDelete();
                $table->string('plan_name', 50); // pro_monthly, pro_annual
                $table->unsignedInteger('price');
                $table->string('payment_method', 50)->default('wallet'); // wallet, jazzcash, easypaisa, card
                $table->string('transaction_reference', 100)->unique();
                $table->string('status', 30)->default('active'); // active, expired, cancelled
                $table->dateTime('starts_at')->nullable();
                $table->dateTime('expires_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_subscriptions');

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'platform_fee')) {
                $table->dropColumn(['platform_fee', 'technician_payout', 'commission_rate']);
            }
        });

        Schema::table('professionals', function (Blueprint $table) {
            if (Schema::hasColumn('professionals', 'subscription_plan')) {
                $table->dropColumn(['subscription_plan', 'subscribed_until', 'is_featured']);
            }
        });
    }
};
