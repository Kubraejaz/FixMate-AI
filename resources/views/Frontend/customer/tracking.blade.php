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
                
                <!-- Interactive Real-Time Leaflet GPS Map Container -->
                <div class="portal-card" style="padding: 0; overflow: hidden; background: #0F172A; position: relative; height: 380px; border-radius: 16px; border: 2px solid #FFCC00; box-shadow: 0 8px 24px rgba(0,0,0,0.12);">
                    
                    <div id="liveTrackingMap" style="width: 100%; height: 100%; min-height: 380px; z-index: 1;"></div>

                    <!-- Floating Live ETA & Status Badge -->
                    <div style="position: absolute; top: 16px; left: 16px; z-index: 999; background: rgba(255,255,255,0.96); backdrop-filter: blur(8px); border-radius: 12px; padding: 10px 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 12px; border: 1px solid #E2E8F0;">
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            ⏱️
                        </div>
                        <div>
                            <span style="font-size: 11px; color: #64748B; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Live Dynamic ETA</span>
                            <strong id="liveEtaText" style="display: block; font-size: 15px; color: #0F172A;">Loading ETA...</strong>
                        </div>
                    </div>

                    <!-- Top Right: Live GPS Streaming Status -->
                    <div style="position: absolute; top: 16px; right: 16px; z-index: 999; background: #065F46; color: #FFF; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 7px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); border: 1px solid #10B981;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #34D399; display: inline-block; box-shadow: 0 0 8px #34D399;"></span>
                        <span id="liveStatusText">LIVE GPS STREAMING</span>
                    </div>

                    <!-- Bottom Controls: Distance Pill & Recenter Buttons -->
                    <div style="position: absolute; bottom: 16px; left: 16px; z-index: 999; display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                        <span id="liveDistanceBadge" style="background: #0F172A; color: #FFCC00; border: 1px solid #334155; border-radius: 8px; padding: 7px 14px; font-size: 12px; font-weight: 800; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                            Calculating distance...
                        </span>
                        <button type="button" onclick="centerRoute()" style="background: #FFFFFF; color: #0F172A; border: 1px solid #CBD5E1; border-radius: 8px; padding: 7px 12px; font-size: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            🎯 Fit Route
                        </button>
                        <button type="button" onclick="centerTechnician()" style="background: #FFFFFF; color: #0F172A; border: 1px solid #CBD5E1; border-radius: 8px; padding: 7px 12px; font-size: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            🛵 Tech
                        </button>
                        <button type="button" onclick="centerDestination()" style="background: #FFFFFF; color: #0F172A; border: 1px solid #CBD5E1; border-radius: 8px; padding: 7px 12px; font-size: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                            🏠 Home
                        </button>
                    </div>

                    <!-- Arrival Banner Alert (Hidden by default, triggered when arrived) -->
                    <div id="arrivedAlertBanner" style="display: none; position: absolute; bottom: 16px; right: 16px; z-index: 999; background: #10B981; color: #FFFFFF; border-radius: 10px; padding: 8px 16px; font-size: 12.5px; font-weight: 800; box-shadow: 0 4px 15px rgba(0,0,0,0.2); align-items: center; gap: 8px;">
                        <span>✓</span> Technician has arrived at your gate!
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

@if($booking)
<!-- Leaflet OpenStreetMap Assets -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
@keyframes radarPing {
    0% { transform: scale(1); opacity: 0.8; }
    100% { transform: scale(2.2); opacity: 0; }
}
@keyframes pulseGps {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.85); }
}
.leaflet-popup-content-wrapper {
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trackingEndpoint = "{{ route('customer.booking.tracking-data', $booking->id) }}";
    let initialData = @json($booking->getLiveTrackingPayload());

    let map = null;
    let techMarker = null;
    let destMarker = null;
    let routeLine = null;

    const techIcon = L.divIcon({
        className: 'tech-marker-wrapper',
        html: `<div style="position: relative; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background: #0F172A; border: 3px solid #FFCC00; border-radius: 50%; box-shadow: 0 6px 18px rgba(0,0,0,0.35); font-size: 20px;">
                    🛵
                    <span style="position: absolute; inset: -4px; border-radius: 50%; border: 2px solid #FFCC00; animation: radarPing 2s infinite ease-out; pointer-events: none;"></span>
               </div>`,
        iconSize: [44, 44],
        iconAnchor: [22, 22]
    });

    const destIcon = L.divIcon({
        className: 'dest-marker-wrapper',
        html: `<div style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #10B981; border: 3px solid #FFFFFF; border-radius: 50%; box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4); font-size: 19px;">
                    🏠
               </div>`,
        iconSize: [40, 40],
        iconAnchor: [20, 20]
    });

    function initMap(data) {
        const techCoord = [data.technician.lat, data.technician.lng];
        const destCoord = [data.destination.lat, data.destination.lng];

        map = L.map('liveTrackingMap', {
            zoomControl: false,
            attributionControl: false
        }).setView(destCoord, 14);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        techMarker = L.marker(techCoord, { icon: techIcon }).addTo(map)
            .bindPopup(`<strong>${data.technician.name}</strong><br><span style="font-size:12px;color:#666;">En-route to your address</span>`);

        destMarker = L.marker(destCoord, { icon: destIcon }).addTo(map)
            .bindPopup(`<strong>Your Address</strong><br><span style="font-size:12px;color:#666;">${data.destination.address}</span>`);

        routeLine = L.polyline([techCoord, destCoord], {
            color: '#FFB800',
            weight: 5,
            opacity: 0.85,
            dashArray: '8, 8',
            lineCap: 'round'
        }).addTo(map);

        centerRoute();
        updateUI(data);
    }

    window.centerRoute = function() {
        if (!map || !techMarker || !destMarker) return;
        const bounds = L.latLngBounds([techMarker.getLatLng(), destMarker.getLatLng()]);
        map.fitBounds(bounds, { padding: [60, 60], maxZoom: 16 });
    };

    window.centerTechnician = function() {
        if (!map || !techMarker) return;
        map.flyTo(techMarker.getLatLng(), 16);
        techMarker.openPopup();
    };

    window.centerDestination = function() {
        if (!map || !destMarker) return;
        map.flyTo(destMarker.getLatLng(), 16);
        destMarker.openPopup();
    };

    function updateUI(data) {
        const etaText = document.getElementById('liveEtaText');
        const distanceBadge = document.getElementById('liveDistanceBadge');
        const arrivedBanner = document.getElementById('arrivedAlertBanner');

        if (etaText) {
            etaText.textContent = `~${data.eta_minutes} Mins (${data.distance_km} km away)`;
        }

        if (distanceBadge) {
            distanceBadge.textContent = `📍 ${data.distance_km} km away • ${data.technician.updated_at}`;
        }

        if (arrivedBanner) {
            if (data.is_arrived) {
                arrivedBanner.style.display = 'flex';
                document.getElementById('liveStatusText').textContent = 'TECHNICIAN ARRIVED';
            } else {
                arrivedBanner.style.display = 'none';
            }
        }
    }

    function pollLocation() {
        fetch(trackingEndpoint, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            const newTechCoord = [data.technician.lat, data.technician.lng];
            const destCoord = [data.destination.lat, data.destination.lng];

            if (techMarker) {
                techMarker.setLatLng(newTechCoord);
            }
            if (routeLine) {
                routeLine.setLatLngs([newTechCoord, destCoord]);
            }

            updateUI(data);
        })
        .catch(err => console.debug('Tracking poll:', err));
    }

    initMap(initialData);

    // Dynamic continuous polling every 4 seconds
    setInterval(pollLocation, 4000);
});
</script>
@endif

@endsection
