<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OtpTest extends TestCase
{
    use RefreshDatabase;

    private function digits(string $code): array
    {
        return str_split($code);
    }

    private function capturedCode(User $user): string
    {
        $code = null;

        Notification::assertSentTo($user, OtpNotification::class, function ($notification) use (&$code) {
            $code = $notification->code;

            return true;
        });

        return (string) $code;
    }

    public function test_customer_registration_completes_after_otp(): void
    {
        Notification::fake();

        $this->post(route('register.customer.store'), [
            'name' => 'OTP Customer',
            'identifier' => 'otp-customer@example.com',
            'city' => 'Karachi',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]);

        $user = User::where('email', 'otp-customer@example.com')->firstOrFail();
        $code = $this->capturedCode($user);

        $response = $this->post('/verify-otp', [
            'identifier' => 'otp-customer@example.com',
            'otp' => $this->digits($code),
        ]);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertAuthenticatedAs($user);

        $this->assertNotNull($user->fresh()->contact_verified_at);
    }

    public function test_technician_registration_lands_on_verification_after_otp(): void
    {
        Notification::fake();

        $this->post(route('register.technician.store'), [
            'name' => 'OTP Technician',
            'phone' => '0346-1122334',
            'cnic' => '42201-0000000-1',
            'experience' => '1 - 2 Years',
            'trade' => 'Carpentry & Locksmith',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]);

        $user = User::where('phone', '03461122334')->firstOrFail();
        $code = $this->capturedCode($user);

        $response = $this->post('/verify-otp', [
            'identifier' => '03461122334',
            'otp' => $this->digits($code),
        ]);

        $response->assertRedirect(route('technician.verification'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_resend_issues_a_new_working_code(): void
    {
        Notification::fake();

        $this->post(route('register.customer.store'), [
            'name' => 'Resend Customer',
            'identifier' => 'resend@example.com',
            'city' => 'Lahore',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]);

        $user = User::where('email', 'resend@example.com')->firstOrFail();
        $staleCode = $this->capturedCode($user);

        $this->post(route('verify-otp.resend'))
            ->assertRedirect(route('verify-otp'))
            ->assertSessionHas('status');

        $freshCode = $this->capturedCode($user);
        $this->assertNotSame($staleCode, $freshCode);

        $this->post('/verify-otp', [
            'identifier' => 'resend@example.com',
            'otp' => ['0', '0', '0', '0', '0', '0'],
        ])->assertSessionHasErrors('otp');

        $this->post('/verify-otp', [
            'identifier' => 'resend@example.com',
            'otp' => $this->digits($freshCode),
        ])->assertRedirect(route('customer.dashboard'));
    }

    public function test_resend_requires_an_active_verification_session(): void
    {
        $this->post(route('verify-otp.resend'))->assertRedirect(route('register'));
    }

    public function test_wrong_otp_is_rejected_and_attempts_increment(): void
    {
        Notification::fake();

        $this->post(route('register.customer.store'), [
            'name' => 'Wrong OTP',
            'identifier' => 'wrong-otp@example.com',
            'city' => 'Lahore',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]);

        $user = User::where('email', 'wrong-otp@example.com')->firstOrFail();
        $this->capturedCode($user);

        $response = $this->post('/verify-otp', [
            'identifier' => 'wrong-otp@example.com',
            'otp' => ['0', '0', '0', '0', '0', '0'],
        ]);

        $response->assertSessionHasErrors('otp');
        $this->assertGuest();
        $this->assertSame(1, (int) $user->fresh()->otp_attempts);
    }

    public function test_expired_otp_is_rejected(): void
    {
        Notification::fake();

        $this->post(route('register.customer.store'), [
            'name' => 'Expired OTP',
            'identifier' => 'expired-otp@example.com',
            'city' => 'Lahore',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]);

        $user = User::where('email', 'expired-otp@example.com')->firstOrFail();
        $code = $this->capturedCode($user);

        $user->forceFill(['otp_expires_at' => now()->subMinute()])->save();

        $response = $this->post('/verify-otp', [
            'identifier' => 'expired-otp@example.com',
            'otp' => $this->digits($code),
        ]);

        $response->assertSessionHasErrors('otp');
        $this->assertGuest();
    }

    public function test_password_reset_flow_uses_otp(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'reset-me@example.com',
            'password' => 'oldpassword123',
        ]);

        $this->post(route('forgot-password.store'), [
            'identifier' => 'reset-me@example.com',
        ])->assertRedirect(route('verify-otp'));

        $code = $this->capturedCode($user);

        $this->post('/verify-otp', [
            'identifier' => 'reset-me@example.com',
            'otp' => $this->digits($code),
        ])->assertRedirect(route('reset-password'));

        $this->post(route('reset-password.store'), [
            'identifier' => 'reset-me@example.com',
            'password' => 'freshpassword456',
            'password_confirmation' => 'freshpassword456',
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('freshpassword456', $user->fresh()->password));
        $this->assertFalse(Hash::check('oldpassword123', $user->fresh()->password));
    }

    public function test_reset_password_requires_otp_approval(): void
    {
        $user = User::factory()->create([
            'email' => 'no-otp@example.com',
            'password' => 'oldpassword123',
        ]);

        $response = $this->post(route('reset-password.store'), [
            'identifier' => 'no-otp@example.com',
            'password' => 'freshpassword456',
            'password_confirmation' => 'freshpassword456',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('oldpassword123', $user->fresh()->password));
    }
}