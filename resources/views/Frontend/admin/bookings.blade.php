@extends('Frontend.layouts.admin')

@section('title', 'All Bookings — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>All Platform Bookings</h1>
        <p>Monitor live job dispatches, OTP handshakes, escrow releases, and disputes.</p>
    </div>
    <div class="adm-page-actions">
        <button type="button" class="adm-btn adm-btn-ghost" onclick="showToast('CSV export started')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <path d="M7 10l5 5 5-5"></path>
                <path d="M12 15V3"></path>
            </svg>
            Export CSV
        </button>
    </div>
</div>

<!-- Filter Bar -->
<div class="adm-card" style="padding: 14px 18px; margin-bottom: 18px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
    <input type="text" class="adm-input" style="flex: 1; min-width: 220px;" placeholder="Filter by Booking ID, customer or technician...">
    <select class="adm-select" style="width: 180px;">
        <option>All Statuses</option>
        <option>En Route</option>
        <option>Scheduled</option>
        <option>Completed</option>
    </select>
    <select class="adm-select" style="width: 160px;">
        <option>All Cities</option>
        <option>Karachi</option>
        <option>Lahore</option>
        <option>Islamabad</option>
    </select>
    <button type="button" class="adm-btn adm-btn-primary" onclick="showToast('Filters applied')">Apply</button>
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
                    <th>Service</th>
                    <th>City / Area</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>#FM-10245</strong></td>
                    <td>Ahmed Khan</td>
                    <td>Ali Khan</td>
                    <td>Plumbing &mdash; Sink Leak</td>
                    <td>Karachi (DHA)</td>
                    <td><span class="adm-badge yellow">En Route &middot; ETA 10m</span></td>
                    <td><strong>Rs. 800</strong></td>
                    <td style="text-align: right;"><a href="{{ url('/customer/tracking') }}" class="adm-card-link">Live Map</a></td>
                </tr>
                <tr>
                    <td><strong>#FM-10190</strong></td>
                    <td>Bilal Tariq</td>
                    <td>Imran Shah</td>
                    <td>AC Master Service</td>
                    <td>Karachi (Gulshan)</td>
                    <td><span class="adm-badge blue">Scheduled</span></td>
                    <td><strong>Rs. 1,800</strong></td>
                    <td style="text-align: right;"><a href="#" class="adm-card-link">Details</a></td>
                </tr>
                <tr>
                    <td><strong>#FM-09942</strong></td>
                    <td>Sara Ahmed</td>
                    <td>Riaz Ahmed</td>
                    <td>Breaker Wiring</td>
                    <td>Karachi (Clifton)</td>
                    <td><span class="adm-badge green">Completed</span></td>
                    <td><strong>Rs. 1,200</strong></td>
                    <td style="text-align: right;"><a href="#" class="adm-card-link">Receipt</a></td>
                </tr>
                <tr>
                    <td><strong>#FM-09877</strong></td>
                    <td>Dr. Ayesha K.</td>
                    <td>Umar Tariq</td>
                    <td>Deep Cleaning</td>
                    <td>Islamabad (F-7)</td>
                    <td><span class="adm-badge red">Disputed</span></td>
                    <td><strong>Rs. 2,400</strong></td>
                    <td style="text-align: right;"><a href="{{ url('/admin/complaints') }}" class="adm-card-link">Arbitrate</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
