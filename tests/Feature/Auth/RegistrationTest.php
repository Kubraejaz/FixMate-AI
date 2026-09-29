<?php

namespace Tests\Feature\Auth;

use App\Models\Technician;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_with_email(): void
    {
        Notification::fake();

        $response = $this->post(route('register.customer.store', [
            'name' => 'Fatima Noor',
            'identifier' => 'fatima@example.com',
            'city' => 'Karachi — DHA, Clifton, Gulshan, Nazimabad',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]));

        $response->assertRedirect(route('verify-otp'));

        $this->assertDatabaseHas('users', [
            'email' => 'fatima@example.com',
            'phone' => null,
            'role' => User::ROLE_CUSTOMER,
            'is_active' => true,
        ]);

        Notification::assertSentTo(
            User::where('email', 'fatima@example.com')->first(),
            OtpNotification::class
        );
    }

    public function test_customer_can_register_with_phone(): void
    {
        Notification::fake();

        $this->post(route('register.customer.store', [
            'name' => 'Bilal Tariq',
            'identifier' => '0321-7654321',
            'city' => 'Lahore — Gulberg, DHA, Cantt, Johar Town',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]));

        $this->assertDatabaseHas('users', [
            'phone' => '03217654321',
            'email' => null,
            'role' => User::ROLE_CUSTOMER,
        ]);
    }

    public function test_role_parameter_cannot_escalate_registration(): void
    {
        Notification::fake();

        $this->post(route('register.customer.store'), [
            'name' => 'Ali Sub',
            'identifier' => 'ali-sub@example.com',
            'city' => 'Karachi',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
            'role' => User::ROLE_ADMIN,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'ali-sub@example.com',
            'role' => User::ROLE_CUSTOMER,
        ]);
    }

    public function test_technician_registration_creates_profile_with_encrypted_cnic(): void
    {
        Notification::fake();

        $this->post(route('register.technician.store'), [
            'name' => 'Rida Ahmed',
            'phone' => '0333-1112223',
            'cnic' => '42201-1234567-1',
            'experience' => '3 - 5 Years',
            'trade' => 'Electrical — Wiring, Breakers, DB Boxes',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]);

        $user = User::where('phone', '03331112223')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->isTechnician());

        $this->assertDatabaseHas('technicians', [
            'user_id' => $user->id,
            'trade' => 'Electrical — Wiring, Breakers, DB Boxes',
            'is_verified' => false,
        ]);

        $profile = Technician::where('user_id', $user->id)->firstOrFail();

        $this->assertNotSame('42201-1234567-1', $profile->getRawOriginal('cnic_number'));
        $this->assertSame('42201-1234567-1', $profile->cnic_number);
    }

    public function test_duplicate_phone_is_rejected(): void
    {
        User::factory()->create(['phone' => '03332225566', 'role' => User::ROLE_CUSTOMER]);

        $response = $this->post(route('register.customer.store'), [
            'name' => 'Duplicate User',
            'identifier' => '0333-2225566',
            'city' => 'Karachi',
            'password' => 'secretpass123',
            'password_confirmation' => 'secretpass123',
        ]);

        $response->assertSessionHasErrors('identifier');
    }

    public function test_password_confirmation_mismatch_is_rejected(): void
    {
        $response = $this->post(route('register.customer.store'), [
            'name' => 'Mismatch User',
            'identifier' => 'mismatch@example.com',
            'city' => 'Karachi',
            'password' => 'secretpass123',
            'password_confirmation' => 'differentpass',
        ]);

        $response->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'mismatch@example.com']);
    }
}