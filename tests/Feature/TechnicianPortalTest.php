<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TechnicianPortalTest extends TestCase
{
    use RefreshDatabase;

    private User $technicianUser;
    private Professional $professional;
    private User $customerUser;
    private Profession $profession;
    private Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            ['name' => 'Plumber', 'base_price' => 800, 'is_active' => true]
        );

        $this->technicianUser = User::factory()->create([
            'role' => 'technician',
            'user_type' => User::TYPE_TECHNICIAN,
            'name' => 'Tariq Mehmood',
            'email' => 'tariq.tech@example.com',
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
                'email' => 'tariq.tech@example.com',
                'phone' => '+923009998877',
                'experience' => '7 Years',
                'is_verified' => true,
            ]
        );

        $this->customerUser = User::factory()->create([
            'role' => 'customer',
            'user_type' => User::TYPE_CUSTOMER,
            'name' => 'Sara Ahmed',
            'email' => 'sara.cust@example.com',
            'phone' => '+923001112233',
            'city' => 'Karachi',
        ]);

        $this->booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $this->customerUser->id,
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

    public function test_technician_can_view_dynamic_dashboard(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.dashboard'));

        $response->assertOk();
        $response->assertSee('Tariq');
        $response->assertSee('Plumber');
        $response->assertSee('Kitchen Sink Joint Repair');
        $response->assertSee($this->booking->booking_number);
    }

    public function test_technician_can_view_jobs_list_with_tabs_and_search(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.jobs'));

        $response->assertOk();
        $response->assertSee($this->booking->booking_number);
        $response->assertSee('Kitchen Sink Joint Repair');

        // Test search filter
        $searchResponse = $this->actingAs($this->technicianUser)
            ->get(route('technician.jobs', ['q' => $this->booking->booking_number]));

        $searchResponse->assertOk();
        $searchResponse->assertSee($this->booking->booking_number);
    }

    public function test_technician_can_view_single_job_details(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.jobs.details', $this->booking->booking_number));

        $response->assertOk();
        $response->assertSee($this->booking->booking_number);
        $response->assertSee('Sara Ahmed');
        $response->assertSee('House 12, Street 4, DHA Phase 6');
    }

    public function test_technician_can_accept_job_and_notify_customer(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->post(route('technician.jobs.accept', $this->booking->id));

        $response->assertRedirect(route('technician.jobs.details', $this->booking->booking_number));

        $this->booking->refresh();
        $this->assertEquals('confirmed', $this->booking->status);

        // Assert customer notification created
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->customerUser->id,
            'type' => 'booking_accepted',
        ]);

        // Assert message dispatched
        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->technicianUser->id,
            'receiver_id' => $this->customerUser->id,
            'booking_id' => $this->booking->id,
        ]);
    }

    public function test_technician_can_start_route(): void
    {
        $this->booking->update(['status' => 'confirmed']);

        $response = $this->actingAs($this->technicianUser)
            ->post(route('technician.jobs.start-route', $this->booking->id));

        $response->assertRedirect(route('technician.active-job'));

        $this->booking->refresh();
        $this->assertEquals('en_route', $this->booking->status);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->customerUser->id,
            'type' => 'technician_en_route',
        ]);
    }

    public function test_technician_can_verify_arrival_otp(): void
    {
        $this->booking->update(['status' => 'en_route']);

        // Test with invalid OTP
        $failResponse = $this->actingAs($this->technicianUser)
            ->post(route('technician.active-job.verify-otp', $this->booking->id), [
                'otp' => '9999',
            ]);

        $failResponse->assertSessionHas('error');
        $this->booking->refresh();
        $this->assertEquals('en_route', $this->booking->status);

        // Test with correct OTP
        $successResponse = $this->actingAs($this->technicianUser)
            ->post(route('technician.active-job.verify-otp', $this->booking->id), [
                'otp' => '4321',
            ]);

        $successResponse->assertSessionHas('success');
        $this->booking->refresh();
        $this->assertEquals('in_progress', $this->booking->status);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->customerUser->id,
            'type' => 'service_started',
        ]);
    }

    public function test_technician_can_complete_job_and_release_escrow(): void
    {
        $this->booking->update(['status' => 'in_progress']);

        $response = $this->actingAs($this->technicianUser)
            ->post(route('technician.active-job.complete', $this->booking->id));

        $response->assertRedirect(route('technician.earnings'));

        $this->booking->refresh();
        $this->assertEquals('completed', $this->booking->status);
        $this->assertEquals('escrow_released', $this->booking->payment_status);
        $this->assertNotNull($this->booking->completed_at);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->customerUser->id,
            'type' => 'job_completed',
        ]);
    }

    public function test_technician_can_view_earnings_ledger(): void
    {
        $this->booking->update([
            'status' => 'completed',
            'completed_at' => now(),
            'payment_status' => 'escrow_released',
        ]);

        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.earnings'));

        $response->assertOk();
        $response->assertSee($this->booking->booking_number);
        $response->assertSee('Total Lifetime Earnings');
    }

    public function test_technician_can_view_schedule(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.schedule'));

        $response->assertOk();
        $response->assertSee('My Schedule & Bookings');
        $response->assertSee($this->booking->booking_number);
    }

    public function test_technician_can_view_and_submit_kyc_verification(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.verification'));

        $response->assertOk();
        $response->assertSee('Partner Verification & Biometrics');

        $submitResponse = $this->actingAs($this->technicianUser)
            ->post(route('technician.verification.submit'), [
                'cnic_number' => '42201-9876543-1',
                'experience' => '8 Years Master Plumber',
                'city' => 'Karachi',
                'emergency_contact_name' => 'Tariq Khan',
                'emergency_contact_phone' => '0300-9998877',
                'biometric_selfie' => UploadedFile::fake()->create('selfie.jpg', 100, 'image/jpeg'),
                'cnic_front' => UploadedFile::fake()->create('cnic_front.jpg', 100, 'image/jpeg'),
            ]);

        $submitResponse->assertSessionHas('success');
        $this->technicianUser->refresh();
        $this->assertEquals('42201-9876543-1', $this->technicianUser->cnic_number);

        $this->professional->refresh();
        $this->assertEquals('under_review', $this->professional->verification_status);
        $this->assertEquals('submitted', $this->professional->biometric_status);
        $this->assertNotNull($this->professional->biometric_selfie_path);
        Storage::disk('public')->assertExists($this->professional->biometric_selfie_path);
    }

    public function test_technician_can_update_skills(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.skills'));

        $response->assertOk();
        $response->assertSee('Skills &amp; Trade Specialties', false);

        $updateResponse = $this->actingAs($this->technicianUser)
            ->post(route('technician.skills.update'), [
                'profession_id' => $this->profession->id,
                'experience' => '10 Years Master Craftsman',
                'sub_categories' => ['Pipe Leakage & Repair', 'Water Tank Cleaning'],
            ]);

        $updateResponse->assertSessionHas('success');
        $this->professional->refresh();
        $this->assertEquals('10 Years Master Craftsman', $this->professional->experience);
        $this->assertEquals(['Pipe Leakage & Repair', 'Water Tank Cleaning'], $this->professional->sub_categories);
    }

    public function test_technician_can_update_profile(): void
    {
        $response = $this->actingAs($this->technicianUser)
            ->post(route('technician.profile.update'), [
                'name' => 'Tariq Mehmood Pro',
                'phone' => '+923009998877',
                'city' => 'Lahore',
                'area' => 'DHA Phase 5',
                'experience' => '12 Years',
                'description' => 'Certified Master Plumber specializing in residential piping and high pressure systems with 12+ years experience.',
            ]);

        $response->assertSessionHas('success');
        $this->technicianUser->refresh();
        $this->professional->refresh();
        $this->assertEquals('Tariq Mehmood Pro', $this->technicianUser->name);
        $this->assertEquals('Lahore', $this->technicianUser->city);
        $this->assertEquals('Certified Master Plumber specializing in residential piping and high pressure systems with 12+ years experience.', $this->technicianUser->description);
        $this->assertEquals('Certified Master Plumber specializing in residential piping and high pressure systems with 12+ years experience.', $this->professional->description);

        $dashResponse = $this->actingAs($this->technicianUser)->get(route('technician.dashboard'));
        $dashResponse->assertOk();
        $dashResponse->assertSee('Technician Description');
        $dashResponse->assertSee('Certified Master Plumber');
    }

    public function test_technician_can_view_messages_and_send_reply(): void
    {
        Message::create([
            'sender_id' => $this->customerUser->id,
            'receiver_id' => $this->technicianUser->id,
            'booking_id' => $this->booking->id,
            'message' => 'Hello Tariq bhai, when will you arrive?',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.messages', ['client_id' => $this->customerUser->id]));

        $response->assertOk();
        $response->assertSee('Hello Tariq bhai, when will you arrive?');

        $sendResponse = $this->actingAs($this->technicianUser)
            ->post(route('technician.messages.send'), [
                'receiver_id' => $this->customerUser->id,
                'booking_id' => $this->booking->id,
                'message' => 'Assalam o Alaikum, I am packing my tools and will arrive at 10 AM.',
            ]);

        $sendResponse->assertSessionHas('success');

        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->technicianUser->id,
            'receiver_id' => $this->customerUser->id,
            'message' => 'Assalam o Alaikum, I am packing my tools and will arrive at 10 AM.',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->customerUser->id,
            'type' => 'chat_message',
        ]);
    }

    public function test_technician_can_view_and_manage_notifications(): void
    {
        $notif = Notification::create([
            'user_id' => $this->technicianUser->id,
            'type' => 'booking_assigned',
            'title' => 'New Dispatch Assigned',
            'message' => 'Customer booked plumbing service in DHA Phase 6.',
            'link' => route('technician.jobs.details', $this->booking->booking_number),
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.notifications'));

        $response->assertOk();
        $response->assertSee('New Dispatch Assigned');
        $response->assertSee('Notifications &amp; Alerts', false);

        // Mark single as read
        $readResponse = $this->actingAs($this->technicianUser)
            ->patch(route('technician.notifications.read', $notif->id));

        $readResponse->assertSessionHas('success');
        $notif->refresh();
        $this->assertTrue($notif->is_read);

        // Mark all as read
        Notification::create([
            'user_id' => $this->technicianUser->id,
            'type' => 'chat_message',
            'title' => 'Customer Message',
            'message' => 'New chat inquiry',
            'is_read' => false,
        ]);

        $readAllResponse = $this->actingAs($this->technicianUser)
            ->post(route('technician.notifications.read-all'));

        $readAllResponse->assertSessionHas('success');
        $this->assertEquals(0, $this->technicianUser->notifications()->unread()->count());
    }

    public function test_customer_booking_creates_technician_notification_and_message(): void
    {
        $payload = [
            'profession_id' => $this->profession->id,
            'professional_id' => $this->professional->id,
            'service_title' => 'Geyser Thermostat Replacement',
            'service_date' => now()->addDays(2)->toDateString(),
            'service_time_slot' => 'Afternoon (12:00 PM - 3:00 PM)',
            'service_address' => 'House 55, Street 10, Clifton',
            'city' => 'Karachi',
            'problem_description' => 'Geyser water not heating.',
        ];

        $response = $this->actingAs($this->customerUser)
            ->post(route('customer.booking.store'), $payload);

        $createdBooking = Booking::where('user_id', $this->customerUser->id)->latest('id')->first();
        $this->assertNotNull($createdBooking);

        // Assert notification sent to technician user
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->technicianUser->id,
            'type' => 'booking_assigned',
        ]);

        // Assert direct chat message automatically created for technician
        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->customerUser->id,
            'receiver_id' => $this->technicianUser->id,
            'booking_id' => $createdBooking->id,
        ]);
    }

    public function test_technician_can_open_notification_and_mark_as_read(): void
    {
        $notif = Notification::create([
            'user_id' => $this->technicianUser->id,
            'type' => 'chat_message',
            'title' => 'New Customer Inquiry',
            'message' => 'Hello, can you visit tomorrow?',
            'link' => route('technician.messages'),
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.notifications.open', $notif->id));

        $response->assertRedirect(route('technician.messages'));
        $notif->refresh();
        $this->assertTrue($notif->is_read);
    }

    public function test_customer_can_open_notification_and_mark_as_read(): void
    {
        $notif = Notification::create([
            'user_id' => $this->customerUser->id,
            'type' => 'booking_created',
            'title' => 'Booking Confirmed',
            'message' => 'Your booking #123 is confirmed.',
            'link' => route('customer.dashboard'),
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->customerUser)
            ->get(route('customer.notifications.open', $notif->id));

        $response->assertRedirect(route('customer.dashboard'));
        $notif->refresh();
        $this->assertTrue($notif->is_read);
    }

    public function test_newly_registered_technician_reviews_screen_shows_zero_reviews_and_no_static_data(): void
    {
        $newTechUser = User::factory()->create([
            'role' => 'technician',
            'user_type' => User::TYPE_TECHNICIAN,
            'name' => 'Kashif Ali',
            'email' => 'kashif.new@example.com',
            'is_verified' => true,
        ]);

        $response = $this->actingAs($newTechUser)
            ->get(route('technician.reviews'));

        $response->assertOk();
        $response->assertSee('Customer Reviews & Feedback', false);
        $response->assertSee('No Customer Reviews Yet');
        $response->assertSee('0 Reviews Recorded');
        $response->assertSee('0.0');

        // Verify absolutely NO static sample data is displayed
        $response->assertDontSee('Ahmed Raza');
        $response->assertDontSee('Sana Malik');
        $response->assertDontSee('Bilal Ahmed');
        $response->assertDontSee('Hina Kausar');
        $response->assertDontSee('Usman Tariq');
        $response->assertDontSee('Ali bhai');
        $response->assertDontSee('127 reviews');
        $response->assertDontSee('Showing the 5 most recent');
    }

    public function test_technician_reviews_screen_shows_real_reviews_when_present_and_supports_reply(): void
    {
        $review = Review::create([
            'booking_id' => $this->booking->id,
            'user_id' => $this->customerUser->id,
            'professional_id' => $this->professional->id,
            'rating' => 5,
            'comment' => 'Tariq arrived right on time and fixed the leaking sink pipe expertly!',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($this->technicianUser)
            ->get(route('technician.reviews'));

        $response->assertOk();
        $response->assertSee('Sara Ahmed');
        $response->assertSee('Tariq arrived right on time and fixed the leaking sink pipe expertly!');
        $response->assertSee('5.0');
        $response->assertSee('1');
        $response->assertDontSee('No Customer Reviews Yet');

        // Technician submits public reply
        $replyResponse = $this->actingAs($this->technicianUser)
            ->post(route('technician.reviews.reply', $review->id), [
                'reply' => 'Thank you Sara! Always happy to provide top-quality service.',
            ]);

        $replyResponse->assertRedirect();
        $review->refresh();
        $this->assertEquals('Thank you Sara! Always happy to provide top-quality service.', $review->technician_reply);
        $this->assertNotNull($review->technician_replied_at);

        // Verify customer received notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->customerUser->id,
            'type' => 'review_reply',
        ]);

        // Review screen now shows public reply
        $responseAfterReply = $this->actingAs($this->technicianUser)
            ->get(route('technician.reviews'));

        $responseAfterReply->assertOk();
        $responseAfterReply->assertSee('Your Public Response');
        $responseAfterReply->assertSee('Thank you Sara! Always happy to provide top-quality service.');
    }

    public function test_technician_dashboard_shows_alert_and_creates_notification_when_job_date_near(): void
    {
        Booking::query()->delete();

        Booking::create([
            'booking_number' => 'FM-TECH-REMIND-01',
            'user_id' => $this->customerUser->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Main Valve Replacement',
            'service_date' => now()->addDay()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'House 44, PECHS Block 6',
            'city' => 'Karachi',
            'status' => 'confirmed',
            'arrival_otp' => '4829',
            'base_price' => 800,
            'total_price' => 800,
        ]);

        $response = $this->actingAs($this->technicianUser)->get(route('technician.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('UPCOMING JOB TOMORROW');
        $response->assertSee('Main Valve Replacement');

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->technicianUser->id,
            'type' => 'job_reminder',
        ]);
    }

    public function test_technician_with_documents_under_review_cannot_access_other_pages_and_sees_warning(): void
    {
        $underReviewTech = User::factory()->create([
            'role' => 'technician',
            'user_type' => User::TYPE_TECHNICIAN,
            'is_verified' => false,
        ]);
        Professional::create([
            'user_id' => $underReviewTech->id,
            'profession_id' => $this->profession->id,
            'name' => $underReviewTech->name,
            'is_verified' => false,
            'verification_status' => 'under_review',
        ]);

        // Attempting to access dashboard
        $dashResponse = $this->actingAs($underReviewTech)
            ->get(route('technician.dashboard'));

        $dashResponse->assertRedirect(route('technician.verification'));
        $dashResponse->assertSessionHas('warning');

        // Attempting to access jobs page
        $response = $this->actingAs($underReviewTech)
            ->get(route('technician.jobs'));

        $response->assertRedirect(route('technician.verification'));
        $response->assertSessionHas('warning');

        // Verification page itself remains accessible
        $verResponse = $this->actingAs($underReviewTech)
            ->get(route('technician.verification'));
        $verResponse->assertOk();
        $verResponse->assertSee('Audit in Progress');
    }
}

