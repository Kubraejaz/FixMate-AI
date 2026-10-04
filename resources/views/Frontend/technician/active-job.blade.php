@extends('Frontend.layouts.technician')

@section('title', 'Active Service Execution & Customer OTP — FixMate AI Partner Portal')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    @if(! $booking)
        <!-- No Active Job State -->
        <div class="portal-card" style="padding: 48px; text-align: center; background: #FFFFFF; margin-top: 20px;">
            <div style="font-size: 40px; margin-bottom: 12px;">🛠️</div>
            <h2 style="font-size: 22px; font-weight: 900; color: #111; margin: 0 0 8px 0;">No Active Job in Progress</h2>
            <p style="font-size: 14px; color: #666; max-width: 440px; margin: 0 auto 20px auto;">
                You do not have any jobs currently marked as En Route or In Progress. Check your incoming dispatches to accept new work.
            </p>
            <a href="{{ route('technician.jobs') }}" class="btn-yellow" style="padding: 10px 24px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 8px;">
                View Dispatches & Job Requests &rarr;
            </a>
        </div>
    @else
        <!-- Active Status Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 10px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Active Job #{{ $booking->booking_number }}</h1>
                <span style="font-size: 13.5px; color: #666;">Customer: <strong>{{ $booking->user?->name }}</strong> &bull; {{ $booking->service_address }}, {{ $booking->city }}</span>
            </div>
            <span style="background: #FFF9E6; color: #B45309; border: 1px solid #FFECB3; font-size: 12.5px; font-weight: 800; padding: 6px 14px; border-radius: 20px;">
                ● {{ $booking->status_label }}
            </span>
        </div>

        <!-- Job Lifecycle Stepper State Machine -->
        <div class="portal-card" style="padding: 20px; background: #FFFFFF; margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; text-align: center;">
                <div style="flex: 1;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">✓</div>
                    <strong style="font-size: 12px; color: #111; display: block;">1. Accepted</strong>
                </div>
                <div style="flex: 1;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ in_array($booking->status, ['en_route', 'in_progress', 'completed']) ? '#10B981' : '#E5E7EB' }}; color: #FFF; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">
                        {{ in_array($booking->status, ['en_route', 'in_progress', 'completed']) ? '✓' : '2' }}
                    </div>
                    <strong style="font-size: 12px; color: #111; display: block;">2. En Route</strong>
                </div>
                <div style="flex: 1;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ in_array($booking->status, ['in_progress', 'completed']) ? '#10B981' : '#FFCC00' }}; color: {{ in_array($booking->status, ['in_progress', 'completed']) ? '#FFF' : '#000' }}; font-size: 12px; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">
                        {{ in_array($booking->status, ['in_progress', 'completed']) ? '✓' : '3' }}
                    </div>
                    <strong style="font-size: 12px; color: #B45309; display: block;">3. Verify OTP</strong>
                </div>
                <div style="flex: 1;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $booking->status === 'in_progress' ? '#FFCC00' : ($booking->status === 'completed' ? '#10B981' : '#E5E7EB') }}; color: #000; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">
                        {{ $booking->status === 'completed' ? '✓' : '4' }}
                    </div>
                    <strong style="font-size: 12px; color: #666; display: block;">4. In Progress</strong>
                </div>
                <div style="flex: 1; opacity: {{ $booking->status === 'completed' ? '1' : '0.6' }};">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $booking->status === 'completed' ? '#10B981' : '#E5E7EB' }}; color: #666; font-size: 12px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto;">5</div>
                    <strong style="font-size: 12px; color: #666; display: block;">5. Completed</strong>
                </div>
            </div>
        </div>

        @if($booking->status === 'en_route')
            <!-- Live GPS Geolocation Broadcaster Card -->
            <div class="portal-card" style="padding: 24px; background: #0F172A; color: #FFFFFF; border-radius: 16px; margin-bottom: 24px; border: 2px solid #FFCC00; box-shadow: 0 10px 28px rgba(0,0,0,0.25);">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 42px; height: 42px; border-radius: 50%; background: rgba(255,204,0,0.15); border: 2px solid #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                            🛵
                        </div>
                        <div>
                            <strong style="font-size: 16px; display: block; color: #FFFFFF;">Live GPS Dispatch Active</strong>
                            <span style="font-size: 12px; color: #94A3B8;">Broadcasting real-time coordinates to customer map</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="background: #065F46; color: #34D399; border: 1px solid #10B981; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <span style="width: 7px; height: 7px; border-radius: 50%; background: #34D399; animation: pulseGps 1.5s infinite;"></span>
                            GPS SYNC ON
                        </span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: rgba(255,255,255,0.06); padding: 14px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 16px;">
                    <div>
                        <span style="font-size: 11px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">Customer Destination</span>
                        <strong style="display: block; font-size: 13.5px; color: #F8FAFC; margin-top: 2px;">{{ $booking->service_address }}, {{ $booking->city }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 11px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">Real-Time Status</span>
                        <strong id="techGpsStatus" style="display: block; font-size: 13.5px; color: #FFCC00; margin-top: 2px;">
                            Calculating Distance...
                        </strong>
                    </div>
                </div>

                <!-- Simulation & Actions Row -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <span style="font-size: 12px; color: #94A3B8;">
                        💡 Testing without riding? Click below to simulate movement:
                    </span>
                    <button type="button" id="simulateGpsBtn" onclick="simulateStep()" style="background: #FFCC00; color: #000000; font-weight: 900; font-size: 12.5px; border: none; border-radius: 8px; padding: 9px 18px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(255,204,0,0.3);">
                        ⚡ Simulate Movement (30% Closer)
                    </button>
                </div>
            </div>
        @endif
            <!-- Handshake Arrival OTP Verification Card -->
            <div class="portal-card" style="padding: 32px; background: #FFFFFF; margin-bottom: 24px; border: 2px solid #FFCC00;">
                <div style="text-align: center; max-width: 480px; margin: 0 auto;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FFECB3; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px auto;">
                        🔐
                    </div>
                    <h3 style="font-size: 20px; font-weight: 900; color: #111; margin-bottom: 6px;">Customer Handshake OTP</h3>
                    <p style="font-size: 13.5px; color: #666; line-height: 1.5; margin-bottom: 20px;">
                        Ask customer <strong>{{ $booking->user?->name }}</strong> for their 4-digit arrival OTP shown on their booking screen to verify arrival.
                    </p>

                    <form action="{{ route('technician.active-job.verify-otp', $booking->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 20px;">
                            <input type="text" name="otp" placeholder="Enter 4-digit OTP" maxlength="4" required class="form-input" style="width: 200px; height: 50px; text-align: center; font-size: 24px; font-weight: 900; letter-spacing: 6px; margin: 0 auto; display: block;">
                        </div>

                        <div style="display: flex; gap: 12px; justify-content: center;">
                            <button type="submit" class="btn-yellow" style="padding: 12px 28px; font-size: 14px; font-weight: 900; border-radius: 10px; border: none; cursor: pointer;">
                                ✓ Verify OTP & Begin Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Work in Progress / Complete Job Card -->
            <div class="portal-card" style="padding: 32px; background: #ECFDF5; border: 2px solid #10B981; margin-bottom: 24px;">
                <div style="text-align: center; max-width: 500px; margin: 0 auto;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #D1FAE5; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px auto;">
                        ⚡
                    </div>
                    <h3 style="font-size: 20px; font-weight: 900; color: #065F46; margin-bottom: 6px;">Handshake Verified — Service In Progress</h3>
                    <p style="font-size: 13.5px; color: #047857; line-height: 1.5; margin-bottom: 20px;">
                        You have verified the arrival handshake with {{ $booking->user?->name }}. When the repair is finished, click Complete Service below to release the escrow payout of <strong>Rs. {{ number_format($techPayout) }}</strong>.
                    </p>

                    <form action="{{ route('technician.active-job.complete', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-yellow" style="padding: 13px 32px; font-size: 15px; font-weight: 900; border-radius: 10px; border: none; cursor: pointer; background: #10B981; color: #FFF;">
                            ✓ Complete Service & Release Escrow (Rs. {{ number_format($techPayout) }})
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Customer & Service Contact -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <h4 style="font-size: 14px; font-weight: 800; color: #111; margin-bottom: 8px;">Customer Contact</h4>
                <div style="font-size: 13px; color: #555; line-height: 1.6;">
                    <strong>{{ $booking->user?->name }}</strong><br>
                    📞 {{ $booking->user?->phone ?? 'Not provided' }}<br>
                    📍 {{ $booking->service_address }}, {{ $booking->city }}
                </div>
                <div style="display: flex; gap: 8px; margin-top: 10px;">
                    @if($booking->user?->phone)
                        <a href="tel:{{ $booking->user->phone }}" class="btn-outline" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">Call</a>
                    @endif
                    <a href="{{ route('technician.messages', ['client_id' => $booking->user_id]) }}" class="btn-yellow" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">
                        💬 Chat
                    </a>
                </div>
            </div>

            <div>
                <h4 style="font-size: 14px; font-weight: 800; color: #111; margin-bottom: 8px;">Job Summary</h4>
                <div style="font-size: 13px; color: #555; line-height: 1.6;">
                    🔧 {{ $booking->service_title }}<br>
                    💵 Technician Payout: <strong>Rs. {{ number_format($techPayout) }}</strong><br>
                    🛡️ FixMate Escrow Protection Active
                </div>
            </div>
        </div>
    @endif

</div>

@if($booking && $booking->status === 'en_route')
<style>
@keyframes pulseGps {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.3; transform: scale(0.85); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const locationEndpoint = "{{ route('technician.active-job.location', $booking->id) }}";
    const simulateEndpoint = "{{ route('technician.active-job.simulate-step', $booking->id) }}";
    const csrfToken = "{{ csrf_token() }}";
    let initialData = @json($booking->getLiveTrackingPayload());

    const statusEl = document.getElementById('techGpsStatus');
    const simBtn = document.getElementById('simulateGpsBtn');

    function updateStatusUI(data) {
        if (statusEl) {
            statusEl.textContent = `~${data.distance_km} km away • ETA ~${data.eta_minutes} min`;
        }
    }

    updateStatusUI(initialData);

    // 1. Mobile HTML5 Geolocation Broadcasting
    if ("geolocation" in navigator) {
        navigator.geolocation.watchPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                fetch(locationEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        latitude: lat,
                        longitude: lng
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.data) {
                        updateStatusUI(res.data);
                    }
                })
                .catch(err => console.debug('GPS push:', err));
            },
            function(err) {
                console.debug('Geolocation watch warning:', err.message);
            },
            { enableHighAccuracy: true, maximumAge: 10000, timeout: 15000 }
        );
    }

    // 2. Testing Simulation (Allows moving 30% closer with 1 click)
    window.simulateStep = function() {
        if (!simBtn) return;
        simBtn.disabled = true;
        simBtn.textContent = 'Updating...';

        fetch(simulateEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(res => {
            simBtn.disabled = false;
            simBtn.textContent = '⚡ Simulate Movement (30% Closer)';
            if (res.success && res.data) {
                updateStatusUI(res.data);
                if (typeof showToast === 'function') {
                    showToast(`GPS Location Updated! You are now ~${res.data.distance_km} km from customer.`);
                }
            }
        })
        .catch(err => {
            simBtn.disabled = false;
            simBtn.textContent = '⚡ Simulate Movement (30% Closer)';
            console.error('Simulate step error:', err);
        });
    };
});
</script>
@endif

@endsection
