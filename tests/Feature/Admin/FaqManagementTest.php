<?php

namespace Tests\Feature\Admin;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_faqs_list(): void
    {
        $admin = User::factory()->admin()->create();

        Faq::create([
            'question' => 'How does the arrival OTP work?',
            'answer' => 'Arrival OTP verifies the technician before entry.',
            'category' => 'trust_safety',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs'));

        $response->assertStatus(200);
        $response->assertSee('Help Center &amp; FAQs Management', false);
        $response->assertSee('How does the arrival OTP work?');
    }

    public function test_non_admin_cannot_access_faq_management(): void
    {
        $customer = User::factory()->customer()->create();

        $response = $this->actingAs($customer)->get(route('admin.faqs'));
        $response->assertRedirect('/customer/dashboard');
    }

    public function test_admin_can_create_new_faq(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'question' => 'What happens if a technician damages a fixture?',
            'answer' => 'FixMate covers verified property damage up to PKR 50,000 via our customer guarantee fund.',
            'category' => 'warranty_guarantee',
            'sort_order' => 10,
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.faqs.store'), $payload);

        $response->assertRedirect(route('admin.faqs'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('faqs', [
            'question' => 'What happens if a technician damages a fixture?',
            'category' => 'warranty_guarantee',
            'sort_order' => 10,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_existing_faq(): void
    {
        $admin = User::factory()->admin()->create();

        $faq = Faq::create([
            'question' => 'Old Question Title',
            'answer' => 'Old answer text.',
            'category' => 'general',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        $payload = [
            'question' => 'Updated Question Title',
            'answer' => 'Updated comprehensive answer text.',
            'category' => 'general',
            'sort_order' => 8,
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->put(route('admin.faqs.update', $faq), $payload);

        $response->assertRedirect(route('admin.faqs'));
        $response->assertSessionHas('success');

        $faq->refresh();
        $this->assertEquals('Updated Question Title', $faq->question);
        $this->assertEquals('Updated comprehensive answer text.', $faq->answer);
        $this->assertEquals(8, $faq->sort_order);
    }

    public function test_admin_can_delete_faq(): void
    {
        $admin = User::factory()->admin()->create();

        $faq = Faq::create([
            'question' => 'Question To Be Deleted',
            'answer' => 'Answer to be deleted.',
            'category' => 'ai_diagnosis',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.faqs.destroy', $faq));

        $response->assertRedirect(route('admin.faqs'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('faqs', [
            'id' => $faq->id,
        ]);
    }

    public function test_admin_can_toggle_faq_visibility(): void
    {
        $admin = User::factory()->admin()->create();

        $faq = Faq::create([
            'question' => 'Toggle visibility question',
            'answer' => 'Testing toggle switch.',
            'category' => 'general',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patchJson(route('admin.faqs.toggle', $faq));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_active' => false,
        ]);

        $faq->refresh();
        $this->assertFalse($faq->is_active);
    }
}
