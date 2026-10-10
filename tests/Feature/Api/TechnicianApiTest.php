<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TechnicianApiTest extends TestCase
{
    use RefreshDatabase;

    private Profession $profession;

    private User $technicianUser;

    private Professional $professional;

    private User $customer;

    private Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            ['name' => 'Plumber', 'base_price' => 800, 'is_active' => true]
        );

        $this->technicianUser = User::factory()->technician()->create([
            'name' => 'Tariq Mehmood',
            'email' => 'tariq.tech.api@example.com',
            'phone' => '+923009998877',
            'city' => 'Karachi',
            'profession_id' => $this->profession->id,
            'is_verified' => true,
        ]);

        $this->professional = Professional::firstOrCreate(
            ['user_id' => $this->technicianUser->id],
            [
                'profession_id' => $this->profession->id,
                'name' => 'Tariq Mehmood',
                'email' => 'tariq.tech.api@example.com',
                'phone' => '+923009998877',
                'experience' => '7 Years',
                'is_verified' => true,
                'verification_status' => 'verified',
            ]
        );

        $this->customer = User::factory()->customer()->create([
            'name' => 'Sara Ahmed',
            'email' => 'sara.tech.api@example.com',
            'phone' => '+923001112233',
            'city' => 'Karachi',
        ]);

        $this->booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $this->customer->id,
            'professional_id' => null,
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

    public function test_technician_can_view_dashboard_and_jobs(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/dashboard')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['user', 'professional', 'stats']]);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/jobs')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data', 'meta' => ['counts']]);
    }

    public function test_technician_can_show_a_job(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson("/api/v1/technician/jobs/{$this->booking->id}")
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.booking.booking_number', $this->booking->booking_number)
            ->assertJsonPath('data.tech_payout', 1080);
    }

    public function test_technician_can_accept_start_verify_and_complete_a_job(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson("/api/v1/technician/jobs/{$this->booking->id}/accept")
            ->assertOk()
            ->assertJsonPath('data.status', 'confirmed');

        $this->booking->refresh();
        $this->assertSame($this->professional->id, $this->booking->professional_id);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson("/api/v1/technician/jobs/{$this->booking->id}/start-route")
            ->assertOk()
            ->assertJsonPath('data.status', 'en_route');

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson("/api/v1/technician/jobs/{$this->booking->id}/verify-otp", ['otp' => '4321'])
            ->assertOk()
            ->assertJsonPath('data.status', 'in_progress');

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson("/api/v1/technician/jobs/{$this->booking->id}/complete")
            ->assertOk()
            ->assertJsonPath('data.payout', 1080)
            ->assertJsonPath('data.booking.status', 'completed');

        $this->booking->refresh();
        $this->assertSame('escrow_released', $this->booking->payment_status);
    }

    public function test_technician_verify_otp_rejects_invalid_code(): void
    {
        $this->booking->update(['professional_id' => $this->professional->id, 'status' => 'en_route']);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson("/api/v1/technician/jobs/{$this->booking->id}/verify-otp", ['otp' => '0000'])
            ->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_technician_can_view_earnings_and_schedule(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/earnings')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['summary', 'transactions']]);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/schedule')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['upcoming_jobs', 'count']]);
    }

    public function test_technician_can_view_and_update_skills(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/skills')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson('/api/v1/technician/skills', [
                'profession_id' => $this->profession->id,
                'experience' => '10 Years Master Craftsman',
                'sub_categories' => ['Pipe Leakage & Repair', 'Water Tank Cleaning'],
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->professional->refresh();
        $this->assertSame('10 Years Master Craftsman', $this->professional->experience);
        $this->assertSame(['Pipe Leakage & Repair', 'Water Tank Cleaning'], $this->professional->sub_categories);
    }

    public function test_technician_can_view_and_update_profile(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/profile')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->putJson('/api/v1/technician/profile', [
                'name' => 'Tariq Mehmood Pro',
                'phone' => '+923009998877',
                'city' => 'Lahore',
                'area' => 'DHA Phase 5',
                'experience' => '12 Years',
                'description' => 'Certified Master Plumber specializing in residential piping systems.',
            ])
            ->assertOk()
            ->assertJsonPath('data.user.city', 'Lahore');
    }

    public function test_technician_can_view_and_reply_to_reviews(): void
    {
        $review = Review::create([
            'booking_id' => $this->booking->id,
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'rating' => 5,
            'comment' => 'Tariq arrived right on time and fixed the leaking sink pipe expertly.',
            'is_approved' => true,
        ]);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/reviews')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson("/api/v1/technician/reviews/{$review->id}/reply", [
                'reply' => 'Thank you Sara! Always happy to help.',
            ])
            ->assertOk()
            ->assertJsonPath('data.technician_reply', 'Thank you Sara! Always happy to help.');
    }

    public function test_technician_can_chat_with_customers(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/chat/threads')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson("/api/v1/technician/chat/{$this->customer->id}/messages")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson('/api/v1/technician/chat/messages', [
                'receiver_id' => $this->customer->id,
                'booking_id' => $this->booking->id,
                'message' => 'Assalam o Alaikum, I will arrive at 10 AM.',
            ])
            ->assertStatus(201)
            ->assertJsonPath('success', true);
    }

    public function test_technician_can_view_notifications(): void
    {
        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/notifications')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data', 'meta' => ['unread_count']]);
    }

    public function test_technician_can_view_and_submit_verification(): void
    {
        Storage::fake('public');

        $this->actingAs($this->technicianUser, 'sanctum')
            ->getJson('/api/v1/technician/verification')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson('/api/v1/technician/verification', [
                'cnic_number' => '42201-9876543-1',
                'experience' => '8 Years Master Plumber',
                'city' => 'Karachi',
                'emergency_contact_name' => 'Tariq Khan',
                'emergency_contact_phone' => '0300-9998877',
                'biometric_selfie' => UploadedFile::fake()->create('selfie.jpg', 100, 'image/jpeg'),
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->professional->refresh();
        $this->assertSame('under_review', $this->professional->verification_status);
    }

    public function test_technician_under_review_is_blocked_from_dashboard(): void
    {
        $user = User::factory()->technician()->create([
            'profession_id' => $this->profession->id,
            'is_verified' => false,
        ]);

        Professional::create([
            'user_id' => $user->id,
            'profession_id' => $this->profession->id,
            'name' => $user->name,
            'is_verified' => false,
            'verification_status' => 'under_review',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/technician/dashboard')
            ->assertStatus(403)
            ->assertJsonPath('success', false)
            ->assertJsonPath('verification_status', 'under_review');
    }

    public function test_customer_cannot_access_technician_endpoints(): void
    {
        $this->actingAs($this->customer, 'sanctum')
            ->getJson('/api/v1/technician/dashboard')
            ->assertStatus(403)
            ->assertJsonPath('success', false);
    }
}
