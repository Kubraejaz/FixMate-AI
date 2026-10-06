@extends('Frontend.layouts.master')

@section('title', 'Ali Khan (Verified Plumber) — FixMate')
@section('meta_desc', 'Ali Khan: 5 years experience, 247 completed jobs, 4.8 rating. Verified Master Plumber serving Karachi.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px; max-width: 920px;">

    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 20px;">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <a href="{{ url('/find-technician') }}">Technicians</a>
        <span>/</span>
        <span style="color: #111111; font-weight: 600;">Ali Khan Profile</span>
    </div>

    <!-- Profile Header Card (Exact Layout from Mockup 1 & 2) -->
    <div class="card-box" style="padding: 36px; margin-bottom: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div style="display: flex; gap: 24px; align-items: center;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 4px solid #FFCC00; box-shadow: var(--shadow-sm);">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <h1 style="font-size: 24px; font-weight: 800; color: #111;">Ali Khan</h1>
                        <span class="badge badge-verified" style="font-size: 11px;">✓ Verified Technician</span>
                    </div>
                    <p style="font-size: 14px; color: #555; margin-bottom: 4px;">Plumber • 5 years exp</p>
                    <div style="font-size: 13px; color: #111; font-weight: 700;">
                        ★ 4.8 <span style="color: #777; font-weight: 500;">(247 jobs)</span> • 📍 3.2 km away
                    </div>
                </div>
            </div>

            <!-- Profile Action Buttons -->
            <div style="display: flex; gap: 12px;">
                <a href="{{ url('/chat') }}" class="btn-outline" style="padding: 11px 22px;">
                    Chat
                </a>
                <a href="{{ url('/booking-page') }}" class="btn-yellow" style="padding: 11px 26px;">
                    Book Now
                </a>
            </div>
        </div>
    </div>

    <!-- Two-Column Details -->
    <div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 28px;">
        
        <!-- Left: Skills, Previous Work Photos -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Skills & Services -->
            <div class="card-box" style="padding: 26px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 14px;">Skills & Services</h3>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #333;">Plumbing</span>
                    <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #333;">Sink Repair</span>
                    <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #333;">Pipe Repair</span>
                    <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #333;">Toilet Repair</span>
                    <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #333;">Bathroom Renovation</span>
                </div>
            </div>

            <!-- Previous Work Gallery (Using user's added images) -->
            <div class="card-box" style="padding: 26px;">
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 14px;">Previous Work Photos</h3>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <div style="height: 110px; border-radius: 12px; overflow: hidden; border: 1px solid #E5E7EB;">
                        <img src="{{ asset('assets/images/image_3.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="height: 110px; border-radius: 12px; overflow: hidden; border: 1px solid #E5E7EB;">
                        <img src="{{ asset('assets/images/image_8.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="height: 110px; border-radius: 12px; overflow: hidden; border: 1px solid #E5E7EB;">
                        <img src="{{ asset('assets/images/image_6.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>

            <!-- Customer Reviews (From Mockup 1 & 2) -->
            <div class="card-box" style="padding: 26px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 17px; font-weight: 800; color: #111;">Customer Reviews</h3>
                    <span style="font-size: 13px; font-weight: 700; color: #111;">★ 4.8 out of 5</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 14px; padding: 16px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <strong style="font-size: 14px; color: #111;">Sara Ahmed</strong>
                            <span style="color: #FFCC00; font-size: 13px;">★★★★★</span>
                        </div>
                        <p style="font-size: 13px; color: #666; line-height: 1.4;">
                            "Very professional and fixed the kitchen sink issue quickly. Cleaned up everything afterwards!"
                        </p>
                        <span style="font-size: 11px; color: #9CA3AF; margin-top: 4px; display: block;">Sep 20, 2026</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right: Specs, Pricing, Availability -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <div class="card-box" style="padding: 26px;">
                <h4 style="font-size: 15px; font-weight: 800; color: #111; margin-bottom: 14px;">Service Information</h4>
                
                <div style="display: flex; flex-direction: column; gap: 14px; font-size: 13.5px;">
                    <div>
                        <span style="color: #777; display: block; font-size: 12px;">EXPERIENCE</span>
                        <strong style="color: #111;">5 Years Professional Experience</strong>
                    </div>
                    <div>
                        <span style="color: #777; display: block; font-size: 12px;">SERVICE AREAS</span>
                        <strong style="color: #111;">Karachi, DHA, Clifton, Gulshan-e-Iqbal</strong>
                    </div>
                    <div>
                        <span style="color: #777; display: block; font-size: 12px;">AVAILABILITY</span>
                        <strong style="color: #111;">Mon - Sat: 9:00 AM - 7:00 PM</strong>
                    </div>
                    <div>
                        <span style="color: #777; display: block; font-size: 12px;">PRICING</span>
                        <strong style="color: #111; font-size: 16px;">Rs. 500 – 800 / hr ($75)</strong>
                    </div>
                </div>

                <div style="margin-top: 24px;">
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="width: 100%; padding: 12px;">
                        Book Service with Ali
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
