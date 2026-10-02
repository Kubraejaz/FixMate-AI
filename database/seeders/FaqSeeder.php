<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // AI Diagnosis & Pricing
            [
                'question' => 'How does the AI defect diagnosis work from a photo?',
                'answer' => 'Our proprietary computer vision models were trained on over 250,000 localized domestic repair images across Pakistan. When you upload a snapshot of a dripping pipe, burnt socket, or malfunctioning AC condenser, our model identifies the defective component, determines severity, estimates required replacement parts, and suggests standard labor hours.',
                'category' => 'ai_diagnosis',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'What happens if the actual problem is different from the AI estimate?',
                'answer' => 'The AI price provides a transparent baseline. Once the technician arrives and physically inspects the fixture, if concealed damage exists (e.g. broken pipe inside a wall cavity), the technician submits a revised quote through the app with photos. You must digitally approve any price change before additional work commences.',
                'category' => 'ai_diagnosis',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Are there any hidden diagnosis or traveling fees?',
                'answer' => 'No hidden fees. Every job includes transparent line-item pricing: standard inspection/visiting fee, estimated labor charge, and optional materials. If you proceed with the suggested repair, the visiting fee is automatically adjusted toward your total repair bill.',
                'category' => 'ai_diagnosis',
                'sort_order' => 3,
                'is_active' => true,
            ],

            // Trust, Safety & Arrival OTP
            [
                'question' => 'How does the 4-Digit Arrival OTP protect my household?',
                'answer' => 'When you confirm a booking, our system assigns a unique cryptographic 4-digit code displayed only on your phone. When the technician knocks on your door, you ask for their registered name and confirm the code on their technician app. This prevents unauthorized individuals or unverified substitutes from entering your premises.',
                'category' => 'trust_safety',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'What screening process do technicians undergo?',
                'answer' => '100% of technicians undergo a rigorous 4-tier vetting protocol: (1) NADRA CNIC biometric identity verification, (2) Local police character certificate validation, (3) Practical skill testing by our senior master trade assessors, and (4) Ongoing customer rating monitoring (technicians maintaining below 4.5/5 rating are suspended).',
                'category' => 'trust_safety',
                'sort_order' => 5,
                'is_active' => true,
            ],

            // Payments & Escrow Protection
            [
                'question' => 'How does the escrow payment system work?',
                'answer' => 'When you approve a service estimate, your payment is placed into a secure escrow vault. The technician does not receive the funds until you physically verify the repair, check that everything is working properly, and tap "Approve & Release Funds" on your customer screen.',
                'category' => 'payments_escrow',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'What payment methods are supported?',
                'answer' => 'We support all major Pakistani payment methods: JazzCash, EasyPaisa, 1Link/Raast instant bank transfer, Visa/Mastercard debit and credit cards, and verified Cash on Delivery (COD) with in-app digital receipts.',
                'category' => 'payments_escrow',
                'sort_order' => 7,
                'is_active' => true,
            ],

            // Warranty & Customer Protection
            [
                'question' => 'How does the 30-Day FixMate Workmanship Warranty work?',
                'answer' => 'If a serviced fixture experiences the same problem within 30 calendar days of job completion, open your booking history and tap "Claim Warranty". We will dispatch an inspector or technician to re-inspect and correct the issue at zero additional labor cost.',
                'category' => 'warranty_guarantee',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'question' => 'Can I reschedule or cancel a booking after dispatch?',
                'answer' => 'Yes, you can cancel or reschedule for free up to 30 minutes before the scheduled arrival slot. If the technician is already en route, a nominal travel compensation fee may apply unless cancellation is due to technician delay.',
                'category' => 'general',
                'sort_order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
