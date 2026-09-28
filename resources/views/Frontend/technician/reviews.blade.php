@extends('Frontend.layouts.technician')

@section('title', 'Customer Reviews — FixMate AI')

@section('content')

@php
    $distribution = [
        5 => ['count' => 98, 'pct' => 77],
        4 => ['count' => 18, 'pct' => 14],
        3 => ['count' => 7,  'pct' => 6],
        2 => ['count' => 2,  'pct' => 2],
        1 => ['count' => 2,  'pct' => 1],
    ];

    $categories = [
        'Punctuality & Arrival'   => 4.9,
        'Workmanship Quality'     => 4.8,
        'Cleanliness & Tidiness'  => 4.9,
        'Communication'           => 4.7,
        'Value for Money'         => 4.6,
    ];

    $reviews = [
        [
            'name'  => 'Ahmed Raza',
            'img'   => 'image_1.png',
            'date'  => '2 Oct 2025',
            'job'   => 'FM-10245',
            'task'  => 'Kitchen Sink Leak — P-trap Replacement',
            'stars' => 5,
            'text'  => 'Ali bhai arrived ten minutes early and had the replacement P-trap fitted within the hour. He cleaned up the cabinet area afterwards, which I really appreciated. Already booked him for the bedroom heater.',
            'reply' => null,
        ],
        [
            'name'  => 'Sana Malik',
            'img'   => 'image_3.png',
            'date'  => '28 Sep 2025',
            'job'   => 'FM-10188',
            'task'  => 'Split AC Not Cooling — Gas Refill',
            'stars' => 5,
            'text'  => 'Diagnosed a low gas issue within ten minutes and explained the price before starting. Very transparent about what was included in the service charge.',
            'reply' => null,
        ],
        [
            'name'  => 'Bilal Ahmed',
            'img'   => 'image_5.png',
            'date'  => '21 Sep 2025',
            'job'   => 'FM-10102',
            'task'  => 'Bathroom Wall Water Ingress',
            'stars' => 4,
            'text'  => 'Solid work sealing the grout lines, though the visit ran about half an hour over the booked window. Fixed the leak properly and showed me the moisture reading afterwards.',
            'reply' => 'Apologies for the delay on this one, Bilal. The previous job overran and I should have called ahead to let you know. The moisture reading is holding steady at 12%, so the ingress is resolved.',
        ],
        [
            'name'  => 'Hina Kausar',
            'img'   => 'image_2.png',
            'date'  => '14 Sep 2025',
            'job'   => 'FM-10044',
            'task'  => 'Main Supply Line Leak',
            'stars' => 5,
            'text'  => 'Late night emergency call and Ali still responded within the hour. Genuinely saved us from a flooded kitchen. Cannot recommend him enough.',
            'reply' => null,
        ],
        [
            'name'  => 'Usman Tariq',
            'img'   => 'image_6.png',
            'date'  => '3 Sep 2025',
            'job'   => 'FM-9987',
            'task'  => 'Ceiling Fan Replacement',
            'stars' => 2,
            'text'  => 'The fitting itself was fine, but he did not bring the mounting bracket I had confirmed over the phone and had to source one locally, which added an extra charge.',
            'reply' => null,
        ],
    ];
@endphp

<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; flex-wrap: wrap; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 24px; font-weight: 900; color: #111; margin-bottom: 4px; letter-spacing: -0.02em;">Customer Reviews</h1>
        <p style="font-size: 13.5px; color: #666; margin: 0;">What your customers said after each completed job.</p>
    </div>
    <a href="{{ url('/technicians/ali-khan') }}" class="btn-outline" style="font-size: 13px; padding: 9px 16px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
        View Public Profile
    </a>
</div>

