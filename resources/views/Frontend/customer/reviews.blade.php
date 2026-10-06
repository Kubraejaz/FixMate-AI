@extends('Frontend.layouts.customer')

@section('title', 'Rate & Review Services — FixMate')

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Service Ratings & Reviews</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Rate your completed home repair services and help maintain top quality standards.</p>
    </div>

    @if ($errors->any())
        <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 1. Completed Bookings Awaiting Review -->
    @php
        $pendingReviews = $completedBookings->filter(fn($b) => ! $b->review);
    @endphp

    @if($pendingReviews->isNotEmpty())
        <div style="margin-bottom: 32px;">
            <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 14px;">Completed Services Awaiting Your Feedback</h3>
            
            <div style="display: flex; flex-direction: column; gap: 18px;">
                @foreach($pendingReviews as $booking)
                    <div class="portal-card" style="padding: 24px; background: #FFFFFF; border-radius: 16px; border-top: 4px solid #FFCC00;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="{{ asset($booking->professional?->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $booking->professional?->name ?? 'Pro' }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                                <div>
                                    <strong style="display: block; font-size: 15px; color: #111;">{{ $booking->service_title }}</strong>
                                    <span style="font-size: 12px; color: #666;">Completed by <strong>{{ $booking->professional?->name ?? 'Technician' }}</strong> • Booking #{{ $booking->booking_number }}</span>
                                </div>
                            </div>
                            <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px;">Completed</span>
                        </div>

                        <form action="{{ route('customer.review.store', $booking->id) }}" method="POST">
                            @csrf

                            <div style="margin-bottom: 16px;">
                                <label style="font-size: 13px; font-weight: 700; color: #374151; display: block; margin-bottom: 8px;">Select Star Rating</label>
                                <div style="display: flex; gap: 14px; font-size: 14px;">
                                    @for($i = 5; $i >= 1; $i--)
                                        <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; border: 1px solid var(--border-color); padding: 6px 12px; border-radius: 8px;">
                                            <input type="radio" name="rating" value="{{ $i }}" {{ $i === 5 ? 'checked' : '' }} style="accent-color: #FFCC00;">
                                            <span style="color: #F59E0B; font-weight: 700;">{{ str_repeat('★', $i) }} ({{ $i }})</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 16px;">
                                <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Share Your Review</label>
                                <textarea name="comment" class="form-input" rows="3" required placeholder="How was the punctuality, cleanliness and quality of the repair?" style="padding: 10px 12px; font-size: 13.5px;"></textarea>
                            </div>

                            <button type="submit" class="btn-yellow" style="padding: 9px 24px; font-size: 13px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 2. Past Reviews List -->
    <div>
        <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 14px;">My Submitted Reviews ({{ $myReviews->count() }})</h3>

        @forelse($myReviews as $rev)
            <div class="portal-card" style="padding: 20px; background: #FFFFFF; border-radius: 14px; margin-bottom: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <strong style="font-size: 14.5px; color: #111;">{{ $rev->booking?->service_title ?? 'Verified Service' }}</strong>
                            <span style="font-size: 12px; color: #F59E0B;">{{ str_repeat('★', $rev->rating) }}</span>
                        </div>
                        <span style="font-size: 12px; color: #777;">Pro: {{ $rev->professional?->name ?? 'FixMate Professional' }} • {{ $rev->created_at->format('M d, Y') }}</span>
                    </div>
                    <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 7px; border-radius: 8px;">Verified</span>
                </div>
                <p style="font-size: 13.5px; color: #4B5563; margin: 0; line-height: 1.5;">
                    "{{ $rev->comment }}"
                </p>
            </div>
        @empty
            <div class="portal-card" style="padding: 36px; text-align: center; background: #FFFFFF; border-radius: 14px;">
                <span style="font-size: 32px; display: block; margin-bottom: 6px;">⭐</span>
                <strong style="display: block; font-size: 15px; color: #111; margin-bottom: 4px;">No reviews submitted yet</strong>
                <span style="font-size: 13px; color: #666;">Once your booked services are marked as completed by technicians, you can rate and review them here.</span>
            </div>
        @endforelse
    </div>

</div>
@endsection
