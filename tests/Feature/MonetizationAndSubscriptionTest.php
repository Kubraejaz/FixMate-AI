<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianSubscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonetizationAndSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $techUser;

    private Professional $professional;

    private User $customer;

    private Profession $profession;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'electrician'],
            ['name' => 'Electrician', 'base_price' => 1000, 'is_active' => true]
        );

        $this->techUser = User::factory()->technician()->create([
            'profession_id' => $this->profession->id,
            'is_verified' => true,
        ]);

        $this->professional = Professional::create([
            'user_id' => $this->techUser->id,
            'profession_id' => $this->profession->id,
            'name' => $this->techUser->name,
            'is_verified' => true,
            'verification_status' => 'verified',
            'subscription_plan' => 'free',
        ]);

        $this->customer = User::factory()->customer()->create();
    }

    public function test_phase1_standard_technician_pays_platform_commission(): void
    {
        cache()->forever('platform_commission', 10.0);

        $booking = Booking::create([
            'booking_number' => 'FM-MON-001',
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Wiring Repair',
            'service_date' => now()->toDateString(),
            'service_time_slot' => '10:00 AM - 12:00 PM',
            'service_address' => 'House 12, Street 4, Lahore',
            'city' => 'Lahore',
            'arrival_otp' => '1234',
            'base_price' => 2000,
            'total_price' => 2000,
            'status' => 'confirmed',
        ]);

        $booking->calculateFinancials($this->professional);

        $this->assertEquals(10.0, $booking->commission_rate);
        $this->assertEquals(200, $booking->platform_fee); // 10% of 2000
        $this->assertEquals(1800, $booking->technician_payout); // 90% of 2000
    }

    public function test_phase1_admin_can_update_commission_and_subscription_pricing(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/settings', [
                'platform_commission' => 15.0,
                'subscription_monthly_price' => 600,
                'subscription_annual_price' => 5999,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertEquals(15.0, (float) cache('platform_commission'));
        $this->assertEquals(600, (int) cache('subscription_monthly_price'));
        $this->assertEquals(5999, (int) cache('subscription_annual_price'));
    }

    public function test_phase2_technician_can_view_and_upgrade_to_pro_vip_subscription(): void
    {
        cache()->forever('platform_commission', 10.0);
        cache()->forever('subscription_monthly_price', 500);

        // 1. View subscription status
        $this->actingAs($this->techUser, 'sanctum')
            ->getJson('/api/v1/technician/subscription')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.current_subscription.is_pro', false)
            ->assertJsonPath('data.current_subscription.commission_rate', 10);

        // 2. Upgrade to Pro Monthly
        $response = $this->actingAs($this->techUser, 'sanctum')
            ->postJson('/api/v1/technician/subscription/upgrade', [
                'plan_name' => 'pro_monthly',
                'payment_method' => 'wallet',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.technician.is_pro', true)
            ->assertJsonPath('data.technician.commission_rate', 0);

        $this->professional->refresh();
        $this->assertTrue($this->professional->isPro());
        $this->assertEquals('pro_monthly', $this->professional->subscription_plan);
        $this->assertTrue($this->professional->is_featured);
        $this->assertNotNull($this->professional->subscribed_until);
        $this->assertTrue($this->professional->subscribed_until->isFuture());

        // Check subscription record exists
        $this->assertDatabaseHas('technician_subscriptions', [
            'professional_id' => $this->professional->id,
            'plan_name' => 'pro_monthly',
            'status' => 'active',
        ]);
    }

    public function test_phase2_pro_technician_enjoys_zero_percent_commission_on_completed_jobs(): void
    {
        cache()->forever('platform_commission', 10.0);

        // Give technician active Pro VIP status
        $this->professional->update([
            'subscription_plan' => 'pro_monthly',
            'subscribed_until' => now()->addDays(30),
            'is_featured' => true,
        ]);

        $booking = Booking::create([
            'booking_number' => 'FM-PRO-999',
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Generator Overhaul',
            'service_date' => now()->toDateString(),
            'service_time_slot' => '02:00 PM - 04:00 PM',
            'service_address' => 'Phase 6 DHA, Lahore',
            'city' => 'Lahore',
            'arrival_otp' => '4321',
            'base_price' => 5000,
            'total_price' => 5000,
            'status' => 'in_progress',
        ]);

        // Complete job via API
        $this->actingAs($this->techUser, 'sanctum')
            ->postJson("/api/v1/technician/jobs/{$booking->id}/complete")
            ->assertOk()
            ->assertJsonPath('data.payout', 5000) // 100% payout! (0% commission)
            ->assertJsonPath('data.platform_fee', 0)
            ->assertJsonPath('data.is_pro', true);

        $booking->refresh();
        $this->assertEquals(0, $booking->platform_fee);
        $this->assertEquals(5000, $booking->technician_payout);
    }

    public function test_phase2_admin_tracks_subscription_revenue_and_active_subscribers(): void
    {
        // Create an active subscription
        TechnicianSubscription::create([
            'professional_id' => $this->professional->id,
            'plan_name' => 'pro_monthly',
            'price' => 500,
            'payment_method' => 'easypaisa',
            'transaction_reference' => 'SUB-TEST-1234',
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        $this->professional->update([
            'subscription_plan' => 'pro_monthly',
            'subscribed_until' => now()->addDays(30),
        ]);

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/payments')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.summary.subscription_revenue', 500)
            ->assertJsonPath('data.summary.active_subscribers_count', 1);
    }

    public function test_phase2_technician_can_upgrade_via_web_portal_route(): void
    {
        $response = $this->actingAs($this->techUser)
            ->post(route('technician.subscription.upgrade'), [
                'plan_name' => 'pro_monthly',
                'payment_method' => 'wallet',
            ]);

        $response->assertRedirect();
        $this->professional->refresh();
        $this->assertTrue($this->professional->isPro());
        $this->assertEquals('pro_monthly', $this->professional->subscription_plan);

        // Check dashboard view renders the Pro VIP status
        $dashResponse = $this->actingAs($this->techUser)
            ->get(route('technician.dashboard'));

        $dashResponse->assertOk();
        $dashResponse->assertSee('FixMate Pro VIP Partner (Active)');
        $dashResponse->assertSee('0% Fee Active');
    }

    public function test_phase2_customer_can_upgrade_to_vip_home_care_pass_via_web(): void
    {
        // 1. Initial dashboard shows upgrade banner
        $initialDash = $this->actingAs($this->customer)
            ->get(route('customer.dashboard'));

        $initialDash->assertOk();
        $initialDash->assertSee('FixMate Home Care VIP Pass');
        $initialDash->assertSee('Rs. 299');

        // 2. Customer upgrades to VIP monthly
        $upgradeResponse = $this->actingAs($this->customer)
            ->post(route('customer.subscription.upgrade'), [
                'plan_name' => 'vip_monthly',
                'payment_method' => 'jazzcash',
                'account_number' => '03001234567',
                'mpin' => '1234',
            ]);

        $upgradeResponse->assertRedirect();
        $this->customer->refresh();

        $this->assertTrue($this->customer->isVip());
        $this->assertEquals('vip_monthly', $this->customer->subscription_plan);
        $this->assertNotNull($this->customer->subscribed_until);
        $this->assertTrue($this->customer->subscribed_until->isFuture());

        // 3. Customer dashboard now shows active VIP badge
        $vipDash = $this->actingAs($this->customer)
            ->get(route('customer.dashboard'));

        $vipDash->assertOk();
        $vipDash->assertSee('FixMate Home Care VIP Member (Active)');
        $vipDash->assertSee('0% Convenience Fee Active');
    }

    public function test_phase2_technician_can_cancel_subscription(): void
    {
        $this->professional->update([
            'subscription_plan' => 'pro_monthly',
            'subscribed_until' => now()->addDays(30),
            'is_featured' => true,
        ]);

        $this->actingAs($this->techUser, 'sanctum')
            ->postJson('/api/v1/technician/subscription/cancel')
            ->assertOk()
            ->assertJsonPath('data.is_pro', false)
            ->assertJsonPath('data.subscription_plan', 'free');

        $this->professional->refresh();
        $this->assertFalse($this->professional->isPro());
        $this->assertEquals('free', $this->professional->subscription_plan);
    }

    public function test_phase2_technician_can_view_subscription_checkout_page(): void
    {
        $response = $this->actingAs($this->techUser)
            ->get(route('technician.subscription.checkout', ['plan' => 'pro_annual']));

        $response->assertOk();
        $response->assertSee('FixMate Pro VIP Partner Checkout');
        $response->assertSee('Annual VIP Pass');
        $response->assertSee('Deduct from FixMate Wallet Balance');
        $response->assertSee('JazzCash Mobile Account');
        $response->assertSee('EasyPaisa Mobile Account');
        $response->assertSee('Debit / Credit Card');
    }

    public function test_phase2_technician_can_upgrade_with_jazzcash_verified_payment(): void
    {
        $response = $this->actingAs($this->techUser)
            ->post(route('technician.subscription.upgrade'), [
                'plan_name' => 'pro_monthly',
                'payment_method' => 'jazzcash',
                'jazzcash_mobile' => '03001234567',
                'jazzcash_mpin' => '1234',
            ]);

        $response->assertRedirect(route('technician.dashboard'));
        $this->professional->refresh();
        $this->assertTrue($this->professional->isPro());
        $this->assertEquals('pro_monthly', $this->professional->subscription_plan);

        $this->assertDatabaseHas('technician_subscriptions', [
            'professional_id' => $this->professional->id,
            'plan_name' => 'pro_monthly',
            'payment_method' => 'jazzcash',
            'status' => 'active',
        ]);
    }

    public function test_phase2_technician_can_upgrade_with_card_verified_payment(): void
    {
        $response = $this->actingAs($this->techUser)
            ->post(route('technician.subscription.upgrade'), [
                'plan_name' => 'pro_annual',
                'payment_method' => 'card',
                'card_name' => 'AHMED KHAN',
                'card_number' => '4242424242424242',
                'card_expiry' => '12/28',
                'card_cvc' => '123',
            ]);

        $response->assertRedirect(route('technician.dashboard'));
        $this->professional->refresh();
        $this->assertTrue($this->professional->isPro());
        $this->assertEquals('pro_annual', $this->professional->subscription_plan);

        $this->assertDatabaseHas('technician_subscriptions', [
            'professional_id' => $this->professional->id,
            'plan_name' => 'pro_annual',
            'payment_method' => 'card',
            'status' => 'active',
        ]);
    }

    public function test_phase2_technician_subscription_fails_without_required_payment_credentials(): void
    {
        // Missing jazzcash_mobile when method is jazzcash
        $response = $this->actingAs($this->techUser)
            ->post(route('technician.subscription.upgrade'), [
                'plan_name' => 'pro_monthly',
                'payment_method' => 'jazzcash',
            ]);

        $response->assertSessionHasErrors(['jazzcash_mobile']);
        $this->professional->refresh();
        $this->assertFalse($this->professional->isPro());

        // Missing card details when method is card
        $cardResponse = $this->actingAs($this->techUser)
            ->post(route('technician.subscription.upgrade'), [
                'plan_name' => 'pro_monthly',
                'payment_method' => 'card',
            ]);

        $cardResponse->assertSessionHasErrors(['card_name', 'card_number', 'card_expiry', 'card_cvc']);
        $this->professional->refresh();
        $this->assertFalse($this->professional->isPro());
    }

    public function test_technician_can_verify_jazzcash_gateway_push_prompt(): void
    {
        $response = $this->actingAs($this->techUser)
            ->postJson(route('technician.subscription.verify-gateway'), [
                'gateway' => 'jazzcash',
                'phone' => '03001234567',
                'amount' => 500,
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('gateway', 'jazzcash')
            ->assertJsonPath('phone', '03001234567')
            ->assertJsonPath('prompt_dispatched', true);

        $this->assertNotEmpty($response->json('reference_id'));
    }

    public function test_technician_can_verify_easypaisa_gateway_push_prompt(): void
    {
        $response = $this->actingAs($this->techUser)
            ->postJson(route('technician.subscription.verify-gateway'), [
                'gateway' => 'easypaisa',
                'phone' => '03451234567',
                'amount' => 500,
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('gateway', 'easypaisa')
            ->assertJsonPath('phone', '03451234567')
            ->assertJsonPath('prompt_dispatched', true);

        $this->assertNotEmpty($response->json('reference_id'));
    }

    public function test_gateway_verification_rejects_invalid_phone(): void
    {
        $response = $this->actingAs($this->techUser)
            ->postJson(route('technician.subscription.verify-gateway'), [
                'gateway' => 'jazzcash',
                'phone' => '12345',
                'amount' => 500,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_customer_can_process_escrow_payment_via_jazzcash(): void
    {
        $booking = Booking::create([
            'booking_number' => 'FM-JC-001',
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Electrical Fitting',
            'service_date' => now()->toDateString(),
            'service_time_slot' => '02:00 PM - 04:00 PM',
            'service_address' => 'House 45, DHA Phase 5, Lahore',
            'city' => 'Lahore',
            'arrival_otp' => '9988',
            'base_price' => 1500,
            'total_price' => 1500,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->customer)
            ->post(route('customer.payment.process', $booking->id), [
                'payment_method' => 'jazzcash',
                'account_number' => '03001234567',
            ]);

        $response->assertRedirect(route('customer.booking.confirm', $booking->id));
        $booking->refresh();
        $this->assertEquals('jazzcash', $booking->payment_method);
        $this->assertEquals('escrow_held', $booking->payment_status);
    }

    public function test_customer_can_process_escrow_payment_via_easypaisa(): void
    {
        $booking = Booking::create([
            'booking_number' => 'FM-EP-001',
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'AC Servicing',
            'service_date' => now()->toDateString(),
            'service_time_slot' => '11:00 AM - 01:00 PM',
            'service_address' => 'Apartment 3B, Gulberg, Lahore',
            'city' => 'Lahore',
            'arrival_otp' => '4455',
            'base_price' => 2500,
            'total_price' => 2500,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->customer)
            ->post(route('customer.payment.process', $booking->id), [
                'payment_method' => 'easypaisa',
                'account_number' => '03451234567',
            ]);

        $response->assertRedirect(route('customer.booking.confirm', $booking->id));
        $booking->refresh();
        $this->assertEquals('easypaisa', $booking->payment_method);
        $this->assertEquals('escrow_held', $booking->payment_status);
    }

    public function test_technician_upgrade_fails_with_invalid_random_otp_and_succeeds_with_correct_otp(): void
    {
        // 1. Request OTP via verify-gateway
        $verifyRes = $this->actingAs($this->techUser)
            ->postJson(route('technician.subscription.verify-gateway'), [
                'gateway' => 'jazzcash',
                'phone' => '03001234567',
                'amount' => 500,
            ]);

        $verifyRes->assertOk();
        $realOtp = $verifyRes->json('otp');
        $this->assertNotEmpty($realOtp);

        // 2. Try submitting a completely random incorrect OTP
        $wrongResponse = $this->actingAs($this->techUser)
            ->post(route('technician.subscription.upgrade'), [
                'plan_name' => 'pro_monthly',
                'payment_method' => 'jazzcash',
                'jazzcash_mobile' => '03001234567',
                'jazzcash_mpin' => '999999', // random wrong number
            ]);

        // Must fail and redirect back with session error
        $wrongResponse->assertSessionHas('error');
        $this->professional->refresh();
        $this->assertFalse($this->professional->isPro());

        // 3. Submit with the exact real generated OTP
        $correctResponse = $this->actingAs($this->techUser)
            ->post(route('technician.subscription.upgrade'), [
                'plan_name' => 'pro_monthly',
                'payment_method' => 'jazzcash',
                'jazzcash_mobile' => '03001234567',
                'jazzcash_mpin' => $realOtp,
            ]);

        $correctResponse->assertRedirect(route('technician.dashboard'));
        $this->professional->refresh();
        $this->assertTrue($this->professional->isPro());
    }
}
