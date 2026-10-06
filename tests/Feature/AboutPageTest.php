<?php

namespace Tests\Feature;

use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_dynamic_about_page(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('FixMate');
        $response->assertSee('Transforming Home Maintenance with');
        $response->assertSee('Completed Jobs');
        $response->assertSee('Verified Technicians');
        $response->assertSee('Satisfaction Score');
    }

    public function test_about_page_renders_live_professions_and_featured_technicians(): void
    {
        $profession = Profession::create([
            'name' => 'Master Solar Specialist',
            'slug' => 'master-solar-specialist',
            'description' => 'Solar inverters and panel grid repairs',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'name' => 'Tariq Mehmood',
            'user_type' => User::TYPE_TECHNICIAN,
        ]);

        $tech = Professional::create([
            'user_id' => $user->id,
            'profession_id' => $profession->id,
            'name' => 'Tariq Mehmood',
            'email' => 'tariq@example.com',
            'phone' => '03009988776',
            'experience' => '8+ Years',
            'is_verified' => true,
        ]);

        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('Master Solar Specialist');
        $response->assertSee('Tariq Mehmood');
        $response->assertSee('Meet Our Certified Master Technicians');
        $response->assertSee('NADRA Verified');
    }
}
