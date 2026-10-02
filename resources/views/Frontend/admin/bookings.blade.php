@extends('Frontend.layouts.admin')

@section('title', 'All Bookings & Dispatches — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>All Platform Bookings</h1>
        <p>{{ $totalBookingsCount }} live dispatches &middot; Rs. {{ number_format($escrowHeldAmount) }} currently held in Escrow Protection.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ route('admin.payments') }}" class="adm-btn adm-btn-ghost">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2.5"></rect>
                <path d="M2 10h20"></path>
            </svg>
            Escrow Console (Rs. {{ number_format($escrowHeldAmount) }})
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="adm-card" style="padding: 14px 18px; margin-bottom: 18px;">
    <form method="GET" action="{{ route('admin.bookings') }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <input type="text" name="q" value="{{ request('q') }}" class="adm-input" style="flex: 1; min-width: 220px;" placeholder="Filter by Booking #FM, customer, technician, or trade...">
        
        <select name="status" class="adm-select" style="width: 180px;" onchange="this.form.submit()">
            <option value="all">All Statuses</option>
            <option value="en_route" {{ request('status') === 'en_route' ? 'selected' : '' }}>En Route</option>
            <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="disputed" {{ request('status') === 'disputed' ? 'selected' : '' }}>Disputed</option>
        </select>

        <select name="city" class="adm-select" style="width: 160px;" onchange="this.form.submit()">
            <option value="all">All Cities</option>
            <option value="Karachi" {{ request('city') === 'Karachi' ? 'selected' : '' }}>Karachi</option>
            <option value="Lahore" {{ request('city') === 'Lahore' ? 'selected' : '' }}>Lahore</option>
            <option value="Islamabad" {{ request('city') === 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
        </select>

        <button type="submit" class="adm-btn adm-btn-primary">Apply</button>
        @if(request()->hasAny(['q', 'status', 'city']))
            <a href="{{ route('admin.bookings') }}" class="adm-btn adm-btn-ghost">Reset</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Customer</th>
                    <th>Technician</th>
                    <th>Trade / Service</th>
                    <th>City / Area</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                    <tr>
                        <td><strong>#{{ $b['id'] }}</strong></td>
                        <td>{{ $b['customer_name'] }}</td>
                        <td>{{ $b['technician_name'] }}</td>
                        <td>{{ $b['service_title'] }}</td>
                        <td>{{ $b['city'] }}</td>
                        <td>
                            <span class="adm-badge {{ $b['status_badge'] }}">
                                {{ $b['status_label'] }}
                            </span>
                        </td>
                        <td><strong>Rs. {{ number_format($b['amount']) }}</strong></td>
                        <td style="text-align: right;">
                            @if($b['status'] === 'disputed')
                                <a href="{{ route('admin.inquiries') }}" class="adm-card-link" style="color: #E11D48; font-weight: 700;">Arbitrate &rarr;</a>
                            @else
                                <span style="font-size: 12px; color: var(--adm-muted);">{{ $b['created_at'] }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 36px; color: var(--adm-muted);">
                            No bookings match the filter criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
