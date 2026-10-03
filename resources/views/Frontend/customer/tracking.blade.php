@extends('Frontend.layouts.customer')

@section('title', 'Live Tracking & Booking Details — FixMate AI')

@section('content')
<div style="max-width: 920px; margin: 0 auto;">
    
    @if(! $booking)
        <div class="portal-card" style="padding: 48px; text-align: center; background: #FFFFFF; border-radius: 16px;">
            <div style="font-size: 44px; margin-bottom: 12px;">📍</div>
            <h2 style="font-size: 22px; font-weight: 900; color: #111; margin-bottom: 6px;">No Active Booking to Track</h2>
            <p style="font-size: 14px; color: #666; max-width: 480px; margin: 0 auto 20px auto;">
                You currently don't have an active or en-route service booking. Once you schedule a certified professional, live GPS status and arrival OTP will appear right here.
            </p>
            <a href="{{ route('customer.booking') }}" class="btn-yellow" style="padding: 10px 24px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 10px;">
                Schedule a Service Now
            </a>
        </div>
    @else
        <!-- Header with Back Link & Status Badge matching Mockup 1 -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <a href="{{ route('customer.bookings') }}" style="font-size: 13px; color: #666; text-decoration: none; display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                    ← Back to My Bookings
                </a>
                <h1 style="font-size: 24px; font-weight: 900; color: #111; margin: 0;">Booking #{{ $booking->booking_number }}</h1>
                <span style="font-size: 13.5px; color: #666;">{{ $booking->service_title }}</span>
            </div>
            <div>
                <span style="background: #FFF9E6; color: #B45309; border: 1px solid #FFECB3; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #F59E0B; display: inline-block;"></span>
                    {{ $booking->status_label }}
                </span>
            </div>
        </div>

        @php
            $statusRank = match ($booking->status) {
                'pending' => 1,
                'confirmed' => 2,
                'en_route' => 3,
                'in_progress' => 4,
                'completed' => 5,
                default => 1,
            };
        @endphp

        <!-- Stepper bar matching Mockup 1 -->
        <div class="portal-card" style="padding: 18px 24px; background: #FFFFFF; margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; position: relative;">
                
                <!-- Step 1: Requested -->
                <div style="text-align: center; flex: 1;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">✓</div>
                    <strong style="font-size: 12px; color: #111; display: block;">Booking</strong>
                    <span style="font-size: 10px; color: #888;">{{ $booking->created_at->format('h:i A') }}</span>
                </div>

                <!-- Step 2: Assigned -->
                <div style="text-align: center; flex: 1; {{ $statusRank < 2 ? 'opacity: 0.5;' : '' }}">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $statusRank >= 2 ? '#10B981' : '#E5E7EB' }}; color: {{ $statusRank >= 2 ? '#FFF' : '#666' }}; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">
                        {{ $statusRank >= 2 ? '✓' : '2' }}
                    </div>
                    <strong style="font-size: 12px; color: #111; display: block;">Assigned</strong>
                    <span style="font-size: 10px; color: #888;">{{ $booking->professional ? $booking->professional->name : 'Auto' }}</span>
                </div>

                <!-- Step 3: En Route -->
                <div style="text-align: center; flex: 1; {{ $statusRank < 3 ? 'opacity: 0.5;' : '' }}">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $statusRank >= 3 ? '#FFCC00' : '#E5E7EB' }}; color: #000; font-size: 13px; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; {{ $statusRank == 3 ? 'box-shadow: 0 0 0 4px rgba(255,204,0,0.3);' : '' }}">
                        {{ $statusRank > 3 ? '✓' : '●' }}
                    </div>
                    <strong style="font-size: 12px; color: {{ $statusRank == 3 ? '#B45309' : '#111' }}; display: block;">On The Way</strong>
                    <span style="font-size: 10px; color: #B45309; font-weight: 700;">ETA ~15 min</span>
                </div>

                <!-- Step 4: In Progress -->
                <div style="text-align: center; flex: 1; {{ $statusRank < 4 ? 'opacity: 0.5;' : '' }}">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $statusRank >= 4 ? '#10B981' : '#E5E7EB' }}; color: {{ $statusRank >= 4 ? '#FFF' : '#666' }}; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">
                        {{ $statusRank >= 4 ? '✓' : '4' }}
                    </div>
                    <strong style="font-size: 12px; color: #666; display: block;">Service Started</strong>
                    <span style="font-size: 10px; color: #888;">OTP Verified</span>
                </div>

                <!-- Step 5: Completed -->
                <div style="text-align: center; flex: 1; {{ $statusRank < 5 ? 'opacity: 0.5;' : '' }}">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $statusRank == 5 ? '#10B981' : '#E5E7EB' }}; color: {{ $statusRank == 5 ? '#FFF' : '#666' }}; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">
                        {{ $statusRank == 5 ? '✓' : '5' }}
                    </div>
                    <strong style="font-size: 12px; color: #666; display: block;">Completed</strong>
                    <span style="font-size: 10px; color: #888;">Escrow Release</span>
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

                        <!-- Technician Marker -->
                        <g transform="translate(180, 80)">
                            <circle cx="0" cy="0" r="18" fill="#111111" stroke="#FFCC00" stroke-width="3" />
                            <text x="0" y="4" font-size="12" text-anchor="middle" fill="#FFCC00">🛵</text>
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
                            <strong style="display: block; font-size: 15px; color: #111;">{{ $booking->service_time_slot }} <span style="color: #059669; font-size: 12px;">(Active)</span></strong>
                        </div>
                    </div>

                    <div style="position: absolute; bottom: 16px; right: 16px; background: #FFFFFF; border-radius: 8px; padding: 6px 12px; font-size: 11px; font-weight: 700; color: #374151; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        Technician is ~2.1 km away
                    </div>
                </div>

                <!-- Technician Contact & Arrival OTP Card matching Mockup 1 -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    
                    <!-- Pro Info & Call/Chat -->
                    <div style="display: flex; gap: 14px; align-items: center;">
                        <img src="{{ asset($booking->professional?->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $booking->professional?->name ?? 'Pro' }}" style="width: 58px; height: 58px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                        <div>
                            <strong style="display: block; font-size: 16px; color: #111;">{{ $booking->professional?->name ?? 'FixMate Dedicated Pro' }}</strong>
                            <span style="font-size: 12.5px; color: #666; display: block; margin-bottom: 4px;">{{ $booking->profession?->name ?? 'Technician' }} • ★ {{ number_format($booking->professional?->rating ?? 4.9, 1) }}</span>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" onclick="document.getElementById('trackCallModal').style.display='flex';" class="btn-outline" style="padding: 5px 12px; font-size: 11.5px; border-radius: 6px; cursor: pointer; border: 1px solid var(--border-color);">
                                    📞 Call
                                </button>
                                <a href="{{ route('customer.messages', ['tech_id' => $booking->professional_id]) }}" class="btn-yellow" style="padding: 5px 14px; font-size: 11.5px; border-radius: 6px; text-decoration: none; font-weight: 700;">
                                    💬 Chat
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Handshake Arrival OTP Card (Critical Security Feature from SRS) -->
                    <div style="background: #FFFDF0; border: 2px dashed #FEF08A; border-radius: 12px; padding: 14px 18px; text-align: center;">
                        <span style="font-size: 11px; font-weight: 800; color: #92400E; text-transform: uppercase; letter-spacing: 0.5px;">Arrival Verification OTP</span>
                        <strong style="display: block; font-size: 26px; font-weight: 900; letter-spacing: 4px; color: #111; margin: 4px 0;">{{ $booking->arrival_otp }}</strong>
                        <span style="font-size: 10.5px; color: #777;">Provide this 4-digit code ONLY when the technician arrives at your door</span>
                    </div>

                </div>

                <!-- Call Modal -->
                @php
                    $techPhone = $booking->professional?->phone ?: '03001234567';
                    $waTechPhone = preg_replace('/[^0-9]/', '', $techPhone);
                    if (str_starts_with($waTechPhone, '0')) {
                        $waTechPhone = '92' . substr($waTechPhone, 1);
                    }
                @endphp
                <div id="trackCallModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
                    <div style="background: #FFFFFF; border-radius: 16px; width: 90%; max-width: 400px; padding: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative; text-align: center;">
                        <button type="button" onclick="document.getElementById('trackCallModal').style.display='none';" style="position: absolute; top: 14px; right: 14px; background: none; border: none; font-size: 18px; color: #94A3B8; cursor: pointer;">✕</button>

                        <img src="{{ asset($booking->professional?->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $booking->professional?->name ?? 'Pro' }}" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 3px solid #FFB800; margin: 0 auto 10px auto; display: block;">
                        
                        <h3 style="font-size: 17px; font-weight: 900; color: #0F172A; margin-bottom: 2px;">{{ $booking->professional?->name ?? 'Dedicated Pro' }}</h3>
                        <p style="font-size: 12.5px; color: #64748B; margin: 0 0 16px 0;">En-route for Booking #{{ $booking->booking_number }}</p>

                        <div style="background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 12px; padding: 12px; margin-bottom: 16px;">
                            <span style="font-size: 11px; text-transform: uppercase; color: #64748B; font-weight: 700; display: block; margin-bottom: 2px;">Technician Contact</span>
                            <strong style="font-size: 19px; font-weight: 900; color: #0F172A;">{{ $techPhone }}</strong>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $techPhone }}'); alert('Phone number copied to clipboard: {{ $techPhone }}');" class="btn-outline" style="width: 100%; padding: 10px 0; font-size: 13px; font-weight: 700; border-radius: 8px; cursor: pointer;">
                                📋 Copy Phone Number
                            </button>
                            <a href="https://wa.me/{{ $waTechPhone }}?text={{ urlencode('Hello, I am waiting for you for FixMate booking #' . $booking->booking_number) }}" target="_blank" rel="noopener noreferrer" style="background: #25D366; color: #FFFFFF; font-weight: 800; font-size: 13px; padding: 10px 0; border-radius: 8px; text-decoration: none; display: block;">
                                💬 WhatsApp Chat
                            </a>
                            <a href="tel:{{ $techPhone }}" style="background: #0F172A; color: #FFFFFF; font-weight: 800; font-size: 13px; padding: 10px 0; border-radius: 8px; text-decoration: none; display: block;">
                                📞 Call on Phone
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Booking Details Card matching Mockup 1 -->
            <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Booking Details</h3>

                <div style="display: flex; flex-direction: column; gap: 14px; font-size: 13.5px; margin-bottom: 20px;">
                    <div>
                        <span style="font-size: 11.5px; color: #777; display: block;">Service</span>
                        <strong style="color: #111;">{{ $booking->service_title }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 11.5px; color: #777; display: block;">Scheduled Date & Time</span>
                        <strong style="color: #111;">{{ $booking->service_date ? $booking->service_date->format('M d, Y') : 'Today' }} • {{ $booking->service_time_slot }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 11.5px; color: #777; display: block;">Service Address</span>
                        <strong style="color: #111;">{{ $booking->service_address }}, {{ $booking->city }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 11.5px; color: #777; display: block;">Estimated Cost</span>
                        <strong style="color: #047857; font-size: 15px;">Rs. {{ number_format($booking->total_price) }}</strong>
                        <span style="font-size: 11px; color: #888; display: block;">(Funds held securely in escrow)</span>
                    </div>
                </div>

                <!-- Cancel / Support Links -->
                <div style="border-top: 1px solid var(--border-color); padding-top: 16px; display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('customer.complaints', ['booking' => $booking->booking_number]) }}" style="font-size: 12.5px; color: #666; text-decoration: none;">
                        ⚠️ Report Issue / Change Schedule
                    </a>
                    <a href="{{ url('/contact') }}" style="font-size: 12.5px; color: #B45309; text-decoration: none; font-weight: 700;">
                        FixMate 24/7 Support Hotline →
                    </a>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
