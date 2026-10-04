@extends('Frontend.layouts.technician')

@section('title', 'My Jobs & Dispatched Requests — FixMate AI Partner Portal')

@section('content')
<div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Jobs & Dispatches</h1>
            <p style="font-size: 14px; color: #666; margin: 0;">Manage your open incoming requests, active repairs, and completed history.</p>
        </div>

        <form action="{{ route('technician.jobs') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search booking, customer..." class="form-input" style="padding: 8px 14px; font-size: 13px; width: 220px;">
            <button type="submit" class="btn-yellow" style="padding: 8px 16px; font-size: 13px; font-weight: 800;">Search</button>
        </form>
    </div>

    <!-- Tabs: All, Pending, In Progress, Completed -->
    <div style="display: flex; gap: 10px; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; flex-wrap: wrap;">
        <a href="{{ route('technician.jobs', ['tab' => 'all', 'q' => request('q')]) }}" 
           class="{{ $tab === 'all' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
            All Jobs ({{ $allCount }})
        </a>
        <a href="{{ route('technician.jobs', ['tab' => 'pending', 'q' => request('q')]) }}" 
           class="{{ $tab === 'pending' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
            Pending Requests ({{ $pendingCount }})
        </a>
        <a href="{{ route('technician.jobs', ['tab' => 'active', 'q' => request('q')]) }}" 
           class="{{ $tab === 'active' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
            Active / In Progress ({{ $activeCount }})
        </a>
        <a href="{{ route('technician.jobs', ['tab' => 'completed', 'q' => request('q')]) }}" 
           class="{{ $tab === 'completed' ? 'btn-yellow' : 'btn-outline' }}" 
           style="padding: 7px 18px; font-size: 13px; border-radius: 20px; text-decoration: none;">
            Completed ({{ $completedCount }})
        </a>
    </div>

    <!-- Jobs Cards List -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        @forelse($jobs as $job)
            @php
                $payout = (int) round($job->total_price * 0.90);
                $isPending = $job->status === 'pending';
                $cardBg = $isPending ? '#FFFDF0' : '#FFFFFF';
                $border = $isPending ? '2px solid #FFCC00' : '1px solid var(--border-color)';
            @endphp
            
            <div class="portal-card" style="padding: 20px 24px; background: {{ $cardBg }}; border: {{ $border }}; display: grid; grid-template-columns: auto 1fr auto; gap: 20px; align-items: center;">
                <img src="{{ asset($job->problem_image ?: 'assets/images/image_6.png') }}" style="width: 70px; height: 70px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
                
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                        <strong style="font-size: 16px; color: #111;">{{ $job->service_title }} (#{{ $job->booking_number }})</strong>
                        <span style="background: {{ $job->status === 'completed' ? '#ECFDF5' : ($job->status === 'pending' ? '#FEF3C7' : '#EFF6FF') }}; color: {{ $job->status === 'completed' ? '#047857' : ($job->status === 'pending' ? '#92400E' : '#1D4ED8') }}; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px;">
                            {{ $job->status_label }}
                        </span>
                    </div>
                    <div style="font-size: 13px; color: #666; margin-bottom: 4px;">
                        Customer: <strong>{{ $job->user?->name ?? 'Homeowner' }}</strong> &bull; 📍 {{ $job->service_address }}, {{ $job->city }}
                    </div>
                    <div style="font-size: 12px; color: #777; display: flex; gap: 12px; flex-wrap: wrap;">
                        <span>📅 Slot: {{ $job->service_date->format('M d, Y') }} &bull; {{ $job->service_time_slot }}</span>
                        <span style="color: #047857; font-weight: 800;">Est. Payout: Rs. {{ number_format($payout) }}</span>
                        <span>Payment: {{ ucfirst(str_replace('_', ' ', $job->payment_status)) }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px; align-items: center;">
                    <a href="{{ route('technician.jobs.details', $job->booking_number) }}" class="btn-outline" style="padding: 8px 16px; font-size: 13px; text-decoration: none;">
                        Details
                    </a>

                    @if($job->status === 'pending')
                        <form action="{{ route('technician.jobs.accept', $job->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-yellow" style="padding: 8px 18px; font-size: 13px; font-weight: 800; border: none; cursor: pointer;">
                                Accept Job
                            </button>
                        </form>
                    @elseif(in_array($job->status, ['confirmed', 'en_route', 'in_progress']))
                        <a href="{{ route('technician.active-job') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px; text-decoration: none;">
                            Manage Service &rarr;
                        </a>
                    @elseif($job->status === 'completed')
                        <span style="font-size: 12px; color: #059669; font-weight: 700; background: #ECFDF5; padding: 5px 12px; border-radius: 6px;">
                            ✓ Payout Cleared
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="portal-card" style="padding: 44px; text-align: center; background: #FFFFFF;">
                <div style="font-size: 32px; margin-bottom: 10px;">📋</div>
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0 0 6px 0;">No Jobs Found</h3>
                <p style="font-size: 13px; color: #666; margin: 0;">No bookings currently match this filter criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 24px;">
        {{ $jobs->links() }}
    </div>

</div>
@endsection
