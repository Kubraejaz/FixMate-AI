@extends('Frontend.layouts.public')

@section('title', 'Frequently Asked Questions (FAQs) — FixMate AI | Help Center')
@section('meta_desc', 'Got questions about FixMate AI? Find detailed answers on AI problem diagnosis, upfront pricing, escrow payments, technician verification, and our 30-day warranty.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 56px 0 40px 0; text-align: center; background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%); border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 800px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #FFB800;"></span>
                <span style="font-size: 12.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">Help & Knowledge Center</span>
            </div>
            <h1 style="font-size: 42px; font-weight: 900; color: #0F172A; margin: 0 0 16px 0; letter-spacing: -0.03em; line-height: 1.15;">
                Frequently Asked <span style="color: #FFB800;">Questions</span>
            </h1>
            <p style="font-size: 16.5px; color: #64748B; margin: 0 auto; line-height: 1.7; max-width: 660px;">
                Everything you need to know about our AI computer vision diagnosis, certified technician vetting, escrow payments, and customer protection.
            </p>
        </div>
    </section>

    <!-- FAQs Section -->
    <section style="padding: 60px 0 70px 0;">
        <div class="container" style="max-width: 940px;">
            
            <!-- Category: AI Diagnosis & Pricing -->
            <div style="margin-bottom: 44px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #F1F5F9;">
                    <span style="font-size: 24px;">🤖</span>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0;">AI Diagnosis & Pricing</h2>
                </div>

                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;" open>
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>How does the AI defect diagnosis work from a photo?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            Our proprietary computer vision models were trained on over 250,000 localized domestic repair images across Pakistan. When you upload a snapshot of a dripping pipe, burnt socket, or malfunctioning AC condenser, our model identifies the defective component, determines severity, estimates required replacement parts, and suggests standard labor hours.
                        </p>
                    </details>

                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;">
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>What happens if the actual problem is different from the AI estimate?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            The AI price provides a transparent baseline. Once the technician arrives and physically inspects the fixture, if concealed damage exists (e.g. broken pipe inside a wall cavity), the technician submits a revised quote through the app with photos. You must digitally approve any price change before additional work commences.
                        </p>
                    </details>

                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;">
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>Are there any hidden diagnosis or traveling fees?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            No hidden fees. Every job includes transparent line-item pricing: standard inspection/visiting fee, estimated labor charge, and optional materials. If you proceed with the suggested repair, the visiting fee is automatically adjusted toward your total repair bill.
                        </p>
                    </details>
                </div>
            </div>

            <!-- Category: Trust, Safety & Arrival OTP -->
            <div style="margin-bottom: 44px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #F1F5F9;">
                    <span style="font-size: 24px;">🛡️</span>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0;">Trust, Safety & Arrival OTP</h2>
                </div>

                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;" open>
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>How does the 4-Digit Arrival OTP protect my household?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            When you confirm a booking, our system assigns a unique cryptographic 4-digit code displayed only on your phone. When the technician knocks on your door, you ask for their registered name and confirm the code on their technician app. This prevents unauthorized individuals or unverified substitutes from entering your premises.
                        </p>
                    </details>

                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;">
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>What screening process do technicians undergo?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            100% of technicians undergo a rigorous 4-tier vetting protocol: (1) NADRA CNIC biometric identity verification, (2) Local police character certificate validation, (3) Practical skill testing by our senior master trade assessors, and (4) Ongoing customer rating monitoring (technicians maintaining below 4.5/5 rating are suspended).
                        </p>
                    </details>
                </div>
            </div>

            <!-- Category: Payments & Escrow Protection -->
            <div style="margin-bottom: 44px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #F1F5F9;">
                    <span style="font-size: 24px;">💳</span>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0;">Payments & Escrow Protection</h2>
                </div>

                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;">
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>How does the escrow payment system work?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            When you approve a service estimate, your payment is placed into a secure escrow vault. The technician does not receive the funds until you physically verify the repair, check that everything is working properly, and tap "Approve & Release Funds" on your customer screen.
                        </p>
                    </details>

                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;">
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>What payment methods are supported?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            We support all major Pakistani payment methods: JazzCash, EasyPaisa, 1Link/Raast instant bank transfer, Visa/Mastercard debit and credit cards, and verified Cash on Delivery (COD) with in-app digital receipts.
                        </p>
                    </details>

                    <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer;">
                        <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                            <span>How does the 30-Day FixMate Workmanship Warranty work?</span>
                            <span style="color: #FFB800; font-size: 20px; font-weight: 900;">▾</span>
                        </summary>
                        <p style="font-size: 14.5px; color: #64748B; line-height: 1.7; margin: 14px 0 0 0;">
                            If a serviced fixture experiences the same problem within 30 calendar days of job completion, open your booking history and tap "Claim Warranty". We will dispatch an inspector or technician to re-inspect and correct the issue at zero additional labor cost.
                        </p>
                    </details>
                </div>
            </div>

            <!-- Still Have Questions Contact Banner -->
            <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 20px; padding: 36px; display: flex; align-items: center; justify-content: space-between; gap: 24px;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Have a question that is not listed here?</h3>
                    <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.6;">Our support representatives in Islamabad, Lahore, and Karachi are available 7 days a week.</p>
                </div>
                <div style="display: flex; gap: 12px; flex-shrink: 0;">
                    <a href="{{ url('/contact') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 24px; border-radius: 10px; text-decoration: none;">
                        Contact Us →
                    </a>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
