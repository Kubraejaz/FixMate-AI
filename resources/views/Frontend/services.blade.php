@extends('Frontend.layouts.master')

@section('title', 'Our Services — FixMate')
@section('meta_desc', 'Wide range of verified home services: Plumbing, Electrical, AC Repair, Cleaning, Carpentry, Painting, Appliance Repair, and WiFi Networking.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Services Header (Mockup 1) -->
    <div style="text-align: center; max-width: 620px; margin: 0 auto 36px auto;">
        <h1 style="font-size: 32px; font-weight: 800; color: #111; margin-bottom: 8px;">Our Services</h1>
        <p style="font-size: 15px; color: #757575;">Wide range of home services at your fingertips with upfront transparent pricing</p>
    </div>

    @php
        $professionsList = \App\Models\Profession::where('is_active', true)->get();
    @endphp

    <!-- Categories & Sub-Categories Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px;">
        @forelse($professionsList as $prof)
            <div class="card-box" style="display: flex; flex-direction: column; justify-content: space-between; gap: 14px; padding: 22px; transition: all 0.2s;">
                <div>
                    <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                        <div style="width: 48px; height: 48px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                            {{ $prof->display_icon }}
                        </div>
                        <div>
                            <h4 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 2px;">{{ $prof->name }}</h4>
                            <p style="font-size: 12px; color: #757575; margin: 0;">{{ $prof->headline ?: 'Verified Home Service' }}</p>
                        </div>
                    </div>

                    @if(!empty($prof->sub_categories_list))
                        <div style="margin-bottom: 12px;">
                            <span style="font-size: 11px; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">
                                Sub-Categories:
                            </span>
                            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                @foreach($prof->sub_categories_list as $sub)
                                    <span style="font-size: 11px; font-weight: 600; color: #334155; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 2px 7px; border-radius: 6px;">
                                        {{ $sub }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #F1F5F9; padding-top: 12px;">
                    <span style="font-size: 13px; font-weight: 700; color: #0F172A;">{{ $prof->formatted_price }}</span>
                    <a href="{{ url('/services/' . $prof->slug) }}" class="btn-yellow" style="font-size: 12px; padding: 6px 14px; text-decoration: none;">Book Service</a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #F8FAFC; border-radius: 16px;">
                <p style="color: #64748B; margin: 0;">No active services currently listed.</p>
            </div>
        @endforelse
    </div>

    <!-- Yellow Callout Banner (Exact from Mockup 1) -->
    <div style="background: #FFFDF0; border: 1px solid #FFECB3; border-radius: 20px; padding: 26px 36px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 48px;">
        <div>
            <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 4px;">Looking for a verified specialist?</h3>
            <p style="font-size: 14px; color: #666;">Browse our full trade directory or connect directly with top-rated local professionals.</p>
        </div>
        <a href="{{ route('technicians') }}" class="btn-yellow" style="padding: 12px 24px; font-size: 14px; text-decoration: none;">
            Find Technicians
        </a>
    </div>

    <!-- Top Technicians in these Services -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="font-size: 20px; font-weight: 800; color: #111;">Available Technicians Near You</h3>
        <a href="{{ url('/find-technician') }}" class="btn-outline" style="font-size: 13px; padding: 8px 16px;">Filter by Location</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        <!-- Pro 1 -->
        <div class="tech-card">
            <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                <img src="{{ asset('assets/images/image_1.png') }}" class="tech-avatar">
                <div>
                    <h4 style="font-size: 16px; font-weight: 800; color: #111;">Ali Khan</h4>
                    <span style="font-size: 12.5px; color: #555;">Plumber • 5 Yrs Exp</span>
                    <div style="font-size: 12px; font-weight: 700; color: #111;">★ 4.8 (247 jobs)</div>
                </div>
            </div>
            <div style="font-size: 12px; color: #777; margin-bottom: 16px;">
                Skills: Pipe Repair, Water Valve, Drain Clean
            </div>
            <a href="{{ url('/technician-profile/ali-khan') }}" class="btn-yellow" style="width: 100%;">Book Ali Khan</a>
        </div>

        <!-- Pro 2 -->
        <div class="tech-card">
            <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                <img src="{{ asset('assets/images/image_2.png') }}" class="tech-avatar">
                <div>
                    <h4 style="font-size: 16px; font-weight: 800; color: #111;">Riaz Ahmed</h4>
                    <span style="font-size: 12.5px; color: #555;">Electrician • 7 Yrs Exp</span>
                    <div style="font-size: 12px; font-weight: 700; color: #111;">★ 4.7 (189 jobs)</div>
                </div>
            </div>
            <div style="font-size: 12px; color: #777; margin-bottom: 16px;">
                Skills: Breaker Short, Ceiling Fan, Wiring
            </div>
            <a href="{{ url('/technician-profile/riaz-ahmed') }}" class="btn-yellow" style="width: 100%;">Book Riaz Ahmed</a>
        </div>

        <!-- Pro 3 -->
        <div class="tech-card">
            <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                <img src="{{ asset('assets/images/image_5.png') }}" class="tech-avatar">
                <div>
                    <h4 style="font-size: 16px; font-weight: 800; color: #111;">Imran Shah</h4>
                    <span style="font-size: 12.5px; color: #555;">AC Technician • 6 Yrs Exp</span>
                    <div style="font-size: 12px; font-weight: 700; color: #111;">★ 4.9 (312 jobs)</div>
                </div>
            </div>
            <div style="font-size: 12px; color: #777; margin-bottom: 16px;">
                Skills: Inverter AC Tune-up, Gas Refill, Deep Coil Wash
            </div>
            <a href="{{ url('/technician-profile/imran-shah') }}" class="btn-yellow" style="width: 100%;">Book Imran Shah</a>
        </div>
    </div>

</div>
@endsection
