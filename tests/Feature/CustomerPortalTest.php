<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CustomerPortalTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;
    private Profession $profession;
    private Professional $technician;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'role' => 'customer',
            'name' => 'Sara Ahmed',
            'email' => 'sara@example.com',
            'phone' => '+923001234567',
            'city' => 'Karachi',
            'area' => 'Clifton Block 2',
        ]);

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            [
                'name' => 'Plumber',
                'description' => 'Certified plumbing services',
                'base_price' => 500,
                'is_active' => true,
            ]
        );

        $techUser = User::factory()->create([
            'role' => 'technician',
            'name' => 'Tariq Mehmood',
            'email' => 'tariq@example.com',
        ]);

        $this->technician = Professional::create([
            'user_id' => $techUser->id,
            'profession_id' => $this->profession->id,
            'name' => 'Tariq Mehmood',
            'experience' => '6 years',
            'rating' => 4.9,
            'jobs_completed' => 50,
            'is_verified' => true,
        ]);
    }

    public function test_customer_can_view_dynamic_dashboard(): void
    {
        Booking::create([
            'booking_number' => 'FM-99991',
            'user_id' => $this->customer->id,
            'professional_id' => $this->technician->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Emergency Pipe Leak Fix',
            'service_date' => now()->toDateString(),
            'service_time_slot' => 'Afternoon (12:00 PM - 3:00 PM)',
            'service_address' => 'House 12-A, Street 4, Clifton Block 2',
            'city' => 'Karachi',
            'status' => 'confirmed',
            'arrival_otp' => '3921',
            'base_price' => 500,
            'total_price' => 500,
            'payment_status' => 'escrow_held',
            'payment_method' => 'escrow',
        ]);

        $response = $this->actingAs($this->customer)->get('/customer/dashboard');

        $response->assertOk();
        $response->assertSee('Welcome, Sara Ahmed');
        $response->assertSee('Emergency Pipe Leak Fix');
        $response->assertSee('Tariq Mehmood');
    }

    public function test_customer_can_view_diagnose_and_ai_results(): void
    {
        $diagnoseResponse = $this->actingAs($this->customer)->get('/customer/diagnose');
        $diagnoseResponse->assertOk();
        $diagnoseResponse->assertSee('Plumber');

        $aiResponse = $this->actingAs($this->customer)->get('/customer/ai-result?category=plumber&issue=Leaking+pipe');
        $aiResponse->assertOk();
        $aiResponse->assertSee('Plumber');
        $aiResponse->assertSee('Leaking pipe');
    }

    public function test_customer_can_view_technicians_directory_with_filters(): void
    {
        $response = $this->actingAs($this->customer)->get('/customer/technicians?profession=' . $this->profession->id);

        $response->assertOk();
        $response->assertSee('Tariq Mehmood');
        $response->assertSee('Plumber');
    }

    public function test_customer_can_submit_real_booking_with_otp_and_redirect_to_confirmation(): void
    {
        $payload = [
            'profession_id' => $this->profession->id,
            'professional_id' => $this->technician->id,
            'service_title' => 'Water Tank Float Valve Repair',
            'service_date' => now()->addDay()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'Apartment 4B, Ocean View, Clifton',
            'city' => 'Karachi',
            'problem_description' => 'Water overflows from rooftop water tank.',
        ];

        $response = $this->actingAs($this->customer)->post('/customer/booking', $payload);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->customer->id,
            'service_title' => 'Water Tank Float Valve Repair',
            'city' => 'Karachi',
            'status' => 'pending',
        ]);

        $createdBooking = Booking::where('user_id', $this->customer->id)->latest()->first();
        $this->assertNotNull($createdBooking);
        $this->assertEquals(4, strlen($createdBooking->arrival_otp));

        $response->assertRedirect(route('customer.booking.confirm', $createdBooking->id));

        $confirmResponse = $this->actingAs($this->customer)->get(route('customer.booking.confirm', $createdBooking->id));
        $confirmResponse->assertOk();
        $confirmResponse->assertSee($createdBooking->booking_number);
        $confirmResponse->assertSee($createdBooking->arrival_otp);
    }

    public function test_customer_can_list_and_filter_bookings(): void
    {
        $activeBooking = Booking::create([
            'booking_number' => 'FM-88881',
            'user_id' => $this->customer->id,
            'professional_id' => $this->technician->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Bathroom Tap Replacement',
            'service_date' => now()->toDateString(),
            'service_time_slot' => 'Evening (3:00 PM - 6:00 PM)',
            'service_address' => 'House 12-A, Street 4, Clifton Block 2',
            'city' => 'Karachi',
            'status' => 'en_route',
            'arrival_otp' => '5182',
            'base_price' => 500,
            'total_price' => 500,
        ]);

        $response = $this->actingAs($this->customer)->get('/customer/bookings?status=active');
        $response->assertOk();
        $response->assertSee('Bathroom Tap Replacement');
        $response->assertSee('5182');
    }

    public function test_customer_can_track_booking_live(): void
    {
        $booking = Booking::create([
            'booking_number' => 'FM-77771',
            'user_id' => $this->customer->id,
            'professional_id' => $this->technician->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Main Drain Unclogging',
            'service_date' => now()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'House 12-A, Street 4, Clifton Block 2',
            'city' => 'Karachi',
            'status' => 'en_route',
            'arrival_otp' => '9412',
            'base_price' => 500,
            'total_price' => 500,
        ]);

        $response = $this->actingAs($this->customer)->get(route('customer.booking.tracking', $booking->id));

        $response->assertOk();
        $response->assertSee('Booking #FM-77771');
        $response->assertSee('9412');
        $response->assertSee('Tariq Mehmood');
    }

    public function test_customer_can_cancel_active_booking(): void
    {
        $booking = Booking::create([
            'booking_number' => 'FM-66661',
            'user_id' => $this->customer->id,
            'professional_id' => $this->technician->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Pipe Inspection',
            'service_date' => now()->addDays(2)->toDateString(),
            'service_time_slot' => 'Evening (3:00 PM - 6:00 PM)',
            'service_address' => 'House 12-A, Street 4, Clifton Block 2',
            'city' => 'Karachi',
            'status' => 'pending',
            'arrival_otp' => '4001',
            'base_price' => 500,
            'total_price' => 500,
        ]);

        $response = $this->actingAs($this->customer)->post(route('customer.booking.cancel', $booking->id), [
            'cancellation_reason' => 'Schedule conflict',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_customer_can_update_profile(): void
    {
        $response = $this->actingAs($this->customer)->post('/customer/profile', [
            'name' => 'Sara A. Khan',
            'email' => 'sara@example.com',
            'phone' => '+923009998877',
            'city' => 'Lahore',
            'area' => 'Gulberg III',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $this->customer->id,
            'name' => 'Sara A. Khan',
            'city' => 'Lahore',
            'area' => 'Gulberg III',
        ]);
    }

    public function test_customer_can_submit_dispute_ticket(): void
    {
        $response = $this->actingAs($this->customer)->post('/customer/complaints', [
            'subject' => 'Technician Delayed on Booking #FM-77771',
            'message' => 'Technician arrived 45 minutes late without prior notice.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_inquiries', [
            'email' => $this->customer->email,
            'department' => 'escrow',
        ]);
    }

    public function test_customer_can_review_completed_booking(): void
    {
        $completedBooking = Booking::create([
            'booking_number' => 'FM-55551',
            'user_id' => $this->customer->id,
            'professional_id' => $this->technician->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Geyser Thermostat Replacement',
            'service_date' => now()->subDay()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'House 12-A, Street 4, Clifton Block 2',
            'city' => 'Karachi',
            'status' => 'completed',
            'arrival_otp' => '1234',
            'base_price' => 500,
            'total_price' => 750,
            'completed_at' => now(),
        ]);

        $response = $this->actingAs($this->customer)->post(route('customer.review.store', $completedBooking->id), [
            'rating' => 5,
            'comment' => 'Excellent work! Quick turnaround and very clean workmanship.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reviews', [
            'booking_id' => $completedBooking->id,
            'user_id' => $this->customer->id,
            'rating' => 5,
        ]);
    }

    public function test_customer_can_view_messages_and_send_chat(): void
    {
        $response = $this->actingAs($this->customer)->get('/customer/messages');
        $response->assertOk();
        $response->assertSee('Tariq Mehmood');

        $sendResponse = $this->actingAs($this->customer)->post('/customer/messages', [
            'technician_id' => $this->technician->id,
            'message' => 'Please bring an extra replacement seal.',
        ]);

        $sendResponse->assertSessionHas('success');
    }

    public function test_customer_can_view_payment_and_process_escrow_method(): void
    {
        $booking = Booking::create([
            'booking_number' => 'FM-44441',
            'user_id' => $this->customer->id,
            'professional_id' => $this->technician->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Kitchen Valve Fix',
            'service_date' => now()->toDateString(),
            'service_time_slot' => 'Afternoon (12:00 PM - 3:00 PM)',
            'service_address' => 'House 12-A, Street 4, Clifton Block 2',
            'city' => 'Karachi',
            'status' => 'pending',
            'arrival_otp' => '7823',
            'base_price' => 500,
            'total_price' => 500,
        ]);

        $viewResponse = $this->actingAs($this->customer)->get(route('customer.payment', $booking->id));
        $viewResponse->assertOk();
        $viewResponse->assertSee('Kitchen Valve Fix');
        $viewResponse->assertSee('Rs. 500');

        $processResponse = $this->actingAs($this->customer)->post(route('customer.payment.process', $booking->id), [
            'payment_method' => 'jazzcash',
        ]);

        $processResponse->assertRedirect(route('customer.booking.confirm', $booking->id));
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'payment_method' => 'jazzcash',
            'payment_status' => 'escrow_held',
        ]);
    }

    public function test_dashboard_displays_live_en_route_alert_banner_when_job_active(): void
    {
        $activeJob = Booking::create([
            'booking_number' => 'FM-33331',
            'user_id' => $this->customer->id,
            'professional_id' => $this->technician->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Main Line Clog Cleanout',
            'service_date' => now()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'House 12-A, Street 4, Clifton Block 2',
            'city' => 'Karachi',
            'status' => 'en_route',
            'arrival_otp' => '9988',
            'base_price' => 500,
            'total_price' => 500,
        ]);

        $response = $this->actingAs($this->customer)->get('/customer/dashboard');
        $response->assertOk();
        $response->assertSee('9988');
        $response->assertSee('Tariq Mehmood');
        $response->assertSee('En Route');
    }

    public function test_customer_can_upload_photo_for_ai_diagnosis(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->create('kitchen_pipe_defect.jpg', 150, 'image/jpeg');

        $response = $this->actingAs($this->customer)->post(route('customer.ai-result'), [
            'category' => 'plumber',
            'issue' => 'Severe pipe burst in kitchen cabinet',
            'defect_photo' => $file,
        ]);

        $response->assertOk();
        $response->assertSee('Plumber');
        $response->assertSee('Severe pipe burst in kitchen cabinet');
        $response->assertSee('ai_scan_');
    }

    public function test_customer_can_send_message_and_trigger_notification(): void
    {
        $response = $this->actingAs($this->customer)->post(route('customer.messages.send'), [
            'technician_id' => $this->technician->id,
            'message' => 'Please bring extra teflon tape and wrench.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('messages', [
            'sender_id' => $this->customer->id,
            'receiver_id' => $this->technician->user_id,
            'message' => 'Please bring extra teflon tape and wrench.',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->technician->user_id,
            'type' => 'chat_message',
        ]);
    }

    public function test_customer_can_update_notification_preferences(): void
    {
        $response = $this->actingAs($this->customer)->post(route('customer.settings.notifications'), [
            'sms_alerts' => '1',
            'whatsapp_alerts' => '1',
            'email_receipts' => '1',
            'booking_updates' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->customer->refresh();
        $this->assertTrue($this->customer->getNotificationPref('sms_alerts'));
        $this->assertTrue($this->customer->getNotificationPref('whatsapp_alerts'));
    }

    public function test_customer_can_mark_notifications_as_read(): void
    {
        \App\Models\Notification::sendToUser(
            $this->customer->id,
            'test_alert',
            'Test Notification',
            'Your service has arrived'
        );

        $this->assertEquals(1, $this->customer->notifications()->unread()->count());

        $response = $this->actingAs($this->customer)->post(route('customer.notifications.read'));
        $response->assertRedirect();

        $this->assertEquals(0, $this->customer->notifications()->unread()->count());
    }

    public function test_ai_diagnose_correctly_classifies_ac_defect(): void
    {
        Profession::firstOrCreate(
            ['slug' => 'ac-refrigeration'],
            ['name' => 'AC & Refrigeration', 'base_price' => 1000, 'is_active' => true]
        );

        $response = $this->actingAs($this->customer)->post(route('customer.ai-result'), [
            'category' => 'auto',
            'issue' => 'My split AC outdoor compressor is humming loudly and blowing hot air instead of cooling',
        ]);

        $response->assertOk();
        $response->assertSee('AC &amp; Refrigeration', false);
        $response->assertSee('Service Matched');
        $response->assertSee('Compressor Inspection');
    }

    public function test_ai_diagnose_correctly_flags_irrelevant_content_as_inconclusive(): void
    {
        $response = $this->actingAs($this->customer)->post(route('customer.ai-result'), [
            'category' => 'auto',
            'issue' => 'asdfghjkl random gibberish 12345 pizza delivery',
        ]);

        $response->assertOk();
        $response->assertSee('Please Select a Service Category');
        $response->assertDontSee('Service Matched');
    }

    public function test_ai_diagnose_classifies_uploaded_repair_image_even_without_text(): void
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $file = UploadedFile::fake()->createWithContent('kitchen_sink_leak.png', $png);

        $response = $this->actingAs($this->customer)->post(route('customer.ai-result'), [
            'category' => 'auto',
            'issue' => '',
            'defect_photo' => $file,
            'image_vision_trade' => 'plumber',
            'image_vision_confidence' => 96,
            'image_vision_defect' => 'Pipe Joint Leak & Water Drainage Defect',
            'image_is_doc' => '0',
        ]);

        $response->assertOk();
        $response->assertSee('Service Matched');
        $response->assertSee('Plumber');
        $response->assertSee('Attached Photo for Technician');
    }

    public function test_ai_diagnose_rejects_document_screenshot_image_when_text_is_irrelevant(): void
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $file = UploadedFile::fake()->createWithContent('medical_card_screenshot.png', $png);

        $response = $this->actingAs($this->customer)->post(route('customer.ai-result'), [
            'category' => 'auto',
            'issue' => 'please check this',
            'defect_photo' => $file,
            'image_vision_trade' => 'irrelevant_document',
            'image_vision_confidence' => 92,
            'image_is_doc' => '1',
        ]);

        $response->assertOk();
        $response->assertSee('Please Select a Service Category');
        $response->assertDontSee('Service Matched');
    }

    public function test_ai_diagnose_supports_multi_modal_image_and_text_agreement(): void
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $file = UploadedFile::fake()->createWithContent('drain_pipe.png', $png);

        $response = $this->actingAs($this->customer)->post(route('customer.ai-result'), [
            'category' => 'auto',
            'issue' => 'Water is leaking heavily from the drain pipe under the sink',
            'defect_photo' => $file,
            'image_vision_trade' => 'plumber',
            'image_vision_confidence' => 96,
            'image_is_doc' => '0',
        ]);

        $response->assertOk();
        $response->assertSee('Service Matched');
        $response->assertSee('Plumber');
        $response->assertSee('Attached Photo for Technician');
    }

    public function test_customer_can_view_notifications_page(): void
    {
        \App\Models\Notification::create([
            'user_id' => $this->customer->id,
            'type' => 'booking',
            'title' => 'Technician Assigned',
            'message' => 'Tariq Mehmood has accepted your booking.',
            'link' => route('customer.bookings'),
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->customer)->get(route('customer.notifications'));
        $response->assertOk();
        $response->assertSee('Notifications');
        $response->assertSee('Technician Assigned');
        $response->assertSee('Tariq Mehmood has accepted your booking.');
    }

    public function test_customer_can_open_notification_and_mark_read(): void
    {
        $notification = \App\Models\Notification::create([
            'user_id' => $this->customer->id,
            'type' => 'booking',
            'title' => 'Job Completed',
            'message' => 'Please release payment.',
            'link' => route('customer.bookings'),
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->customer)->get(route('customer.notifications.open', $notification->id));
        $response->assertRedirect(route('customer.bookings'));

        $this->assertTrue((bool) $notification->fresh()->is_read);
    }

    public function test_customer_can_mark_all_notifications_read(): void
    {
        \App\Models\Notification::create([
            'user_id' => $this->customer->id,
            'type' => 'booking',
            'title' => 'Update 1',
            'message' => 'First message',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->customer)->post(route('customer.notifications.read-all'));
        $response->assertRedirect();

        $unreadCount = \App\Models\Notification::where('user_id', $this->customer->id)->where('is_read', false)->count();
        $this->assertEquals(0, $unreadCount);
    }

    public function test_customer_can_view_services_page_inside_portal(): void
    {
        $response = $this->actingAs($this->customer)->get(route('customer.services'));

        $response->assertStatus(200);
        $response->assertViewIs('Frontend.customer.services');
        $response->assertSee('All Services &amp; Trade Categories', false);
        $response->assertSee('Plumber');
    }

    public function test_customer_can_filter_services_by_search_and_category(): void
    {
        Profession::firstOrCreate(
            ['slug' => 'electrician'],
            [
                'name' => 'Electrician',
                'description' => 'Wiring and breakers',
                'base_price' => 700,
                'is_active' => true,
            ]
        );

        $response = $this->actingAs($this->customer)->get(route('customer.services', ['search' => 'Wiring']));

        $response->assertStatus(200);
        $response->assertSee('Electrician');

        $responseCat = $this->actingAs($this->customer)->get(route('customer.services', ['category' => 'plumber']));
        $responseCat->assertStatus(200);
        $responseCat->assertSee('Plumber');
    }

    public function test_guest_is_redirected_to_login_when_accessing_customer_services(): void
    {
        $response = $this->get(route('customer.services'));
        $response->assertRedirect(route('login'));
    }
}


