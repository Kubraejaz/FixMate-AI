
@extends('Frontend.layouts.technician')

@section('title', 'Customer Reviews & Reputation — FixMate AI Partner Portal')

@section('content')

<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; flex-wrap: wrap; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px; letter-spacing: -0.02em;">Customer Reviews & Feedback</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Verified ratings and testimonials received from customers upon job completion.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('technician.profile') }}" class="btn-outline" style="font-size: 13px; padding: 9px 16px; text-decoration: none;">
            Partner Profile &rarr;
        </a>
        <a href="{{ route('technician.jobs') }}" class="btn-yellow" style="font-size: 13px; padding: 9px 18px; text-decoration: none; font-weight: 800;">
            View Job Requests
        </a>
    </div>
</div>

<!-- Rating Summary Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">

    <!-- Average Rating -->
    <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Average Rating</span>
        <div style="display: flex; align-items: baseline; gap: 8px; margin-top: 6px;">
            <strong style="font-size: 28px; font-weight: 900; color: #111; line-height: 1;">
                {{ $totalReviews > 0 ? number_format($avgRating, 1) : '0.0' }}
            </strong>
            <span style="font-size: 15px;">
                @if($totalReviews > 0)
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= round($avgRating) ? '#FFCC00' : '#E5E7EB' }};">★</span>
                    @endfor
                @else
                    <span style="color: #D1D5DB;">☆☆☆☆☆</span>
                @endif
            </span>
        </div>
        <span style="font-size: 11.5px; color: {{ $totalReviews > 0 ? '#059669' : '#888' }}; font-weight: 700; display: block; margin-top: 4px;">
            {{ $totalReviews > 0 ? 'Verified Customer Average' : 'New Partner — No ratings yet' }}
        </span>
    </div>

    <!-- Total Reviews -->
    <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Total Reviews</span>
        <strong style="display: block; font-size: 28px; font-weight: 900; color: #111; margin-top: 6px; line-height: 1;">
            {{ $totalReviews }}
        </strong>
        <span style="font-size: 11.5px; color: {{ $totalReviews > 0 ? '#10B981' : '#6B7280' }}; font-weight: 700;">
            {{ $totalReviews > 0 ? 'Verified Feedback Received' : '0 Reviews Recorded' }}
        </span>
    </div>

    <!-- Public Reply Rate -->
    <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Public Reply Rate</span>
        <strong style="display: block; font-size: 28px; font-weight: 900; color: #111; margin-top: 6px; line-height: 1;">
            {{ $totalReviews > 0 ? $replyRate . '%' : '—' }}
        </strong>
        <span style="font-size: 11.5px; color: #B45309; font-weight: 700;">
            {{ $totalReviews > 0 ? 'Technician Responses' : 'No reviews to reply' }}
        </span>
    </div>

    <!-- Customer Satisfaction -->
    <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Customer Satisfaction</span>
        <strong style="display: block; font-size: 28px; font-weight: 900; color: #111; margin-top: 6px; line-height: 1;">
            {{ $totalReviews > 0 ? $satisfactionRate . '%' : '—' }}
        </strong>
        <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">
            {{ $totalReviews > 0 ? '4 & 5 Star Ratings' : 'Awaiting initial jobs' }}
        </span>
    </div>

</div>

