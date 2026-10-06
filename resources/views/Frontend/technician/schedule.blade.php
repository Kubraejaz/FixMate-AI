@extends('Frontend.layouts.technician')

@section('title', 'Weekly Schedule & Calendar — FixMate Partner Portal')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Schedule &amp; Bookings</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">View your scheduled appointments and active service dispatches.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <span style="background: #ECFDF5; color: #047857; font-weight: 800; font-size: 12px; padding: 6px 14px; border-radius: 20px; border: 1px solid #A7F3D0;">
                Today: {{ now()->format('l, M d') }}
            </span>
        </div>
    </div>

    <!-- Day Schedule Timeline Card -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 20px;">
            Upcoming Service Appointments ({{ $upcomingJobs->count() }})
        </h3>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($upcomingJobs as $job)
                @php
                    $isToday = $job->service_date->isToday();
                    $bgColor = $isToday ? '#FFFDF0' : '#FFFFFF';
                    $borderColor = $isToday ? '#FDE68A' : 'var(--border-color)';
                @endphp
                
                <div style="display: grid; grid-template-columns: 120px 1fr auto; gap: 20px; align-items: center; border: 1px solid {{ $borderColor }}; background: {{ $bgColor }}; border-radius: 12px; padding: 16px 18px;">
                    <div>
                        <strong style="font-size: 13px; color: #111; display: block;">{{ $job->service_date->format('M d, Y') }}</strong>
                        <span style="font-size: 11.5px; color: #666;">{{ $job->service_time_slot }}</span>
                    </div>

                    <div>
                        <strong style="font-size: 15px; color: #111; display: block; margin-bottom: 2px;">
                            {{ $job->service_title }} (#{{ $job->booking_number }})
                        </strong>
                        <span style="font-size: 12.5px; color: #555;">
                            Customer: <strong>{{ $job->user?->name }}</strong> &bull; 📍 {{ $job->service_address }}, {{ $job->city }}
                        </span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="background: {{ $job->status === 'completed' ? '#ECFDF5' : ($job->status === 'in_progress' ? '#FEF3C7' : '#EFF6FF') }}; color: {{ $job->status === 'completed' ? '#047857' : ($job->status === 'in_progress' ? '#92400E' : '#1D4ED8') }}; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 8px;">
                            {{ $job->status_label }}
                        </span>

                        @if(in_array($job->status, ['confirmed', 'en_route', 'in_progress']))
                            <a href="{{ route('technician.active-job') }}" class="btn-yellow" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">
                                Active Job &rarr;
                            </a>
                        @else
                            <a href="{{ route('technician.jobs.details', $job->booking_number) }}" class="btn-outline" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">
                                Details
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div style="padding: 36px; text-align: center; color: #888;">
                    <div style="font-size: 32px; margin-bottom: 8px;">📅</div>
                    <p style="margin: 0; font-size: 13.5px;">No upcoming service appointments scheduled. Open job requests will show here when accepted.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
