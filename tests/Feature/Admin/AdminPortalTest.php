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
        $response->assertSee('Service Quality &amp; Escrow Health', false);
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
        $responseAnalytics->assertSee('Trade Demand &amp; Growth Analytics', false);

        $responseScans = $this->actingAs($this->admin)->get(route('admin.ai-diagnostics'));
        $responseScans->assertRedirect(route('admin.analytics'));
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

    public function test_admin_can_view_notifications_page(): void
    {
        \App\Models\Notification::create([
            'user_id' => $this->admin->id,
            'type' => 'alert',
            'title' => 'Critical System Alert',
            'message' => 'New technician document verification submitted.',
            'link' => route('admin.technicians'),
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.notifications'));
        $response->assertStatus(200);
        $response->assertSee('Platform Alerts');
        $response->assertSee('Critical System Alert');
        $response->assertSee('New technician document verification submitted.');
    }

    public function test_admin_can_open_notification_and_mark_read(): void
    {
        $notification = \App\Models\Notification::create([
            'user_id' => $this->admin->id,
            'type' => 'alert',
            'title' => 'Urgent Escrow Update',
            'message' => 'Escrow held for booking FM-991.',
            'link' => route('admin.payments'),
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.notifications.open', $notification->id));
        $response->assertRedirect(route('admin.payments'));

        $this->assertTrue((bool) $notification->fresh()->is_read);
    }

    public function test_admin_can_mark_all_notifications_read(): void
    {
        \App\Models\Notification::create([
            'user_id' => $this->admin->id,
            'type' => 'booking',
            'title' => 'Booking 1',
            'message' => 'Test message 1',
            'is_read' => false,
        ]);
        \App\Models\Notification::create([
            'user_id' => $this->admin->id,
            'type' => 'booking',
            'title' => 'Booking 2',
            'message' => 'Test message 2',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.notifications.read-all'));
        $response->assertRedirect();

        $unreadCount = \App\Models\Notification::where('user_id', $this->admin->id)->where('is_read', false)->count();
        $this->assertEquals(0, $unreadCount);
    }
}

