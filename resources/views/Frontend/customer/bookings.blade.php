@extends('Frontend.layouts.customer')

@section('title', 'My Bookings — FixMate AI')

@section('content')
<div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Bookings</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">Track ongoing repair services and review your service history.</p>
        </div>
        <div>
            <a href="{{ route('customer.booking') }}" class="btn-yellow" style="padding: 10px 20px; font-size: 13.5px; font-weight: 800; text-decoration: none; border-radius: 10px;">
                + New Booking
            </a>
        </div>
    </div>

    <!-- Status Tabs & Search Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; gap: 10px;">
            @php $currentStatus = request('status', ''); @endphp
            <a href="{{ route('customer.bookings') }}" class="{{ $currentStatus === '' ? 'btn-yellow' : 'btn-outline' }}" style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
                All
            </a>
            <a href="{{ route('customer.bookings', ['status' => 'active']) }}" class="{{ $currentStatus === 'active' ? 'btn-yellow' : 'btn-outline' }}" style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
                Active
            </a>
            <a href="{{ route('customer.bookings', ['status' => 'completed']) }}" class="{{ $currentStatus === 'completed' ? 'btn-yellow' : 'btn-outline' }}" style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
                Completed
            </a>
            <a href="{{ route('customer.bookings', ['status' => 'cancelled']) }}" class="{{ $currentStatus === 'cancelled' ? 'btn-yellow' : 'btn-outline' }}" style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
                Cancelled
            </a>
        </div>

        <form action="{{ route('customer.bookings') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" placeholder="Search by #ID or service..." value="{{ request('search') }}" class="form-input" style="padding: 6px 12px; font-size: 13px; width: 220px; border-radius: 8px;">
            <button type="submit" class="btn-outline" style="padding: 6px 14px; font-size: 13px; border-radius: 8px;">Filter</button>
        </form>
    </div>

    <!-- Bookings Cards List -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        
        @forelse($bookings as $booking)
            <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center; {{ in_array($booking->status, ['pending', 'confirmed', 'en_route', 'in_progress']) ? 'border-left: 5px solid #FFCC00;' : '' }}">
                <img src="{{ asset($booking->professional?->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $booking->professional?->name ?? 'Pro' }}" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                        <strong style="font-size: 17px; color: #111;">{{ $booking->service_title }}</strong>
                        <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px; {{ $booking->status === 'completed' ? 'background: #ECFDF5; color: #047857;' : ($booking->status === 'cancelled' ? 'background: #FEE2E2; color: #B91C1C;' : 'background: #FFF9E6; color: #B45309; border: 1px solid #FFECB3;') }}">
                            {{ $booking->status_label }}
                        </span>
                        @if($booking->arrival_otp && in_array($booking->status, ['pending', 'confirmed', 'en_route']))
                            <span style="background: #EFF6FF; color: #1D4ED8; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px;">
                                OTP: {{ $booking->arrival_otp }}
                            </span>
                        @endif
                    </div>
                    <div style="font-size: 13px; color: #666; margin-bottom: 6px;">
                        Booking <strong>#{{ $booking->booking_number }}</strong> • Assigned to <strong>{{ $booking->professional?->name ?? 'FixMate Pro Team' }}</strong> ({{ $booking->profession?->name ?? 'Specialist' }})
                    </div>
                    <div style="font-size: 12px; color: #888;">
                        Scheduled: {{ $booking->service_date ? $booking->service_date->format('M d, Y') : 'Today' }} • {{ $booking->service_time_slot }} | Address: {{ $booking->service_address }}, {{ $booking->city }}
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                    <strong style="font-size: 16px; color: #047857;">Rs. {{ number_format($booking->total_price) }}</strong>
                    
                    <div style="display: flex; gap: 8px;">
                        @if(in_array($booking->status, ['pending', 'confirmed', 'en_route', 'in_progress']))
                            <a href="{{ route('customer.booking.tracking', $booking->id) }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px; text-decoration: none; border-radius: 8px;">
                                📍 Live Tracking
                            </a>
                            <form action="{{ route('customer.booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel booking #{{ $booking->booking_number }}?');">
                                @csrf
                                <button type="submit" class="btn-outline" style="padding: 7px 12px; font-size: 12px; border-radius: 8px; color: #DC2626; border-color: #FCA5A5; cursor: pointer;">
                                    Cancel
                                </button>
                            </form>
                        @elseif($booking->status === 'completed')
                            <a href="{{ route('customer.reviews') }}" class="btn-yellow" style="padding: 7px 16px; font-size: 12.5px; text-decoration: none; border-radius: 8px;">
                                ⭐ Rate & Review
                            </a>
                        @else
                            <span style="font-size: 12px; color: #9CA3AF; padding: 7px 0;">Cancelled</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="portal-card" style="padding: 48px; text-align: center; background: #FFFFFF;">
                <span style="font-size: 36px; display: block; margin-bottom: 8px;">📋</span>
                <strong style="display: block; font-size: 17px; color: #111; margin-bottom: 6px;">No bookings found</strong>
                <p style="font-size: 13.5px; color: #666; margin-bottom: 20px;">You haven't scheduled any service jobs matching this criteria yet.</p>
                <a href="{{ route('customer.booking') }}" class="btn-yellow" style="padding: 10px 24px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 10px;">
                    Schedule a Service
                </a>
            </div>
        @endforelse

    </div>

    <div style="margin-top: 24px;">
        {{ $bookings->links() }}
    </div>

</div>
@endsection
