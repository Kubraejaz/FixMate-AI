@extends('Frontend.layouts.admin')

@section('title', 'Dashboard & KPIs — FixMate AI Admin')

@section('content')

<!-- Page Header -->
<div class="adm-page-head">
    <div>
        <h1>Dashboard</h1>
        <p>Overview of platform activity, AI diagnostics, and revenue metrics.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ url('/admin/technicians/verification') }}" class="adm-btn adm-btn-ghost">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            Review Pending KYC (3)
        </a>
        <a href="{{ url('/admin/categories') }}" class="adm-btn adm-btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Manage Categories
        </a>
    </div>
</div>

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
        <div class="kpi-value">2,548</div>
        <div class="kpi-foot up">&#8593; 14% this month</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Total Technicians</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6z"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value">1,203</div>
        <div class="kpi-foot warn">987 verified (82%)</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Total Bookings</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                    <path d="M16 2v4"></path>
                    <path d="M8 2v4"></path>
                    <path d="M3 10h18"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value">4,892</div>
        <div class="kpi-foot up">3,902 completed</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Platform Revenue</span>
            <span class="kpi-icon" style="background: var(--adm-accent);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0F172A" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20"></path>
                    <path d="M17 6.5c0-1.9-2.2-3-5-3s-5 1.1-5 3 2.2 2.6 5 3.4 5 1.5 5 3.4-2.2 3-5 3-5-1.1-5-3"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value accent">Rs. 1,245,000</div>
        <div class="kpi-foot">12% net commission</div>
    </div>

</div>

<!-- Charts Row -->
<div class="adm-grid-2">

    <!-- Bookings Trend -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Monthly Bookings Growth</h3>
            <span class="sub">Jan 2026 &ndash; Sep 2026</span>
        </div>

        <svg class="adm-chart" viewBox="0 0 500 200" preserveAspectRatio="none">
            <defs>
                <linearGradient id="admChartGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#FFC107" stop-opacity="0.30"></stop>
                    <stop offset="100%" stop-color="#FFC107" stop-opacity="0"></stop>
                </linearGradient>
            </defs>
            <line x1="0" y1="40" x2="500" y2="40" stroke="#E2E8F0" stroke-dasharray="3 4"></line>
            <line x1="0" y1="90" x2="500" y2="90" stroke="#E2E8F0" stroke-dasharray="3 4"></line>
            <line x1="0" y1="140" x2="500" y2="140" stroke="#E2E8F0" stroke-dasharray="3 4"></line>
            <line x1="0" y1="190" x2="500" y2="190" stroke="#CBD5E1"></line>
            <path d="M 0 160 Q 70 140 140 130 T 280 80 T 420 50 L 500 30 L 500 190 L 0 190 Z" fill="url(#admChartGrad)"></path>
            <path d="M 0 160 Q 70 140 140 130 T 280 80 T 420 50 T 500 30" fill="none" stroke="#E0A800" stroke-width="3" stroke-linecap="round"></path>
            <circle cx="140" cy="130" r="4" fill="#FFC107"></circle>
            <circle cx="280" cy="80" r="4" fill="#FFC107"></circle>
            <circle cx="420" cy="50" r="4" fill="#FFC107"></circle>
            <circle cx="500" cy="30" r="5" fill="#FFFFFF" stroke="#E0A800" stroke-width="2.5"></circle>
        </svg>

        <div class="adm-axis">
            <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span>
            <span>May</span><span>Jun</span><span>Jul</span><span>Aug</span>
            <span>Sep &middot; peak 4,892</span>
        </div>
    </div>

    <!-- Location Split -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Bookings by Location</h3>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">Karachi</span>
                <span class="val">45% &middot; 2,201</span>
            </div>
            <div class="adm-bar yellow"><span style="width: 45%;"></span></div>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">Lahore</span>
                <span class="val">28% &middot; 1,370</span>
            </div>
            <div class="adm-bar blue"><span style="width: 28%;"></span></div>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">Islamabad</span>
                <span class="val">18% &middot; 880</span>
            </div>
            <div class="adm-bar green"><span style="width: 18%;"></span></div>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">Rawalpindi &amp; Others</span>
                <span class="val">9% &middot; 441</span>
            </div>
            <div class="adm-bar purple"><span style="width: 9%;"></span></div>
        </div>
    </div>

</div>

<!-- Detail Row -->
<div class="adm-grid-2-even">

    <!-- Requested Services -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Most Requested Services</h3>
            <a href="{{ url('/admin/categories') }}" class="adm-card-link">Manage All &rarr;</a>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">Plumbing &mdash; Pipes &amp; Sinks</span>
                <span class="val">1,248 jobs</span>
            </div>
            <div class="adm-bar yellow"><span style="width: 85%;"></span></div>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">Electrical &mdash; Wiring &amp; DB</span>
                <span class="val">892 jobs</span>
            </div>
            <div class="adm-bar blue"><span style="width: 65%;"></span></div>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">AC &amp; Cooling &mdash; Inverter Wash</span>
                <span class="val">740 jobs</span>
            </div>
            <div class="adm-bar green"><span style="width: 55%;"></span></div>
        </div>

        <div class="adm-bar-row">
            <div class="adm-bar-head">
                <span class="name">Deep Cleaning &amp; Sanitation</span>
                <span class="val">520 jobs</span>
            </div>
            <div class="adm-bar purple"><span style="width: 40%;"></span></div>
        </div>
    </div>

    <!-- AI Engine Health -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>AI Diagnostics Accuracy</h3>
            <span class="adm-badge green">94.2% precision</span>
        </div>

        <div class="adm-stat-row">
            <span class="label">Total images processed</span>
            <span class="value">14,920 scans</span>
        </div>
        <div class="adm-stat-row">
            <span class="label">Mean analysis latency</span>
            <span class="value">1.24 seconds</span>
        </div>
        <div class="adm-stat-row">
            <span class="label">Cost prediction accuracy</span>
            <span class="value">91.8% within bounds</span>
        </div>
        <div class="adm-stat-row">
            <span class="label">Customer acceptance rate</span>
            <span class="value">87% confirmed</span>
        </div>

        <a href="{{ url('/admin/analytics') }}" class="adm-btn adm-btn-ghost" style="width: 100%; margin-top: 18px;">
            Open Analytics Suite
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"></path>
                <path d="M12 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

</div>

@endsection
