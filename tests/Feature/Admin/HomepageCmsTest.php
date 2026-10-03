<?php

namespace Tests\Feature\Admin;

use App\Models\HomepageSetting;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WorkflowStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageCmsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@fixmate.ai',
            'user_type' => User::TYPE_ADMIN,
        ]);

        $this->customer = User::factory()->create([
            'email' => 'customer@fixmate.ai',
            'user_type' => User::TYPE_CUSTOMER,
        ]);
    }

    public function test_admin_can_view_homepage_cms_editor(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.homepage'));

        $response->assertStatus(200);
        $response->assertSee('Homepage CMS & Content Editor');
        $response->assertSee('Hero Section & Primary Imagery');
        $response->assertSee('Homeowner Testimonials');
        $response->assertSee('Workflow Steps');
    }

    public function test_admin_can_update_hero_and_guarantee_copy(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.homepage.hero'), [
            'hero_badge' => 'Exclusive Smart AI Network',
            'hero_title_main' => 'Premium Home Repairs',
            'hero_title_highlight' => 'Effortless',
            'hero_subtitle' => 'The fastest home service dispatch across Pakistan.',
            'hero_script_text' => 'Quality First',
            'hero_trusted_tag' => 'Certified Master Craftsmen',
            'guarantee_title' => 'FixMate 100% Assurance',
            'guarantee_subtitle' => 'Complete peace of mind on all services.',
            'warranty_days' => 45,
            'hero_image' => 'assets/images/image_8.png',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('homepage_settings', [
            'hero_title_main' => 'Premium Home Repairs',
            'hero_title_highlight' => 'Effortless',
            'warranty_days' => 45,
        ]);

        // Verify public home page reflects the new copy
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertSee('Premium Home Repairs');
        $homeResponse->assertSee('Effortless');
    }

    public function test_admin_can_create_and_delete_testimonials(): void
    {
        // 1. Create Testimonial
        $createResponse = $this->actingAs($this->admin)->post(route('admin.homepage.testimonials.store'), [
            'name' => 'Fatima Noor',
            'location' => 'Karachi — DHA Phase 8',
            'trade' => 'Solar Maintenance',
            'rating' => 5,
            'comment' => 'Exceptional response time and crystal clear diagnosis.',
            'avatar' => 'assets/images/image_2.png',
        ]);

        $createResponse->assertRedirect();
        $this->assertDatabaseHas('testimonials', [
            'name' => 'Fatima Noor',
            'trade' => 'Solar Maintenance',
        ]);

        // Verify public home page sees Fatima Noor
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertSee('Fatima Noor');
        $homeResponse->assertSee('Solar Maintenance');

        // 2. Delete Testimonial
        $testimonial = Testimonial::where('name', 'Fatima Noor')->first();
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.homepage.testimonials.destroy', $testimonial));
        $deleteResponse->assertRedirect();

        $this->assertDatabaseMissing('testimonials', ['name' => 'Fatima Noor']);
    }

    public function test_admin_can_create_and_delete_workflow_steps(): void
    {
        // 1. Create Step
        $createResponse = $this->actingAs($this->admin)->post(route('admin.homepage.steps.store'), [
            'step_number' => 6,
            'icon' => '⭐',
            'title' => 'VIP Warranty Followup',
            'description' => 'Free 30-day health inspection.',
            'badge_color' => '#10B981',
        ]);

        $createResponse->assertRedirect();
        $this->assertDatabaseHas('workflow_steps', [
            'title' => 'VIP Warranty Followup',
            'step_number' => 6,
        ]);

        // Verify public home page sees VIP Warranty Followup
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertSee('VIP Warranty Followup');

        // 2. Delete Step
        $step = WorkflowStep::where('title', 'VIP Warranty Followup')->first();
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.homepage.steps.destroy', $step));
        $deleteResponse->assertRedirect();

        $this->assertDatabaseMissing('workflow_steps', ['title' => 'VIP Warranty Followup']);
    }

    public function test_non_admin_cannot_access_homepage_cms(): void
    {
        $response = $this->actingAs($this->customer)->get(route('admin.homepage'));
        $response->assertRedirect('/customer/dashboard');
    }
}
