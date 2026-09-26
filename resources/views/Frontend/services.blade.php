@extends('Frontend.layouts.master')

@section('title', 'Our Services — FixMate AI')
@section('meta_desc', 'Wide range of verified home services: Plumbing, Electrical, AC Repair, Cleaning, Carpentry, Painting, Appliance Repair, and WiFi Networking.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Services Header (Mockup 1) -->
    <div style="text-align: center; max-width: 620px; margin: 0 auto 36px auto;">
        <h1 style="font-size: 32px; font-weight: 800; color: #111; margin-bottom: 8px;">Our Services</h1>
        <p style="font-size: 15px; color: #757575;">Wide range of home services at your fingertips with upfront transparent pricing</p>
    </div>

    <!-- 8 Categories Grid (Exact matching Mockup 1) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
        
        <!-- 1. Plumbing -->
        <a href="{{ url('/find-technician?cat=plumbing') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                🚰
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">Plumbing</h4>
                <p style="font-size: 12.5px; color: #757575;">Fix leaks, pipes & more</p>
            </div>
        </a>

        <!-- 2. Electrical -->
        <a href="{{ url('/find-technician?cat=electrical') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                ⚡
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">Electrical</h4>
                <p style="font-size: 12.5px; color: #757575;">Wiring, switches & repairs</p>
            </div>
        </a>

        <!-- 3. AC & Cooling -->
        <a href="{{ url('/find-technician?cat=ac') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                ❄️
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">AC & Cooling</h4>
                <p style="font-size: 12.5px; color: #757575;">Installation & repair</p>
            </div>
        </a>

        <!-- 4. Appliance Repair -->
        <a href="{{ url('/find-technician?cat=appliance') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                🔧
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">Appliance Repair</h4>
                <p style="font-size: 12.5px; color: #757575;">Fridge, washing machine etc.</p>
            </div>
        </a>

        <!-- 5. Carpentry -->
        <a href="{{ url('/find-technician?cat=carpentry') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                🪚
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">Carpentry</h4>
                <p style="font-size: 12.5px; color: #757575;">Furniture & woodwork</p>
            </div>
        </a>

        <!-- 6. Painting -->
        <a href="{{ url('/find-technician?cat=painting') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                🎨
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">Painting</h4>
                <p style="font-size: 12.5px; color: #757575;">Interior & exterior</p>
            </div>
        </a>

        <!-- 7. Cleaning -->
        <a href="{{ url('/find-technician?cat=cleaning') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                🧹
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">Cleaning</h4>
                <p style="font-size: 12.5px; color: #757575;">Home & office cleaning</p>
            </div>
        </a>

        <!-- 8. Internet / Networking -->
        <a href="{{ url('/find-technician?cat=networking') }}" class="card-box" style="display: flex; gap: 16px; align-items: center; transition: all 0.2s;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                📶
            </div>
            <div>
                <h4 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 2px;">Internet/Networking</h4>
                <p style="font-size: 12.5px; color: #757575;">WiFi & network setup</p>
            </div>
        </a>

    </div>

    <!-- Yellow Callout Banner (Exact from Mockup 1) -->
    <div style="background: #FFFDF0; border: 1px solid #FFECB3; border-radius: 20px; padding: 26px 36px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 48px;">
        <div>
            <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 4px;">Not sure what you need?</h3>
            <p style="font-size: 14px; color: #666;">Describe your problem and let our AI find the right service and technician.</p>
        </div>
        <a href="{{ url('/describe-problem') }}" class="btn-yellow" style="padding: 12px 24px; font-size: 14px;">
            Describe Problem
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
