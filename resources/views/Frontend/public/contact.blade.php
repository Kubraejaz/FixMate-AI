@extends('Frontend.layouts.public')

@section('title', 'Contact Us — FixMate AI | 24/7 Home Repair & Dispatch Desk')
@section('meta_desc', 'Contact FixMate AI for emergency home repairs, technician onboarding, billing assistance, or corporate property maintenance in Pakistan.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Executive Header -->
    <section style="padding: 48px 0 36px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 780px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">24/7 SUPPORT & DISPATCH NETWORK</span>
            </div>
            <h1 style="font-size: 38px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                We're Here to Help You
            </h1>
            <p style="font-size: 15.5px; color: #64748B; margin: 0; line-height: 1.6;">
                Have an urgent pipe burst, questions about an active booking, or need partner support? Reach our specialized desks or track your ticket live below.
            </p>
        </div>
    </section>

    <!-- 4 Specialized Direct Support Channels -->
    <section style="padding: 40px 0 20px 0; background: #FFFFFF;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                
                <!-- Channel 1: Customer Care -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #E0F2FE; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px;">
                        📞
                    </div>
                    <span style="font-size: 11px; font-weight: 800; color: #0369A1; text-transform: uppercase; display: block; margin-bottom: 4px;">Homeowner Helpline</span>
                    <strong style="font-size: 16px; color: #0F172A; display: block; margin-bottom: 6px;">Booking &amp; Status</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0 0 12px 0; line-height: 1.5;">Direct tracking, rescheduling, or booking questions with our concierge.</p>
                    <a href="tel:+923001234567" style="font-size: 13.5px; font-weight: 800; color: #0284C7; text-decoration: none; display: block;">+92 300 1234567 &rarr;</a>
                    <span style="font-size: 11px; color: #94A3B8; display: block; margin-top: 4px;">Available 7 Days • 8 AM – 10 PM</span>
                </div>

                <!-- Channel 2: Emergency Squad -->
                <div style="background: #FFF1F2; border: 1px solid #FECDD3; border-radius: 16px; padding: 22px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFE4E6; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px;">
                        🚨
                    </div>
                    <span style="font-size: 11px; font-weight: 800; color: #BE123C; text-transform: uppercase; display: block; margin-bottom: 4px;">Rapid 20-Min Response</span>
                    <strong style="font-size: 16px; color: #0F172A; display: block; margin-bottom: 6px;">Emergency Squad</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0 0 12px 0; line-height: 1.5;">Major pipe bursts, gas line odor, live electrical sparks or power outages.</p>
                    <a href="tel:+92518899229" style="font-size: 13.5px; font-weight: 800; color: #E11D48; text-decoration: none; display: block;">+92 51 8899229 &rarr;</a>
                    <span style="font-size: 11px; color: #E11D48; font-weight: 700; display: block; margin-top: 4px;">24/7 Priority Emergency Desk</span>
                </div>

                <!-- Channel 3: Technician Partner Ops -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #FEF3C7; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px;">
                        🧑‍🔧
                    </div>
                    <span style="font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; display: block; margin-bottom: 4px;">Technician Desk</span>
                    <strong style="font-size: 16px; color: #0F172A; display: block; margin-bottom: 6px;">Partner Operations</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0 0 12px 0; line-height: 1.5;">NADRA biometric verification, wallet withdrawals, and skill testing.</p>
                    <a href="mailto:partners@fixmate.ai" style="font-size: 13.5px; font-weight: 800; color: #B45309; text-decoration: none; display: block;">partners@fixmate.ai &rarr;</a>
                    <span style="font-size: 11px; color: #94A3B8; display: block; margin-top: 4px;">Mon – Sat • 9 AM – 6 PM</span>
                </div>

                <!-- Channel 4: Corporate / Facilities -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: #DCFCE7; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 14px;">
                        🏢
                    </div>
                    <span style="font-size: 11px; font-weight: 800; color: #166534; text-transform: uppercase; display: block; margin-bottom: 4px;">Commercial AMC</span>
                    <strong style="font-size: 16px; color: #0F172A; display: block; margin-bottom: 6px;">Corporate Facilities</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0 0 12px 0; line-height: 1.5;">Property managers, commercial offices, schools, and housing societies.</p>
                    <a href="mailto:corporate@fixmate.ai" style="font-size: 13.5px; font-weight: 800; color: #15803D; text-decoration: none; display: block;">corporate@fixmate.ai &rarr;</a>
                    <span style="font-size: 11px; color: #94A3B8; display: block; margin-top: 4px;">Dedicated Account Manager</span>
                </div>

            </div>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- DYNAMIC TICKET STATUS TRACKER SECTION                     -->
    <!-- ======================================================== -->
    <section id="inquiry-tracker" style="padding: 24px 0 36px 0; background: #FFFFFF;">
        <div class="container">
            <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 20px; padding: 32px 36px; color: #FFFFFF; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15); position: relative; overflow: hidden;">
                
                <div style="position: absolute; right: -40px; bottom: -40px; width: 180px; height: 180px; background: rgba(255, 184, 0, 0.08); border-radius: 50%; pointer-events: none;"></div>

                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 22px;">
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 184, 0, 0.15); border: 1px solid rgba(255, 184, 0, 0.4); padding: 3px 12px; border-radius: 50px; margin-bottom: 8px;">
                            <span style="font-size: 11px; font-weight: 800; color: #FFD54F; letter-spacing: 0.05em; text-transform: uppercase;">LIVE DATABASE LOOKUP</span>
                        </div>
                        <h2 style="font-size: 24px; font-weight: 800; color: #FFFFFF; margin: 0 0 4px 0;">Track Your Support Ticket Status</h2>
                        <p style="font-size: 13.5px; color: #94A3B8; margin: 0;">Have you contacted us? Enter your Reference Number (e.g. <code>FM-INQ-XXXXXX</code>) or mobile phone to see your ticket status and resolution notes.</p>
                    </div>

                    <!-- Fast Lookup Form -->
                    <form action="{{ route('contact') }}#inquiry-tracker" method="GET" style="display: flex; gap: 10px; width: 100%; max-width: 480px;">
                        <input type="text" name="track_ref" value="{{ request('track_ref') }}" placeholder="e.g. FM-INQ-1A2B3C or 0300-1234567" required style="flex: 1; height: 46px; border-radius: 12px; border: 1.5px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.1); color: #FFFFFF; padding: 0 16px; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#FFB800'; this.style.background='rgba(255, 255, 255, 0.16)'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.2)'; this.style.background='rgba(255, 255, 255, 0.1)'">
                        <button type="submit" style="background: #FFB800; color: #0F172A; border: none; padding: 0 22px; height: 46px; border-radius: 12px; font-weight: 800; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.3); transition: background 0.15s;" onmouseover="this.style.background='#F59E0B'" onmouseout="this.style.background='#FFB800'">
                            <span>Search</span>
                            <span>&rarr;</span>
                        </button>
                    </form>
                </div>

                <!-- Case 1: Track Error Alert -->
                @if(isset($trackError))
                    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 12px; padding: 14px 18px; margin-top: 14px; display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; color: #FCA5A5;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 18px;">⚠️</span>
                            <span>{{ $trackError }}</span>
                        </div>
                        <a href="{{ route('contact') }}#inquiry-form" style="color: #FFB800; font-weight: 700; text-decoration: underline; font-size: 12.5px;">Submit New Inquiry &rarr;</a>
                    </div>
                @endif

                <!-- Case 2: Tracked Inquiry Found in Database -->
                @if(isset($trackedInquiry))
                    @php
                        $badge = $trackedInquiry->status_badge;
                    @endphp
                    <div style="background: #FFFFFF; border-radius: 16px; padding: 24px; color: #0F172A; margin-top: 18px; box-shadow: 0 6px 20px rgba(0,0,0,0.18);">
                        
                        <!-- Top Bar with Ref and Status -->
                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 12px; border-bottom: 1px solid #E2E8F0; padding-bottom: 16px; margin-bottom: 16px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="font-family: monospace; font-size: 15px; font-weight: 800; background: #EEF2F6; color: #0F172A; padding: 4px 10px; border-radius: 8px;">
                                    #{{ $trackedInquiry->reference_no }}
                                </span>
                                <div>
                                    <span style="font-size: 12px; color: #64748B;">Submitted on</span>
                                    <strong style="font-size: 12px; color: #0F172A;">{{ $trackedInquiry->created_at->format('M d, Y · h:i A') }}</strong>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 800; padding: 5px 12px; border-radius: 50px; background: {{ $badge['bg'] }}; color: {{ $badge['color'] }};">
                                    <span style="width: 7px; height: 7px; border-radius: 50%; background: currentColor;"></span>
                                    {{ $badge['label'] }}
                                </span>
                                <a href="{{ route('contact') }}#inquiry-tracker" style="font-size: 12px; color: #64748B; text-decoration: none; padding: 4px 8px; border-radius: 6px; background: #F1F5F9;">Clear</a>
                            </div>
                        </div>

                        <!-- Ticket Details Grid -->
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 18px; font-size: 13px;">
                            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 12px; border-radius: 10px;">
                                <span style="font-size: 11px; text-transform: uppercase; color: #94A3B8; font-weight: 700; display: block;">Sender / Customer</span>
                                <strong style="color: #0F172A; font-size: 14px;">{{ $trackedInquiry->name }}</strong>
                                <span style="display: block; font-size: 11.5px; color: #64748B; margin-top: 2px;">📍 {{ $trackedInquiry->city }}</span>
                            </div>

                            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 12px; border-radius: 10px;">
                                <span style="font-size: 11px; text-transform: uppercase; color: #94A3B8; font-weight: 700; display: block;">Assigned Department</span>
                                <strong style="color: #0F172A; font-size: 14px;">{{ $trackedInquiry->department_label }}</strong>
                                <span style="display: block; font-size: 11.5px; color: #64748B; margin-top: 2px;">Concierge Dispatch Squad</span>
                            </div>

                            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 12px; border-radius: 10px;">
                                <span style="font-size: 11px; text-transform: uppercase; color: #94A3B8; font-weight: 700; display: block;">Contact Verified</span>
                                <strong style="color: #0F172A; font-size: 14px;">{{ substr($trackedInquiry->phone, 0, 4) . '****' . substr($trackedInquiry->phone, -3) }}</strong>
                                <span style="display: block; font-size: 11.5px; color: #15803D; margin-top: 2px;">✓ Verified via Ticket</span>
                            </div>
                        </div>

                        <!-- Inquiry Message Preview -->
                        <div style="margin-bottom: 16px;">
                            <span style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #64748B; display: block; margin-bottom: 6px;">Your Inquiry Message:</span>
                            <div style="background: #FAFBFD; border: 1px solid #E2E8F0; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; line-height: 1.5; color: #334155;">
                                {{ $trackedInquiry->message }}
                            </div>
                        </div>

                        <!-- Official Support Response Box -->
                        <div>
                            <span style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #0F172A; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                                <span>🛡️</span>
                                <span>FixMate Concierge Resolution &amp; Staff Update:</span>
                            </span>

                            @if($trackedInquiry->admin_notes)
                                <div style="background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 16px 18px; color: #166534; font-size: 13.5px; line-height: 1.6;">
                                    <div style="font-weight: 700; margin-bottom: 4px; display: flex; justify-content: space-between; align-items: center;">
                                        <span>Official Admin Resolution Note</span>
                                        <span style="font-size: 11px; color: #15803D; font-weight: 600;">Updated: {{ $trackedInquiry->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <p style="margin: 0; white-space: pre-wrap;">{{ $trackedInquiry->admin_notes }}</p>
                                </div>
                            @else
                                <div style="background: #EFF6FF; border: 1.5px solid #BFDBFE; border-radius: 12px; padding: 14px 18px; color: #1E40AF; font-size: 13px; line-height: 1.5;">
                                    <strong>Status: In Queue for Review</strong> — Your request is actively assigned to our <strong>{{ $trackedInquiry->department_label }}</strong> team. An operator will contact your registered phone number or update this ticket with direct resolution instructions.
                                </div>
                            @endif
                        </div>

                    </div>
                @endif

                <!-- Case 3: Logged-in User Past Inquiries -->
                @if(isset($userInquiries) && $userInquiries->isNotEmpty() && !isset($trackedInquiry))
                    <div style="margin-top: 22px; border-top: 1px dashed rgba(255, 255, 255, 0.2); padding-top: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="font-size: 13px; font-weight: 700; color: #FFD54F;">Your Recent Support Inquiries ({{ $userInquiries->count() }})</span>
                            <span style="font-size: 11.5px; color: #94A3B8;">Recognized from your signed-in profile</span>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 10px;">
                            @foreach($userInquiries as $uInq)
                                @php
                                    $uBadge = $uInq->status_badge;
                                @endphp
                                <a href="{{ route('contact', ['track_ref' => $uInq->reference_no]) }}#inquiry-tracker" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 10px; padding: 12px 14px; text-decoration: none; display: block; transition: all 0.15s;" onmouseover="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.borderColor='#FFB800'" onmouseout="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.borderColor='rgba(255, 255, 255, 0.15)'">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                        <span style="font-family: monospace; font-size: 12.5px; font-weight: 800; color: #FFFFFF;">#{{ $uInq->reference_no }}</span>
                                        <span style="font-size: 10.5px; font-weight: 800; padding: 2px 7px; border-radius: 50px; background: {{ $uBadge['bg'] }}; color: {{ $uBadge['color'] }};">
                                            {{ $uBadge['label'] }}
                                        </span>
                                    </div>
                                    <div style="font-size: 12px; color: #CBD5E1; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $uInq->department_label }} · {{ $uInq->created_at->format('M d') }}
                                    </div>
                                    <span style="font-size: 11px; color: #FFB800; font-weight: 700;">View Live Update &rarr;</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <!-- Main Contact & City Hubs Section -->
    <section style="padding: 20px 0 60px 0;">
        <div class="container">
            
            <div style="display: grid; grid-template-columns: 1fr 1.25fr; gap: 40px; align-items: start;">
                
                <!-- Left: Physical City Hubs & Trust Info -->
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">Our Regional Hubs</h2>
                    <p style="font-size: 14px; color: #64748B; line-height: 1.6; margin: 0 0 24px 0;">
                        FixMate AI operates local operations and technician dispatch hubs across Pakistan's major metropolitan centers.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 28px;">
                        
                        <!-- Islamabad HQ -->
                        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                <strong style="font-size: 15px; color: #0F172A;">Islamabad (Headquarters)</strong>
                                <span style="font-size: 11px; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 2px 8px; border-radius: 12px;">Active Hub</span>
                            </div>
                            <p style="font-size: 13px; color: #64748B; margin: 0 0 6px 0; line-height: 1.4;">
                                Level 4, Evacuee Trust Complex, F-5/1, Agha Khan Road, Islamabad
                            </p>
                            <span style="font-size: 12.5px; color: #0F172A; font-weight: 600;">Direct: +92 51 8899220 • contact.isb@fixmate.ai</span>
                        </div>

                        <!-- Lahore Hub -->
                        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                <strong style="font-size: 15px; color: #0F172A;">Lahore Regional Center</strong>
                                <span style="font-size: 11px; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 2px 8px; border-radius: 12px;">Active Hub</span>
                            </div>
                            <p style="font-size: 13px; color: #64748B; margin: 0 0 6px 0; line-height: 1.4;">
                                9th Floor, Arfa Software Technology Park, Ferozepur Road, Lahore
                            </p>
                            <span style="font-size: 12.5px; color: #0F172A; font-weight: 600;">Direct: +92 42 3598110 • contact.lhr@fixmate.ai</span>
                        </div>

                        <!-- Karachi Hub -->
                        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                <strong style="font-size: 15px; color: #0F172A;">Karachi Operations Center</strong>
                                <span style="font-size: 11px; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 2px 8px; border-radius: 12px;">Active Hub</span>
                            </div>
                            <p style="font-size: 13px; color: #64748B; margin: 0 0 6px 0; line-height: 1.4;">
                                Suite 604, Emerald Tower, Do Talwar, Clifton Block 5, Karachi
                            </p>
                            <span style="font-size: 12.5px; color: #0F172A; font-weight: 600;">Direct: +92 21 3582490 • contact.khi@fixmate.ai</span>
                        </div>

                    </div>

                    <!-- SLA Promise Card -->
                    <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 14px; padding: 18px; display: flex; align-items: center; gap: 14px;">
                        <span style="font-size: 26px;">⚡</span>
                        <div>
                            <strong style="display: block; font-size: 13.5px; color: #92400E;">Guaranteed Rapid Response SLA</strong>
                            <p style="font-size: 12.5px; color: #78350F; margin: 2px 0 0 0; line-height: 1.4;">
                                Web submissions are answered in under 15 minutes during business hours. Emergency reports trigger immediate automated dispatch.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right: Categorized Smart Contact Form -->
                <div id="inquiry-form" style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 20px; padding: 32px; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    
                    <div style="margin-bottom: 20px;">
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Send Us a Message</h3>
                        <p style="font-size: 13.5px; color: #64748B; margin: 0;">Fill in your details below and our dispatch coordinator will assist you right away.</p>
                    </div>

                    @if(session('success_inquiry'))
                        <div style="background: #ECFDF5; border: 2px solid #86EFAC; border-radius: 14px; padding: 20px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #10B981; color: #FFF; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 16px; flex-shrink: 0;">
                                    ✓
                                </div>
                                <div style="flex: 1;">
                                    <strong style="display: block; font-size: 15px; color: #065F46; margin-bottom: 4px;">Inquiry Dispatched Successfully!</strong>
                                    <p style="font-size: 13px; color: #047857; margin: 0 0 10px 0; line-height: 1.5;">
                                        {{ session('success_inquiry') }}
                                    </p>
                                    @if(session('inquiry_ref'))
                                        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; background: #FFFFFF; border: 1px dashed #059669; padding: 8px 14px; border-radius: 8px; font-size: 13px;">
                                            <div>
                                                <span style="color: #64748B;">Tracking Reference:</span>
                                                <strong style="color: #0F172A; font-family: monospace; font-size: 14px; margin-left: 4px;">{{ session('inquiry_ref') }}</strong>
                                            </div>
                                            <a href="{{ route('contact', ['track_ref' => session('inquiry_ref')]) }}#inquiry-tracker" style="color: #0284C7; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                                Track Live Status in Ticket Tracker &rarr;
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 12px; padding: 14px; margin-bottom: 20px; font-size: 13px; color: #991B1B;">
                            <strong style="display: block; margin-bottom: 4px;">Please correct the following:</strong>
                            <ul style="margin: 0; padding-left: 18px;">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        
                        <!-- Inquiry Category -->
                        <div style="margin-bottom: 16px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">How can we assist you? *</label>
                            <select name="department" required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 11px 14px; font-size: 14px; outline: none; background: #FFFFFF; color: #0F172A; font-family: inherit;">
                                <option value="">Select Department / Category</option>
                                <option value="booking" {{ old('department') == 'booking' ? 'selected' : '' }}>Customer: Booking Question or Status Tracking</option>
                                <option value="emergency" {{ old('department') == 'emergency' ? 'selected' : '' }}>Customer: Emergency Breakdown / Rapid Dispatch</option>
                                <option value="escrow" {{ old('department') == 'escrow' ? 'selected' : '' }}>Customer: Payment, Invoice or Escrow Query</option>
                                <option value="technician" {{ old('department') == 'technician' ? 'selected' : '' }}>Technician: Onboarding & NADRA Biometric KYC</option>
                                <option value="corporate" {{ old('department') == 'corporate' ? 'selected' : '' }}>Business: Commercial / Housing Society AMC</option>
                                <option value="general" {{ old('department') == 'general' ? 'selected' : '' }}>General Feedback or Partnership</option>
                            </select>
                        </div>

                        <!-- 2 Columns: Name & Phone -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" placeholder="e.g. Tariq Mehmood" required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 11px 14px; font-size: 14px; outline: none; background: #FFFFFF; font-family: inherit;">
                            </div>
                            <div>
                                <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Mobile / WhatsApp Number *</label>
                                <input type="tel" name="phone" value="{{ old('phone', auth()->user()?->phone) }}" placeholder="0300 1234567" required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 11px 14px; font-size: 14px; outline: none; background: #FFFFFF; font-family: inherit;">
                            </div>
                        </div>

                        <!-- 2 Columns: City & Optional Email -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">City / Region *</label>
                                <select name="city" required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 11px 14px; font-size: 14px; outline: none; background: #FFFFFF; color: #0F172A; font-family: inherit;">
                                    <option value="Islamabad" {{ old('city', auth()->user()?->city) == 'Islamabad' ? 'selected' : '' }}>Islamabad / Rawalpindi</option>
                                    <option value="Lahore" {{ old('city', auth()->user()?->city) == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                    <option value="Karachi" {{ old('city', auth()->user()?->city) == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                    <option value="Peshawar" {{ old('city', auth()->user()?->city) == 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
                                    <option value="Faisalabad" {{ old('city', auth()->user()?->city) == 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
                                    <option value="Multan" {{ old('city', auth()->user()?->city) == 'Multan' ? 'selected' : '' }}>Multan</option>
                                    <option value="Other" {{ old('city', auth()->user()?->city) == 'Other' ? 'selected' : '' }}>Other City</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Email Address (Optional)</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" placeholder="name@example.com" style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 11px 14px; font-size: 14px; outline: none; background: #FFFFFF; font-family: inherit;">
                            </div>
                        </div>

                        <!-- Message -->
                        <div style="margin-bottom: 20px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Your Message / Issue Details *</label>
                            <textarea name="message" rows="4" placeholder="Please describe your issue, address or questions in detail..." required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 11px 14px; font-size: 14px; outline: none; background: #FFFFFF; font-family: inherit; resize: vertical;">{{ old('message') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" style="width: 100%; background: #FFB800; border: none; padding: 14px 0; border-radius: 12px; font-size: 15px; font-weight: 800; color: #0F172A; cursor: pointer; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.35); transition: background 0.15s;" onmouseover="this.style.background='#F59E0B'" onmouseout="this.style.background='#FFB800'">
                            Submit Request &amp; Connect with Dispatch &rarr;
                        </button>

                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 14px; font-size: 12px; color: #64748B;">
                            <span>🔒 256-bit encrypted SSL</span>
                            <span>•</span>
                            <span>Your contact details are strictly confidential</span>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </section>

    <!-- Instant Self-Service Answers Section -->
    <section style="padding: 40px 0 60px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 900px;">
            <div style="text-align: center; margin-bottom: 32px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase;">INSTANT HELP</span>
                <h3 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 4px 0 8px 0;">Looking for quick answers?</h3>
                <p style="font-size: 14px; color: #64748B; margin: 0;">Check common questions answered below or visit our full <a href="{{ url('/faqs') }}" style="color: #2563EB; font-weight: 700; text-decoration: none;">FAQ Knowledge Center</a>.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
                    <strong style="font-size: 14.5px; color: #0F172A; display: block; margin-bottom: 6px;">How does the Arrival OTP work?</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0; line-height: 1.5;">When the technician reaches your gate, share the 4-digit OTP shown in your app. This confirms legitimate arrival and protects you against unauthorized individuals.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
                    <strong style="font-size: 14.5px; color: #0F172A; display: block; margin-bottom: 6px;">When is payment deducted?</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0; line-height: 1.5;">Your payment is held safely in escrow. Money is only released to the technician after you inspect the finished work and mark it as satisfied.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
                    <strong style="font-size: 14.5px; color: #0F172A; display: block; margin-bottom: 6px;">Can I reschedule or cancel?</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0; line-height: 1.5;">Yes! You can reschedule or cancel directly from your customer portal free of charge up to 30 minutes before the scheduled arrival time.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px;">
                    <strong style="font-size: 14.5px; color: #0F172A; display: block; margin-bottom: 6px;">What if the problem returns?</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0; line-height: 1.5;">All standard jobs carry a 60-day workmanship warranty. If a repaired pipe or switch fails, our team re-dispatches a senior technician at zero extra labor cost.</p>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
