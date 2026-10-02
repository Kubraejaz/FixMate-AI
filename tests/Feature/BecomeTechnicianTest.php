<?php

namespace Tests\Feature;

use App\Models\Profession;
use App\Models\TechnicianApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BecomeTechnicianTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_view_become_technician_landing_page(): void
    {
        $profession = Profession::create([
            'name' => 'HVAC Expert',
            'slug' => 'hvac-expert',
            'description' => 'Air conditioner repair and installation',
            'is_active' => true,
        ]);

        $response = $this->get(route('become-technician'));

        $response->assertStatus(200);
        $response->assertSee('Work On Your Schedule');
        $response->assertSee('HVAC Expert');
        $response->assertSee('Estimate Your Monthly Income');
    }

    public function test_candidate_can_submit_partner_application(): void
    {
        $profession = Profession::create([
            'name' => 'Master Electrician',
            'slug' => 'master-electrician',
            'description' => 'Wiring and circuit diagnostics',
            'is_active' => true,
        ]);

        $payload = [
            'name' => 'Kashif Mehmood',
            'phone' => '0312-3456789',
            'email' => 'kashif@example.com',
            'cnic_number' => '35201-1122334-7',
            'profession_id' => $profession->id,
            'city' => 'Lahore',
            'experience_years' => 5,
            'workshop_type' => 'freelancer',
            'tools_available' => 'has_own_tools',
            'documents_list' => 'CNIC, Police Certificate',
        ];

        $response = $this->post(route('become-technician.store'), $payload);

        $response->assertRedirect(route('become-technician'));
        $response->assertSessionHas('success_application');
        $response->assertSessionHas('app_ref');

        $this->assertDatabaseHas('technician_applications', [
            'name' => 'Kashif Mehmood',
            'email' => 'kashif@example.com',
            'cnic_number' => '35201-1122334-7',
            'city' => 'Lahore',
            'profession_id' => $profession->id,
            'status' => 'pending',
        ]);
    }
}
