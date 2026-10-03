<?php

namespace Tests\Feature;

use App\Models\CommunityIssue;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicHomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_view_dynamic_home_page_with_all_content(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('AI Powered Home Service Platform');
        $response->assertSee('Smart Home Services');
        $response->assertSee('Popular Services');
        $response->assertSee('How FixMate AI Works');
        $response->assertSee('Featured Technicians');
        $response->assertSee('What Homeowners Say');
        $response->assertSee('FixMate AI Guarantee');
    }

    public function test_home_page_renders_active_professions_and_featured_technicians(): void
    {
        $profession = Profession::create([
            'name' => 'Solar Master Tech',
            'slug' => 'solar-master-tech',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'name' => 'Javed Iqbal',
            'user_type' => User::TYPE_TECHNICIAN,
        ]);

        $pro = Professional::create([
            'user_id' => $user->id,
            'profession_id' => $profession->id,
            'name' => 'Javed Iqbal',
            'phone' => '03001122334',
            'experience' => '9 Years',
            'is_verified' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Solar Master Tech');
        $response->assertSee('Javed Iqbal');
        $response->assertSee('Verified');
    }
}
