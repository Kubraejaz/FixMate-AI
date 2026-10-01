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
            'description' => 'Solar panel maintenance and inverter setup',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.categories'));

        $response->assertOk();
        $response->assertSee('Solar Specialist');
        $response->assertSee('Services &amp; Professions Catalog', false);
    }

    public function test_admin_can_create_a_new_service_category(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'CCTV & Smart Security',
            'slug' => 'cctv-smart-security',
            'description' => 'IP camera installation and DVR repair',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.categories'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('professions', [
            'name' => 'CCTV & Smart Security',
            'slug' => 'cctv-smart-security',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_an_existing_service(): void
    {
        $admin = User::factory()->admin()->create();

        $service = Profession::create([
            'name' => 'Old Service Name',
            'slug' => 'old-service-name',
            'description' => 'Old description',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.categories.update', $service->id), [
            'name' => 'Updated Service Name',
            'slug' => 'updated-service-name',
            'description' => 'Updated description text',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.categories'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('professions', [
            'id' => $service->id,
            'name' => 'Updated Service Name',
            'slug' => 'updated-service-name',
        ]);
    }

    public function test_admin_can_toggle_service_status(): void
    {
        $admin = User::factory()->admin()->create();

        $service = Profession::create([
            'name' => 'Test Service',
            'slug' => 'test-service',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.categories.toggle', $service->id));

        $response->assertRedirect(route('admin.categories'));

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

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $service->id));

        $response->assertRedirect(route('admin.categories'));
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

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $service->id));

        $response->assertRedirect(route('admin.categories'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('professions', [
            'id' => $service->id,
        ]);
    }

    public function test_customer_cannot_access_admin_services(): void
    {
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->get(route('admin.categories'));

        $response->assertRedirect('/customer/dashboard');
    }
}
