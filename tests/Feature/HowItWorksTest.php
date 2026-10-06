<?php

namespace Tests\Feature;

use App\Models\HomepageSetting;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use App\Models\WorkflowStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HowItWorksTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_dynamic_how_it_works_page_with_cms_steps(): void
    {
        $profession = Profession::create([
            'name' => 'Certified Electrician',
            'slug' => 'certified-electrician',
            'base_price' => 850,
            'price_unit' => 'base',
            'description' => 'Fix short circuits and wiring',
            'is_active' => true,
        ]);

        WorkflowStep::create([
            'step_number' => 1,
            'title' => 'Custom AI Defect Upload',
            'description' => 'Upload clear photos of the leaking pipe or short circuit.',
            'icon' => '📸',
            'badge_color' => '#FFB800',
            'is_active' => true,
        ]);

        $response = $this->get(route('how-it-works'));

        $response->assertStatus(200);
        $response->assertSee('FixMate');
        $response->assertSee('Certified Electrician');
        $response->assertSee('Custom AI Defect Upload');
        $response->assertSee('Try Our Upfront Pricing Engine');
    }

    public function test_user_can_view_dynamic_about_page_with_active_trades(): void
    {
        Profession::create([
            'name' => 'Master Plumber',
            'slug' => 'master-plumber',
            'base_price' => 700,
            'is_active' => true,
        ]);

        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('FixMate');
        $response->assertSee('Master Plumber');
        $response->assertSee('Certified Trade Disciplines');
    }

    public function test_user_can_view_dynamic_technician_profile(): void
    {
        $user = User::factory()->technician()->create(['city' => 'Karachi — Clifton']);
        $profession = Profession::create([
            'name' => 'Master Plumber',
            'slug' => 'master-plumber',
            'base_price' => 950,
            'price_unit' => 'visit',
            'warranty_text' => '45-Day Rework Guarantee',
            'is_active' => true,
        ]);

        $pro = Professional::create([
            'user_id' => $user->id,
            'profession_id' => $profession->id,
            'name' => 'Tariq Mehmood',
            'email' => 'tariq@example.com',
            'phone' => '+923001234567',
            'cnic_number' => '42101-1234567-1',
            'experience' => '8 years',
            'is_verified' => true,
            'description' => 'Dedicated plumbing contractor specialized in geysers, pumps, and PVC installations.',
            'sub_categories' => ['Pipe Leakage & Repair', 'Water Tank Cleaning'],
        ]);

        $response = $this->get('/technicians/' . $pro->id);

        $response->assertStatus(200);
        $response->assertSee('Tariq Mehmood');
        $response->assertSee('Master Plumber');
        $response->assertSee('Rs. 950');
        $response->assertSee('45-Day Rework Guarantee');
        $response->assertSee('Karachi — Clifton');
        $response->assertSee('Dedicated plumbing contractor specialized in geysers, pumps, and PVC installations.');
        $response->assertSee('Pipe Leakage &amp; Repair', false);
    }

    public function test_public_services_page_displays_categories_and_sub_categories(): void
    {
        Profession::create([
            'name' => 'HVAC & AC Service',
            'slug' => 'ac-service',
            'base_price' => 1200,
            'is_active' => true,
            'sub_categories' => ['Split AC Deep Chemical Wash', 'Inverter Error Code Diagnostic'],
        ]);

        $response = $this->get(route('services'));
        $response->assertStatus(200);
        $response->assertSee('HVAC &amp; AC Service', false);
        $response->assertSee('Split AC Deep Chemical Wash');
        $response->assertSee('Inverter Error Code Diagnostic');
    }

    public function test_public_service_details_page_displays_sub_categories(): void
    {
        $prof = Profession::create([
            'name' => 'Carpentry & Woodwork',
            'slug' => 'carpentry',
            'base_price' => 1000,
            'is_active' => true,
            'sub_categories' => ['Door Lock & Hinge Fix', 'Custom Cabinet Assembly'],
        ]);

        $response = $this->get(route('service-details', $prof->slug));
        $response->assertStatus(200);
        $response->assertSee('Carpentry &amp; Woodwork', false);
        $response->assertSee('Sub-Categories &amp; Specialized Coverage', false);
        $response->assertSee('Door Lock &amp; Hinge Fix', false);
        $response->assertSee('Custom Cabinet Assembly');
    }

    public function test_privacy_and_terms_pages_display_dynamic_warranty_settings(): void
    {
        HomepageSetting::instance()->update([
            'warranty_days' => 45,
        ]);

        $privacy = $this->get(route('privacy-policy'));
        $privacy->assertStatus(200);
        $privacy->assertSee('45-day re-work protection warranty');

        $terms = $this->get(route('terms'));
        $terms->assertStatus(200);
        $terms->assertSee('45-day re-work warranty');
    }
}
