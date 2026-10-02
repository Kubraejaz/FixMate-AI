<?php

namespace Tests\Feature\Admin;

use App\Models\CommunityIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_community_dispatch_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        CommunityIssue::create([
            'reference_no' => 'FM-CIV-8001',
            'reporter_name' => 'Waqas',
            'title' => 'Transformer spark hazard',
            'description' => 'Dangerous sparking',
            'category' => 'electrical_hazard',
            'city' => 'Karachi',
            'location' => 'Gulshan Block 7',
            'status' => 'alert_active',
            'upvotes_count' => 30,
            'is_approved' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.community'));

        $response->assertStatus(200);
        $response->assertSee('Neighborhood Hazards &amp; Dispatch Console', false);
        $response->assertSee('FM-CIV-8001');
        $response->assertSee('Transformer spark hazard');
    }

    public function test_non_admin_cannot_access_community_dispatch(): void
    {
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->get(route('admin.community'));
        $response->assertRedirect('/customer/dashboard');
    }

    public function test_admin_can_update_issue_status_and_dispatch_notes(): void
    {
        $admin = User::factory()->admin()->create();

        $issue = CommunityIssue::create([
            'reference_no' => 'FM-CIV-8002',
            'reporter_name' => 'Rashid',
            'title' => 'Sewer overflow near gate',
            'description' => 'Water line blocked',
            'category' => 'sewerage',
            'city' => 'Lahore',
            'location' => 'DHA Phase 3',
            'status' => 'reported',
            'priority' => 'normal',
            'is_approved' => true,
        ]);

        $payload = [
            'status' => 'in_progress',
            'status_update' => 'Mobile Tanker Squad #2 Dispatched on Site',
            'priority' => 'high',
            'category' => 'sewerage',
            'city' => 'Lahore',
            'location' => 'DHA Phase 3, Sector Y',
            'is_approved' => '1',
        ];

        $response = $this->actingAs($admin)->put(route('admin.community.update', $issue), $payload);

        $response->assertRedirect(route('admin.community'));
        $response->assertSessionHas('success');

        $issue->refresh();
        $this->assertEquals('in_progress', $issue->status);
        $this->assertEquals('Mobile Tanker Squad #2 Dispatched on Site', $issue->status_update);
        $this->assertEquals('high', $issue->priority);
    }

    public function test_admin_can_toggle_issue_approval(): void
    {
        $admin = User::factory()->admin()->create();

        $issue = CommunityIssue::create([
            'reference_no' => 'FM-CIV-8003',
            'reporter_name' => 'Junaid',
            'title' => 'Unapproved test post',
            'description' => 'Check moderation toggle',
            'category' => 'general',
            'city' => 'Multan',
            'location' => 'Bosan Road',
            'status' => 'reported',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($admin)->patchJson(route('admin.community.toggle', $issue));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_approved' => false,
        ]);

        $issue->refresh();
        $this->assertFalse($issue->is_approved);
    }

    public function test_admin_can_delete_issue(): void
    {
        $admin = User::factory()->admin()->create();

        $issue = CommunityIssue::create([
            'reference_no' => 'FM-CIV-8004',
            'reporter_name' => 'Tariq',
            'title' => 'Duplicate issue',
            'description' => 'To be deleted',
            'category' => 'general',
            'city' => 'Faisalabad',
            'location' => 'Madina Town',
            'status' => 'reported',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.community.destroy', $issue));

        $response->assertRedirect(route('admin.community'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('community_issues', [
            'id' => $issue->id,
        ]);
    }
}
