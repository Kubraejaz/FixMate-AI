<?php

namespace Tests\Feature;

use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFaqTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_view_faqs_page(): void
    {
        Faq::create([
            'question' => 'How does escrow protection work?',
            'answer' => 'Escrow holds payments until you approve the technician repair work.',
            'category' => 'payments_escrow',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('faqs'));

        $response->assertStatus(200);
        $response->assertSee('Frequently Asked');
        $response->assertSee('How does escrow protection work?');
        $response->assertSee('Escrow holds payments until you approve');
    }

    public function test_inactive_faqs_are_hidden_from_public(): void
    {
        Faq::create([
            'question' => 'Draft Question That Is Hidden',
            'answer' => 'This answer should not be visible to public users.',
            'category' => 'general',
            'sort_order' => 1,
            'is_active' => false,
        ]);

        $response = $this->get(route('faqs'));

        $response->assertStatus(200);
        $response->assertDontSee('Draft Question That Is Hidden');
    }

    public function test_user_can_filter_faqs_by_category(): void
    {
        Faq::create([
            'question' => 'What is AI Diagnosis?',
            'answer' => 'AI estimates parts and labor from photos.',
            'category' => 'ai_diagnosis',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'How do I pay with JazzCash?',
            'answer' => 'We accept JazzCash, EasyPaisa, and bank transfer.',
            'category' => 'payments_escrow',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get(route('faqs', ['category' => 'ai_diagnosis']));

        $response->assertStatus(200);
        $response->assertSee('What is AI Diagnosis?');
        $response->assertDontSee('How do I pay with JazzCash?');
    }

    public function test_user_can_search_faqs_by_keyword(): void
    {
        Faq::create([
            'question' => 'What is the 30-day warranty policy?',
            'answer' => 'All verified jobs come with our guaranteed 30-day warranty.',
            'category' => 'warranty_guarantee',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'How are technicians screened?',
            'answer' => 'We check NADRA biometric identity and police character certificates.',
            'category' => 'trust_safety',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get(route('faqs', ['search' => 'warranty']));

        $response->assertStatus(200);
        $response->assertSee('What is the 30-day warranty policy?');
        $response->assertDontSee('How are technicians screened?');
    }
}
