<?php

namespace Tests\Feature\Api;

use App\Models\CommunityIssue;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_endpoint_returns_success_envelope(): void
    {
        $this->getJson('/api/v1/home')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['success', 'message', 'data' => ['hero', 'stats', 'professions', 'workflow_steps']]);
    }

    public function test_about_and_policy_endpoints_return_success(): void
    {
        $this->getJson('/api/v1/about')->assertOk()->assertJsonPath('success', true);
        $this->getJson('/api/v1/how-it-works')->assertOk()->assertJsonPath('success', true);
        $this->getJson('/api/v1/privacy-policy')->assertOk()->assertJsonPath('success', true);
        $this->getJson('/api/v1/terms')->assertOk()->assertJsonPath('success', true);
    }

    public function test_services_index_and_show(): void
    {
        $profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            ['name' => 'Plumber', 'base_price' => 800, 'is_active' => true]
        );

        $this->getJson('/api/v1/services?search=Plumber')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.0.slug', 'plumber');

        $this->getJson('/api/v1/services/plumber')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $profession->id);
    }

    public function test_technician_directory_index_and_show(): void
    {
        $profession = Profession::firstOrCreate(
            ['slug' => 'plumber'],
            ['name' => 'Plumber', 'is_active' => true]
        );

        $user = User::factory()->technician()->create(['is_verified' => true]);

        $professional = Professional::create([
            'user_id' => $user->id,
            'profession_id' => $profession->id,
            'name' => 'Tariq Mehmood',
            'email' => $user->email,
            'phone' => '+923009998877',
            'is_verified' => true,
        ]);

        $this->getJson('/api/v1/technicians')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->getJson("/api/v1/technicians/{$professional->id}")
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $professional->id);
    }

    public function test_faqs_index_returns_success(): void
    {
        $this->getJson('/api/v1/faqs')->assertOk()->assertJsonPath('success', true);
    }

    public function test_guest_can_report_a_community_hazard(): void
    {
        $response = $this->postJson('/api/v1/community/report', [
            'title' => 'Broken street light on main road',
            'description' => 'The street light near block 6 has been off for almost a week now.',
            'category' => 'street_light',
            'city' => 'Karachi',
            'location' => 'PECHS Block 6',
            'reporter_name' => 'Ali Raza',
            'priority' => 'high',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['reference_no', 'title', 'status']]);

        $this->assertDatabaseHas('community_issues', [
            'title' => 'Broken street light on main road',
        ]);
    }

    public function test_community_index_returns_approved_issues(): void
    {
        CommunityIssue::create([
            'reference_no' => 'FM-CIV-1234',
            'reporter_name' => 'Ali Raza',
            'title' => 'Overflowing drain near market',
            'description' => 'The drain outside the vegetable market is overflowing badly.',
            'category' => 'sewerage',
            'city' => 'Karachi',
            'location' => 'Gulshan Market',
            'status' => 'reported',
            'priority' => 'normal',
            'upvotes_count' => 3,
            'is_approved' => true,
        ]);

        $this->getJson('/api/v1/community')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.total_approved', 1);
    }
}