<!-- Rating Summary Row -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">

    <div class="portal-card" style="padding: 20px;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Average Rating</span>
        <div style="display: flex; align-items: baseline; gap: 6px; margin-top: 6px;">
            <strong style="font-size: 28px; font-weight: 900; color: #111; line-height: 1;">4.8</strong>
            <span style="color: #FFCC00; font-size: 15px;">★★★★★</span>
        </div>
    </div>

    <div class="portal-card" style="padding: 20px;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Total Reviews</span>
        <strong style="display: block; font-size: 28px; font-weight: 900; color: #111; margin-top: 6px; line-height: 1;">127</strong>
        <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">+14 this month</span>
    </div>

    <div class="portal-card" style="padding: 20px;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Reply Rate</span>
        <strong style="display: block; font-size: 28px; font-weight: 900; color: #111; margin-top: 6px; line-height: 1;">82%</strong>
        <span style="font-size: 11.5px; color: #B45309; font-weight: 700;">3 awaiting reply</span>
    </div>

    <div class="portal-card" style="padding: 20px;">
        <span style="font-size: 11px; font-weight: 800; color: #9CA3AF; text-transform: uppercase;">Repeat Customers</span>
        <strong style="display: block; font-size: 28px; font-weight: 900; color: #111; margin-top: 6px; line-height: 1;">64%</strong>
        <span style="font-size: 11.5px; color: #10B981; font-weight: 700;">Top 10% in your area</span>
    </div>

</div>

