@extends('Frontend.layouts.public')

@section('title', 'How It Works — FixMate AI | Smart Home Services')
@section('meta_desc', 'Discover how FixMate AI works: from instant computer vision defect diagnosis and upfront cost estimation to verified technician dispatch and protected escrow payments.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 56px 0 40px 0; text-align: center; background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%); border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 800px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #FFB800;"></span>
                <span style="font-size: 12.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">Step-by-Step Experience</span>
            </div>
            <h1 style="font-size: 42px; font-weight: 900; color: #0F172A; margin: 0 0 16px 0; letter-spacing: -0.03em; line-height: 1.15;">
                How <span style="color: #FFB800;">FixMate AI</span> Works
            </h1>
            <p style="font-size: 16.5px; color: #64748B; margin: 0 auto; line-height: 1.7; max-width: 660px;">
                From taking a quick photo on your phone to completed repair with guaranteed warranty. Here is how our intelligent platform protects your home, your time, and your money.
            </p>
        </div>
    </section>

    <!-- 5-Step Visual Walkthrough -->
    <section style="padding: 60px 0 70px 0;">
        <div class="container" style="max-width: 1040px;">
            
            <div style="display: flex; flex-direction: column; gap: 28px;">
                
                <!-- Step 1 -->
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 32px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02); transition: all 0.2s;">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 2px solid #FEF08A; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        01
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 1 • Instant Capture</span>
                        </div>
                        <h3 style="font-size: 21px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Snap a Photo or Describe the Issue</h3>
                        <p style="font-size: 14.5px; color: #64748B; margin: 0; line-height: 1.7;">
                            Simply take a photo of your leaking pipe, broken socket, or noisy air conditioner. You can also type in Urdu or English, or record a quick 10-second voice note explaining the problem.
                        </p>
                    </div>
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 14px 20px; border-radius: 14px; text-align: center; min-width: 140px;">
                        <span style="font-size: 26px; display: block; margin-bottom: 4px;">📸</span>
                        <span style="font-size: 12px; font-weight: 700; color: #475569;">Camera / Voice</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div style="background: #FFFDF0; border: 1.5px solid #FDE68A; border-radius: 20px; padding: 32px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 8px 24px rgba(255, 184, 0, 0.08);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFB800; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35);">
                        02
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 2 • Artificial Intelligence</span>
                        </div>
                        <h3 style="font-size: 21px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">AI Diagnostic Analysis & Upfront Pricing</h3>
                        <p style="font-size: 14.5px; color: #64748B; margin: 0; line-height: 1.7;">
                            Our computer vision neural network recognizes the damaged component, diagnoses the underlying fault, specifies parts required, and calculates a fair, standardized labor cost range. No surprise bills.
                        </p>
                    </div>
                    <div style="background: #FFFFFF; border: 1px solid #FEF08A; padding: 14px 20px; border-radius: 14px; text-align: center; min-width: 140px;">
                        <span style="font-size: 26px; display: block; margin-bottom: 4px;">⚡</span>
                        <span style="font-size: 12px; font-weight: 800; color: #92400E;">Instant Estimate</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 32px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 2px solid #FEF08A; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        03
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 3 • Verified Matching</span>
                        </div>
                        <h3 style="font-size: 21px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Match with Top-Rated Verified Professionals</h3>
                        <p style="font-size: 14.5px; color: #64748B; margin: 0; line-height: 1.7;">
                            Compare nearby certified technicians based on customer review scores, distance from your home, verified badges, and historical completion rates. Pick your favorite or auto-dispatch the fastest pro.
                        </p>
                    </div>
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 14px 20px; border-radius: 14px; text-align: center; min-width: 140px;">
                        <span style="font-size: 26px; display: block; margin-bottom: 4px;">🛡️</span>
                        <span style="font-size: 12px; font-weight: 700; color: #475569;">100% Vetted</span>
                    </div>
                </div>

                <!-- Step 4 -->
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 32px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 2px solid #FEF08A; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        04
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 4 • Safe Dispatch</span>
                        </div>
                        <h3 style="font-size: 21px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Live GPS Tracking & Arrival OTP Handshake</h3>
                        <p style="font-size: 14.5px; color: #64748B; margin: 0; line-height: 1.7;">
                            Watch the technician’s live route on our interactive map. When they ring your doorbell, verify their identity using a secure 4-digit Arrival OTP generated on your dashboard before letting them in.
                        </p>
                    </div>
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 14px 20px; border-radius: 14px; text-align: center; min-width: 140px;">
                        <span style="font-size: 26px; display: block; margin-bottom: 4px;">📍</span>
                        <span style="font-size: 12px; font-weight: 700; color: #475569;">4-Digit OTP</span>
                    </div>
                </div>

                <!-- Step 5 -->
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 32px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #10B981; color: #FFFFFF; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        05
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #047857; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 5 • Escrow & Warranty</span>
                        </div>
                        <h3 style="font-size: 21px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Work Approval, Escrow Release & 30-Day Guarantee</h3>
                        <p style="font-size: 14.5px; color: #64748B; margin: 0; line-height: 1.7;">
                            Test the repaired fixture with the technician. Once you approve the work, funds are released from secure escrow. The job is backed by FixMate AI's 30-day workmanship re-inspection guarantee.
                        </p>
                    </div>
                    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; padding: 14px 20px; border-radius: 14px; text-align: center; min-width: 140px;">
                        <span style="font-size: 26px; display: block; margin-bottom: 4px;">✅</span>
                        <span style="font-size: 12px; font-weight: 800; color: #047857;">30-Day Cover</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Comparison Table: Traditional vs FixMate AI -->
    <section style="padding: 60px 0; background: #F8FAFC; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 960px;">
            <div style="text-align: center; margin-bottom: 40px;">
                <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Why Choose FixMate AI</span>
                <h3 style="font-size: 30px; font-weight: 900; color: #0F172A; margin: 8px 0 10px 0; letter-spacing: -0.02em;">Traditional Handyman vs FixMate AI Certified</h3>
            </div>

            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background: #0F172A; color: #FFFFFF;">
                            <th style="padding: 18px 24px; font-weight: 800; font-size: 15px;">Service Feature</th>
                            <th style="padding: 18px 24px; font-weight: 800; font-size: 15px; color: #94A3B8;">Local Marketplace Handyman</th>
                            <th style="padding: 18px 24px; font-weight: 800; font-size: 15px; background: #FFB800; color: #0F172A;">FixMate AI Certified</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 16px 24px; font-weight: 700; color: #0F172A;">Price Certainty</td>
                            <td style="padding: 16px 24px; color: #EF4444;">❌ Arbitrary quote upon arrival</td>
                            <td style="padding: 16px 24px; font-weight: 700; color: #047857; background: #FFFDF0;">✓ AI Pre-calculated cost index</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 16px 24px; font-weight: 700; color: #0F172A;">Identity & Background Vetting</td>
                            <td style="padding: 16px 24px; color: #EF4444;">❌ Unverified, no background check</td>
                            <td style="padding: 16px 24px; font-weight: 700; color: #047857; background: #FFFDF0;">✓ 100% NADRA CNIC & Police Vetted</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 16px 24px; font-weight: 700; color: #0F172A;">Arrival Verification</td>
                            <td style="padding: 16px 24px; color: #EF4444;">❌ Anyone can show up</td>
                            <td style="padding: 16px 24px; font-weight: 700; color: #047857; background: #FFFDF0;">✓ Secure 4-Digit Arrival OTP</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 16px 24px; font-weight: 700; color: #0F172A;">Payment Protection</td>
                            <td style="padding: 16px 24px; color: #EF4444;">❌ Cash in advance with no recourse</td>
                            <td style="padding: 16px 24px; font-weight: 700; color: #047857; background: #FFFDF0;">✓ Protected Escrow, released upon sign-off</td>
                        </tr>
                        <tr>
                            <td style="padding: 16px 24px; font-weight: 700; color: #0F172A;">Workmanship Warranty</td>
                            <td style="padding: 16px 24px; color: #EF4444;">❌ No warranty once they leave</td>
                            <td style="padding: 16px 24px; font-weight: 700; color: #047857; background: #FFFDF0;">✓ 30-Day Free Re-inspection Warranty</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section style="padding: 60px 0;">
        <div class="container" style="max-width: 860px; text-align: center;">
            <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 24px; padding: 48px; color: #FFFFFF;">
                <h3 style="font-size: 28px; font-weight: 900; margin: 0 0 12px 0;">Have a home repair emergency right now?</h3>
                <p style="font-size: 15px; color: #94A3B8; margin: 0 auto 24px auto; max-width: 540px; line-height: 1.6;">
                    Upload an image or describe your issue. Our AI diagnosis engine takes under 10 seconds to estimate and match you with a pro.
                </p>
                <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ url('/services') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14.5px; padding: 13px 28px; border-radius: 10px; text-decoration: none;">
                        Explore Home Services
                    </a>
                    <a href="{{ url('/technicians') }}" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.25); color: #FFFFFF; font-weight: 700; font-size: 14.5px; padding: 13px 26px; border-radius: 10px; text-decoration: none;">
                        Find Local Technicians
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
