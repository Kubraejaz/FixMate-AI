@extends('Frontend.layouts.technician')

@section('title', 'Job #' . $booking->booking_number . ' Details — FixMate')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <!-- Header with Back Link -->
    <div style="margin-bottom: 20px;">
        <a href="{{ route('technician.jobs') }}" style="font-size: 13px; color: #666; text-decoration: none; display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
            ← Back to Job Requests
        </a>
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0;">Job #{{ $booking->booking_number }} Details</h1>
            <span style="background: {{ $booking->status === 'completed' ? '#ECFDF5' : '#FFF9E6' }}; color: {{ $booking->status === 'completed' ? '#047857' : '#B45309' }}; border: 1px solid #FFECB3; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                {{ $booking->status_label }}
            </span>
        </div>
    </div>

    <!-- Main Job Card -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        
        <!-- Customer Info Strip -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; margin-bottom: 20px; flex-wrap: wrap; gap: 14px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 16px;">
                    {{ strtoupper(substr($booking->user?->name ?? 'C', 0, 2)) }}
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0 0 2px 0;">{{ $booking->user?->name ?? 'Customer' }}</h3>
                    <span style="font-size: 13px; color: #666;">📞 {{ $booking->user?->phone ?? 'Contact on arrival' }} &bull; Verified Homeowner</span>
                </div>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 12px; color: #777;">Scheduled Slot</span>
                <strong style="display: block; font-size: 14px; color: #111;">{{ $booking->service_date->format('M d, Y') }} &bull; {{ $booking->service_time_slot }}</strong>
            </div>
        </div>

        <!-- Problem & Service Request Details -->
        <div style="margin-bottom: 24px;">
            <span style="font-size: 11.5px; font-weight: 800; color: #B45309; text-transform: uppercase;">Service Request</span>
            <h2 style="font-size: 20px; font-weight: 900; color: #111; margin: 4px 0 10px 0;">{{ $booking->service_title }}</h2>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 16px;">
                {{ $booking->problem_description ?: 'Customer requested standard inspection and maintenance for ' . ($booking->profession?->name ?? 'this trade') . '.' }}
            </p>

            <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px;">
                <div>
                    <span style="font-size: 11px; color: #777; text-transform: uppercase;">Category</span>
                    <strong style="display: block; font-size: 14px; color: #111;">{{ $booking->profession?->name ?? 'General Maintenance' }}</strong>
                </div>
                <div>
                    <span style="font-size: 11px; color: #777; text-transform: uppercase;">Total Booking Fee</span>
                    <strong style="display: block; font-size: 14px; color: #111;">Rs. {{ number_format($booking->total_price) }}</strong>
                </div>
                <div>
                    <span style="font-size: 11px; color: #777; text-transform: uppercase;">Technician Payout (90%)</span>
                    <strong style="display: block; font-size: 15px; color: #047857;">Rs. {{ number_format($techPayout) }}</strong>
                </div>
                <div>
                    <span style="font-size: 11px; color: #777; text-transform: uppercase;">Escrow Status</span>
                    <strong style="display: block; font-size: 14px; color: #B45309;">{{ ucfirst(str_replace('_', ' ', $booking->payment_status)) }}</strong>
                </div>
            </div>

            <!-- Uploaded Photos from User -->
            @if($booking->problem_image)
                <span style="font-size: 12.5px; font-weight: 700; color: #374151; display: block; margin-bottom: 10px;">Customer Uploaded Problem Photo:</span>
                <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                    <div style="width: 180px; height: 140px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color);">
                        <img src="{{ asset($booking->problem_image) }}" alt="Problem" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            @endif
        </div>

        <!-- Location & Directions -->
        <div style="border-top: 1px solid var(--border-color); padding-top: 20px; margin-bottom: 28px;">
            <span style="font-size: 11.5px; font-weight: 800; color: #6B7280; text-transform: uppercase;">Service Address & Location</span>
            <strong style="display: block; font-size: 15px; color: #111; margin: 4px 0 6px 0;">
                {{ $booking->service_address }}, {{ $booking->city }}
            </strong>
        </div>

        <!-- Action Row -->
        <div style="display: flex; gap: 14px; flex-wrap: wrap;">
            <a href="{{ route('technician.messages', ['client_id' => $booking->user_id]) }}" class="btn-outline" style="padding: 12px 24px; font-size: 14px; text-decoration: none;">
                💬 Chat With Customer
            </a>

            @if($booking->status === 'pending')
                <form action="{{ route('technician.jobs.accept', $booking->id) }}" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 900; border: none; cursor: pointer;">
                        Accept Job & Dispatch Confirmation →
                    </button>
                </form>
            @elseif($booking->status === 'confirmed')
                <form action="{{ route('technician.jobs.start-route', $booking->id) }}" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 900; border: none; cursor: pointer;">
                        Start Route (En Route) →
                    </button>
                </form>
            @elseif(in_array($booking->status, ['en_route', 'in_progress']))
                <a href="{{ route('technician.active-job') }}" class="btn-yellow" style="flex: 1; text-align: center; padding: 12px 0; font-size: 14.5px; font-weight: 900; text-decoration: none;">
                    Go to Active Job Screen & Verify OTP →
                </a>
            @elseif($booking->status === 'completed')
                <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #047857; padding: 12px 24px; border-radius: 8px; font-weight: 800; font-size: 14px;">
                    ✓ Service successfully completed. Payout released to wallet.
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
