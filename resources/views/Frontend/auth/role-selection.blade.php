@extends('Frontend.layouts.public')

@section('title', 'Select Your Account Type — FixMate AI Registration')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 50px 0;">
    <div class="container" style="max-width: 720px; text-align: center;">
        
        <div style="margin-bottom: 32px;">
            <div style="display: inline-flex; width: 44px; height: 44px; border-radius: 12px; background: #FFCC00; align-items: center; justify-content: center; margin-bottom: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <h1 style="font-size: 30px; font-weight: 900; color: #111; margin-bottom: 8px;">Join FixMate AI</h1>
            <p style="font-size: 15px; color: #666; margin: 0;">Please select how you would like to use FixMate AI</p>
        </div>

        <!-- Role Choice Cards -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; text-align: left;">
            
            <!-- Customer Card -->
            <a href="{{ url('/register/customer') }}" class="portal-card" style="padding: 32px; text-decoration: none; border: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderColor='#FFCC00'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)';">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: #EFF6FF; border: 1px solid #DBEAFE; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 18px;">
                    🏠
                </div>
                <div style="display: inline-block; background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 4px; margin-bottom: 8px;">I need home repairs</div>
                <h3 style="font-size: 20px; font-weight: 800; color: #111; margin-bottom: 8px;">Customer</h3>
                <p style="font-size: 13.5px; color: #666; line-height: 1.5; margin-bottom: 20px;">
                    Scan defects using AI, get instant cost estimates, book certified technicians, and track them live with arrival OTPs.
                </p>
                <span class="btn-yellow" style="display: block; text-align: center; padding: 10px 0; font-size: 13.5px;">Register as Customer →</span>
            </a>

            <!-- Technician Card -->
            <a href="{{ url('/register/technician') }}" class="portal-card" style="padding: 32px; text-decoration: none; border: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderColor='#FFCC00'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='transparent'; this.style.transform='translateY(0)';">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 18px;">
                    🛠️
                </div>
                <div style="display: inline-block; background: #FFF9E6; color: #B45309; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 4px; margin-bottom: 8px;">I provide trade services</div>
                <h3 style="font-size: 20px; font-weight: 800; color: #111; margin-bottom: 8px;">Technician Partner</h3>
                <p style="font-size: 13.5px; color: #666; line-height: 1.5; margin-bottom: 20px;">
                    Receive instant nearby job dispatches, view AI diagnosis photos before accepting, and receive guaranteed payouts.
                </p>
                <span class="btn-outline" style="display: block; text-align: center; padding: 10px 0; font-size: 13.5px;">Register as Technician →</span>
            </a>

        </div>

        <p style="font-size: 13.5px; color: #777;">
            Already have an account? <a href="{{ url('/login') }}" style="color: #111; font-weight: 800; text-decoration: none;">Sign in here</a>
        </p>

    </div>
</div>
@endsection
