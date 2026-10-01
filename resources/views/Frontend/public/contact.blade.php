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
                Have an urgent pipe burst, questions about an active booking, or need partner support? Reach our specialized desks or visit one of our city hubs.
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
                    <strong style="font-size: 16px; color: #0F172A; display: block; margin-bottom: 6px;">Booking & Status</strong>
                    <p style="font-size: 13px; color: #64748B; margin: 0 0 12px 0; line-height: 1.5;">Direct tracking, rescheduling, or booking questions with our concierge.</p>
                    <a href="tel:+923001234567" style="font-size: 13.5px; font-weight: 800; color: #0284C7; text-decoration: none; display: block;">+92 300 1234567 →</a>
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
                    <a href="tel:+92518899229" style="font-size: 13.5px; font-weight: 800; color: #E11D48; text-decoration: none; display: block;">+92 51 8899229 →</a>
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
                    <a href="mailto:partners@fixmate.ai" style="font-size: 13.5px; font-weight: 800; color: #B45309; text-decoration: none; display: block;">partners@fixmate.ai →</a>
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
                    <a href="mailto:corporate@fixmate.ai" style="font-size: 13.5px; font-weight: 800; color: #15803D; text-decoration: none; display: block;">corporate@fixmate.ai →</a>
                    <span style="font-size: 11px; color: #94A3B8; display: block; margin-top: 4px;">Dedicated Account Manager</span>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Contact & City Hubs Section -->
    <section style="padding: 30px 0 60px 0;">
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
                                <div>
                                    <strong style="display: block; font-size: 15px; color: #065F46; margin-bottom: 4px;">Inquiry Dispatched Successfully!</strong>
                                    <p style="font-size: 13px; color: #047857; margin: 0 0 10px 0; line-height: 1.5;">
                                        {{ session('success_inquiry') }}
                                    </p>
                                    @if(session('inquiry_ref'))
                                        <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFFFFF; border: 1px dashed #059669; padding: 6px 14px; border-radius: 8px; font-size: 13px;">
                                            <span style="color: #64748B;">Tracking Reference:</span>
                                            <strong style="color: #0F172A; font-family: monospace; font-size: 14px;">{{ session('inquiry_ref') }}</strong>
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
                                <option value="feedback" {{ old('department') == 'feedback' ? 'selected' : '' }}>General Feedback or Partnership</option>
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
                            Submit Request & Connect with Dispatch →
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
