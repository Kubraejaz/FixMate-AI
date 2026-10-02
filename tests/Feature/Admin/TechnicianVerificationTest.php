<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TechnicianVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_kyc_verification_pipeline(): void
    {
        $admin = User::factory()->admin()->create();

        $profession = Profession::create([
            'name' => 'Plumbing',
            'slug' => 'plumbing',
            'is_active' => true,
        ]);

        TechnicianApplication::create([
            'reference_no' => 'FM-APP-7701',
            'profession_id' => $profession->id,
            'name' => 'Waseem Akram',
            'phone' => '0300-9988776',
            'email' => 'waseem@example.com',
            'cnic_number' => '42201-5544332-1',
            'city' => 'Karachi',
            'experience_years' => 6,
            'workshop_type' => 'freelancer',
            'tools_available' => 'has_own_tools',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.technicians.verification'));

        $response->assertStatus(200);
        $response->assertSee('KYC Verification Pipeline');
        $response->assertSee('Waseem Akram');
        $response->assertSee('42201-5544332-1');
    }

    public function test_non_admin_cannot_access_verification_pipeline(): void
    {
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->get(route('admin.technicians.verification'));
        $response->assertRedirect('/customer/dashboard');
    }

    public function test_admin_can_approve_application_and_verify_technician(): void
    {
        $admin = User::factory()->admin()->create();

        $profession = Profession::create([
            'name' => 'Plumbing',
            'slug' => 'plumbing',
            'is_active' => true,
        ]);

        $techUser = User::factory()->technician()->create([
            'email' => 'tech.approval@example.com',
            'phone' => '0333-1122334',
            'is_verified' => false,
        ]);

        Professional::create([
            'user_id' => $techUser->id,
            'profession_id' => $profession->id,
            'name' => $techUser->name,
            'email' => $techUser->email,
            'phone' => $techUser->phone,
            'is_verified' => false,
        ]);

        $app = TechnicianApplication::create([
            'reference_no' => 'FM-APP-7702',
            'user_id' => $techUser->id,
            'profession_id' => $profession->id,
            'name' => $techUser->name,
            'phone' => $techUser->phone,
            'email' => $techUser->email,
            'cnic_number' => '42101-7788990-3',
            'city' => 'Islamabad',
            'experience_years' => 4,
            'workshop_type' => 'freelancer',
            'tools_available' => 'has_own_tools',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.technicians.verification.approve', $app), [
            'admin_notes' => 'NADRA verified.',
        ]);

        $response->assertRedirect(route('admin.technicians.verification'));
        $response->assertSessionHas('success');

        $app->refresh();
        $this->assertEquals('approved', $app->status);

        $techUser->refresh();
        $this->assertTrue((bool) $techUser->is_verified);

        $professional = Professional::where('user_id', $techUser->id)->first();
        $this->assertTrue((bool) $professional->is_verified);
    }

    public function test_admin_can_reject_application_with_reason(): void
    {
        $admin = User::factory()->admin()->create();

        $profession = Profession::create([
            'name' => 'Solar Maintenance',
            'slug' => 'solar-maintenance',
            'is_active' => true,
        ]);

        $app = TechnicianApplication::create([
            'reference_no' => 'FM-APP-7703',
            'profession_id' => $profession->id,
            'name' => 'Candidate to reject',
            'phone' => '0345-1234567',
            'email' => 'reject@example.com',
            'cnic_number' => '42201-9999999-9',
            'city' => 'Peshawar',
            'experience_years' => 1,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.technicians.verification.reject', $app), [
            'reason' => 'Invalid CNIC provided upon NADRA lookup.',
        ]);

        $response->assertRedirect(route('admin.technicians.verification'));
        $response->assertSessionHas('success');

        $app->refresh();
        $this->assertEquals('rejected', $app->status);
        $this->assertEquals('Invalid CNIC provided upon NADRA lookup.', $app->admin_notes);
    }
}
