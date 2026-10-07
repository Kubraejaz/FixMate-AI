<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_services_catalog(): void
    {
        $admin = User::factory()->admin()->create();

        Profession::create([
            'name' => 'Solar Specialist',
            'slug' => 'solar-specialist',
            'base_price' => 1200,
            'price_unit' => 'visit',
            'description' => 'Solar panel maintenance and inverter setup',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.services'));

        $response->assertOk();
        $response->assertSee('Solar Specialist');
        $response->assertSee('Rs. 1,200');
        $response->assertSee('visit');
    }

    public function test_admin_can_create_a_new_service_category(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.services.store'), [
            'name' => 'CCTV & Smart Security',
            'slug' => 'cctv-smart-security',
            'icon' => '📹',
            'base_price' => 1500,
            'price_unit' => 'service',
            'estimated_duration' => '45 – 90 mins',
            'headline' => 'HD IP Camera Installation & Smart Monitoring',
            'warranty_text' => '90-Day Protection Guarantee',
            'sub_categories' => "IP Camera Installation\nDVR & NVR Setup\nNight Vision Tuning\nMobile App Streaming",
            'feature_points' => "Night vision camera calibration\nDVR/NVR cloud setup\nMobile app live view configuration",
            'included_items' => "Full wiring conduit audit\nBNC connector fitting\nMobile remote view setup",
            'excluded_items' => "Hard disk drive hardware\nCoaxial cable beyond 30 meters",
            'description' => 'IP camera installation and DVR repair',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.services'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('professions', [
            'name' => 'CCTV & Smart Security',
            'slug' => 'cctv-smart-security',
            'base_price' => 1500,
            'price_unit' => 'service',
            'is_active' => true,
        ]);

        $service = Profession::where('slug', 'cctv-smart-security')->first();
        $this->assertNotNull($service);
        $this->assertCount(4, $service->sub_categories);
        $this->assertEquals('IP Camera Installation', $service->sub_categories[0]);
        $this->assertCount(3, $service->feature_points);
        $this->assertEquals('Night vision camera calibration', $service->feature_points[0]);
    }

    public function test_admin_can_update_an_existing_service(): void
    {
        $admin = User::factory()->admin()->create();

        $service = Profession::create([
            'name' => 'Old Service Name',
            'slug' => 'old-service-name',
            'base_price' => 500,
            'price_unit' => 'base',
            'description' => 'Old description',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.services.update', $service->id), [
            'name' => 'Updated Master Plumber',
            'slug' => 'updated-master-plumber',
            'icon' => '💧',
            'base_price' => 950,
            'price_unit' => 'service',
            'estimated_duration' => '30 – 45 mins',
            'headline' => 'Modern Bathroom Fitting & Leak Repairs',
            'warranty_text' => '60-Day Rework Escrow',
            'sub_categories' => "Pipe Leakage Ultrasonic Check\nTeflon Sealing Joint Fitting",
            'feature_points' => "Pipe leakage ultrasonic inspection\nTeflon sanitary thread sealing",
            'description' => 'Updated description text',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.services'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('professions', [
            'id' => $service->id,
            'name' => 'Updated Master Plumber',
            'slug' => 'updated-master-plumber',
            'base_price' => 950,
            'price_unit' => 'service',
        ]);

        $service->refresh();
        $this->assertCount(2, $service->sub_categories);
        $this->assertEquals('Pipe Leakage Ultrasonic Check', $service->sub_categories[0]);
        $this->assertCount(2, $service->feature_points);
        $this->assertEquals('Pipe leakage ultrasonic inspection', $service->feature_points[0]);
    }

    public function test_admin_can_toggle_service_status(): void
    {
        $admin = User::factory()->admin()->create();

        $service = Profession::create([
            'name' => 'Test Service',
            'slug' => 'test-service',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.services.toggle', $service->id));

        $response->assertRedirect(route('admin.services'));

        $this->assertDatabaseHas('professions', [
            'id' => $service->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_cannot_delete_service_with_linked_technicians(): void
    {
        $admin = User::factory()->admin()->create();

        $service = Profession::create([
            'name' => 'Plumber Special',
            'slug' => 'plumber-special',
            'is_active' => true,
        ]);

        $techUser = User::factory()->technician()->create();

        Professional::create([
            'user_id' => $techUser->id,
            'profession_id' => $service->id,
            'name' => 'Test Plumber',
            'email' => 'tech@example.com',
            'phone' => '+923001234567',
            'cnic_number' => '42101-1234567-1',
            'experience' => '5 years',
            'is_verified' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.services.destroy', $service->id));

        $response->assertRedirect(route('admin.services'));
        $response->assertSessionHas('error');

        // Service should still exist in DB
        $this->assertDatabaseHas('professions', [
            'id' => $service->id,
        ]);
    }

    public function test_admin_can_delete_unused_service(): void
    {
        $admin = User::factory()->admin()->create();

        $service = Profession::create([
            'name' => 'Unused Trade',
            'slug' => 'unused-trade',
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.services.destroy', $service->id));

        $response->assertRedirect(route('admin.services'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('professions', [
            'id' => $service->id,
        ]);
    }

    public function test_public_services_page_displays_dynamic_service_attributes(): void
    {
        Profession::create([
            'name' => 'Solar Maintenance Pro',
            'slug' => 'solar-maintenance-pro',
            'icon' => '☀️',
            'base_price' => 1850,
            'price_unit' => 'panel',
            'estimated_duration' => '1 – 2 hours',
            'feature_points' => ['Solar inverter string diagnosis', 'PV cell dust & micro-crack wash'],
            'description' => 'Solar panel maintenance and inverter setup',
            'is_active' => true,
        ]);

        $response = $this->get(route('services'));

        $response->assertOk();
        $response->assertSee('Solar Maintenance Pro');
        $response->assertSee('Rs. 1,850');
        $response->assertSee('panel');
        $response->assertSee('Solar inverter string diagnosis');
    }

    public function test_public_service_details_page_displays_dynamic_service_content(): void
    {
        $prof = Profession::create([
            'name' => 'HVAC Duct Specialist',
            'slug' => 'hvac-duct-specialist',
            'icon' => '❄️',
            'base_price' => 2200,
            'price_unit' => 'unit',
            'headline' => 'Central Air Duct Sanitation & Filter Refresh',
            'estimated_duration' => '2 – 3 hours',
            'warranty_text' => '45-Day Pure Air Escrow',
            'feature_points' => ['Duct pressure differential check'],
            'included_items' => ['HEPA vacuum suction', 'Antibacterial fogging mist'],
            'excluded_items' => ['Galvanized sheet metal duct fabrication'],
            'description' => 'Full HVAC inspection and cleaning for homes.',
            'is_active' => true,
        ]);

        $response = $this->get('/services/' . $prof->slug);

        $response->assertOk();
        $response->assertSee('HVAC Duct Specialist');
        $response->assertSee('Central Air Duct Sanitation & Filter Refresh');
        $response->assertSee('Rs. 2,200');
        $response->assertSee('45-Day Pure Air Escrow');
        $response->assertSee('HEPA vacuum suction');
        $response->assertSee('Galvanized sheet metal duct fabrication');
    }

    public function test_customer_cannot_access_admin_services(): void
    {
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->get(route('admin.categories'));

        $response->assertRedirect('/customer/dashboard');
    }
}
