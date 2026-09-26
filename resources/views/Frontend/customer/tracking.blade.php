@extends('Frontend.layouts.customer')

@section('title', 'Live Tracking & Booking Details — Booking #FM-10245')

@section('content')
<div style="max-width: 920px; margin: 0 auto;">
    
    <!-- Header with Back Link & Status Badge matching Mockup 1 -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <a href="{{ url('/customer/bookings') }}" style="font-size: 13px; color: #666; text-decoration: none; display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                ← Back to My Bookings
            </a>
            <h1 style="font-size: 24px; font-weight: 900; color: #111; margin: 0;">Booking #FM-10245</h1>
            <span style="font-size: 13.5px; color: #666;">Plumbing — Sink Repair</span>
        </div>
        <div>
            <span style="background: #FFF9E6; color: #B45309; border: 1px solid #FFECB3; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #F59E0B; display: inline-block;"></span>
                Technician On The Way
            </span>
        </div>
    </div>

    <!-- Stepper bar matching Mockup 1 -->
    <div class="portal-card" style="padding: 18px 24px; background: #FFFFFF; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; position: relative;">
            
            <div style="text-align: center; flex: 1;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">✓</div>
                <strong style="font-size: 12px; color: #111; display: block;">Booking</strong>
                <span style="font-size: 10px; color: #888;">10:00 AM</span>
            </div>

            <div style="text-align: center; flex: 1;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">✓</div>
                <strong style="font-size: 12px; color: #111; display: block;">Accepted</strong>
                <span style="font-size: 10px; color: #888;">10:02 AM</span>
            </div>

            <div style="text-align: center; flex: 1;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #FFCC00; color: #000; font-size: 13px; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; box-shadow: 0 0 0 4px rgba(255,204,0,0.3);">●</div>
                <strong style="font-size: 12px; color: #B45309; display: block;">On The Way</strong>
                <span style="font-size: 10px; color: #B45309; font-weight: 700;">ETA 10 min</span>
            </div>

            <div style="text-align: center; flex: 1; opacity: 0.5;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #E5E7EB; color: #666; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">○</div>
                <strong style="font-size: 12px; color: #666; display: block;">Service Started</strong>
                <span style="font-size: 10px; color: #888;">OTP Pending</span>
            </div>

            <div style="text-align: center; flex: 1; opacity: 0.5;">
                <div style="width: 28px; height: 28px; border-radius: 50%; background: #E5E7EB; color: #666; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">○</div>
                <strong style="font-size: 12px; color: #666; display: block;">Completed</strong>
                <span style="font-size: 10px; color: #888;">Release Escrow</span>
            </div>

        </div>
    </div>

    <!-- Main Live Tracking Body matching Mockup 1 -->
    <div style="display: grid; grid-template-columns: 1.25fr 0.75fr; gap: 24px; align-items: flex-start;">
        
        <!-- Left: Map Representation & Pro Status Card -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Map View Container with Interactive Marker Simulation -->
            <div class="portal-card" style="padding: 0; overflow: hidden; background: #E5E7EB; position: relative; height: 340px; border-radius: 16px;">
                <!-- Simulated Live GPS Map Graphic -->
                <svg width="100%" height="100%" viewBox="0 0 600 340" style="display: block; background: #E5EBF0;">
                    <!-- Map Roads -->
                    <path d="M 0 100 Q 200 120 400 90 T 600 130" stroke="#FFFFFF" stroke-width="18" fill="none" />
                    <path d="M 120 0 L 150 340" stroke="#FFFFFF" stroke-width="14" fill="none" />
                    <path d="M 350 0 L 330 340" stroke="#FFFFFF" stroke-width="22" fill="none" />
                    <path d="M 0 240 Q 250 220 600 260" stroke="#FFFFFF" stroke-width="16" fill="none" />

                    <!-- Route Highlight Path (Gold / Orange route) -->
                    <path d="M 180 80 Q 240 180 340 230" stroke="#FFCC00" stroke-width="6" stroke-dasharray="8 6" fill="none" />

                    <!-- Technician Marker (Ali Khan) -->
                    <g transform="translate(180, 80)">
                        <circle cx="0" cy="0" r="18" fill="#111111" stroke="#FFCC00" stroke-width="3" />
                        <text x="0" y="4" font-size="12" text-anchor="middle" fill="#FFCC00">🛵</text>
                        <!-- Pulse animation ring -->
                        <circle cx="0" cy="0" r="28" fill="none" stroke="#FFCC00" stroke-width="1.5" opacity="0.6">
                            <animate attributeName="r" values="18;34" dur="1.5s" repeatCount="indefinite" />
                            <animate attributeName="opacity" values="0.8;0" dur="1.5s" repeatCount="indefinite" />
                        </circle>
                    </g>

                    <!-- Destination Marker (Customer Home) -->
                    <g transform="translate(340, 230)">
                        <circle cx="0" cy="0" r="16" fill="#10B981" stroke="#FFFFFF" stroke-width="3" />
                        <text x="0" y="4" font-size="11" text-anchor="middle" fill="#FFFFFF">🏠</text>
                    </g>
                </svg>

                <!-- Floating ETA Card over Map -->
                <div style="position: absolute; top: 16px; left: 16px; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border-radius: 12px; padding: 10px 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        ⏱️
                    </div>
                    <div>
                        <span style="font-size: 11px; color: #666; font-weight: 700; text-transform: uppercase;">Estimated Arrival</span>
                        <strong style="display: block; font-size: 15px; color: #111;">2:50 PM <span style="color: #059669; font-size: 12px;">(10 mins away)</span></strong>
                    </div>
                </div>

                <div style="position: absolute; bottom: 16px; right: 16px; background: #FFFFFF; border-radius: 8px; padding: 6px 12px; font-size: 11px; font-weight: 700; color: #374151; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    Technician is 2.1 km away
                </div>
            </div>

            <!-- Technician Contact & Arrival OTP Card matching Mockup 1 -->
            <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                
                <!-- Pro Info & Call/Chat -->
                <div style="display: flex; gap: 14px; align-items: center;">
                    <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 58px; height: 58px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                    <div>
                        <strong style="display: block; font-size: 16px; color: #111;">Ali Khan</strong>
                        <span style="font-size: 12.5px; color: #666; display: block; margin-bottom: 4px;">Plumber • 4.9 ★ (247)</span>
                        <div style="display: flex; gap: 8px;">
                            <a href="tel:03001234567" class="btn-outline" style="padding: 5px 12px; font-size: 11.5px; border-radius: 6px;">📞 Call</a>
                            <a href="{{ url('/customer/messages?tech=ali-khan') }}" class="btn-yellow" style="padding: 5px 14px; font-size: 11.5px; border-radius: 6px;">💬 Chat</a>
                        </div>
                    </div>
                </div>

                <!-- Handshake Arrival OTP Card (Critical Security Feature from SRS) -->
                <div style="background: #FFFDF0; border: 2px dashed #FEF08A; border-radius: 12px; padding: 14px 18px; text-align: center;">
                    <span style="font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; letter-spacing: 0.5px;">Arrival Verification OTP</span>
                    <strong style="display: block; font-size: 26px; font-weight: 900; letter-spacing: 4px; color: #111; margin: 4px 0;">5829</strong>
                    <span style="font-size: 10.5px; color: #777;">Provide this 4-digit code ONLY when Ali Khan arrives at your door</span>
                </div>

            </div>

        </div>

        <!-- Right: Booking Details Card matching Mockup 1 -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Booking Details</h3>

            <div style="display: flex; flex-direction: column; gap: 14px; font-size: 13.5px; margin-bottom: 20px;">
                <div>
                    <span style="font-size: 11.5px; color: #777; display: block;">Service</span>
                    <strong style="color: #111;">Sink Repair (Kitchen P-trap)</strong>
                </div>

                <div>
                    <span style="font-size: 11.5px; color: #777; display: block;">Scheduled Date & Time</span>
                    <strong style="color: #111;">Today, Sep 27 • 2:30 PM - 3:30 PM</strong>
                </div>

                <div>
                    <span style="font-size: 11.5px; color: #777; display: block;">Service Address</span>
                    <strong style="color: #111;">House 42-B, Street 18, Phase 6, DHA, Karachi</strong>
                </div>

                <div>
                    <span style="font-size: 11.5px; color: #777; display: block;">Estimated Cost</span>
                    <strong style="color: #047857; font-size: 15px;">Rs. 500 – 800</strong>
                    <span style="font-size: 11px; color: #888; display: block;">(Rs. 500 held securely in escrow)</span>
                </div>
            </div>

            <!-- Cancel / Support Links -->
            <div style="border-top: 1px solid var(--border-color); padding-top: 16px; display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ url('/customer/complaints?booking=FM-10245') }}" style="font-size: 12.5px; color: #666; text-decoration: none;">
                    ⚠️ Report Issue / Change Schedule
                </a>
                <a href="{{ url('/contact') }}" style="font-size: 12.5px; color: #B45309; text-decoration: none; font-weight: 700;">
                    FixMate 24/7 Support Hotline →
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