<div style="display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start;">

    <!-- Left: Rating Breakdown -->
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <!-- Star Distribution -->
        <div class="portal-card" style="padding: 24px;">
            <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 16px;">Rating Breakdown</strong>

            @foreach ($distribution as $star => $row)
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 9px;">
                <span style="font-size: 12px; font-weight: 700; color: #555; width: 34px;">{{ $star }} ★</span>
                <div style="flex: 1; height: 8px; background: #F3F4F6; border-radius: 9999px; overflow: hidden;">
                    <div style="width: {{ $row['pct'] }}%; height: 100%; background: #FFCC00; border-radius: 9999px;"></div>
                </div>
                <span style="font-size: 11.5px; color: #888; width: 40px; text-align: right;">{{ $row['count'] }}</span>
            </div>
            @endforeach
        </div>

        <!-- Category Scores -->
        <div class="portal-card" style="padding: 24px;">
            <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 4px;">Category Scores</strong>
            <p style="font-size: 12px; color: #888; margin: 0 0 16px;">Based on the 31 most recent detailed ratings.</p>

            @foreach ($categories as $label => $score)
            <div style="margin-bottom: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 5px;">
                    <span style="font-size: 12.5px; color: #4B5563; font-weight: 600;">{{ $label }}</span>
                    <strong style="font-size: 12.5px; color: #111;">{{ number_format($score, 1) }}</strong>
                </div>
                <div style="height: 6px; background: #F3F4F6; border-radius: 9999px; overflow: hidden;">
                    <div style="width: {{ ($score / 5) * 100 }}%; height: 100%; background: #10B981; border-radius: 9999px;"></div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    <!-- Right: Review List -->
    <div>

        <!-- Filter Tabs -->
        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 18px;">
            <button type="button" class="rev-filter active" data-filter="all"
                style="padding: 7px 14px; border-radius: 9999px; border: 1px solid #111; background: #111; color: #fff; font-size: 12.5px; font-weight: 700; cursor: pointer;">All Reviews</button>
            <button type="button" class="rev-filter" data-filter="unreplied"
                style="padding: 7px 14px; border-radius: 9999px; border: 1px solid var(--border-subtle); background: #fff; color: #555; font-size: 12.5px; font-weight: 700; cursor: pointer;">Needs Reply (3)</button>
            <button type="button" class="rev-filter" data-filter="5"
                style="padding: 7px 14px; border-radius: 9999px; border: 1px solid var(--border-subtle); background: #fff; color: #555; font-size: 12.5px; font-weight: 700; cursor: pointer;">5 ★</button>
            <button type="button" class="rev-filter" data-filter="low"
                style="padding: 7px 14px; border-radius: 9999px; border: 1px solid var(--border-subtle); background: #fff; color: #555; font-size: 12.5px; font-weight: 700; cursor: pointer;">3 ★ &amp; Below</button>
        </div>

        @foreach ($reviews as $rev)
        <div class="rev-item portal-card"
             data-stars="{{ $rev['stars'] }}"
             data-replied="{{ $rev['reply'] ? '1' : '0' }}"
             style="padding: 22px; margin-bottom: 16px;">

            <div style="display: flex; gap: 14px; margin-bottom: 14px;">
                <img src="{{ asset('assets/images/' . $rev['img']) }}" alt="{{ $rev['name'] }}"
                     style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid #FFCC00;">

                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; gap: 10px; flex-wrap: wrap;">
                        <strong style="font-size: 14.5px; color: #111;">{{ $rev['name'] }}</strong>
                        <span style="font-size: 11.5px; color: #999;">{{ $rev['date'] }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 3px; flex-wrap: wrap;">
                        <span style="color: {{ $rev['stars'] >= 4 ? '#FFCC00' : '#F59E0B' }}; font-size: 15px; letter-spacing: 1px;">
                            {{ str_repeat('★', $rev['stars']) }}<span style="color: #E5E7EB;">{{ str_repeat('★', 5 - $rev['stars']) }}</span>
                        </span>
                        <span style="font-size: 11.5px; color: #888;">Job {{ $rev['job'] }} &bull; {{ $rev['task'] }}</span>
                    </div>
                </div>
            </div>

            <p style="font-size: 13.5px; color: #374151; line-height: 1.65; margin: 0 0 14px;">{{ $rev['text'] }}</p>

            @if ($rev['reply'])
                <div style="background: #F9FAFB; border-left: 3px solid #FFCC00; border-radius: 0 10px 10px 0; padding: 12px 16px; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; color: #B45309; text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 4px;">Your Reply</span>
                    <p style="font-size: 13px; color: #4B5563; line-height: 1.6; margin: 0;">{{ $rev['reply'] }}</p>
                </div>
                <a href="{{ url('/technician/messages') }}" class="btn-outline" style="padding: 7px 14px; font-size: 12.5px;">View Conversation</a>
            @else
                <button type="button" class="rev-reply-btn btn-yellow" style="padding: 7px 16px; font-size: 12.5px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                    Reply Publicly
                </button>
            @endif

            <!-- Reply form (hidden) -->
            <div class="rev-reply-form" style="display: none; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border-color);">
                <label class="form-label" style="margin-bottom: 6px;">Your Public Reply</label>
                <textarea class="form-input" rows="3" placeholder="Thank them or address their concern. This reply is visible on your public profile."></textarea>
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn-yellow" style="padding: 9px 20px; font-size: 13px;">Post Reply</button>
                    <button type="button" class="rev-cancel btn-outline" style="padding: 9px 18px; font-size: 13px;">Cancel</button>
                </div>
            </div>

        </div>
        @endforeach

        <p style="text-align: center; font-size: 12.5px; color: #999; margin: 20px 0 0;">Showing the 5 most recent of 127 reviews.</p>

    </div>

</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.rev-filter').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = btn.dataset.filter;

            document.querySelectorAll('.rev-filter').forEach(function (b) {
                const on = b === btn;
                b.classList.toggle('active', on);
                b.style.background = on ? '#111111' : '#FFFFFF';
                b.style.color = on ? '#FFFFFF' : '#555555';
                b.style.borderColor = on ? '#111111' : 'var(--border-subtle)';
            });

            document.querySelectorAll('.rev-item').forEach(function (item) {
                const stars = item.dataset.stars;
                const replied = item.dataset.replied;
                let show = true;
                if (filter === 'unreplied') show = replied === '0';
                else if (filter === '5') show = stars === '5';
                else if (filter === 'low') show = parseInt(stars, 10) <= 3;
                item.style.display = show ? '' : 'none';
            });
        });
    });

    document.querySelectorAll('.rev-reply-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = btn.closest('.rev-item').querySelector('.rev-reply-form');
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
            if (form.style.display === 'block') form.querySelector('textarea').focus();
        });
    });

    document.querySelectorAll('.rev-cancel').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.rev-reply-form').style.display = 'none';
        });
    });
</script>
@endsection
