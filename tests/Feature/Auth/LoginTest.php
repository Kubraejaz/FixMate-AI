<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_login_with_email(): void
    {
        $user = User::factory()->create([
            'email' => 'customer-login@example.com',
            'password' => 'secretpass123',
            'role' => User::ROLE_CUSTOMER,
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => 'customer-login@example.com',
            'password' => 'secretpass123',
        ]);

        $response->assertRedirect('/customer/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_customer_can_login_with_phone(): void
    {
        $user = User::factory()->create([
            'phone' => '03115559988',
            'password' => 'secretpass123',
            'role' => User::ROLE_CUSTOMER,
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => '0311-5559988',
            'password' => 'secretpass123',
        ]);

        $response->assertRedirect('/customer/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_email_login_is_case_insensitive(): void
    {
        User::factory()->create([
            'email' => 'CaseLogin@Example.Com',
            'password' => 'secretpass123',
            'role' => User::ROLE_CUSTOMER,
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => 'caselogin@example.com',
            'password' => 'secretpass123',
        ]);

        $response->assertRedirect('/customer/dashboard');
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin-login@example.com',
            'password' => 'secretpass123',
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => 'admin-login@example.com',
            'password' => 'secretpass123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_technician_login_redirects_to_technician_dashboard(): void
    {
        $tech = User::factory()->create([
            'phone' => '03459998877',
            'password' => 'secretpass123',
            'role' => User::ROLE_TECHNICIAN,
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => '03459998877',
            'password' => 'secretpass123',
        ]);

        $response->assertRedirect('/technician/dashboard');
        $this->assertAuthenticatedAs($tech);
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()->create([
            'email' => 'disabled@example.com',
            'password' => 'secretpass123',
            'is_active' => false,
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => 'disabled@example.com',
            'password' => 'secretpass123',
        ]);

        $response->assertSessionHasErrors('identifier');
        $this->assertGuest();
    }

    public function test_wrong_password_is_rejected(): void
    {
        User::factory()->create([
            'email' => 'wrongpass@example.com',
            'password' => 'secretpass123',
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => 'wrongpass@example.com',
            'password' => 'not-the-password',
        ]);

        $response->assertSessionHasErrors('identifier');
        $this->assertGuest();
    }
}