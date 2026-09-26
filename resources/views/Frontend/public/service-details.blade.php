@extends('Frontend.layouts.public')

@section('title', 'Service Details — FixMate AI')
@section('meta_desc', 'Explore detailed service scope, upfront pricing breakdown, and verified pros for home maintenance.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 20px;">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <a href="{{ url('/services') }}">Services</a>
        <span>/</span>
        <span style="color: #111111; font-weight: 600;">Plumbing & Pipe Leak Repair</span>
    </div>

    <!-- Service Details Hero -->
    <div style="display: grid; grid-template-columns: 1.25fr 1fr; gap: 36px; align-items: start; margin-bottom: 40px;">
        
        <div>
            <!-- Banner Image (Using user's image_3.png) -->
            <div style="border-radius: var(--radius-xl); overflow: hidden; margin-bottom: 24px; border: 1px solid var(--border-color); height: 260px;">
                <img src="{{ asset('assets/images/image_3.png') }}" alt="Plumbing Service" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <span class="badge badge-gold">Plumbing Specialty</span>
                    <span style="font-size: 12px; color: #10B981; font-weight: 700;">● Active Technicians in Karachi</span>
                </div>
                <h1 style="font-size: 28px; font-weight: 800; color: #111; margin-bottom: 8px;">
                    Kitchen Sink & Water Pipe Leak Repair
                </h1>
                <p style="font-size: 14.5px; color: #666; line-height: 1.6;">
                    Expert diagnosis and repair for dripping faucets, kitchen sink P-trap joint leaks, pipe corrosion, and water pressure drop. Carried out by licensed master plumbers with 60-day warranty.
                </p>
            </div>

            <!-- What's Included -->
            <div class="card-box" style="padding: 24px; margin-bottom: 24px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 14px;">What's Included in this Service</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13.5px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>Complete video & joint leak inspection</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>Slip-joint washer and seal replacement</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>Pipe tightening & Teflon thread seal</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="color: #10B981; font-weight: 800;">✓</span>
                        <span>60-Day Re-work Escrow Guarantee</span>
                    </div>
                </div>
            </div>

            <!-- Customer Reviews for this service -->
            <div class="card-box" style="padding: 24px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 14px;">Customer Reviews (4.8 ★)</h3>
                <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 12px; padding: 14px; font-size: 13px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <strong style="color: #111;">Ayesha Siddiqui</strong>
                        <span style="color: #FFCC00;">★★★★★</span>
                    </div>
                    <p style="color: #666;">"Ali arrived within 25 minutes and had the PVC replacement joint in his toolkit. Highly recommended!"</p>
                </div>
            </div>
        </div>

        <!-- Right: Pricing Card & Booking Action -->
        <div style="position: sticky; top: 92px;">
            <div class="card-box" style="padding: 30px; border: 2px solid #FFECB3; background: #FFFDF0;">
                <span style="font-size: 11.5px; font-weight: 700; color: #8C6B00; text-transform: uppercase; display: block; margin-bottom: 4px;">
                    UPFRONT GUARANTEED PRICING
                </span>
                <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 16px;">
                    <strong style="font-size: 32px; font-weight: 900; color: #111;">Rs. 650</strong>
                    <span style="font-size: 13px; color: #777;">Base Inspection & Repair</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px; margin-bottom: 20px; border-top: 1px solid #FFECB3; border-bottom: 1px solid #FFECB3; padding: 14px 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Estimated Duration:</span>
                        <strong style="color: #111;">45 – 60 mins</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Earliest Arrival:</span>
                        <strong style="color: #10B981;">Today &lt; 30 mins</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Payment Mode:</span>
                        <strong style="color: #111;">Escrow Pre-Authorization</strong>
                    </div>
                </div>

                <!-- One Click Booking Button -->
                <a href="{{ url('/customer/booking') }}" class="btn-yellow" style="width: 100%; padding: 13px; font-size: 15px; margin-bottom: 12px;">
                    Book This Service
                </a>
                <a href="{{ url('/customer/diagnose') }}" class="btn-outline" style="width: 100%; padding: 12px; font-size: 13.5px; justify-content: center;">
                    🔍 Run Free AI Diagnostic First
                </a>
                <p style="text-align: center; font-size: 11.5px; color: #888; margin-top: 12px;">
                    Free cancellation up to 30 mins before arrival • Vetted pros only
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
