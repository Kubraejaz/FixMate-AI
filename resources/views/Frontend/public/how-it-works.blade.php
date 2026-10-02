@extends('Frontend.layouts.public')

@section('title', 'How It Works — FixMate AI | Smart Home Services')
@section('meta_desc', 'Discover how FixMate AI works: from instant computer vision defect diagnosis and upfront cost estimation to verified technician dispatch and protected escrow payments.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 56px 0 36px 0; text-align: center; background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%); border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 860px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #FFB800;"></span>
                <span style="font-size: 12.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">Step-by-Step Experience</span>
            </div>
            <h1 style="font-size: 42px; font-weight: 900; color: #0F172A; margin: 0 0 16px 0; letter-spacing: -0.03em; line-height: 1.15;">
                How <span style="color: #FFB800;">FixMate AI</span> Works
            </h1>
            <p style="font-size: 16.5px; color: #64748B; margin: 0 auto 28px auto; line-height: 1.7; max-width: 680px;">
                From taking a quick photo on your phone to completed repair with guaranteed warranty. Here is how our intelligent platform protects your home, your time, and your money.
            </p>

            <!-- Dynamic Platform Trust Badges -->
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; margin-top: 10px;">
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 12px; font-size: 13.5px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <span style="color: #64748B;">Network:</span> <strong style="color: #0F172A;">{{ $stats['total_technicians'] }}+ Verified Techs</strong>
                </div>
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 12px; font-size: 13.5px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <span style="color: #64748B;">Arrival:</span> <strong style="color: #0F172A;">Avg {{ $stats['avg_arrival_mins'] }} Mins</strong>
                </div>
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 12px; font-size: 13.5px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <span style="color: #64748B;">Protection:</span> <strong style="color: #16A34A;">{{ $stats['warranty_days'] }}-Day Warranty</strong>
                </div>
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 10px 18px; border-radius: 12px; font-size: 13.5px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <span style="color: #64748B;">Escrow:</span> <strong style="color: #B45309;">100% Guaranteed</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive AI Diagnostics & Cost Estimator Simulator -->
    <section style="padding: 50px 0 30px 0; background: #FFFFFF;">
        <div class="container" style="max-width: 1040px;">
            <div style="background: #0F172A; border-radius: 24px; padding: 40px; color: #FFFFFF; box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.25);">
                
                <div style="text-align: center; max-width: 620px; margin: 0 auto 36px auto;">
                    <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Interactive Simulator</span>
                    <h2 style="font-size: 30px; font-weight: 900; margin: 8px 0 10px 0; letter-spacing: -0.02em;">
                        Try Our Upfront Pricing Engine
                    </h2>
                    <p style="font-size: 14.5px; color: #94A3B8; margin: 0;">
                        See how FixMate pre-calculates visiting fee, standard labor, and estimated replacement components before you book.
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; align-items: center;">
                    
                    <!-- Controls -->
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; color: #E2E8F0; margin-bottom: 8px;">Select Trade Category</label>
                            <select id="sim_trade" onchange="runCostSimulation()" style="width: 100%; height: 46px; border-radius: 12px; background: #1E293B; border: 1.5px solid #334155; color: #FFFFFF; padding: 0 14px; font-size: 14px; font-family: inherit; outline: none; cursor: pointer;">
                                @foreach($professions as $prof)
                                    <option value="{{ $prof->slug }}" data-name="{{ $prof->name }}">{{ $prof->name }} ({{ $prof->professionals_count }} techs)</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; color: #E2E8F0; margin-bottom: 8px;">Issue Severity</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                                <button type="button" class="sim-sev-btn" data-factor="1" onclick="setSeverity(1, this)" style="background: #FFB800; color: #0F172A; font-weight: 800; border: none; padding: 10px 8px; border-radius: 10px; font-size: 12.5px; cursor: pointer;">Minor Fix</button>
                                <button type="button" class="sim-sev-btn" data-factor="1.6" onclick="setSeverity(1.6, this)" style="background: #1E293B; color: #E2E8F0; border: 1px solid #334155; padding: 10px 8px; border-radius: 10px; font-size: 12.5px; cursor: pointer;">Standard</button>
                                <button type="button" class="sim-sev-btn" data-factor="2.5" onclick="setSeverity(2.5, this)" style="background: #1E293B; color: #E2E8F0; border: 1px solid #334155; padding: 10px 8px; border-radius: 10px; font-size: 12.5px; cursor: pointer;">Emergency</button>
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; color: #E2E8F0; margin-bottom: 8px;">Service City</label>
                            <select id="sim_city" onchange="runCostSimulation()" style="width: 100%; height: 46px; border-radius: 12px; background: #1E293B; border: 1.5px solid #334155; color: #FFFFFF; padding: 0 14px; font-size: 14px; font-family: inherit; outline: none; cursor: pointer;">
                                <option value="Karachi">Karachi (Rapid Radar)</option>
                                <option value="Lahore">Lahore (Central Grid)</option>
                                <option value="Islamabad">Islamabad &amp; Rawalpindi</option>
                            </select>
                        </div>

                    </div>

                    <!-- Simulator Output -->
                    <div style="background: #1E293B; border: 2px solid #FFB800; border-radius: 20px; padding: 30px; text-align: left;">
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #334155; padding-bottom: 12px;">
                            <span style="font-size: 13px; font-weight: 700; color: #94A3B8;">Inspection / Visiting Fee</span>
                            <span id="sim_visiting" style="font-size: 14px; font-weight: 800; color: #FFFFFF;">Rs 500</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #334155; padding-bottom: 12px;">
                            <span style="font-size: 13px; font-weight: 700; color: #94A3B8;">Estimated Labor Charge</span>
                            <span id="sim_labor" style="font-size: 14px; font-weight: 800; color: #FFFFFF;">Rs 1,200</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #334155; padding-bottom: 12px;">
                            <span style="font-size: 13px; font-weight: 700; color: #94A3B8;">Parts &amp; Materials Range</span>
                            <span id="sim_parts" style="font-size: 14px; font-weight: 800; color: #FFB800;">Rs 600 - 1,400</span>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <span style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 800;">Total Escrow Protected Estimate</span>
                            <div id="sim_total" style="font-size: 32px; font-weight: 900; color: #FFFFFF; line-height: 1.2; margin-top: 4px;">
                                Rs 2,300 - 3,100
                            </div>
                            <span style="font-size: 12px; color: #10B981; font-weight: 700; display: block; margin-top: 4px;">
                                ✓ 30-Day Free Re-inspection Included
                            </span>
                        </div>

                        <a id="sim_cta" href="{{ route('technicians') }}" style="display: block; width: 100%; text-align: center; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 12px 0; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(255,184,0,0.3);">
                            Find Verified Technicians for This Service →
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 5-Step Visual Walkthrough -->
    <section style="padding: 50px 0 70px 0;">
        <div class="container" style="max-width: 1040px;">
            
            <div style="text-align: center; margin-bottom: 40px;">
                <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Step-by-Step Experience</span>
                <h2 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 8px 0 10px 0; letter-spacing: -0.02em;">From Booking to 30-Day Guarantee</h2>
            </div>

            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <!-- Step 1 -->
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 30px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 2px solid #FEF08A; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        01
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 1 • Instant Capture</span>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Snap a Photo or Describe the Issue</h3>
                        <p style="font-size: 14.5px; color: #64748B; margin: 0; line-height: 1.7;">
                            Simply take a photo of your leaking pipe, broken socket, or noisy air conditioner. You can also type in Urdu or English, or record a quick voice note explaining the problem.
                        </p>
                    </div>
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 14px 20px; border-radius: 14px; text-align: center; min-width: 140px;">
                        <span style="font-size: 26px; display: block; margin-bottom: 4px;">📸</span>
                        <span style="font-size: 12px; font-weight: 700; color: #475569;">Camera / Voice</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div style="background: #FFFDF0; border: 1.5px solid #FDE68A; border-radius: 20px; padding: 30px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 8px 24px rgba(255, 184, 0, 0.08);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFB800; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35);">
                        02
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 2 • Artificial Intelligence</span>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">AI Diagnostic Analysis &amp; Upfront Pricing</h3>
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
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 30px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 2px solid #FEF08A; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        03
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 3 • Verified Matching</span>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Match with Top-Rated Verified Professionals</h3>
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
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 30px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 2px solid #FEF08A; color: #0F172A; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        04
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 4 • Safe Dispatch</span>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Live GPS Tracking &amp; Arrival OTP Handshake</h3>
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
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 30px 36px; display: grid; grid-template-columns: auto 1fr auto; gap: 28px; align-items: center; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
                    <div style="width: 56px; height: 56px; border-radius: 16px; background: #10B981; color: #FFFFFF; font-size: 22px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        05
                    </div>
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 800; color: #047857; text-transform: uppercase; margin-bottom: 6px;">
                            <span>Step 5 • Escrow &amp; Warranty</span>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Work Approval, Escrow Release &amp; 30-Day Guarantee</h3>
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
                            <td style="padding: 16px 24px; font-weight: 700; color: #0F172A;">Identity &amp; Background Vetting</td>
                            <td style="padding: 16px 24px; color: #EF4444;">❌ Unverified, no background check</td>
                            <td style="padding: 16px 24px; font-weight: 700; color: #047857; background: #FFFDF0;">✓ 100% NADRA CNIC &amp; Police Vetted</td>
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
                    <a href="{{ route('services') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14.5px; padding: 13px 28px; border-radius: 10px; text-decoration: none;">
                        Explore Home Services
                    </a>
                    <a href="{{ route('technicians') }}" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.25); color: #FFFFFF; font-weight: 700; font-size: 14.5px; padding: 13px 26px; border-radius: 10px; text-decoration: none;">
                        Find Local Technicians
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    var currentSeverityFactor = 1;

    function setSeverity(factor, btn) {
        currentSeverityFactor = factor;
        document.querySelectorAll('.sim-sev-btn').forEach(function(b) {
            b.style.background = '#1E293B';
            b.style.color = '#E2E8F0';
            b.style.border = '1px solid #334155';
            b.style.fontWeight = '500';
        });
        btn.style.background = '#FFB800';
        btn.style.color = '#0F172A';
        btn.style.border = 'none';
        btn.style.fontWeight = '800';
        runCostSimulation();
    }

    function runCostSimulation() {
        var tradeSelect = document.getElementById('sim_trade');
        var selectedSlug = tradeSelect.value;
        var selectedOption = tradeSelect.options[tradeSelect.selectedIndex];
        var tradeName = selectedOption.getAttribute('data-name') || 'Technicians';

        var baseLabor = 1000;
        var baseVisiting = 500;
        var basePartsMin = 400;
        var basePartsMax = 1200;

        if (selectedSlug.includes('plumb')) {
            baseLabor = 900;
            basePartsMin = 500;
            basePartsMax = 1500;
        } else if (selectedSlug.includes('electr')) {
            baseLabor = 1100;
            basePartsMin = 600;
            basePartsMax = 1800;
        } else if (selectedSlug.includes('ac') || selectedSlug.includes('hvac')) {
            baseLabor = 1500;
            basePartsMin = 1500;
            basePartsMax = 4000;
        } else if (selectedSlug.includes('paint')) {
            baseLabor = 1400;
            basePartsMin = 1000;
            basePartsMax = 3000;
        }

        var labor = Math.round(baseLabor * currentSeverityFactor);
        var partsMin = Math.round(basePartsMin * currentSeverityFactor);
        var partsMax = Math.round(basePartsMax * currentSeverityFactor);

        var totalMin = baseVisiting + labor + partsMin;
        var totalMax = baseVisiting + labor + partsMax;

        document.getElementById('sim_visiting').textContent = 'Rs ' + baseVisiting;
        document.getElementById('sim_labor').textContent = 'Rs ' + labor.toLocaleString();
        document.getElementById('sim_parts').textContent = 'Rs ' + partsMin.toLocaleString() + ' - ' + partsMax.toLocaleString();
        document.getElementById('sim_total').textContent = 'Rs ' + totalMin.toLocaleString() + ' - ' + totalMax.toLocaleString();

        var cta = document.getElementById('sim_cta');
        cta.textContent = 'Find Verified ' + tradeName + ' →';
        cta.href = "{{ url('/technicians') }}?search=" + encodeURIComponent(tradeName);
    }

    document.addEventListener('DOMContentLoaded', runCostSimulation);
</script>
@endsection
