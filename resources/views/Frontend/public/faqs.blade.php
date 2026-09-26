@extends('Frontend.layouts.public')

@section('title', 'FAQs — FixMate AI | Frequently Asked Questions')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">HELP & SUPPORT</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Frequently Asked Questions</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">Everything you need to know about our AI diagnosis, booking and warranties.</p>
        </div>
    </section>

    <!-- FAQs Accordions -->
    <section style="padding: 48px 0;">
        <div class="container" style="max-width: 800px;">
            
            <div style="display: flex; flex-direction: column; gap: 14px;">
                
                <!-- FAQ 1 -->
                <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px 22px; cursor: pointer;" open>
                    <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        <span>How does the AI problem diagnosis work?</span>
                        <span style="color: #FFB800; font-size: 20px;">▾</span>
                    </summary>
                    <p style="font-size: 14px; color: #64748B; line-height: 1.6; margin: 12px 0 0 0;">
                        Our computer vision model analyzes photos of household issues (such as water leaks, broken switches, or AC faults) to detect the exact issue, estimate the required parts, and predict a fair cost range before you book.
                    </p>
                </details>

                <!-- FAQ 2 -->
                <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px 22px; cursor: pointer;">
                    <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        <span>Are the technicians verified?</span>
                        <span style="color: #FFB800; font-size: 20px;">▾</span>
                    </summary>
                    <p style="font-size: 14px; color: #64748B; line-height: 1.6; margin: 12px 0 0 0;">
                        Yes, 100%. Every technician on FixMate AI undergoes national CNIC identity verification, trade skill vetting, and police background clearance before accepting jobs.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px 22px; cursor: pointer;">
                    <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        <span>What is the Arrival Verification OTP?</span>
                        <span style="color: #FFB800; font-size: 20px;">▾</span>
                    </summary>
                    <p style="font-size: 14px; color: #64748B; line-height: 1.6; margin: 12px 0 0 0;">
                        For your security, a 4-digit OTP is generated on your screen when you book. You provide this OTP to the technician only when they arrive at your home to verify their identity.
                    </p>
                </details>

                <!-- FAQ 4 -->
                <details style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px 22px; cursor: pointer;">
                    <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        <span>What is the FixMate AI 30-day warranty?</span>
                        <span style="color: #FFB800; font-size: 20px;">▾</span>
                    </summary>
                    <p style="font-size: 14px; color: #64748B; line-height: 1.6; margin: 12px 0 0 0;">
                        If any repair work fails within 30 days of completion, our verified technicians will re-inspect and fix it at zero extra diagnostic fee.
                    </p>
                </details>

            </div>

            <!-- Still have questions -->
            <div style="text-align: center; margin-top: 40px; padding: 24px; background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 16px;">
                <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 4px 0;">Still have questions?</h4>
                <p style="font-size: 13.5px; color: #64748B; margin: 0 0 14px 0;">Our customer support team is available 6 days a week to help you.</p>
                <a href="{{ url('/contact') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 9px 22px; border-radius: 50px; text-decoration: none;">
                    Contact Support →
                </a>
            </div>

        </div>
    </section>

</div>
@endsection
