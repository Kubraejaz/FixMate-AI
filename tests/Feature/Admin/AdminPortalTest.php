<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPortalTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@fixmate.ai',
            'user_type' => User::TYPE_ADMIN,
        ]);
    }

    public function test_admin_can_view_dynamic_dashboard_with_kpis(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard & Overview');
        $response->assertSee('Total Customers');
        $response->assertSee('Technicians Pool');
        $response->assertSee('AI Diagnostics Accuracy');
    }

    public function test_admin_can_view_and_toggle_customers(): void
    {
        $customer = User::factory()->create([
            'name' => 'Farhan Zaidi',
            'user_type' => User::TYPE_CUSTOMER,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.customers'));

        $response->assertStatus(200);
        $response->assertSee('Farhan Zaidi');
        $response->assertSee('Registered Customers');

        // Toggle to suspend
        $toggleResponse = $this->actingAs($this->admin)->patch(route('admin.customers.toggle', $customer));
        $toggleResponse->assertRedirect();

        $this->assertFalse((bool) $customer->fresh()->is_active);
    }

    public function test_admin_can_view_and_verify_technicians(): void
    {
        $profession = Profession::create([
            'name' => 'HVAC Expert',
            'slug' => 'hvac-expert',
            'is_active' => true,
        ]);

        $techUser = User::factory()->create([
            'name' => 'Waqas Ahmed',
            'user_type' => User::TYPE_TECHNICIAN,
            'is_verified' => false,
        ]);

        $professional = Professional::create([
            'user_id' => $techUser->id,
            'profession_id' => $profession->id,
            'name' => 'Waqas Ahmed',
            'phone' => '03001234567',
            'experience' => '6 Years',
            'is_verified' => false,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.technicians'));

        $response->assertStatus(200);
        $response->assertSee('Waqas Ahmed');
        $response->assertSee('HVAC Expert');

        // Toggle verification
        $verifyResponse = $this->actingAs($this->admin)->patch(route('admin.technicians.verify', $professional));
        $verifyResponse->assertRedirect();

        $this->assertTrue((bool) $professional->fresh()->is_verified);
    }

    public function test_admin_can_view_bookings_board(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.bookings'));

        $response->assertStatus(200);
        $response->assertSee('All Platform Bookings');
        $response->assertSee('Escrow Protection');
    }

    public function test_admin_can_view_analytics_and_ai_diagnostics(): void
    {
        $responseAnalytics = $this->actingAs($this->admin)->get(route('admin.analytics'));
        $responseAnalytics->assertStatus(200);
        $responseAnalytics->assertSee('Recommendation & AI Matching Analytics');

        $responseScans = $this->actingAs($this->admin)->get(route('admin.ai-diagnostics'));
        $responseScans->assertStatus(200);
        $responseScans->assertSee('AI Diagnostic Logs & Neural Computer Vision');
    }

    public function test_admin_can_view_payments_and_settings(): void
    {
        $responsePayments = $this->actingAs($this->admin)->get(route('admin.payments'));
        $responsePayments->assertStatus(200);
        $responsePayments->assertSee('Escrow & Financial Settlements');

        $responseSettings = $this->actingAs($this->admin)->get(route('admin.settings'));
        $responseSettings->assertStatus(200);
        $responseSettings->assertSee('Platform System Configuration');
    }
}
