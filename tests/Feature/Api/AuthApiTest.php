<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_verify_otp(): void
    {
        $register = $this->postJson('/api/v1/auth/register/customer', [
            'name' => 'Sara Ahmed',
            'identifier' => 'sara.api@example.com',
            'city' => 'Karachi',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
            'device_name' => 'phpunit',
        ]);

        $register->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.requires_otp', true)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['user', 'identifier', 'masked_identifier', 'requires_otp', 'otp'],
            ]);

        $otp = $register->json('data.otp');
        $this->assertNotNull($otp);

        $verify = $this->postJson('/api/v1/auth/verify-otp', [
            'identifier' => 'sara.api@example.com',
            'otp' => $otp,
        ]);

        $verify->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['token', 'token_type', 'user']]);
    }

    public function test_customer_can_login_and_fetch_profile_with_bearer_token(): void
    {
        $user = User::factory()->customer()->create([
            'email' => 'login.api@example.com',
            'password' => 'secretpass123',
        ]);

        $login = $this->postJson('/api/v1/auth/login', [
            'identifier' => 'login.api@example.com',
            'password' => 'secretpass123',
            'device_name' => 'phpunit',
        ]);

        $login->assertOk()->assertJsonPath('success', true);

        $token = $login->json('data.token');
        $this->assertNotEmpty($token);

        $me = $this->withHeader('Authorization', "Bearer {$token}")->getJson('/api/v1/auth/me');

        $me->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.role', 'customer');
    }

    public function test_login_with_invalid_credentials_returns_validation_error(): void
    {
        User::factory()->customer()->create([
            'email' => 'wrongpass.api@example.com',
            'password' => 'secretpass123',
        ]);

        $this->postJson('/api/v1/auth/login', [
            'identifier' => 'wrongpass.api@example.com',
            'password' => 'not-the-password',
        ])
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonValidationErrors(['identifier']);
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()->customer()->create([
            'email' => 'blocked.api@example.com',
            'password' => 'secretpass123',
            'is_active' => false,
        ]);

        $this->postJson('/api/v1/auth/login', [
            'identifier' => 'blocked.api@example.com',
            'password' => 'secretpass123',
        ])
            ->assertStatus(403)
            ->assertJsonPath('success', false);
    }

    public function test_password_reset_flow_issues_and_consumes_otp(): void
    {
        User::factory()->customer()->create([
            'email' => 'reset.api@example.com',
            'password' => 'oldpassword123',
        ]);

        $forgot = $this->postJson('/api/v1/auth/forgot-password', [
            'identifier' => 'reset.api@example.com',
        ])->assertOk();

        $otp = $forgot->json('data.otp');
        $this->assertNotNull($otp);

        $this->postJson('/api/v1/auth/reset-password', [
            'identifier' => 'reset.api@example.com',
            'otp' => $otp,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertOk()->assertJsonPath('success', true);

        $this->postJson('/api/v1/auth/login', [
            'identifier' => 'reset.api@example.com',
            'password' => 'newpassword123',
        ])->assertOk()->assertJsonPath('success', true);
    }

    public function test_guest_cannot_access_protected_endpoints(): void
    {
        $this->getJson('/api/v1/customer/dashboard')->assertStatus(401);
        $this->getJson('/api/v1/technician/dashboard')->assertStatus(401);
        $this->getJson('/api/v1/admin/dashboard')->assertStatus(401);
    }

    public function test_customer_cannot_access_technician_or_admin_endpoints(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer, 'sanctum')
            ->getJson('/api/v1/technician/dashboard')
            ->assertStatus(403)
            ->assertJsonPath('success', false);

        $this->actingAs($customer, 'sanctum')
            ->getJson('/api/v1/admin/dashboard')
            ->assertStatus(403)
            ->assertJsonPath('success', false);
    }
}
