<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PlatformValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected User $technicianUser;
    protected User $adminUser;
    protected Professional $professional;
    protected Profession $profession;
    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'user_type' => User::TYPE_CUSTOMER,
            'name' => 'Fatima Noor',
            'email' => 'fatima@example.com',
            'phone' => '+923001234567',
        ]);

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            [
                'name' => 'Plumbing Specialist',
                'icon' => 'wrench',
                'base_price' => 750,
                'is_active' => true,
            ]
        );

        $this->technicianUser = User::factory()->create([
            'user_type' => User::TYPE_TECHNICIAN,
            'name' => 'Bilal Ahmed',
            'phone' => '+923119998877',
        ]);

        $this->adminUser = User::factory()->create([
            'user_type' => User::TYPE_ADMIN,
            'name' => 'Super Administrator',
            'email' => 'admin@fixmate.ai',
        ]);

        $this->professional = Professional::create([
            'user_id' => $this->technicianUser->id,
            'profession_id' => $this->profession->id,
            'name' => 'Bilal Ahmed',
            'phone' => '+923119998877',
            'email' => 'bilal@example.com',
            'city' => 'Karachi',
            'is_verified' => true,
        ]);

        $this->booking = Booking::create([
            'booking_number' => 'FM-VAL-001',
            'user_id' => $this->customer->id,
            'professional_id' => $this->professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Kitchen Leak Repair',
            'service_date' => now()->toDateString(),
            'service_time_slot' => '10:00 AM - 12:00 PM',
            'service_address' => 'House 14, Street 3, PECHS',
            'city' => 'Karachi',
            'status' => 'completed',
            'arrival_otp' => '9988',
            'base_price' => 750,
            'total_price' => 750,
        ]);
    }

    public function test_customer_registration_rejects_invalid_name_and_mismatched_password(): void
    {
        $response = $this->post(route('register.customer.store'), [
            'name' => '123456', // numbers only
            'identifier' => 'newuser@example.com',
            'city' => 'Lahore',
            'password' => 'secret123',
            'password_confirmation' => 'different_password',
        ]);

        $response->assertSessionHasErrors(['name', 'password']);
    }

    public function test_technician_registration_rejects_invalid_cnic_and_phone(): void
    {
        $response = $this->post(route('register.technician.store'), [
            'name' => 'Valid Name',
            'email' => 'tech@example.com',
            'phone' => 'not-a-phone',
            'cnic' => 'invalid-cnic-format',
            'experience' => '5 years',
            'trade' => 'plumber',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['phone', 'cnic']);
    }

    public function test_booking_creation_rejects_past_date_and_short_address(): void
    {
        $response = $this->actingAs($this->customer)
            ->post(route('customer.booking.store'), [
                'profession_id' => $this->profession->id,
                'service_date' => now()->subDays(2)->toDateString(),
                'service_time_slot' => '10:00 AM - 12:00 PM',
                'service_address' => 'Hi', // too short
                'city' => 'Karachi',
            ]);

        $response->assertSessionHasErrors(['service_date', 'service_address']);
    }

    public function test_review_submission_rejects_rating_outside_range(): void
    {
        $response = $this->actingAs($this->customer)
            ->post(route('customer.review.store', $this->booking->id), [
                'rating' => 7, // outside 1..5
                'comment' => 'AB', // too short
            ]);

        $response->assertSessionHasErrors(['rating', 'comment']);
    }

    public function test_ai_diagnosis_rejects_non_image_defect_photo(): void
    {
        $fakeScript = UploadedFile::fake()->create('malicious.php', 100, 'text/x-php');

        $response = $this->actingAs($this->customer)
            ->post(route('customer.ai-result'), [
                'defect_photo' => $fakeScript,
            ]);

        $response->assertSessionHasErrors(['defect_photo']);
    }

    public function test_community_hazard_report_rejects_invalid_category_and_short_description(): void
    {
        $response = $this->post(route('community.report'), [
            'title' => 'Open Drain Hole',
            'description' => 'Fix', // too short
            'category' => 'invalid_category_slug',
            'city' => 'Karachi',
            'location' => 'Main Commercial Avenue',
            'reporter_name' => 'Citizen Ali',
        ]);

        $response->assertSessionHasErrors(['description', 'category']);
    }

    public function test_admin_settings_rejects_negative_commission_and_invalid_email(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.settings.update'), [
                'platform_commission' => -15, // invalid
                'support_email' => 'not-an-email', // invalid
            ]);

        $response->assertSessionHasErrors(['platform_commission', 'support_email']);
    }

    public function test_admin_kyc_reject_requires_minimum_reason(): void
    {
        $application = TechnicianApplication::create([
            'reference_no' => 'FM-APP-9981',
            'profession_id' => $this->profession->id,
            'name' => 'Zubair Qureshi',
            'phone' => '+923331112233',
            'email' => 'zubair@example.com',
            'cnic_number' => '42101-9988776-1',
            'city' => 'Karachi',
            'experience_years' => 4,
            'workshop_type' => 'freelancer',
            'tools_available' => 'has_own_tools',
            'status' => 'under_review',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->patch(route('admin.technicians.verification.reject', $application->id), [
                'reason' => 'No', // too short, requires min 5 characters
            ]);

        $response->assertSessionHasErrors(['reason']);
    }
}
