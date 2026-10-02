@extends('Frontend.layouts.admin')

@section('title', 'Escrow & Settlements — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Escrow &amp; Financial Settlements</h1>
        <p>Monitor platform escrow protection balances, payment releases, and commission ledger.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge green">Automated Payout Engine Active</span>
    </div>
</div>

<!-- Financial KPI Cards -->
<div class="adm-kpi-grid">
    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Held in Escrow Protection</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value accent">Rs. {{ number_format($escrowHeld) }}</div>
        <div class="kpi-foot">Funds released upon OTP arrival approval</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Settled Payouts This Month</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-value">Rs. {{ number_format($settledThisMonth) }}</div>
        <div class="kpi-foot up">Paid out to verified technicians</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Net Platform Commission (12%)</span>
            <span class="kpi-icon" style="background: var(--adm-info-soft);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-value">Rs. {{ number_format($netCommission) }}</div>
        <div class="kpi-foot">Retained platform operations revenue</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-top">
            <span class="kpi-label">Disputed Escrow Rate</span>
            <span class="kpi-icon" style="background: #FEE2E2;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </span>
        </div>
        <div class="kpi-value">0.8%</div>
        <div class="kpi-foot">Protected by 30-day warranty</div>
    </div>
</div>

<!-- Ledger Transactions Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-card-head" style="padding: 12px 6px 14px 6px;">
        <h3>Recent Escrow &amp; Payout Transactions</h3>
        <span class="adm-badge green">100% Reconciled</span>
    </div>
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Booking</th>
                    <th>Transaction Type</th>
                    <th>Beneficiary (Tech)</th>
                    <th>Customer</th>
                    <th>Gross Amount</th>
                    <th>Platform Fee</th>
                    <th>Status</th>
                    <th style="text-align: right;">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $tx)
                    <tr>
                        <td><strong>{{ $tx['reference'] }}</strong></td>
                        <td>{{ $tx['booking_id'] }}</td>
                        <td>{{ $tx['type'] }}</td>
                        <td>{{ $tx['technician'] }}</td>
                        <td>{{ $tx['customer'] }}</td>
                        <td><strong>Rs. {{ number_format($tx['amount']) }}</strong></td>
                        <td>Rs. {{ number_format($tx['fee']) }}</td>
                        <td>
                            <span class="adm-badge {{ $tx['status'] === 'Settled' ? 'green' : 'yellow' }}">
                                {{ $tx['status'] }}
                            </span>
                        </td>
                        <td style="text-align: right; font-size: 12px; color: var(--adm-muted);">
                            {{ $tx['date'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
