<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_portal_pages(): void
    {
        $this->get('/customer/dashboard')->assertRedirect(route('login'));
        $this->get('/technician/dashboard')->assertRedirect(route('login'));
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
    }

    public function test_customer_is_blocked_from_admin_portal(): void
    {
        $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);

        $this->actingAs($customer)
            ->get('/admin/dashboard')
            ->assertRedirect('/customer/dashboard');
    }

    public function test_customer_is_blocked_from_technician_portal(): void
    {
        $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);

        $this->actingAs($customer)
            ->get('/technician/dashboard')
            ->assertRedirect('/customer/dashboard');
    }

    public function test_technician_is_blocked_from_customer_portal(): void
    {
        $tech = User::factory()->create(['role' => User::ROLE_TECHNICIAN]);

        $this->actingAs($tech)
            ->get('/customer/dashboard')
            ->assertRedirect('/technician/dashboard');
    }

    public function test_technician_is_blocked_from_admin_portal(): void
    {
        $tech = User::factory()->create(['role' => User::ROLE_TECHNICIAN]);

        $this->actingAs($tech)
            ->get('/admin/dashboard')
            ->assertRedirect('/technician/dashboard');
    }

    public function test_admin_is_blocked_from_customer_portal(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get('/customer/dashboard')
            ->assertRedirect('/admin/dashboard');
    }

    public function test_admin_can_access_admin_portal(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_customer_can_access_customer_portal(): void
    {
        $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);

        $this->actingAs($customer)
            ->get('/customer/dashboard')
            ->assertOk();
    }

    public function test_technician_can_access_technician_portal(): void
    {
        $tech = User::factory()->create(['role' => User::ROLE_TECHNICIAN]);

        $this->actingAs($tech)
            ->get('/technician/dashboard')
            ->assertOk();
    }
}