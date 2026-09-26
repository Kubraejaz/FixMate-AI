@extends('Frontend.layouts.master')

@section('title', 'Recommended Technicians — FixMate AI')
@section('meta_desc', 'Matched verified plumbers for kitchen sink leakage based on location, availability, and customer reviews.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px; max-width: 860px;">

    <!-- Breadcrumb & Header -->
    <div style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 6px;">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/describe-problem') }}">Describe Problem</a>
            <span>/</span>
            <span style="color: #111111; font-weight: 600;">Recommended Technicians</span>
        </div>
        <h1 style="font-size: 28px; font-weight: 800; color: #111; margin-bottom: 4px;">Recommended Technicians</h1>
        <p style="font-size: 14px; color: #757575;">
            Based on your diagnosed problem (<strong>Kitchen Sink Leakage</strong>), location (<strong>Karachi</strong>), and real-time availability.
        </p>
    </div>

    <!-- Filter Tabs (Nearby, Top Rated, Most Experienced) -->
    <div style="display: flex; gap: 10px; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
        <button type="button" class="btn-yellow" style="padding: 7px 16px; font-size: 13px;">
            📍 Nearby First
        </button>
        <button type="button" class="btn-outline" style="padding: 7px 16px; font-size: 13px;">
            ⭐ Top Rated
        </button>
        <button type="button" class="btn-outline" style="padding: 7px 16px; font-size: 13px;">
            🏆 Most Experienced
        </button>
    </div>

    <!-- Technicians List -->
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <!-- Technician 1: Ali Khan (Recommended #1) -->
        <div class="card-box" style="border: 2px solid #FFECB3; background: #FFFDF0; padding: 26px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; margin-bottom: 16px; flex-wrap: wrap;">
                <div style="display: flex; gap: 18px; align-items: center;">
                    <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <h3 style="font-size: 18px; font-weight: 800; color: #111;">Ali Khan</h3>
                            <span class="badge badge-verified" style="font-size: 11px;">✓ Verified Pro</span>
                        </div>
                        <p style="font-size: 13.5px; color: #555; margin-bottom: 4px;">Plumber • 5 Yrs Exp • <strong>3.2 km away</strong></p>
                        <div style="font-size: 13px; font-weight: 700; color: #111;">
                            ★ 4.8 <span style="color: #777; font-weight: 500;">(247 completed jobs)</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ url('/technician-profile/ali-khan') }}" class="btn-outline" style="font-size: 13px; padding: 9px 16px;">
                        View Profile
                    </a>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="font-size: 13px; padding: 9px 20px;">
                        Book Now
                    </a>
                </div>
            </div>

            <!-- Skills Pills -->
            <div style="display: flex; gap: 8px; margin-bottom: 14px; flex-wrap: wrap;">
                <span style="background: #FFFFFF; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Plumbing</span>
                <span style="background: #FFFFFF; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Sink Repair</span>
                <span style="background: #FFFFFF; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Pipe Repair</span>
                <span style="background: #FFFFFF; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Drain Unclog</span>
            </div>

            <!-- Why Recommended Notice (From Mockup 1) -->
            <div style="background: #FFFFFF; border: 1px solid #FFECB3; border-radius: 12px; padding: 10px 14px; font-size: 12.5px; color: #8C6B00; display: flex; align-items: center; gap: 8px;">
                <span>💡</span>
                <span><strong>Why recommended?</strong> This technician has completed 28 similar kitchen plumbing jobs in your exact neighborhood.</span>
            </div>
        </div>

        <!-- Technician 2: Riaz Ahmed -->
        <div class="card-box" style="padding: 26px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; margin-bottom: 16px; flex-wrap: wrap;">
                <div style="display: flex; gap: 18px; align-items: center;">
                    <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #E5E7EB;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <h3 style="font-size: 18px; font-weight: 800; color: #111;">Riaz Ahmed</h3>
                            <span class="badge badge-verified" style="font-size: 11px;">✓ Verified Pro</span>
                        </div>
                        <p style="font-size: 13.5px; color: #555; margin-bottom: 4px;">Plumbing Specialist • 7 Yrs Exp • <strong>4.1 km away</strong></p>
                        <div style="font-size: 13px; font-weight: 700; color: #111;">
                            ★ 4.7 <span style="color: #777; font-weight: 500;">(189 completed jobs)</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ url('/technician-profile/riaz-ahmed') }}" class="btn-outline" style="font-size: 13px; padding: 9px 16px;">
                        View Profile
                    </a>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="font-size: 13px; padding: 9px 20px;">
                        Book Now
                    </a>
                </div>
            </div>

            <div style="display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Plumbing</span>
                <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Toilet Repair</span>
                <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Leak Repair</span>
            </div>

            <div style="font-size: 12px; color: #757575;">
                Completed 22 similar jobs in your area • 100% On-time arrival rate
            </div>
        </div>

        <!-- Technician 3: Imran Shah -->
        <div class="card-box" style="padding: 26px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; margin-bottom: 16px; flex-wrap: wrap;">
                <div style="display: flex; gap: 18px; align-items: center;">
                    <img src="{{ asset('assets/images/image_5.png') }}" alt="Imran Shah" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #E5E7EB;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <h3 style="font-size: 18px; font-weight: 800; color: #111;">Imran Shah</h3>
                            <span class="badge badge-verified" style="font-size: 11px;">✓ Verified Pro</span>
                        </div>
                        <p style="font-size: 13.5px; color: #555; margin-bottom: 4px;">Master Plumber • 8 Yrs Exp • <strong>2.8 km away</strong></p>
                        <div style="font-size: 13px; font-weight: 700; color: #111;">
                            ★ 4.9 <span style="color: #777; font-weight: 500;">(312 completed jobs)</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ url('/technician-profile/imran-shah') }}" class="btn-outline" style="font-size: 13px; padding: 9px 16px;">
                        View Profile
                    </a>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="font-size: 13px; padding: 9px 20px;">
                        Book Now
                    </a>
                </div>
            </div>

            <div style="display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Plumbing</span>
                <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Pipe Fitting</span>
                <span style="background: #FAFAFA; border: 1px solid #E5E7EB; padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #444;">Bathroom Repair</span>
            </div>

            <div style="font-size: 12px; color: #757575;">
                Emergency dispatch ready • 60-day warranty on all joint work
            </div>
        </div>

    </div>

</div>
@endsection
