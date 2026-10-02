@extends('Frontend.layouts.admin')

@section('title', 'Growth & Recommendation Analytics — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Recommendation &amp; AI Matching Analytics</h1>
        <p>Performance of computer vision diagnostics, technician matching, and conversion.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge yellow">Average matching score 91.4%</span>
    </div>
</div>

<!-- Funnel KPIs -->
<div class="adm-kpi-grid" style="grid-template-columns: repeat(4, minmax(0, 1fr));">

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Registered Customers</span>
            <span class="kpi-icon" style="background: var(--adm-info-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </span>
        </div>
        <div class="kpi-value">{{ number_format($totalCustomers) }}</div>
        <div class="kpi-foot up">Platform consumer base</div>
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
        <div class="kpi-value">{{ number_format($totalTechnicians) }}</div>
        <div class="kpi-foot">{{ $verifiedTechnicians }} NADRA verified</div>
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
        <div class="kpi-value">{{ number_format($totalInquiries) }}</div>
        <div class="kpi-foot up">Tickets managed</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Civic Hazards Resolved</span>
            <span class="kpi-icon" style="background: #FEE2E2;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value accent">{{ number_format($resolvedIssues) }}</div>
        <div class="kpi-foot up">Resolved community dispatches</div>
    </div>

</div>

<!-- Two Columns -->
<div class="adm-grid-2">

    <!-- Active Trade Disciplines Capacity -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Specialist Capacity by Trade Discipline</h3>
            <a href="{{ route('admin.categories') }}" class="adm-card-link">Categories &rarr;</a>
        </div>

        @foreach($professions as $prof)
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--adm-border-soft);">
                <div class="adm-person">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                        🛠️
                    </div>
                    <div>
                        <div class="pname">{{ $prof->name }}</div>
                        <div class="pmeta">{{ $prof->professionals_count }} active specialists</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <span class="adm-badge green">Capacity Normal</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Common Problems Classification -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Most Common Detected Defect Types</h3>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px; margin-bottom: 10px;">
            <div class="pname" style="font-size: 13.5px;">Kitchen Sink &amp; P-trap Pipe Leakage</div>
            <div class="pmeta" style="margin-top: 3px;">382 scans &middot; 94.6% precision</div>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px; margin-bottom: 10px;">
            <div class="pname" style="font-size: 13.5px;">AC Inverter Condenser &amp; Gas Leaks</div>
            <div class="pmeta" style="margin-top: 3px;">294 scans &middot; 91.0% precision</div>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px; margin-bottom: 10px;">
            <div class="pname" style="font-size: 13.5px;">Circuit Breaker DB Tripping &amp; Neutral Short</div>
            <div class="pmeta" style="margin-top: 3px;">188 scans &middot; 97.2% precision</div>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px;">
            <div class="pname" style="font-size: 13.5px;">Door Lock Realignment &amp; Woodwork</div>
            <div class="pmeta" style="margin-top: 3px;">142 scans &middot; 88.5% precision</div>
        </div>
    </div>

</div>

@endsection
