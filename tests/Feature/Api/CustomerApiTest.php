<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    private Profession $profession;

    private User $customer;

    private User $technicianUser;

    private Professional $professional;

    private Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            ['name' => 'Plumber', 'base_price' => 800, 'is_active' => true]
        );

        $this->customer = User::factory()->customer()->create([
            'name' => 'Sara Ahmed',
            'email' => 'sara.api.cust@example.com',
            'phone' => '+923001112233',
            'city' => 'Karachi',
        ]);

        $this->technicianUser = User::factory()->technician()->create([
            'name' => 'Tariq Mehmood',
            'email' => 'tariq.api@example.com',
            'phone' => '+923009998877',
            'is_verified' => true,
        ]);

        $this->professional = Professional::firstOrCreate(
            ['user_id' => $this->technicianUser->id],
            [
                'profession_id' => $this->profession->id,
                'name' => 'Tariq Mehmood',
                'email' => 'tariq.api@example.com',
                'phone' => '+923009998877',
                'experience' => '7 Years',
                'is_verified' => true,
                'verification_status' => 'verified',
            ]
        );

        $this->booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Kitchen Sink Joint Repair',
            'problem_description' => 'Water leaking heavily from P-trap',
            'service_date' => now()->addDay()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'House 12, Street 4, DHA Phase 6',
            'city' => 'Karachi',
            'status' => 'pending',
            'arrival_otp' => '4321',
            'base_price' => 800,
            'total_price' => 1200,
            'payment_status' => 'escrow_held',
            'payment_method' => 'escrow',
        ]);
    }

    public function test_customer_can_view_dashboard(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->getJson('/api/v1/customer/dashboard')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['user', 'stats', 'recent_bookings']]);
    }

    public function test_customer_can_list_bookings(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->getJson('/api/v1/customer/bookings')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.booking_number', $this->booking->booking_number);
    }

    public function test_customer_can_create_a_booking(): void
    {
        $response = $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/customer/bookings', [
                'profession_id' => $this->profession->id,
                'professional_id' => $this->professional->id,
                'service_title' => 'Geyser Thermostat Replacement',
                'service_date' => now()->addDays(2)->toDateString(),
                'service_time_slot' => 'Afternoon (12:00 PM - 3:00 PM)',
                'service_address' => 'House 55, Street 10, Clifton',
                'city' => 'Karachi',
                'problem_description' => 'Geyser water not heating.',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['booking' => ['booking_number'], 'arrival_otp']]);

        $this->assertDatabaseHas('bookings', [
            'service_title' => 'Geyser Thermostat Replacement',
            'user_id' => $this->customer->id,
        ]);
    }

    public function test_customer_can_show_cancel_and_track_a_booking(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->getJson("/api/v1/customer/bookings/{$this->booking->id}")
            ->assertOk()
            ->assertJsonPath('data.booking_number', $this->booking->booking_number);

        $this->actingAs($this->customer, 'sanctum')
            ->getJson("/api/v1/customer/bookings/{$this->booking->id}/tracking")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->customer, 'sanctum')
            ->postJson("/api/v1/customer/bookings/{$this->booking->id}/cancel", [
                'cancellation_reason' => 'Change of plans',
            ])
            ->assertOk()
            ->assertJsonPath('data.status', 'cancelled');

        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_customer_can_submit_a_review_for_completed_booking(): void
    {
        $this->booking->update(['status' => 'completed', 'completed_at' => now(), 'payment_status' => 'escrow_released']);

        $this->actingAs($this->customer, 'sanctum')
            ->postJson("/api/v1/customer/bookings/{$this->booking->id}/review", [
                'rating' => 5,
                'comment' => 'Excellent service, arrived on time and fixed the leak.',
            ])
            ->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.rating', 5);

        $this->assertDatabaseHas('reviews', [
            'booking_id' => $this->booking->id,
            'rating' => 5,
        ]);
    }

    public function test_customer_can_file_a_complaint(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/customer/complaints', [
                'subject' => 'Late arrival',
                'message' => 'The technician arrived two hours late without notice.',
            ])
            ->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('contact_inquiries', [
            'email' => $this->customer->email,
            'department' => 'escrow',
        ]);
    }

    public function test_customer_can_view_chat_threads_and_send_a_message(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->getJson('/api/v1/customer/chat/threads')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/customer/chat/messages', [
                'technician_id' => $this->professional->id,
                'booking_id' => $this->booking->id,
                'message' => 'Assalam o Alaikum, are you available tomorrow?',
            ])
            ->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->customer->id,
            'receiver_id' => $this->technicianUser->id,
        ]);
    }

    public function test_customer_can_manage_notifications(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->getJson('/api/v1/customer/notifications')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/customer/notifications/read-all')
            ->assertOk()
            ->assertJsonPath('data.unread_count', 0);
    }

    public function test_customer_can_view_and_update_profile(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->getJson('/api/v1/customer/profile')
            ->assertOk()
            ->assertJsonPath('data.email', $this->customer->email);

        $this->actingAs($this->customer, 'sanctum')
            ->putJson('/api/v1/customer/profile', [
                'name' => 'Sara A. Ahmed',
                'email' => $this->customer->email,
                'phone' => '+923001112233',
                'city' => 'Lahore',
            ])
            ->assertOk()
            ->assertJsonPath('data.city', 'Lahore');
    }

    public function test_customer_can_update_password(): void
    {
        $this->actingAs($this->customer, 'sanctum');
        $this->actingAs($this->customer, 'web');

        $this->postJson('/api/v1/customer/password', [
            'current_password' => 'password',
            'password' => 'newsecretpass123',
            'password_confirmation' => 'newsecretpass123',
        ])
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_customer_can_run_ai_diagnosis(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/customer/ai/diagnose', [
                'issue' => 'water is leaking from the kitchen pipe under the sink',
            ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_recognized', true);
    }

    public function test_customer_can_view_upgrade_and_cancel_vip_subscription(): void
    {
        // 1. Initial subscription status
        $this->actingAs($this->customer, 'sanctum')
            ->getJson('/api/v1/customer/subscription')
            ->assertOk()
            ->assertJsonPath('data.current_subscription.is_vip', false)
            ->assertJsonPath('data.current_subscription.plan', 'free');

        // 2. Upgrade to VIP
        $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/customer/subscription/upgrade', [
                'plan_name' => 'vip_monthly',
                'payment_method' => 'jazzcash',
            ])
            ->assertStatus(201)
            ->assertJsonPath('data.subscription.is_vip', true)
            ->assertJsonPath('data.subscription.plan_name', 'vip_monthly');

        $this->customer->refresh();
        $this->assertTrue($this->customer->isVip());
        $this->assertEquals('vip_monthly', $this->customer->subscription_plan);

        // 3. Cancel VIP subscription
        $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/customer/subscription/cancel')
            ->assertOk()
            ->assertJsonPath('data.is_vip', false)
            ->assertJsonPath('data.subscription_plan', 'free');

        $this->customer->refresh();
        $this->assertFalse($this->customer->isVip());
        $this->assertEquals('free', $this->customer->subscription_plan);
    }

    public function test_customer_cannot_access_another_customers_booking(): void
    {
        $other = User::factory()->customer()->create();

        $this->actingAs($other, 'sanctum')
            ->getJson("/api/v1/customer/bookings/{$this->booking->id}")
            ->assertStatus(403);
    }
}