<div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start;">

    <!-- Left: Star Distribution & Verification Status -->
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <!-- Star Distribution -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                <strong style="font-size: 15px; color: #111;">Rating Breakdown</strong>
                <span style="font-size: 12px; color: #888;">{{ $totalReviews }} total</span>
            </div>

            @foreach ($distribution as $star => $row)
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                <span style="font-size: 12.5px; font-weight: 700; color: #4B5563; width: 34px;">{{ $star }} ★</span>
                <div style="flex: 1; height: 8px; background: #F3F4F6; border-radius: 9999px; overflow: hidden;">
                    <div style="width: {{ $row['pct'] }}%; height: 100%; background: #FFCC00; border-radius: 9999px; transition: width 0.3s ease;"></div>
                </div>
                <span style="font-size: 12px; color: #6B7280; width: 44px; text-align: right; font-weight: 600;">
                    {{ $row['count'] }} <span style="font-size: 10.5px; color: #9CA3AF;">({{ $row['pct'] }}%)</span>
                </span>
            </div>
            @endforeach
        </div>

        <!-- Rating Guidelines / Category Insights -->
        <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
            <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 6px;">Quality Performance Standards</strong>
            <p style="font-size: 12.5px; color: #666; margin: 0 0 16px; line-height: 1.5;">
                FixMate AI monitors customer satisfaction scores to boost your placement in nearby instant dispatches.
            </p>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12.5px;">
                    <span style="color: #4B5563;">Punctuality &amp; Arrival</span>
                    <strong style="color: #111;">{{ $totalReviews > 0 ? number_format($avgRating, 1) : '—' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12.5px;">
                    <span style="color: #4B5563;">Workmanship Quality</span>
                    <strong style="color: #111;">{{ $totalReviews > 0 ? number_format($avgRating, 1) : '—' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12.5px;">
                    <span style="color: #4B5563;">Cleanliness &amp; Safety</span>
                    <strong style="color: #111;">{{ $totalReviews > 0 ? number_format($avgRating, 1) : '—' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12.5px;">
                    <span style="color: #4B5563;">Clear Communication</span>
                    <strong style="color: #111;">{{ $totalReviews > 0 ? number_format($avgRating, 1) : '—' }}</strong>
                </div>
            </div>
        </div>

    </div>

    <!-- Right: Review List -->
    <div>

        <!-- Filter Tabs -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
            <a href="{{ route('technician.reviews', ['filter' => 'all']) }}" 
               class="{{ $filter === 'all' ? 'btn-yellow' : 'btn-outline' }}" 
               style="padding: 7px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; text-decoration: none;">
                All Reviews ({{ $totalReviews }})
            </a>
            <a href="{{ route('technician.reviews', ['filter' => '5']) }}" 
               class="{{ $filter === '5' ? 'btn-yellow' : 'btn-outline' }}" 
               style="padding: 7px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; text-decoration: none;">
                5 ★ Only ({{ $distribution[5]['count'] ?? 0 }})
            </a>
            <a href="{{ route('technician.reviews', ['filter' => 'low']) }}" 
               class="{{ in_array($filter, ['low', '4']) ? 'btn-yellow' : 'btn-outline' }}" 
               style="padding: 7px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; text-decoration: none;">
                4 ★ &amp; Below ({{ ($distribution[4]['count'] ?? 0) + ($distribution[3]['count'] ?? 0) + ($distribution[2]['count'] ?? 0) + ($distribution[1]['count'] ?? 0) }})
            </a>
        </div>

        @forelse ($reviews as $rev)
            @php
                $rStars = (int) $rev->rating;
                $userName = $rev->user?->name ?? 'Verified Homeowner';
                $userInitial = strtoupper(substr($userName, 0, 1));
                $userImg = $rev->user?->profile_image;
            @endphp
            <div class="portal-card" style="padding: 22px 24px; margin-bottom: 16px; background: #FFFFFF; border: 1px solid var(--border-color); border-radius: 14px;">

                <div style="display: flex; gap: 14px; margin-bottom: 14px;">
                    @if($userImg)
                        <img src="{{ asset($userImg) }}" alt="{{ $userName }}" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #FFCC00;">
                    @else
                        <div style="width: 46px; height: 46px; border-radius: 50%; background: #FEF3C7; color: #92400E; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; flex-shrink: 0; border: 2px solid #FFCC00;">
                            {{ $userInitial }}
                        </div>
                    @endif

                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; gap: 10px; flex-wrap: wrap;">
                            <strong style="font-size: 15px; color: #111;">{{ $userName }}</strong>
                            <span style="font-size: 12px; color: #999;">{{ $rev->created_at->format('d M Y') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 3px; flex-wrap: wrap;">
                            <span style="color: #FFCC00; font-size: 15px; letter-spacing: 1px;">
                                {{ str_repeat('★', $rStars) }}<span style="color: #E5E7EB;">{{ str_repeat('★', max(0, 5 - $rStars)) }}</span>
                            </span>
                            @if($rev->booking)
                                <span style="font-size: 11.5px; color: #6B7280;">
                                    Booking #{{ $rev->booking->booking_number }} &bull; {{ $rev->booking->service_title }}
                                </span>
                            @else
                                <span style="font-size: 11.5px; color: #6B7280;">Verified Platform Service</span>
                            @endif
                        </div>
                    </div>
                </div>

                <p style="font-size: 14px; color: #374151; line-height: 1.6; margin: 0 0 14px; background: #F9FAFB; padding: 12px 16px; border-radius: 8px; border: 1px solid #F3F4F6;">
                    {{ $rev->comment }}
                </p>

                <!-- Public Reply Section -->
                @if ($rev->technician_reply)
                    <div style="background: #FFFDF0; border-left: 3px solid #FFCC00; border-radius: 0 10px 10px 0; padding: 12px 16px; margin-bottom: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px;">
                            <span style="font-size: 11px; font-weight: 800; color: #B45309; text-transform: uppercase; letter-spacing: 0.04em;">Your Public Response</span>
                            <span style="font-size: 11px; color: #9CA3AF;">{{ $rev->technician_replied_at ? $rev->technician_replied_at->format('d M Y') : '' }}</span>
                        </div>
                        <p style="font-size: 13px; color: #4B5563; line-height: 1.6; margin: 0;">{{ $rev->technician_reply }}</p>
                    </div>
                @else
                    <button type="button" class="btn-yellow" onclick="toggleReplyBox({{ $rev->id }})" style="padding: 7px 16px; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px;">
                        <span>💬</span>
                        <span>Reply to Customer</span>
                    </button>

                    <!-- Reply Form -->
                    <div id="replyBox-{{ $rev->id }}" style="display: none; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border-color);">
                        <form action="{{ route('technician.reviews.reply', $rev->id) }}" method="POST">
                            @csrf
                            <label class="form-label" style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block;">Your Public Response</label>
                            <textarea name="reply" required rows="3" class="form-input" style="width: 100%; padding: 10px 12px; font-size: 13.5px;" placeholder="Thank the client for their feedback or address their points. Visible on your public partner profile."></textarea>
                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                <button type="submit" class="btn-yellow" style="padding: 8px 18px; font-size: 13px; font-weight: 800; border: none; cursor: pointer; border-radius: 6px;">
                                    Publish Reply
                                </button>
                                <button type="button" class="btn-outline" onclick="toggleReplyBox({{ $rev->id }})" style="padding: 8px 16px; font-size: 13px; border-radius: 6px;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>
        @empty
            <div class="portal-card" style="padding: 56px 28px; text-align: center; background: #FFFFFF; border-radius: 16px;">
                <div style="font-size: 42px; margin-bottom: 12px;">⭐</div>
                <h3 style="font-size: 19px; font-weight: 900; color: #111; margin: 0 0 8px 0;">No Customer Reviews Yet</h3>
                <p style="font-size: 14px; color: #666; max-width: 480px; margin: 0 auto 22px auto; line-height: 1.6;">
                    As you accept and complete service dispatches on FixMate AI, customer feedback and ratings will appear here dynamically in real-time.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('technician.jobs') }}" class="btn-yellow" style="padding: 10px 22px; font-size: 13.5px; font-weight: 800; text-decoration: none; border-radius: 8px;">
                        Browse Available Dispatches &rarr;
                    </a>
                    <a href="{{ route('technician.profile') }}" class="btn-outline" style="padding: 10px 20px; font-size: 13.5px; text-decoration: none; border-radius: 8px;">
                        Complete Partner Profile
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div style="margin-top: 24px;">
                {{ $reviews->links() }}
            </div>
        @endif

    </div>

</div>

<script>
    function toggleReplyBox(id) {
        var el = document.getElementById('replyBox-' + id);
        if (el) {
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
    }
</script>

@endsection
