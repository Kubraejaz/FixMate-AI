<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use App\Models\VideoMeeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoMeetingApiTest extends TestCase
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
            'email' => 'sara.video@example.com',
            'city' => 'Karachi',
        ]);

        $this->technicianUser = User::factory()->technician()->create([
            'name' => 'Tariq Mehmood',
            'email' => 'tariq.video@example.com',
            'is_verified' => true,
        ]);

        $this->professional = Professional::create([
            'user_id' => $this->technicianUser->id,
            'profession_id' => $this->profession->id,
            'name' => 'Tariq Mehmood',
            'email' => $this->technicianUser->email,
            'phone' => '+923009998877',
            'is_verified' => true,
            'verification_status' => 'verified',
        ]);

        $this->booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Kitchen Sink Joint Repair',
            'service_date' => now()->addDay()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'House 12, Street 4, DHA Phase 6',
            'city' => 'Karachi',
            'status' => 'confirmed',
            'arrival_otp' => '4321',
            'base_price' => 800,
            'total_price' => 1200,
            'payment_status' => 'escrow_held',
            'payment_method' => 'escrow',
        ]);
    }

    public function test_customer_can_initiate_a_video_meeting(): void
    {
        $response = $this->actingAs($this->customer, 'sanctum')
            ->postJson('/api/v1/video-meetings', [
                'booking_id' => $this->booking->id,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['meeting' => ['meeting_code'], 'meeting_code', 'room_url', 'receiver_name']]);

        $this->assertDatabaseHas('video_meetings', [
            'caller_id' => $this->customer->id,
            'receiver_id' => $this->technicianUser->id,
        ]);
    }

    public function test_participant_can_view_status_and_end_meeting(): void
    {
        $meeting = VideoMeeting::create([
            'meeting_code' => 'FM-TALK-TEST1234',
            'booking_id' => $this->booking->id,
            'caller_id' => $this->customer->id,
            'receiver_id' => $this->technicianUser->id,
            'status' => 'initiated',
            'started_at' => now(),
        ]);

        $this->actingAs($this->customer, 'sanctum')
            ->getJson("/api/v1/video-meetings/{$meeting->meeting_code}")
            ->assertOk()
            ->assertJsonPath('data.meeting_code', $meeting->meeting_code);

        $this->actingAs($this->technicianUser, 'sanctum')
            ->postJson("/api/v1/video-meetings/{$meeting->meeting_code}/join")
            ->assertOk()
            ->assertJsonPath('data.meeting.status', 'connected');

        $this->actingAs($this->customer, 'sanctum')
            ->postJson("/api/v1/video-meetings/{$meeting->meeting_code}/end")
            ->assertOk()
            ->assertJsonPath('data.status', 'ended');
    }

    public function test_non_participant_cannot_access_meeting(): void
    {
        $stranger = User::factory()->customer()->create();

        $meeting = VideoMeeting::create([
            'meeting_code' => 'FM-TALK-PRIVATE1',
            'booking_id' => null,
            'caller_id' => $this->customer->id,
            'receiver_id' => $this->technicianUser->id,
            'status' => 'initiated',
            'started_at' => now(),
        ]);

        $this->actingAs($stranger, 'sanctum')
            ->getJson("/api/v1/video-meetings/{$meeting->meeting_code}")
            ->assertStatus(403);
    }
}
