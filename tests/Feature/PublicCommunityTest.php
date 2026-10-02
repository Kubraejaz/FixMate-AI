<?php

namespace Tests\Feature;

use App\Models\CommunityIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCommunityTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_view_community_feed(): void
    {
        CommunityIssue::create([
            'reference_no' => 'FM-CIV-9001',
            'reporter_name' => 'Khurram S.',
            'reporter_role' => 'Resident',
            'title' => 'Main waterline valve broken',
            'description' => 'Water flooding road since 6 AM.',
            'category' => 'water_supply',
            'city' => 'Karachi',
            'location' => 'Clifton Block 2',
            'status' => 'in_progress',
            'upvotes_count' => 12,
            'is_approved' => true,
        ]);

        $response = $this->get(route('community'));

        $response->assertStatus(200);
        $response->assertSee('Neighborhood Maintenance Feed');
        $response->assertSee('Main waterline valve broken');
        $response->assertSee('Clifton Block 2');
    }

    public function test_user_can_filter_issues_by_city(): void
    {
        CommunityIssue::create([
            'reference_no' => 'FM-CIV-9002',
            'reporter_name' => 'Ali',
            'title' => 'Karachi Transformer Spark',
            'description' => 'Dangerous sparks',
            'category' => 'electrical_hazard',
            'city' => 'Karachi',
            'location' => 'DHA Phase 5',
            'status' => 'alert_active',
            'is_approved' => true,
        ]);

        CommunityIssue::create([
            'reference_no' => 'FM-CIV-9003',
            'reporter_name' => 'Hamza',
            'title' => 'Lahore Drainage Clog',
            'description' => 'Blocked drain',
            'category' => 'sewerage',
            'city' => 'Lahore',
            'location' => 'Model Town',
            'status' => 'scheduled',
            'is_approved' => true,
        ]);

        $response = $this->get(route('community', ['city' => 'Karachi']));

        $response->assertStatus(200);
        $response->assertSee('Karachi Transformer Spark');
        $response->assertDontSee('Lahore Drainage Clog');
    }

    public function test_user_can_report_civic_hazard(): void
    {
        $payload = [
            'title' => 'Broken manhole cover on main boulevard',
            'description' => 'Open manhole posing severe hazard to vehicles and pedestrians.',
            'category' => 'sewerage',
            'city' => 'Islamabad',
            'location' => 'G-11 Markaz, near commercial bank',
            'reporter_name' => 'Zubair Qureshi',
            'reporter_role' => 'Commuter',
            'reporter_phone' => '0300-5544332',
            'priority' => 'critical',
        ];

        $response = $this->post(route('community.report'), $payload);

        $response->assertRedirect(route('community', ['city' => 'Islamabad']));
        $response->assertSessionHas('success_hazard_report');

        $this->assertDatabaseHas('community_issues', [
            'title' => 'Broken manhole cover on main boulevard',
            'city' => 'Islamabad',
            'reporter_name' => 'Zubair Qureshi',
            'category' => 'sewerage',
            'status' => 'alert_active',
            'upvotes_count' => 1,
        ]);
    }

    public function test_user_can_upvote_and_unvote_an_issue(): void
    {
        $issue = CommunityIssue::create([
            'reference_no' => 'FM-CIV-9004',
            'reporter_name' => 'Bilal',
            'title' => 'Street lamp fuse burned out',
            'description' => 'Dark zone at night.',
            'category' => 'street_light',
            'city' => 'Rawalpindi',
            'location' => 'Satellite Town',
            'status' => 'reported',
            'upvotes_count' => 5,
            'is_approved' => true,
        ]);

        // First upvote
        $response1 = $this->postJson(route('community.upvote', $issue));
        $response1->assertStatus(200);
        $response1->assertJson([
            'success' => true,
            'upvoted' => true,
            'count' => 6,
        ]);

        $this->assertEquals(6, $issue->fresh()->upvotes_count);

        // Second click unvotes
        $response2 = $this->postJson(route('community.upvote', $issue));
        $response2->assertStatus(200);
        $response2->assertJson([
            'success' => true,
            'upvoted' => false,
            'count' => 5,
        ]);

        $this->assertEquals(5, $issue->fresh()->upvotes_count);
    }
}
