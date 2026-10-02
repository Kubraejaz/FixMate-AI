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
                        Work On Your Schedule. <br><span style="color: #FFB800;">Earn Up to Rs 140,000+ /Mo</span>
                    </h1>
                    <p style="font-size: 16px; color: #64748B; margin: 0 0 24px 0; line-height: 1.7;">
                        Connect directly with verified domestic clients in your neighborhood. Get problem photos and estimated budgets before accepting jobs, with 100% guaranteed escrow payouts.
                    </p>
                    <div style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
                        <a href="#apply" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 15px; padding: 13px 30px; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 14px rgba(255, 184, 0, 0.35); transition: all 0.2s;">
                            Apply as a Technician ↓
                        </a>
                        <a href="#calculator" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #1E293B; font-weight: 700; font-size: 14.5px; padding: 12px 24px; border-radius: 10px; text-decoration: none;">
                            Calculate Income
                        </a>
                    </div>
                    <div style="display: flex; gap: 24px; margin-top: 28px; padding-top: 20px; border-top: 1px solid #E2E8F0; font-size: 13.5px; color: #64748B; flex-wrap: wrap;">
                        <span>✓ Zero Registration Fee</span>
                        <span>✓ Instant Daily/Weekly Payouts</span>
                        <span>✓ Over <strong>{{ $totalVerifiedTechnicians }}+</strong> Verified Partners</span>
                    </div>
                </div>
                <div style="text-align: center; position: relative;">
                    <img src="{{ asset('assets/images/Cleaning_Professional.png') }}" alt="FixMate AI Technician Partner" style="height: 400px; width: auto; object-fit: contain; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.12));">
                </div>
            </div>
        </div>
    </section>

    <!-- Success Notification -->
    @if(session('success_application'))
        <div class="container" style="max-width: 1140px; margin-top: 30px;">
            <div style="background: #F0FDF4; border: 2px solid #86EFAC; border-radius: 16px; padding: 24px; display: flex; align-items: flex-start; justify-content: space-between; gap: 18px; box-shadow: 0 4px 14px rgba(22, 163, 74, 0.1);">
                <div style="display: flex; gap: 14px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #16A34A; color: #FFF; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">✓</div>
                    <div>
                        <strong style="font-size: 18px; color: #166534; display: block; margin-bottom: 4px;">Partner Application Received!</strong>
                        <p style="font-size: 14.5px; color: #15803D; margin: 0 0 10px 0; line-height: 1.5;">{{ session('success_application') }}</p>
                        @if(session('app_ref'))
                            <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFFFFF; border: 1px dashed #16A34A; padding: 6px 14px; border-radius: 8px; font-size: 13.5px;">
                                <span style="color: #64748B;">Application Tracking Reference:</span>
                                <strong style="color: #0F172A; font-family: monospace; font-size: 15px;">{{ session('app_ref') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #166534;">&times;</button>
            </div>
        </div>
    @endif

    <!-- Dynamic Trades in High Demand -->
    <section style="padding: 40px 0 20px 0;">
        <div class="container" style="max-width: 1140px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 4px 0;">Open Trade Partner Categories</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0;">Current active trade specialties dispatched daily across major cities.</p>
                </div>
                <span style="font-size: 12.5px; color: #16A34A; font-weight: 700; background: #DCFCE7; padding: 4px 12px; border-radius: 20px;">
                    ● Accepting Applications in {{ count($cities) }} Cities
                </span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 14px;">
                @foreach($professions as $prof)
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 16px; display: flex; align-items: center; justify-content: space-between; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#FFB800'; this.style.background='#FFFDF0';" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC';">
                        <div>
                            <strong style="font-size: 14.5px; color: #0F172A; display: block;">{{ $prof->name }}</strong>
                            <span style="font-size: 12px; color: #64748B;">{{ $prof->professionals_count }} active partners</span>
                        </div>
                        <span style="font-size: 18px; color: #FFB800;">⚡</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Interactive Earning Potential Calculator -->
    <section id="calculator" style="padding: 50px 0 60px 0;">
        <div class="container" style="max-width: 1140px;">
            <div style="background: #0F172A; border-radius: 24px; padding: 40px; color: #FFFFFF; box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.3);">
                <div style="text-align: center; max-width: 600px; margin: 0 auto 36px auto;">
                    <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Interactive Calculator</span>
                    <h2 style="font-size: 30px; font-weight: 900; margin: 8px 0 10px 0; letter-spacing: -0.02em;">Estimate Your Monthly Income</h2>
                    <p style="font-size: 14.5px; color: #94A3B8; margin: 0;">Select your trade specialty and availability to view real estimated monthly take-home earnings.</p>
                </div>

                <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 40px; align-items: center;">
                    
                    <!-- Controls -->
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        
                        <div>
                            <label style="display: block; font-size: 13.5px; font-weight: 700; color: #E2E8F0; margin-bottom: 8px;">Select Trade Specialty</label>
                            <select id="calc_trade" onchange="recalculateEarnings()" style="width: 100%; height: 46px; border-radius: 12px; background: #1E293B; border: 1.5px solid #334155; color: #FFFFFF; padding: 0 14px; font-size: 14px; font-family: inherit; outline: none; cursor: pointer;">
                                @foreach($professions as $prof)
                                    <option value="{{ $prof->slug }}">{{ $prof->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <label style="font-size: 13.5px; font-weight: 700; color: #E2E8F0;">Hours Worked Per Day</label>
                                <strong id="calc_hours_val" style="color: #FFB800; font-size: 14.5px;">6 Hours / Day</strong>
                            </div>
                            <input type="range" id="calc_hours" min="3" max="10" value="6" step="1" oninput="recalculateEarnings()" style="width: 100%; accent-color: #FFB800; cursor: pointer;">
                            <div style="display: flex; justify-content: space-between; font-size: 11.5px; color: #64748B; margin-top: 4px;">
                                <span>Part-time (3h)</span>
                                <span>Standard (6h)</span>
                                <span>Full-day (10h)</span>
                            </div>
                        </div>

                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <label style="font-size: 13.5px; font-weight: 700; color: #E2E8F0;">Working Days Per Week</label>
                                <strong id="calc_days_val" style="color: #FFB800; font-size: 14.5px;">5 Days / Week</strong>
                            </div>
                            <input type="range" id="calc_days" min="2" max="6" value="5" step="1" oninput="recalculateEarnings()" style="width: 100%; accent-color: #FFB800; cursor: pointer;">
                            <div style="display: flex; justify-content: space-between; font-size: 11.5px; color: #64748B; margin-top: 4px;">
                                <span>2 days</span>
                                <span>4 days</span>
                                <span>6 days</span>
                            </div>
                        </div>

                    </div>

                    <!-- Output Card -->
                    <div style="background: #1E293B; border: 2px solid #FFB800; border-radius: 20px; padding: 32px; text-align: center;">
                        <span style="font-size: 12.5px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 6px;">Estimated Monthly Payout</span>
                        <div id="calc_total_earnings" style="font-size: 40px; font-weight: 900; color: #FFFFFF; line-height: 1.1; margin-bottom: 6px;">Rs 96,000</div>
                        <span style="font-size: 13px; color: #94A3B8; display: block; margin-bottom: 20px;">Net take-home after platform commission</span>

                        <div style="background: rgba(255,255,255,0.06); border-radius: 12px; padding: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: left; margin-bottom: 20px;">
                            <div>
                                <span style="font-size: 11.5px; color: #94A3B8; display: block;">Est. Bookings / Mo</span>
                                <strong id="calc_monthly_jobs" style="font-size: 16px; color: #FFFFFF;">60 Bookings</strong>
                            </div>
                            <div>
                                <span style="font-size: 11.5px; color: #94A3B8; display: block;">Escrow Payout</span>
                                <strong style="font-size: 16px; color: #10B981;">Daily / JazzCash</strong>
                            </div>
                        </div>

                        <a href="#apply" style="display: block; width: 100%; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14.5px; padding: 12px 0; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(255,184,0,0.3);">
                            Claim These Earnings →
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Partner Fast-Track Application Form -->
    <section id="apply" style="padding: 40px 0 70px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 860px;">
            
            <div style="text-align: center; margin-bottom: 36px;">
                <span style="font-size: 12px; font-weight: 800; color: #FFB800; text-transform: uppercase; letter-spacing: 0.05em;">Fast-Track Registration</span>
                <h2 style="font-size: 32px; font-weight: 900; color: #0F172A; margin: 8px 0 10px 0; letter-spacing: -0.02em;">Submit Partner Application</h2>
                <p style="font-size: 15px; color: #64748B; margin: 0;">Fill out your trade profile below. Our inspector team will schedule your practical assessment within 24 hours.</p>
            </div>

            <!-- Form Card -->
            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                
                @if($errors->any())
                    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 13.5px;">
                        <strong style="display: block; margin-bottom: 6px;">Please fix the application errors:</strong>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('become-technician.store') }}" method="POST">
                    @csrf
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        
                        <!-- Row 1: Name & Phone -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Full Name <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="name" value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" required placeholder="e.g. Tariq Mehmood" style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 14px; outline: none; font-family: inherit;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Mobile Phone (JazzCash / EasyPaisa) <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone', Auth::check() ? Auth::user()->phone : '') }}" required placeholder="0300-1234567" style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 14px; outline: none; font-family: inherit;">
                            </div>
                        </div>

                        <!-- Row 2: Email & CNIC -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Email Address <span style="color: #DC2626;">*</span></label>
                                <input type="email" name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" required placeholder="technician@example.com" style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 14px; outline: none; font-family: inherit;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">NADRA CNIC Number <span style="color: #DC2626;">*</span></label>
                                <input type="text" name="cnic_number" value="{{ old('cnic_number') }}" required placeholder="42101-1234567-1" style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 14px; outline: none; font-family: inherit; font-family: monospace;">
                            </div>
                        </div>

                        <!-- Row 3: Trade & City -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Trade Specialty <span style="color: #DC2626;">*</span></label>
                                <select name="profession_id" required style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 14px; font-family: inherit; background: #FFFFFF;">
                                    @foreach($professions as $prof)
                                        <option value="{{ $prof->id }}" {{ old('profession_id') == $prof->id ? 'selected' : '' }}>
                                            {{ $prof->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Operating City <span style="color: #DC2626;">*</span></label>
                                <select name="city" required style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 14px; font-family: inherit; background: #FFFFFF;">
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ old('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Row 4: Experience & Setup -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Years of Experience <span style="color: #DC2626;">*</span></label>
                                <input type="number" name="experience_years" value="{{ old('experience_years', 4) }}" min="1" max="50" required style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 14px; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Working Setup <span style="color: #DC2626;">*</span></label>
                                <select name="workshop_type" style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 13px; background: #FFFFFF;">
                                    <option value="freelancer" {{ old('workshop_type') === 'freelancer' ? 'selected' : '' }}>Freelance Mobile</option>
                                    <option value="independent_workshop" {{ old('workshop_type') === 'independent_workshop' ? 'selected' : '' }}>Have Own Workshop</option>
                                    <option value="company_employed" {{ old('workshop_type') === 'company_employed' ? 'selected' : '' }}>Contractor Team</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Tool Inventory <span style="color: #DC2626;">*</span></label>
                                <select name="tools_available" style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 13px; background: #FFFFFF;">
                                    <option value="has_own_tools" {{ old('tools_available') === 'has_own_tools' ? 'selected' : '' }}>Complete Tool Kit</option>
                                    <option value="basic_tools" {{ old('tools_available') === 'basic_tools' ? 'selected' : '' }}>Basic Tools</option>
                                    <option value="needs_tool_support" {{ old('tools_available') === 'needs_tool_support' ? 'selected' : '' }}>Need Tool Financing</option>
                                </select>
                            </div>
                        </div>

                        <!-- Documents Available -->
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">Available Documents for Inspector Review</label>
                            <input type="text" name="documents_list" value="{{ old('documents_list', 'CNIC, Police Clearance, Trade Diploma') }}" placeholder="e.g. Original CNIC, Electrician Certificate, Police Verification" style="width: 100%; height: 44px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 13.5px; outline: none;">
                        </div>

                        <!-- Submit Button -->
                        <div style="padding-top: 10px;">
                            <button type="submit" style="width: 100%; background: #FFB800; border: none; padding: 15px 0; border-radius: 12px; font-size: 16px; font-weight: 800; color: #0F172A; cursor: pointer; box-shadow: 0 4px 14px rgba(255,184,0,0.35); transition: background 0.15s ease;" onmouseover="this.style.background='#F59E0B'" onmouseout="this.style.background='#FFB800'">
                                Submit Application &amp; Connect with Inspector →
                            </button>
                            <p style="text-align: center; font-size: 12px; color: #64748B; margin-top: 12px;">
                                By submitting, you consent to identity verification via NADRA and FixMate AI safety standards.
                            </p>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </section>

</div>

<script>
    function recalculateEarnings() {
        var hours = parseInt(document.getElementById('calc_hours').value) || 6;
        var days = parseInt(document.getElementById('calc_days').value) || 5;

        document.getElementById('calc_hours_val').textContent = hours + " Hours / Day";
        document.getElementById('calc_days_val').textContent = days + " Days / Week";

        // Average jobs per hour based on Pakistan domestic repair standards: approx 1 job per 2 hours
        var jobsPerDay = Math.max(1, Math.round(hours / 2));
        var monthlyJobs = jobsPerDay * days * 4;

        // Base payout per job approx Rs 1,600
        var totalEarnings = monthlyJobs * 1600;

        document.getElementById('calc_total_earnings').textContent = "Rs " + totalEarnings.toLocaleString();
        document.getElementById('calc_monthly_jobs').textContent = monthlyJobs + " Bookings";
    }

    // Run calculation once on load
    document.addEventListener('DOMContentLoaded', recalculateEarnings);
</script>
@endsection
