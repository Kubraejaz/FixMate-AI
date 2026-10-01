@extends('Frontend.layouts.public')

@section('title', 'Find Verified Technicians — FixMate AI')
@section('meta_desc', 'Browse NADRA-verified, background-checked plumbers, electricians, AC technicians, and carpenters near you in Pakistan.')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Executive Header -->
    <section style="padding: 48px 0 36px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 780px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">VERIFIED LOCAL PROS</span>
            </div>
            <h1 style="font-size: 38px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                Find Top-Rated Technicians Near You
            </h1>
            <p style="font-size: 15.5px; color: #64748B; margin: 0; line-height: 1.6;">
                Every specialist is NADRA biometric-screened, skills-certified, and insured with FixMate Escrow payment release.
            </p>
        </div>
    </section>

    <!-- Search & Filter Bar Section -->
    <section style="padding: 32px 0 20px 0;">
        <div class="container">
            
            <!-- Dynamic Filter Bar -->
            <form method="GET" action="{{ url('/technicians') }}" style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 12px 18px; display: flex; gap: 14px; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.03); flex-wrap: wrap;">
                <div style="flex: 1; min-width: 240px; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 18px; color: #94A3B8;">🔍</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, profession, or experience..." style="width: 100%; border: none; background: transparent; outline: none; font-size: 14px; font-family: inherit;">
                </div>
                <div style="border-left: 1px solid #CBD5E1; padding-left: 14px;">
                    <select name="profession" style="border: none; background: transparent; outline: none; font-size: 13.5px; font-weight: 700; color: #0F172A; cursor: pointer;">
                        <option value="">All Professions</option>
                        @foreach(($professions ?? \App\Models\Profession::where('is_active', true)->get()) as $prof)
                            <option value="{{ $prof->id }}" {{ request('profession') == $prof->id ? 'selected' : '' }}>
                                {{ $prof->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" style="background: #FFB800; border: none; outline: none; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 800; color: #0F172A; cursor: pointer; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                    Find Pro
                </button>
                @if(request('search') || request('profession'))
                    <a href="{{ url('/technicians') }}" style="font-size: 13px; color: #64748B; text-decoration: none; font-weight: 600;">Clear</a>
                @endif
            </form>

            <!-- Quick Filter Chips -->
            <div style="display: flex; gap: 10px; margin-top: 14px; flex-wrap: wrap; font-size: 13px;">
                <span style="font-weight: 700; color: #64748B; align-self: center;">Quick Filters:</span>
                <a href="{{ url('/technicians') }}" style="text-decoration: none; {{ !request('profession') ? 'background: #0F172A; color: #FFF;' : 'background: #F1F5F9; color: #334155;' }} padding: 4px 14px; border-radius: 50px; font-weight: 700;">All</a>
                @foreach(($professions ?? \App\Models\Profession::where('is_active', true)->get())->take(5) as $prof)
                    <a href="{{ url('/technicians?profession=' . $prof->id) }}" style="text-decoration: none; {{ request('profession') == $prof->id ? 'background: #0F172A; color: #FFF;' : 'background: #F1F5F9; color: #334155;' }} padding: 4px 14px; border-radius: 50px; font-weight: 600;">
                        {{ $prof->name }}
                    </a>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Technicians Grid Section -->
    <section style="padding: 24px 0 60px 0;">
        <div class="container">
            
            @php
                $avatarList = [
                    asset('assets/images/image_1.png'),
                    asset('assets/images/image_2.png'),
                    asset('assets/images/image_3.png'),
                    asset('assets/images/image_4.png'),
                ];
            @endphp

            @if(isset($technicians) && $technicians->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 22px;">
                    @foreach($technicians as $index => $tech)
                        @php
                            $avatar = $avatarList[$index % count($avatarList)];
                        @endphp
                        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s;" onmouseover="this.style.borderColor='#FFB800'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.transform='translateY(0)'">
                            <div>
                                <div style="position: relative; width: 76px; height: 76px; margin: 0 auto 12px auto;">
                                    <img src="{{ $avatar }}" alt="{{ $tech->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2.5px solid #FFB800;">
                                    <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;" title="NADRA Verified Pro">✓</span>
                                </div>
                                <div style="display: inline-block; background: #DCFCE7; color: #15803D; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 20px; margin-bottom: 6px;">● ONLINE NOW</div>
                                <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">{{ $tech->name }}</strong>
                                <span style="font-size: 12.5px; color: #64748B; display: block; margin-bottom: 6px;">
                                    {{ $tech->profession?->name ?? 'Service Specialist' }} • {{ $tech->experience ?? '5+ yrs exp' }}
                                </span>
                                
                                <div style="font-size: 12px; color: #64748B; margin-bottom: 12px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                                    <span style="color: #D97706; font-weight: 800;">★ 4.8</span>
                                    <span>(Active Partner)</span>
                                    <span>•</span>
                                    <span style="color: #0F172A; font-weight: 600;">📍 {{ $tech->user?->city ?? 'Verified Area' }}</span>
                                </div>

                                <div style="background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 10px; padding: 10px; font-size: 12px; color: #475569; margin-bottom: 14px; text-align: left;">
                                    <div>• Verified biometric credentials</div>
                                    <div>• Standard labor benchmark tools</div>
                                    <div>• 60-day FixMate rework warranty</div>
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <a href="{{ url('/technicians/' . $tech->id) }}" style="text-align: center; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 700; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none;">View Profile</a>
                                <a href="{{ url('/customer/diagnose') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 12.5px; padding: 9px 0; border-radius: 8px; text-decoration: none; display: block; box-shadow: 0 2px 6px rgba(255, 184, 0, 0.3);">
                                    Book Pro
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(method_exists($technicians, 'links'))
                    <div style="margin-top: 30px; display: flex; justify-content: center;">
                        {{ $technicians->links() }}
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 48px; background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 18px;">
                    <div style="font-size: 36px; margin-bottom: 12px;">🔍</div>
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">No technicians found</h3>
                    <p style="font-size: 14px; color: #64748B; margin: 0 0 16px 0;">Try adjusting your search keywords or profession filter.</p>
                    <a href="{{ url('/technicians') }}" style="background: #0F172A; color: #FFF; padding: 8px 20px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 700;">View All Technicians</a>
                </div>
            @endif
        </div>
    </section>

    <!-- 5-Step Technician Vetting Section -->
    <section style="padding: 50px 0; background: #F8FAFC; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 980px;">
            <div style="text-align: center; margin-bottom: 36px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E; text-transform: uppercase;">SAFETY PROTOCOL</span>
                <h2 style="font-size: 28px; font-weight: 900; color: #0F172A; margin: 4px 0 8px 0;">How We Vet Every Handyman</h2>
                <p style="font-size: 14.5px; color: #64748B; margin: 0;">Only the top 12% of applicants qualify to enter your home under the FixMate AI standard.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">1</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">NADRA Biometric</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Every technician’s national CNIC and criminal records are verified with police registration.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">2</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">In-Field Practical Test</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Hands-on testing on simulated plumbing manifolds, electrical panels, and inverter boards.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">3</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">Gate Arrival OTP</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Technicians cannot start a job without customer pin verification, preventing unauthorized entry.</p>
                </div>

                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FEF08A; margin: 0 auto 12px auto; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #92400E;">4</div>
                    <strong style="display: block; font-size: 14.5px; color: #0F172A; margin-bottom: 6px;">4.5★ Retention Rule</strong>
                    <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.4;">Partners whose average drops below 4.5 are automatically suspended until retraining.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Partner CTA Strip -->
    <section style="padding: 40px 0; background: #FFFFFF;">
        <div class="container" style="max-width: 840px;">
            <div style="background: #0F172A; border-radius: 18px; padding: 30px 36px; display: flex; align-items: center; justify-content: space-between; color: #FFFFFF; gap: 24px;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 900; margin: 0 0 6px 0; color: #FFFFFF;">Are you a skilled plumber, electrician, or AC tech?</h3>
                    <p style="font-size: 13.5px; color: #94A3B8; margin: 0;">Get high-paying jobs in your area and earn up to Rs. 120,000+ monthly with guaranteed weekly payouts.</p>
                </div>
                <a href="{{ url('/become-technician') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 12px 26px; border-radius: 50px; text-decoration: none; white-space: nowrap;">
                    Join as Partner →
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
