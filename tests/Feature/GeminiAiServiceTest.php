<?php

namespace Tests\Feature;

use App\Models\Profession;
use App\Models\User;
use App\Services\GeminiAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiAiServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Profession::firstOrCreate(
            ['slug' => 'plumber'],
            [
                'name' => 'Plumber',
                'icon' => 'wrench',
                'description' => 'Pipe and water fixture repair',
                'base_price' => 750,
                'is_active' => true,
            ]
        );

        Profession::firstOrCreate(
            ['slug' => 'electrician'],
            [
                'name' => 'Electrician',
                'icon' => 'zap',
                'description' => 'Wiring, fuse and electrical repairs',
                'base_price' => 850,
                'is_active' => true,
            ]
        );
    }

    public function test_gemini_service_falls_back_when_not_configured(): void
    {
        config(['services.gemini.api_key' => null]);
        cache()->forget('gemini_api_key');

        $service = new GeminiAiService();
        $this->assertFalse($service->isConfigured());

        $result = $service->diagnoseDefect('Water leaking under sink');
        $this->assertFalse($result['success']);
        $this->assertEquals('fallback', $result['provider']);
    }

    public function test_gemini_service_parses_successful_multimodal_response(): void
    {
        config(['services.gemini.api_key' => 'AIzaSyTestMockKey123456789']);

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'is_repair_defect' => true,
                                        'confidence' => 97,
                                        'trade_slug' => 'plumber',
                                        'trade_name' => 'Plumber',
                                        'defect_title' => 'P-Trap Thread Corroded Leak',
                                        'summary' => 'Severe hydrostatic seal failure beneath kitchen drain pipe.',
                                        'tools' => 'Pipe Wrench, Teflon Tape, Basin Spanner',
                                        'repair_time' => '35 - 50 Mins',
                                        'cost_min' => 1200,
                                        'cost_max' => 2200,
                                        'safety_alert' => 'Turn off the under-sink shutoff valves immediately.',
                                    ]),
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = new GeminiAiService();
        $this->assertTrue($service->isConfigured());

        $result = $service->diagnoseDefect('Kitchen pipe leaking water profusely');

        $this->assertTrue($result['success']);
        $this->assertEquals('gemini', $result['provider']);
        $this->assertEquals('plumber', $result['data']['trade_slug']);
        $this->assertEquals('P-Trap Thread Corroded Leak', $result['data']['defect_title']);
        $this->assertEquals('Turn off the under-sink shutoff valves immediately.', $result['data']['safety_alert']);
    }

    public function test_customer_ai_result_screen_uses_gemini_response_when_active(): void
    {
        $customer = User::factory()->create([
            'user_type' => User::TYPE_CUSTOMER,
        ]);

        $response = $this->actingAs($customer)->post(route('customer.ai-result'), [
            'issue' => 'My breaker box is making buzzing sparking sound',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Service Request Summary');
        $response->assertSee('Electrician');
        $response->assertSee('Circuit Breaker Inspection');
    }
}
