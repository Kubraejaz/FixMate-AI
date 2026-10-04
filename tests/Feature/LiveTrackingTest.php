<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LiveTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected User $technicianUser;
    protected Professional $professional;
    protected Profession $profession;
    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'user_type' => User::TYPE_CUSTOMER,
            'name' => 'Ayesha Khan',
            'phone' => '+923001234567',
        ]);

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            [
                'name' => 'Plumbing Specialist',
                'icon' => 'wrench',
                'description' => 'Fix leaking pipes and sanitation',
                'base_price' => 750,
                'is_active' => true,
            ]
        );

        $this->technicianUser = User::factory()->create([
            'user_type' => User::TYPE_TECHNICIAN,
            'name' => 'Ali Khan',
            'phone' => '+923119876543',
        ]);

        $this->professional = Professional::create([
            'user_id' => $this->technicianUser->id,
            'profession_id' => $this->profession->id,
            'name' => 'Ali Khan',
            'phone' => '+923119876543',
            'email' => 'ali.tech@example.com',
            'city' => 'Karachi',
            'rating' => 4.9,
            'is_verified' => true,
        ]);

        $this->booking = Booking::create([
            'booking_number' => 'FM-88991',
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Emergency Kitchen Pipe Leak',
            'service_date' => now()->toDateString(),
            'service_time_slot' => '10:00 AM - 12:00 PM',
            'service_address' => 'House 42, Block 6, PECHS',
            'city' => 'Karachi',
            'status' => 'en_route',
            'arrival_otp' => '4491',
            'base_price' => 750,
            'total_price' => 1200,
            'destination_latitude' => 24.8716,
            'destination_longitude' => 67.0599,
            'technician_latitude' => 24.8530,
            'technician_longitude' => 67.0250,
        ]);
    }

    public function test_customer_can_view_tracking_page_with_leaflet_map(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('customer.booking.tracking', $this->booking->id));

        $response->assertStatus(200);
        $response->assertSee('liveTrackingMap');
        $response->assertSee('LIVE GPS STREAMING');
        $response->assertSee('Booking #FM-88991');
        $response->assertSee('4491'); // Arrival OTP
    }

    public function test_customer_can_poll_live_tracking_coordinates_json(): void
    {
        $response = $this->actingAs($this->customer)
            ->getJson(route('customer.booking.tracking-data', $this->booking->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'booking_id',
            'booking_number',
            'status',
            'technician' => ['name', 'lat', 'lng', 'phone', 'rating', 'updated_at'],
            'destination' => ['address', 'city', 'lat', 'lng'],
            'distance_km',
            'eta_minutes',
            'arrival_otp',
            'is_arrived',
        ]);

        $data = $response->json();
        $this->assertEquals('Ali Khan', $data['technician']['name']);
        $this->assertGreaterThan(0, $data['distance_km']);
        $this->assertGreaterThan(0, $data['eta_minutes']);
    }

    public function test_technician_can_broadcast_live_gps_coordinates(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->postJson(route('technician.active-job.location', $this->booking->id), [
                'latitude' => 24.8620,
                'longitude' => 67.0450,
                'eta_minutes' => 8,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->booking->refresh();
        $this->assertEquals(24.8620, (float) $this->booking->technician_latitude);
        $this->assertEquals(67.0450, (float) $this->booking->technician_longitude);
        $this->assertEquals(8, $this->booking->tracking_eta_minutes);
        $this->assertNotNull($this->booking->location_updated_at);
    }

    public function test_technician_can_simulate_movement_step(): void
    {
        $initialDist = $this->booking->getLiveTrackingPayload()['distance_km'];

        $response = $this->actingAs($this->technicianUser)
            ->postJson(route('technician.active-job.simulate-step', $this->booking->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->booking->refresh();
        $newDist = $this->booking->getLiveTrackingPayload()['distance_km'];

        // Simulated movement must bring technician closer to customer destination
        $this->assertLessThan($initialDist, $newDist);
    }

    public function test_unauthorized_user_cannot_access_tracking_data(): void
    {
        $otherCustomer = User::factory()->create([
            'user_type' => User::TYPE_CUSTOMER,
        ]);

        $response = $this->actingAs($otherCustomer)
            ->getJson(route('customer.booking.tracking-data', $this->booking->id));

        $response->assertStatus(403);
    }
}
