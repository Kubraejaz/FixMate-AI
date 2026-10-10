<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\CommunityIssue;
use App\Models\ContactInquiry;
use App\Models\Faq;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WorkflowStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Profession $profession;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create([
            'email' => 'admin.api@example.com',
            'password' => 'secretpass123',
        ]);

        $this->profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            ['name' => 'Plumber', 'base_price' => 800, 'is_active' => true]
        );
    }

    private function customer(): User
    {
        return User::factory()->customer()->create(['city' => 'Karachi']);
    }

    private function technicianWithProfile(): array
    {
        $user = User::factory()->technician()->create(['is_verified' => true, 'profession_id' => $this->profession->id]);

        $professional = Professional::create([
            'user_id' => $user->id,
            'profession_id' => $this->profession->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '+923009998877',
            'experience' => '5 Years',
            'is_verified' => true,
            'verification_status' => 'verified',
        ]);

        return [$user, $professional];
    }

    public function test_admin_can_view_dashboard_and_analytics(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/dashboard')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['stats', 'recent_customers']]);

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/analytics')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['totals', 'by_city']]);
    }

    public function test_admin_can_view_bookings(): void
    {
        $customer = $this->customer();
        [$techUser, $professional] = $this->technicianWithProfile();

        Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'user_id' => $customer->id,
            'professional_id' => $professional->id,
            'profession_id' => $this->profession->id,
            'service_title' => 'Kitchen Sink Repair',
            'service_date' => now()->toDateString(),
            'service_time_slot' => 'Morning (9:00 AM - 12:00 PM)',
            'service_address' => 'House 1, Street 2',
            'city' => 'Karachi',
            'status' => 'pending',
            'arrival_otp' => '4321',
            'base_price' => 800,
            'total_price' => 1200,
            'payment_status' => 'escrow_held',
            'payment_method' => 'escrow',
        ]);

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/bookings')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.stats.total', 1);

        $booking = Booking::first();
        $this->actingAs($this->admin, 'sanctum')
            ->getJson("/api/v1/admin/bookings/{$booking->id}")
            ->assertOk()
            ->assertJsonPath('data.booking_number', $booking->booking_number);
    }

    public function test_admin_can_manage_technician_verification_pipeline(): void
    {
        [$techUser, $professional] = $this->technicianWithProfile();
        $professional->update(['is_verified' => false, 'verification_status' => 'pending']);

        $application = TechnicianApplication::create([
            'reference_no' => 'FM-APP-8801',
            'user_id' => $techUser->id,
            'profession_id' => $this->profession->id,
            'name' => $techUser->name,
            'phone' => $techUser->phone ?? '+923009998877',
            'email' => $techUser->email,
            'cnic_number' => '42201-5544332-1',
            'city' => 'Karachi',
            'experience_years' => 6,
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/technicians/verification')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.stats.total', 1);

        $this->actingAs($this->admin, 'sanctum')
            ->patchJson("/api/v1/admin/technicians/verification/{$application->id}/approve", [
                'admin_notes' => 'NADRA verified.',
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('technician_applications', [
            'id' => $application->id,
            'status' => 'approved',
        ]);

        $professional->refresh();
        $this->assertSame('verified', $professional->verification_status);
        $this->assertTrue((bool) $professional->is_verified);
    }

    public function test_admin_can_manage_technicians_pool(): void
    {
        [$techUser, $professional] = $this->technicianWithProfile();

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/technicians')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1);

        $this->actingAs($this->admin, 'sanctum')
            ->patchJson("/api/v1/admin/technicians/{$professional->id}/verify")
            ->assertOk()
            ->assertJsonPath('success', true);

        $professional->refresh();
        $this->assertFalse((bool) $professional->is_verified);

        $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/v1/admin/technicians/{$professional->id}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('professionals', ['id' => $professional->id]);
    }

    public function test_admin_can_manage_customers(): void
    {
        $customer = $this->customer();

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/customers')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->admin, 'sanctum')
            ->patchJson("/api/v1/admin/customers/{$customer->id}/toggle")
            ->assertOk()
            ->assertJsonPath('success', true);

        $customer->refresh();
        $this->assertFalse((bool) $customer->is_active);

        $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/v1/admin/customers/{$customer->id}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('users', ['id' => $customer->id]);
    }

    public function test_admin_can_crud_services(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/services')
            ->assertOk()
            ->assertJsonPath('success', true);

        $create = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/services', [
                'name' => 'CCTV & Smart Security',
                'slug' => 'cctv-smart-security',
                'base_price' => 1500,
                'price_unit' => 'service',
                'is_active' => true,
            ]);

        $create->assertStatus(201)->assertJsonPath('success', true);
        $serviceId = $create->json('data.id');

        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/v1/admin/services/{$serviceId}", [
                'name' => 'CCTV Security Pro',
                'slug' => 'cctv-security-pro',
                'base_price' => 1800,
                'is_active' => true,
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'CCTV Security Pro');

        $this->actingAs($this->admin, 'sanctum')
            ->patchJson("/api/v1/admin/services/{$serviceId}/toggle")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/v1/admin/services/{$serviceId}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('professions', ['id' => $serviceId]);
    }

    public function test_admin_can_crud_faqs(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/faqs')
            ->assertOk()
            ->assertJsonPath('success', true);

        $create = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/faqs', [
                'question' => 'How does escrow work?',
                'answer' => 'Funds are held securely until you confirm completion.',
                'category' => 'payments_escrow',
                'is_active' => true,
            ]);

        $create->assertStatus(201)->assertJsonPath('success', true);
        $faqId = $create->json('data.id');

        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/v1/admin/faqs/{$faqId}", [
                'question' => 'How does FixMate escrow work?',
                'answer' => 'Funds are held securely until you confirm job completion.',
                'category' => 'payments_escrow',
                'is_active' => true,
            ])
            ->assertOk()
            ->assertJsonPath('data.question', 'How does FixMate escrow work?');

        $this->actingAs($this->admin, 'sanctum')
            ->patchJson("/api/v1/admin/faqs/{$faqId}/toggle")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/v1/admin/faqs/{$faqId}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('faqs', ['id' => $faqId]);
    }

    public function test_admin_can_manage_community_hazards(): void
    {
        $issue = CommunityIssue::create([
            'reference_no' => 'FM-CIV-5555',
            'reporter_name' => 'Ali Raza',
            'title' => 'Overflowing drain near market',
            'description' => 'The drain outside the vegetable market is overflowing.',
            'category' => 'sewerage',
            'city' => 'Karachi',
            'location' => 'Gulshan Market',
            'status' => 'reported',
            'priority' => 'normal',
            'upvotes_count' => 1,
            'is_approved' => true,
        ]);

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/community')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/v1/admin/community/{$issue->id}", [
                'status' => 'resolved',
                'priority' => 'high',
                'category' => 'sewerage',
                'city' => 'Karachi',
                'location' => 'Gulshan Market',
                'status_update' => 'Civic team cleared the blockage.',
            ])
            ->assertOk()
            ->assertJsonPath('data.status', 'resolved');

        $this->actingAs($this->admin, 'sanctum')
            ->patchJson("/api/v1/admin/community/{$issue->id}/toggle")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/v1/admin/community/{$issue->id}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('community_issues', ['id' => $issue->id]);
    }

    public function test_admin_can_manage_inquiries(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/inquiries')
            ->assertOk()
            ->assertJsonPath('success', true);

        $create = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/inquiries', [
                'department' => 'escrow',
                'name' => 'Bilal Khan',
                'phone' => '0300-1234567',
                'email' => 'bilal@example.com',
                'city' => 'Karachi',
                'message' => 'I need help with an escrow dispute.',
                'status' => 'new',
            ]);

        $create->assertStatus(201)->assertJsonPath('success', true);
        $inquiryId = $create->json('data.id');

        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/v1/admin/inquiries/{$inquiryId}", [
                'status' => 'in_progress',
                'admin_notes' => 'Assigned to arbitration team.',
            ])
            ->assertOk()
            ->assertJsonPath('data.status', 'in_progress');

        $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/v1/admin/inquiries/{$inquiryId}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('contact_inquiries', ['id' => $inquiryId]);
    }

    public function test_admin_can_manage_homepage_cms(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/homepage')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['settings', 'testimonials', 'steps']]);

        $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/homepage/hero', [
                'hero_badge' => 'Verified Experts',
                'hero_title_main' => 'Home Repair Made Simple',
                'hero_title_highlight' => 'On Demand',
                'hero_subtitle' => 'Book trusted technicians in minutes.',
                'guarantee_title' => '30-Day Warranty',
                'guarantee_subtitle' => 'Every job is protected.',
                'warranty_days' => 30,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $testimonial = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/homepage/testimonials', [
                'name' => 'Ayesha Malik',
                'location' => 'Karachi',
                'trade' => 'Plumber',
                'rating' => 5,
                'comment' => 'Fantastic service and very professional.',
            ]);

        $testimonial->assertStatus(201)->assertJsonPath('success', true);

        $step = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/homepage/steps', [
                'step_number' => 1,
                'icon' => '📷',
                'title' => 'Describe Your Problem',
                'description' => 'Share details or upload a defect photo.',
                'badge_color' => '#FFC107',
            ]);

        $step->assertStatus(201)->assertJsonPath('success', true);

        $this->assertDatabaseHas('testimonials', ['name' => 'Ayesha Malik']);
        $this->assertDatabaseHas('workflow_steps', ['title' => 'Describe Your Problem']);
    }

    public function test_admin_can_view_and_update_settings_and_payments(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/settings')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['platform_commission', 'payout_frequency']]);

        $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/admin/settings', [
                'platform_commission' => 15,
                'payout_frequency' => 'weekly',
                'maintenance_mode' => false,
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/admin/payments')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['summary', 'transactions']]);
    }

    public function test_non_admin_cannot_access_admin_endpoints(): void
    {
        $customer = $this->customer();

        $this->actingAs($customer, 'sanctum')
            ->getJson('/api/v1/admin/dashboard')
            ->assertStatus(403)
            ->assertJsonPath('success', false);
    }
}
