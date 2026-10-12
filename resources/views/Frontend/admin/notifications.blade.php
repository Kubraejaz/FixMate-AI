@extends('Frontend.layouts.admin')

@section('title', 'System Alerts & Audit Notifications — FixMate Admin')

@section('extra_css')
<style>
    /* ============ Alerts Feed Specialized Styles ============ */
    .notif-live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--adm-success-soft);
        color: var(--adm-success);
        border: 1px solid #BBF7D0;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .notif-pulse-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--adm-success);
        box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7);
        animation: notifPulse 2s infinite;
    }

    @keyframes notifPulse {
        0% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
        100% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }

    /* KPI interactive cards */
    .notif-kpi-link {
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .notif-kpi-link:hover .adm-kpi {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -8px rgba(15, 23, 42, 0.12);
        border-color: #CBD5E1;
    }

    .notif-kpi-link.active .adm-kpi {
        border-color: var(--adm-accent);
        box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.35);
    }

    /* Filter Toolbar */
    .notif-filter-bar {
        background: var(--adm-surface);
        border: 1px solid var(--adm-border);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 22px;
        box-shadow: var(--adm-shadow);
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .notif-filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .notif-search-form {
        flex: 1;
        min-width: 260px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notif-search-wrap {
        position: relative;
        flex: 1;
    }

    .notif-search-wrap svg {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--adm-faint);
        pointer-events: none;
    }

    .notif-search-input {
        width: 100%;
        height: 38px;
        padding: 0 14px 0 38px;
        font-size: 13px;
        font-family: inherit;
        background: var(--adm-bg);
        border: 1.5px solid transparent;
        border-radius: 9px;
        outline: none;
        color: var(--adm-ink);
        transition: all 0.18s ease;
    }

    .notif-search-input:focus {
        background: var(--adm-surface);
        border-color: var(--adm-accent);
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.18);
    }

    .notif-select {
        height: 38px;
        padding: 0 32px 0 12px;
        font-size: 13px;
        font-family: inherit;
        font-weight: 600;
        color: var(--adm-ink);
        background: var(--adm-bg) url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%2364748B' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center;
        border: 1.5px solid transparent;
        border-radius: 9px;
        outline: none;
        appearance: none;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .notif-select:focus {
        background-color: var(--adm-surface);
        border-color: var(--adm-accent);
    }

    .notif-status-tabs {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .notif-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid var(--adm-border);
        background: var(--adm-surface);
        color: var(--adm-body);
        transition: all 0.16s ease;
    }

    .notif-tab:hover {
        border-color: #CBD5E1;
        background: var(--adm-bg);
        color: var(--adm-ink);
    }

    .notif-tab.active {
        background: var(--adm-accent-soft);
        border-color: var(--adm-accent);
        color: #B45309;
    }

    .notif-tab .pill-count {
        font-size: 11px;
        font-weight: 800;
        padding: 1px 7px;
        border-radius: 12px;
        background: var(--adm-border-soft);
        color: var(--adm-ink);
    }

    .notif-tab.active .pill-count {
        background: var(--adm-accent);
        color: var(--adm-ink);
    }

    /* Alert Feed Item */
    .notif-card {
        background: var(--adm-surface);
        border: 1px solid var(--adm-border);
        border-radius: 14px;
        padding: 18px 22px;
        display: flex;
        gap: 18px;
        align-items: flex-start;
        justify-content: space-between;
        position: relative;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
    }

    .notif-card:hover {
        box-shadow: 0 6px 18px -4px rgba(15, 23, 42, 0.08);
        border-color: #CBD5E1;
    }

    .notif-card.is-unread {
        background: #FFFDF5;
        border-color: #FDE68A;
        border-left: 4px solid var(--adm-accent);
    }

    .notif-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(0, 0, 0, 0.04);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .notif-icon-box.kyc {
        background: #FEF3C7;
        color: #D97706;
    }

    .notif-icon-box.booking {
        background: #ECFDF5;
        color: #059669;
    }

    .notif-icon-box.payment {
        background: #F5F3FF;
        color: #7C3AED;
    }

    .notif-icon-box.inquiry {
        background: #EFF6FF;
        color: #2563EB;
    }

    .notif-icon-box.default {
        background: #F1F5F9;
        color: #475569;
    }

    .notif-body-wrap {
        flex: 1;
        min-width: 0;
    }

    .notif-meta-line {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
        flex-wrap: wrap;
    }

    .notif-badge-tag {
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .notif-badge-tag.kyc { background: #FEF3C7; color: #92400E; }
    .notif-badge-tag.booking { background: #DCFCE7; color: #166534; }
    .notif-badge-tag.payment { background: #F3E8FF; color: #6B21A8; }
    .notif-badge-tag.inquiry { background: #DBEAFE; color: #1E40AF; }
    .notif-badge-tag.default { background: #E2E8F0; color: #334155; }

    .notif-new-pill {
        background: var(--adm-danger);
        color: #FFFFFF;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 10px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        box-shadow: 0 2px 6px rgba(225, 29, 72, 0.3);
    }

    .notif-time {
        font-size: 12px;
        color: var(--adm-faint);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .notif-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--adm-ink);
        line-height: 1.35;
        margin-bottom: 6px;
    }

    .notif-desc {
        font-size: 13.5px;
        color: var(--adm-body);
        line-height: 1.55;
        margin: 0 0 12px 0;
        word-break: break-word;
    }

    .notif-footer-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .notif-side-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .notif-icon-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--adm-border);
        background: var(--adm-surface);
        color: var(--adm-muted);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.16s ease;
    }

    .notif-icon-btn:hover {
        background: var(--adm-border-soft);
        color: var(--adm-ink);
        border-color: #CBD5E1;
    }

    .notif-icon-btn.danger:hover {
        background: var(--adm-danger-soft);
        color: var(--adm-danger);
        border-color: #FECACA;
    }

    @media (max-width: 640px) {
        .notif-card {
            flex-direction: column;
            gap: 14px;
        }
        .notif-side-actions {
            align-self: flex-end;
            margin-top: -38px;
        }
    }
</style>
@endsection

@section('content')

<!-- Page Heading & Actions -->
<div class="adm-page-head">
    <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px; flex-wrap: wrap;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: var(--adm-accent); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0F172A" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>
            <h1 style="margin: 0; font-size: 26px;">Platform Alerts &amp; System Notifications</h1>
            <span class="notif-live-indicator">
                <span class="notif-pulse-dot"></span>
                <span>Live Audit Stream</span>
            </span>
        </div>
        <p>Real-time audit log streaming for technician KYC submissions, booking dispatches, escrow transactions, and support escalations.</p>
    </div>

    <div class="adm-page-actions">
        @if($stats['unread'] > 0)
            <form action="{{ route('admin.notifications.read-all') }}" method="POST" style="margin: 0;" onsubmit="return confirm('Mark all unread alerts as reviewed?');">
                @csrf
                <button type="submit" class="adm-btn adm-btn-primary" style="height: 38px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Mark All Read ({{ $stats['unread'] }})</span>
                </button>
            </form>
        @else
            <span class="adm-badge green" style="padding: 9px 16px; font-size: 13px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>All Queues Caught Up</span>
            </span>
        @endif

        @if($stats['read'] > 0)
            <form action="{{ route('admin.notifications.clear-read') }}" method="POST" style="margin: 0;" onsubmit="return confirm('Clear all reviewed notifications from history?');">
                @csrf
                <button type="submit" class="adm-btn adm-btn-ghost" style="height: 38px;" title="Clear Reviewed Alerts">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    <span>Clear Reviewed</span>
                </button>
            </form>
        @endif
    </div>
</div>

<!-- Flash Feedback Messages -->
@if(session('success'))
    <div style="background: #F0FDF4; border: 1.5px solid #86EFAC; color: #166534; padding: 13px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 16px;">✓</span>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #166534; line-height: 1;">&times;</button>
    </div>
@endif

<!-- Summary KPI Cards -->
<div class="adm-kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 22px;">

    <!-- Total Alerts -->
    <a href="{{ route('admin.notifications', ['filter' => 'all', 'category' => 'all']) }}" class="notif-kpi-link {{ ($filter === 'all' && $category === 'all') ? 'active' : '' }}">
        <div class="adm-kpi">
            <div class="kpi-top">
                <span class="kpi-label">Total System Alerts</span>
                <span class="kpi-icon" style="background: #F1F5F9;">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">{{ number_format($stats['total']) }}</div>
            <div class="kpi-foot">All platform events</div>
        </div>
    </a>

    <!-- Unread Alerts -->
    <a href="{{ route('admin.notifications', ['filter' => 'unread', 'category' => $category]) }}" class="notif-kpi-link {{ $filter === 'unread' ? 'active' : '' }}">
        <div class="adm-kpi">
            <div class="kpi-top">
                <span class="kpi-label">Action Required</span>
                <span class="kpi-icon" style="background: #FFF1F2;">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#E11D48" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </span>
            </div>
            <div class="kpi-value" style="color: {{ $stats['unread'] > 0 ? '#E11D48' : 'var(--adm-ink)' }};">
                {{ number_format($stats['unread']) }}
            </div>
            <div class="kpi-foot {{ $stats['unread'] > 0 ? 'warn' : 'up' }}">
                {{ $stats['unread'] > 0 ? 'Unreviewed notifications' : 'Zero backlog' }}
            </div>
        </div>
    </a>

    <!-- KYC & Partner Alerts -->
    <a href="{{ route('admin.notifications', ['filter' => $filter, 'category' => 'kyc']) }}" class="notif-kpi-link {{ $category === 'kyc' ? 'active' : '' }}">
        <div class="adm-kpi">
            <div class="kpi-top">
                <span class="kpi-label">KYC Verifications</span>
                <span class="kpi-icon" style="background: var(--adm-accent-soft);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">{{ number_format($stats['kyc']) }}</div>
            <div class="kpi-foot warn">Partner credentials &amp; CNIC</div>
        </div>
    </a>

    <!-- Bookings & Dispatch Alerts -->
    <a href="{{ route('admin.notifications', ['filter' => $filter, 'category' => 'booking']) }}" class="notif-kpi-link {{ $category === 'booking' ? 'active' : '' }}">
        <div class="adm-kpi">
            <div class="kpi-top">
                <span class="kpi-label">Dispatches &amp; Jobs</span>
                <span class="kpi-icon" style="background: var(--adm-success-soft);">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">{{ number_format($stats['booking']) }}</div>
            <div class="kpi-foot up">Live customer dispatches</div>
        </div>
    </a>

    <!-- Escrow & Payments -->
    <a href="{{ route('admin.notifications', ['filter' => $filter, 'category' => 'payment']) }}" class="notif-kpi-link {{ $category === 'payment' ? 'active' : '' }}">
        <div class="adm-kpi">
            <div class="kpi-top">
                <span class="kpi-label">Escrows &amp; Payouts</span>
                <span class="kpi-icon" style="background: #F5F3FF;">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </span>
            </div>
            <div class="kpi-value">{{ number_format($stats['payment']) }}</div>
            <div class="kpi-foot">Transaction triggers</div>
        </div>
    </a>

</div>

<!-- Filter Toolbar -->
<div class="notif-filter-bar">
    <div class="notif-filter-top">

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.notifications') }}" class="notif-search-form">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <div class="notif-search-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" value="{{ $search }}" class="notif-search-input" placeholder="Search alerts by technician, booking #FM, customer, or message...">
            </div>

            <select name="category" class="notif-select" onchange="this.form.submit()">
                <option value="all" {{ $category === 'all' ? 'selected' : '' }}>All Event Categories</option>
                <option value="kyc" {{ $category === 'kyc' ? 'selected' : '' }}>🛡️ Partner KYC &amp; Verification</option>
                <option value="booking" {{ $category === 'booking' ? 'selected' : '' }}>⚡ Bookings &amp; Dispatches</option>
                <option value="payment" {{ $category === 'payment' ? 'selected' : '' }}>💰 Escrow &amp; Payments</option>
                <option value="inquiry" {{ $category === 'inquiry' ? 'selected' : '' }}>💬 Support &amp; Inquiries</option>
            </select>

            <button type="submit" class="adm-btn adm-btn-primary" style="height: 38px; padding: 0 16px;">
                Filter
            </button>

            @if($search !== '' || $category !== 'all' || $filter !== 'all')
                <a href="{{ route('admin.notifications') }}" class="adm-btn adm-btn-ghost" style="height: 38px;" title="Reset all filters">
                    Reset
                </a>
            @endif
        </form>

    </div>

    <!-- Status Sub-tabs -->
    <div class="notif-status-tabs">
        <a href="{{ route('admin.notifications', ['filter' => 'all', 'category' => $category, 'q' => $search]) }}" 
           class="notif-tab {{ $filter === 'all' ? 'active' : '' }}">
            <span>All Alerts</span>
            <span class="pill-count">{{ $stats['total'] }}</span>
        </a>

        <a href="{{ route('admin.notifications', ['filter' => 'unread', 'category' => $category, 'q' => $search]) }}" 
           class="notif-tab {{ $filter === 'unread' ? 'active' : '' }}">
            <span style="color: #E11D48;">●</span>
            <span>Unread Only</span>
            <span class="pill-count" style="{{ $stats['unread'] > 0 ? 'background: #FFE4E6; color: #BE123C;' : '' }}">{{ $stats['unread'] }}</span>
        </a>

        <a href="{{ route('admin.notifications', ['filter' => 'read', 'category' => $category, 'q' => $search]) }}" 
           class="notif-tab {{ $filter === 'read' ? 'active' : '' }}">
            <span>Reviewed</span>
            <span class="pill-count">{{ $stats['read'] }}</span>
        </a>
    </div>
</div>

<!-- Alerts Feed List -->
<div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
    @forelse($notifications as $notif)
        @php
            $isUnread = !$notif->is_read;
            
            // Map category, visual icons, and badges
            $type = (string) $notif->type;
            if (str_starts_with($type, 'kyc') || $type === 'technician_registered') {
                $catKey = 'kyc';
                $catLabel = 'Partner KYC';
            } elseif (str_starts_with($type, 'booking') || str_starts_with($type, 'job') || str_starts_with($type, 'service') || $type === 'technician_en_route') {
                $catKey = 'booking';
                $catLabel = 'Dispatch / Job';
            } elseif (str_starts_with($type, 'escrow') || str_starts_with($type, 'payment') || str_starts_with($type, 'payout')) {
                $catKey = 'payment';
                $catLabel = 'Escrow & Finance';
            } elseif (str_starts_with($type, 'inquiry') || str_starts_with($type, 'complaint') || $type === 'chat_message' || $type === 'review_reply') {
                $catKey = 'inquiry';
                $catLabel = 'Support / Inquiry';
            } else {
                $catKey = 'default';
                $catLabel = 'System Notice';
            }
        @endphp

        <div class="notif-card {{ $isUnread ? 'is-unread' : '' }}" id="notif-item-{{ $notif->id }}">
            
            <!-- Category Icon Box -->
            <div class="notif-icon-box {{ $catKey }}">
                @if($catKey === 'kyc')
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M9 12l2 2 4-4"></path>
                    </svg>
                @elseif($catKey === 'booking')
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                @elseif($catKey === 'payment')
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                @elseif($catKey === 'inquiry')
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                @else
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                @endif
            </div>

            <!-- Content Body -->
            <div class="notif-body-wrap">
                <div class="notif-meta-line">
                    <span class="notif-badge-tag {{ $catKey }}">{{ $catLabel }}</span>

                    @if($isUnread)
                        <span class="notif-new-pill">
                            <span>●</span>
                            <span>NEW</span>
                        </span>
                    @endif

                    <span class="notif-time" title="{{ $notif->created_at->format('M d, Y h:i A') }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>{{ $notif->created_at->diffForHumans() }}</span>
                        <span style="color: var(--adm-border);">&bull;</span>
                        <span style="font-size: 11px;">{{ $notif->created_at->format('d M, Y') }}</span>
                    </span>
                </div>

                <div class="notif-title">{{ $notif->title }}</div>

                <p class="notif-desc">{{ $notif->message }}</p>

                <!-- Footer Action Buttons -->
                <div class="notif-footer-actions">
                    @if($notif->link)
                        <a href="{{ route('admin.notifications.open', $notif->id) }}" class="adm-btn adm-btn-primary adm-btn-sm" style="font-size: 12px; height: 32px; gap: 6px;">
                            <span>Inspect &amp; Take Action</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    @endif

                    @if($isUnread)
                        <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST" style="margin: 0;" class="ajax-notif-action" data-action="read" data-id="{{ $notif->id }}">
                            @csrf
                            <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 12px; height: 32px; gap: 5px;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span>Mark as Read</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.notifications.unread', $notif->id) }}" method="POST" style="margin: 0;" class="ajax-notif-action" data-action="unread" data-id="{{ $notif->id }}">
                            @csrf
                            <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 12px; height: 32px; color: var(--adm-muted);">
                                <span>Mark Unread</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Side Action (Delete / Dismiss) -->
            <div class="notif-side-actions">
                <form action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST" style="margin: 0;" class="ajax-notif-delete" data-id="{{ $notif->id }}" onsubmit="return confirm('Dismiss and remove this alert?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="notif-icon-btn danger" title="Dismiss Alert">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    @empty
        <!-- High Quality Empty State -->
        <div class="adm-card" style="padding: 60px 24px; text-align: center; border-radius: 16px;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--adm-accent-soft); color: #B45309; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>

            <h3 style="font-size: 18px; font-weight: 800; color: var(--adm-ink); margin-bottom: 6px;">
                @if($search !== '')
                    No notifications matched "{{ $search }}"
                @elseif($filter === 'unread')
                    Zero Unread Alerts — You're All Caught Up!
                @else
                    No Notifications in this Category
                @endif
            </h3>

            <p style="font-size: 13.5px; color: var(--adm-muted); max-width: 480px; margin: 0 auto 20px; line-height: 1.5;">
                @if($search !== '')
                    Try searching with broader terms or clear your search query to inspect other platform audit logs.
                @elseif($filter === 'unread')
                    All recent partner KYC verifications, booking dispatches, and dispute items have been reviewed by administrators.
                @else
                    New platform events will stream into this console automatically as customers and partners interact with FixMate.
                @endif
            </p>

            @if($search !== '' || $category !== 'all' || $filter !== 'all')
                <a href="{{ route('admin.notifications') }}" class="adm-btn adm-btn-primary" style="height: 38px; display: inline-flex; margin: 0 auto;">
                    <span>Clear All Filters</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </a>
            @endif
        </div>
    @endforelse
</div>

<!-- Modern Pagination -->
@if($notifications->hasPages())
    <div class="adm-pagination-wrap">
        {{ $notifications->links() }}
    </div>
@endif

@endsection

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Optional smooth AJAX action handler for mark read/unread and delete
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
               || document.querySelector('input[name="_token"]')?.value;

    function updateTopBarCounter(newCount) {
        const topBadge = document.getElementById('adminNotifBadge');
        const countText = document.getElementById('adminNotifCountText');
        if (topBadge) {
            if (newCount > 0) {
                topBadge.textContent = newCount;
                topBadge.style.display = 'flex';
            } else {
                topBadge.style.display = 'none';
            }
        }
        if (countText) {
            countText.textContent = newCount;
        }
    }

    // Handle AJAX Mark Read / Unread
    document.querySelectorAll('.ajax-notif-action').forEach(form => {
        form.addEventListener('submit', function (e) {
            // allow normal form submission if Shift or Ctrl is pressed
            if (e.shiftKey || e.ctrlKey) return;
            e.preventDefault();

            const card = this.closest('.notif-card');
            const url = this.getAttribute('action');
            const isReadAction = this.dataset.action === 'read';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (isReadAction) {
                        card.classList.remove('is-unread');
                        const newPill = card.querySelector('.notif-new-pill');
                        if (newPill) newPill.remove();
                        // replace button with Mark Unread
                        form.outerHTML = `
                            <form action="${url.replace('/read', '/unread')}" method="POST" style="margin: 0;" class="ajax-notif-action" data-action="unread" data-id="${form.dataset.id}">
                                <input type="hidden" name="_token" value="${token}">
                                <button type="submit" class="adm-btn adm-btn-ghost adm-btn-sm" style="font-size: 12px; height: 32px; color: var(--adm-muted);">
                                    <span>Mark Unread</span>
                                </button>
                            </form>
                        `;
                    } else {
                        card.classList.add('is-unread');
                        location.reload(); // refresh to update tab counters cleanly
                    }
                    if (typeof data.unread_count !== 'undefined') {
                        updateTopBarCounter(data.unread_count);
                    }
                } else {
                    form.submit();
                }
            })
            .catch(() => form.submit());
        });
    });

    // Handle AJAX Delete
    document.querySelectorAll('.ajax-notif-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm('Dismiss and remove this alert?')) {
                e.preventDefault();
                return;
            }
            e.preventDefault();

            const card = this.closest('.notif-card');
            const url = this.getAttribute('action');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(-10px)';
                    setTimeout(() => card.remove(), 250);
                    if (typeof data.unread_count !== 'undefined') {
                        updateTopBarCounter(data.unread_count);
                    }
                } else {
                    form.submit();
                }
            })
            .catch(() => form.submit());
        });
    });
});
</script>
@endsection
