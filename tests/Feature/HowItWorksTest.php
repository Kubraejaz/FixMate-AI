<?php

namespace Tests\Feature;

use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HowItWorksTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_dynamic_how_it_works_page(): void
    {
        $profession = Profession::create([
            'name' => 'Certified Electrician',
            'slug' => 'certified-electrician',
            'description' => 'Fix short circuits and wiring',
            'is_active' => true,
        ]);

        $response = $this->get(route('how-it-works'));

        $response->assertStatus(200);
        $response->assertSee('FixMate AI');
        $response->assertSee('Certified Electrician');
        $response->assertSee('Try Our Upfront Pricing Engine');
        $response->assertSee('Interactive Simulator');
    }
}
