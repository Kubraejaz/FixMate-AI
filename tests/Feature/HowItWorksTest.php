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
        $response->assertSee('FixMate AI');
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
        $response->assertSee('About FixMate AI');
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
        ]);

        $response = $this->get('/technicians/' . $pro->id);

        $response->assertStatus(200);
        $response->assertSee('Tariq Mehmood');
        $response->assertSee('Master Plumber');
        $response->assertSee('Rs. 950');
        $response->assertSee('45-Day Rework Guarantee');
        $response->assertSee('Karachi — Clifton');
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
