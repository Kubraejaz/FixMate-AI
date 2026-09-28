@extends('Frontend.layouts.public')

@section('title', 'Become a Technician Partner — FixMate AI | Grow Your Trade Earnings')
@section('meta_desc', 'Join Pakistan’s premier certified trade technician network. Enjoy guaranteed prompt payouts, local jobs dispatched to your phone, and zero registration fees.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Hero Header -->
    <section style="padding: 60px 0 50px 0; background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%); border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 1140px;">
            <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 40px; align-items: center;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #FFB800;"></span>
                        <span style="font-size: 12.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">FixMate AI Partner Network</span>
                    </div>
                    <h1 style="font-size: 42px; font-weight: 900; color: #0F172A; margin: 0 0 16px 0; letter-spacing: -0.03em; line-height: 1.18;">
                        Work On Your Schedule. <br><span style="color: #FFB800;">Earn Up to Rs 120,000+ /Mo</span>
                    </h1>
                    <p style="font-size: 16px; color: #64748B; margin: 0 0 24px 0; line-height: 1.7;">
                        Connect directly with verified domestic clients in your neighborhood. Get problem photos and estimated budgets before accepting jobs, with 100% guaranteed escrow payouts.
                    </p>
                    <div style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
                        <a href="{{ url('/register/technician') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 15px; padding: 13px 30px; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 14px rgba(255, 184, 0, 0.35); transition: all 0.2s;">
                            Apply as a Technician →
                        </a>
                        <a href="#benefits" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #1E293B; font-weight: 700; font-size: 14.5px; padding: 12px 24px; border-radius: 10px; text-decoration: none;">
                            Learn How It Works
                        </a>
                    </div>
                    <div style="display: flex; gap: 24px; margin-top: 28px; padding-top: 20px; border-top: 1px solid #E2E8F0; font-size: 13.5px; color: #64748B;">
                        <span>✓ Zero Registration Fee</span>
                        <span>✓ Instant Daily/Weekly Payouts</span>
                        <span>✓ Verified Safe Customers</span>
                    </div>
                </div>
                <div style="text-align: center; position: relative;">
                    <img src="{{ asset('assets/images/Cleaning_Professional.png') }}" alt="FixMate AI Technician Partner" style="height: 420px; width: auto; object-fit: contain; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.12));">
                </div>
            </div>
        </div>
    </section>

    <!-- 4 Key Partner Benefits -->
    <section id="benefits" style="padding: 70px 0 60px 0;">
        <div class="container" style="max-width: 1140px;">
            <div style="text-align: center; max-width: 640px; margin: 0 auto 48px auto;">
                <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Why Join Us</span>
                <h2 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 8px 0 12px 0; letter-spacing: -0.02em;">Better Pay, Better Dignity, Better Security</h2>
                <p style="font-size: 15px; color: #64748B; margin: 0; line-height: 1.6;">No more waiting on street corners or dealing with unreliable customers who bargain down after the job is finished.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 60px;">
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 18px; padding: 28px; text-align: left;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
                        💰
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Escrow Guaranteed Pay</h3>
                    <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">Customer funds are held in escrow before you head out. Complete the job and receive payout via JazzCash, EasyPaisa, or Raast.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 18px; padding: 28px; text-align: left;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #EFF6FF; border: 1px solid #DBEAFE; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
                        📍
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Jobs In Your Area</h3>
                    <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">Smart GPS radar routes jobs within 3-6km of your location so you save fuel and finish more bookings per day.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 18px; padding: 28px; text-align: left;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #ECFDF5; border: 1px solid #A7F3D0; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
                        🛡️
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Arrival OTP Security</h3>
                    <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">Every customer must provide their unique 4-digit code on arrival. Your safety and job authenticity are always verified.</p>
                </div>

                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 18px; padding: 28px; text-align: left;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #FFF1F2; border: 1px solid #FECDD3; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
                        ⭐
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Reputation Growth</h3>
                    <p style="font-size: 13.5px; color: #64748B; line-height: 1.6; margin: 0;">Top-rated technicians get Pro Badges, priority dispatch for high-value commercial jobs, and weekly performance bonuses.</p>
                </div>
            </div>

            <!-- Earning Potential Matrix -->
            <div style="background: #0F172A; border-radius: 24px; padding: 44px; color: #FFFFFF; margin-bottom: 70px;">
                <div style="text-align: center; max-width: 600px; margin: 0 auto 36px auto;">
                    <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Income Transparency</span>
                    <h3 style="font-size: 28px; font-weight: 900; margin: 8px 0 10px 0; letter-spacing: -0.02em;">How Much Can You Earn?</h3>
                    <p style="font-size: 14.5px; color: #94A3B8; margin: 0;">Estimated average monthly take-home earnings based on active partner data in Lahore, Karachi, and Islamabad.</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                    <div style="background: #1E293B; border: 1px solid #334155; border-radius: 16px; padding: 28px; text-align: center;">
                        <span style="font-size: 13px; font-weight: 700; color: #94A3B8; text-transform: uppercase;">Part-Time Pro</span>
                        <div style="font-size: 32px; font-weight: 900; color: #FFFFFF; margin: 12px 0 6px 0;">Rs 45,000 - 65,000</div>
                        <p style="font-size: 13px; color: #94A3B8; margin: 0 0 16px 0;">15 to 20 hours/week • 2-3 jobs daily</p>
                        <span style="display: inline-block; font-size: 12px; background: rgba(255,255,255,0.08); padding: 4px 12px; border-radius: 50px; color: #CBD5E1;">Ideal for side income</span>
                    </div>

                    <div style="background: #1E293B; border: 2px solid #FFB800; border-radius: 16px; padding: 28px; text-align: center; position: relative;">
                        <span style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #FFB800; color: #0F172A; font-size: 11px; font-weight: 900; padding: 3px 12px; border-radius: 50px; text-transform: uppercase;">Most Common</span>
                        <span style="font-size: 13px; font-weight: 700; color: #FFB800; text-transform: uppercase;">Full-Time Dedicated</span>
                        <div style="font-size: 34px; font-weight: 900; color: #FFB800; margin: 12px 0 6px 0;">Rs 85,000 - 130,000</div>
                        <p style="font-size: 13px; color: #94A3B8; margin: 0 0 16px 0;">40 hours/week • 4-6 jobs daily</p>
                        <span style="display: inline-block; font-size: 12px; background: rgba(255, 184, 0, 0.15); padding: 4px 12px; border-radius: 50px; color: #FEF08A;">Full professional career</span>
                    </div>

                    <div style="background: #1E293B; border: 1px solid #334155; border-radius: 16px; padding: 28px; text-align: center;">
                        <span style="font-size: 13px; font-weight: 700; color: #94A3B8; text-transform: uppercase;">Master Trade Team Lead</span>
                        <div style="font-size: 32px; font-weight: 900; color: #FFFFFF; margin: 12px 0 6px 0;">Rs 150,000 - 220,000+</div>
                        <p style="font-size: 13px; color: #94A3B8; margin: 0 0 16px 0;">Commercial contracts & team jobs</p>
                        <span style="display: inline-block; font-size: 12px; background: rgba(255,255,255,0.08); padding: 4px 12px; border-radius: 50px; color: #CBD5E1;">Senior specialists & master electricians</span>
                    </div>
                </div>
            </div>

            <!-- 4-Step Onboarding Process -->
            <div style="margin-bottom: 70px;">
                <div style="text-align: center; max-width: 600px; margin: 0 auto 36px auto;">
                    <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">How to Join</span>
                    <h3 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 8px 0 10px 0; letter-spacing: -0.02em;">Get Approved in 4 Simple Steps</h3>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #FFB800; color: #0F172A; font-weight: 900; display: flex; align-items: center; justify-content: center; margin-bottom: 14px;">1</div>
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Online Registration</h4>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">Submit your CNIC, trade specialty (e.g. Electrician, AC Repair), and contact details in 3 minutes.</p>
                    </div>

                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #FFB800; color: #0F172A; font-weight: 900; display: flex; align-items: center; justify-content: center; margin-bottom: 14px;">2</div>
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Skill Assessment</h4>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">Short practical interview and tool checklist verification with a FixMate Trade Inspector.</p>
                    </div>

                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #FFB800; color: #0F172A; font-weight: 900; display: flex; align-items: center; justify-content: center; margin-bottom: 14px;">3</div>
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Background Verification</h4>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">NADRA identity authentication and police character certificate validation for customer safety.</p>
                    </div>

                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #10B981; color: #FFFFFF; font-weight: 900; display: flex; align-items: center; justify-content: center; margin-bottom: 14px;">✓</div>
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Start Earning</h4>
                        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">Download the technician portal, set your status to Available, and receive dispatched local jobs.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom CTA Banner -->
            <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 24px; padding: 44px; text-align: center;">
                <h3 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Take charge of your career today</h3>
                <p style="font-size: 14.5px; color: #64748B; margin: 0 auto 20px auto; max-width: 520px; line-height: 1.6;">
                    Applications reviewed within 24 hours. Join thousands of respected trade professionals across Pakistan.
                </p>
                <a href="{{ url('/register/technician') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 15px; padding: 13px 32px; border-radius: 10px; text-decoration: none; display: inline-block; box-shadow: 0 4px 14px rgba(255, 184, 0, 0.35);">
                    Start Technician Application →
                </a>
            </div>

        </div>
    </section>

</div>
@endsection
