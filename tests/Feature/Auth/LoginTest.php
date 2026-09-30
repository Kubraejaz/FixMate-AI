<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
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
            'phone' => OtpService::normalizePhone('03115559988'),
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

    /**
     * A number stored in E.164 must be found no matter how the user spells it
     * on the login form, otherwise login silently fails on an exact match.
     */
    public function test_stored_phone_is_found_regardless_of_how_it_is_typed(): void
    {
        $user = User::factory()->create([
            'phone' => '+923441234567',
            'password' => 'secretpass123',
            'role' => User::ROLE_TECHNICIAN,
        ]);

        $spellings = [
            '+923441234567',
            '00923441234567',
            '923441234567',
            '03441234567',
            '0344-1234567',
            '3441234567',
            '0344 1234567',
        ];

        foreach ($spellings as $typed) {
            $found = OtpService::findByIdentifier($typed);

            $this->assertNotNull($found, "No match for format: {$typed}");
            $this->assertTrue($user->is($found), "Wrong user matched for format: {$typed}");
        }
    }

    public function test_technician_can_log_in_with_the_national_phone_format(): void
    {
        $user = User::factory()->create([
            'phone' => '+923441234567',
            'password' => 'secretpass123',
            'role' => User::ROLE_TECHNICIAN,
        ]);

        $response = $this->post(route('login.store'), [
            'identifier' => '0344-1234567',
            'password' => 'secretpass123',
        ]);

        $response->assertRedirect('/technician/dashboard');
        $this->assertTrue(Auth::check() && Auth::user()->is($user));
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
            'phone' => OtpService::normalizePhone('03459998877'),
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