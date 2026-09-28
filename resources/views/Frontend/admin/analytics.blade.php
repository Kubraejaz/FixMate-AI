@extends('Frontend.layouts.admin')

@section('title', 'Growth Analytics — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Recommendation &amp; AI Matching Analytics</h1>
        <p>Performance of computer vision diagnostics, technician matching, and conversion.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge yellow">Average matching score 87%</span>
    </div>
</div>

<!-- Funnel KPIs -->
<div class="adm-kpi-grid" style="grid-template-columns: repeat(3, minmax(0, 1fr));">

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Total Inquiries (AI Scans)</span>
            <span class="kpi-icon" style="background: var(--adm-info-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 2v3"></path><path d="M12 19v3"></path>
                    <path d="M2 12h3"></path><path d="M19 12h3"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value">1,248</div>
        <div class="kpi-foot up">Processed by computer vision</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Successful Matches</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value">892</div>
        <div class="kpi-foot">71.4% match confidence</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Confirmed Bookings</span>
            <span class="kpi-icon" style="background: var(--adm-accent);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0F172A" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                    <path d="M16 2v4"></path><path d="M8 2v4"></path>
                    <path d="M3 10h18"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value accent">356</div>
        <div class="kpi-foot up">39.9% booking conversion</div>
    </div>

</div>

<!-- Two Columns -->
<div class="adm-grid-2">

    <!-- Most Recommended Technicians -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Most Recommended Technicians</h3>
            <a href="{{ url('/admin/technicians') }}" class="adm-card-link">View Pool &rarr;</a>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--adm-border-soft);">
            <div class="adm-person">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 42px; height: 42px; border-color: var(--adm-accent);">
                <div>
                    <div class="pname">1. Ali Khan</div>
                    <div class="pmeta">Plumber &middot; &#9733; 4.9</div>
                </div>
            </div>
            <div style="text-align: right;">
                <div class="pname">124 inquiries</div>
                <div class="pmeta" style="color: var(--adm-success); font-weight: 700;">98% match rate</div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--adm-border-soft);">
            <div class="adm-person">
                <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="width: 42px; height: 42px; border-color: var(--adm-accent);">
                <div>
                    <div class="pname">2. Riaz Ahmed</div>
                    <div class="pmeta">Electrician &middot; &#9733; 4.8</div>
                </div>
            </div>
            <div style="text-align: right;">
                <div class="pname">98 inquiries</div>
                <div class="pmeta" style="color: var(--adm-success); font-weight: 700;">94% match rate</div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--adm-border-soft);">
            <div class="adm-person">
                <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="width: 42px; height: 42px; border-color: var(--adm-accent);">
                <div>
                    <div class="pname">3. Imran Shah</div>
                    <div class="pmeta">AC Specialist &middot; &#9733; 4.9</div>
                </div>
            </div>
            <div style="text-align: right;">
                <div class="pname">82 inquiries</div>
                <div class="pmeta" style="color: var(--adm-success); font-weight: 700;">96% match rate</div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0;">
            <div class="adm-person">
                <img src="{{ asset('assets/images/image_4.png') }}" alt="Umar Tariq" style="width: 42px; height: 42px;">
                <div>
                    <div class="pname">4. Umar Tariq</div>
                    <div class="pmeta">Cleaner &middot; &#9733; 4.8</div>
                </div>
            </div>
            <div style="text-align: right;">
                <div class="pname">65 inquiries</div>
                <div class="pmeta" style="color: var(--adm-success); font-weight: 700;">91% match rate</div>
            </div>
        </div>
    </div>

    <!-- Common Problems -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Common Detected Problems</h3>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px; margin-bottom: 10px;">
            <div class="pname" style="font-size: 13.5px;">Kitchen Sink Leakage</div>
            <div class="pmeta" style="margin-top: 3px;">382 scans &middot; 92% precision</div>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px; margin-bottom: 10px;">
            <div class="pname" style="font-size: 13.5px;">AC Not Cooling (Gas / Filter)</div>
            <div class="pmeta" style="margin-top: 3px;">294 scans &middot; 89% precision</div>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px; margin-bottom: 10px;">
            <div class="pname" style="font-size: 13.5px;">Circuit Breaker Tripping</div>
            <div class="pmeta" style="margin-top: 3px;">188 scans &middot; 94% precision</div>
        </div>

        <div style="background: var(--adm-border-soft); border-radius: 10px; padding: 12px 14px;">
            <div class="pname" style="font-size: 13.5px;">Sofa &amp; Carpet Stain Wash</div>
            <div class="pmeta" style="margin-top: 3px;">142 scans &middot; 88% precision</div>
        </div>
    </div>

</div>

@endsection
