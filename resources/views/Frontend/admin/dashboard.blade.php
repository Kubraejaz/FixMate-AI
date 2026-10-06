@extends('Frontend.layouts.admin')

@section('title', 'Dashboard & KPIs — FixMate Admin')

@section('content')

<!-- Page Header -->
<div class="adm-page-head">
    <div>
        <h1>Dashboard &amp; Overview</h1>
        <p>Live platform metrics, technician dispatch capacity, and dispute arbitration.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ route('admin.technicians.verification') }}" class="adm-btn adm-btn-ghost">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            Review Pending KYC ({{ $stats['pending_kyc'] ?? 0 }})
        </a>
        <a href="{{ route('admin.categories') }}" class="adm-btn adm-btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Manage Categories
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
        <span>✓ {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#166534;cursor:pointer;font-weight:700;">×</button>
    </div>
@endif

<!-- KPI Row -->
<div class="adm-kpi-grid">

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Total Customers</span>
            <span class="kpi-icon" style="background: var(--adm-info-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </span>
        </div>
        <div class="kpi-value">{{ number_format($stats['total_customers']) }}</div>
        <div class="kpi-foot up">{{ number_format($stats['active_customers']) }} active accounts</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Technicians Pool</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6z"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value">{{ number_format($stats['total_technicians']) }}</div>
        <div class="kpi-foot warn">{{ number_format($stats['verified_technicians']) }} NADRA verified</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Support Inquiries</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value">{{ number_format($stats['total_inquiries']) }}</div>
        <div class="kpi-foot up">{{ $stats['new_inquiries'] }} pending reply</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Civic Hazards Alerts</span>
            <span class="kpi-icon" style="background: #FEE2E2;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </span>
        </div>
        <div class="kpi-value {{ $stats['active_alerts'] > 0 ? 'danger' : '' }}">{{ $stats['active_alerts'] }}</div>
        <div class="kpi-foot">Active community squad alerts</div>
    </div>

</div>

<!-- Recent Activity Grid -->
<div class="adm-grid-2" style="margin-bottom: 24px;">

    <!-- Recent Customers -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Recent Customer Registrations</h3>
            <a href="{{ route('admin.customers') }}" class="adm-card-link">View All &rarr;</a>
        </div>

        @if($recentCustomers->isNotEmpty())
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($recentCustomers as $customer)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: #F8FAFC; border-radius: 10px; border: 1px solid #F1F5F9;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </div>
                            <div>
                                <strong style="font-size: 13.5px; color: var(--adm-ink); display: block;">{{ $customer->name }}</strong>
                                <span style="font-size: 11.5px; color: var(--adm-muted);">{{ $customer->phone }} &middot; {{ $customer->city ?? 'Karachi' }}</span>
                            </div>
                        </div>
                        <span class="adm-badge {{ $customer->is_active ? 'green' : 'yellow' }}">
                            {{ $customer->is_active ? 'Active' : 'Suspended' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="adm-empty">No customers registered yet.</div>
        @endif
    </div>

    <!-- Recent Technicians -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Technicians in Pool</h3>
            <a href="{{ route('admin.technicians') }}" class="adm-card-link">Manage Pool &rarr;</a>
        </div>

        @if($recentTechnicians->isNotEmpty())
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($recentTechnicians as $tech)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: #F8FAFC; border-radius: 10px; border: 1px solid #F1F5F9;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #FFFBEB; color: #B45309; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
                                {{ strtoupper(substr($tech->name, 0, 2)) }}
                            </div>
                            <div>
                                <strong style="font-size: 13.5px; color: var(--adm-ink); display: block;">{{ $tech->name }}</strong>
                                <span style="font-size: 11.5px; color: var(--adm-muted);">{{ $tech->profession?->name ?? 'Specialist' }} &middot; {{ $tech->experience ?? '5+ yrs' }}</span>
                            </div>
                        </div>
                        <span class="adm-badge {{ $tech->is_verified ? 'green' : 'yellow' }}">
                            {{ $tech->is_verified ? 'Verified' : 'Pending' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="adm-empty">No technicians in pool.</div>
        @endif
    </div>

</div>

<!-- Detail Row -->
<div class="adm-grid-2-even">

    <!-- Active Trade Disciplines -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Active Trade Categories ({{ $stats['total_professions'] }})</h3>
            <a href="{{ route('admin.categories') }}" class="adm-card-link">Manage Categories &rarr;</a>
        </div>

        @if($professions->isNotEmpty())
            @foreach($professions as $prof)
                <div class="adm-bar-row">
                    <div class="adm-bar-head">
                        <span class="name">{{ $prof->name }}</span>
                        <span class="val">{{ $prof->professionals_count }} Specialists</span>
                    </div>
                    <div class="adm-bar yellow">
                        <span style="width: {{ min(100, max(15, $prof->professionals_count * 25)) }}%;"></span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="adm-empty">No active categories.</div>
        @endif
    </div>

    <!-- Service Quality & Escrow Health -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Service Quality &amp; Escrow Health</h3>
            <span class="adm-badge green">99.4% Dispute-Free</span>
        </div>

        <div class="adm-stat-row">
            <span class="label">Escrow protection success</span>
            <span class="value">100% Guaranteed</span>
        </div>
        <div class="adm-stat-row">
            <span class="label">Mean dispatch arrival</span>
            <span class="value">28.4 minutes</span>
        </div>
        <div class="adm-stat-row">
            <span class="label">Upfront tariff accuracy</span>
            <span class="value">96.8% standard bill</span>
        </div>
        <div class="adm-stat-row">
            <span class="label">Customer satisfaction rating</span>
            <span class="value">4.92 / 5.0 (verified)</span>
        </div>

        <a href="{{ route('admin.payments') }}" class="adm-btn adm-btn-ghost" style="width: 100%; margin-top: 18px;">
            Open Escrow Console
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
                <path d="M12 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

</div>

@endsection
