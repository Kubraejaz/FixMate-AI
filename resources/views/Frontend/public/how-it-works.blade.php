@extends('Frontend.layouts.public')

@section('title', 'How It Works — FixMate AI')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">SIMPLE 5-STEP PROCESS</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">How FixMate AI Works</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">Get your home service done in just a few simple steps with AI diagnosis and verified professionals.</p>
        </div>
    </section>

    <!-- 5 Steps Detailed Cards -->
    <section style="padding: 48px 0;">
        <div class="container" style="max-width: 800px;">
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- Step 1 -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px 28px; display: flex; align-items: flex-start; gap: 20px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFC107; color: #0F172A; font-size: 16px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        1
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="font-size: 20px;">📷</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0;">Describe Your Problem</h3>
                        </div>
                        <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.6;">
                            Tell us what's wrong in plain words or upload a quick photo of the issue (like a leaking sink pipe or sparking switch).
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 18px; padding: 24px 28px; display: flex; align-items: flex-start; gap: 20px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFC107; color: #0F172A; font-size: 16px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        2
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="font-size: 20px;">🤖</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0;">AI Computer Vision Analysis</h3>
                        </div>
                        <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.6;">
                            Our trained vision model scans the issue, detects the exact trade category, determines the urgency level, and estimates a fair cost range upfront.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px 28px; display: flex; align-items: flex-start; gap: 20px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFC107; color: #0F172A; font-size: 16px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        3
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="font-size: 20px;">🧑‍🔧</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0;">Get Matched with Nearby Pros</h3>
                        </div>
                        <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.6;">
                            Browse top-rated, background-checked technicians near your home. Check their ratings, distance, and past work photos.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px 28px; display: flex; align-items: flex-start; gap: 20px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #FFC107; color: #0F172A; font-size: 16px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        4
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="font-size: 20px;">📅</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0;">Book & Live Track</h3>
                        </div>
                        <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.6;">
                            Select your convenient time slot, follow your technician on live GPS, and provide the secure 4-digit arrival OTP upon door arrival.
                        </p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 24px 28px; display: flex; align-items: flex-start; gap: 20px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #10B981; color: #FFFFFF; font-size: 16px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        ✓
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span style="font-size: 20px;">🛡️</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0;">Service Complete & Escrow Release</h3>
                        </div>
                        <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.6;">
                            Only release payment once you are fully satisfied with the service. Every job is covered by our 30-day warranty.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Clean Bottom CTA -->
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ url('/customer/diagnose') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 15px; padding: 12px 32px; border-radius: 50px; text-decoration: none; display: inline-block; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.35);">
                    Try AI Problem Diagnosis Now →
                </a>
            </div>

        </div>
    </section>

</div>
@endsection
