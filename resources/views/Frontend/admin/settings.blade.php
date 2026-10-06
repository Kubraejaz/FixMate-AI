@extends('Frontend.layouts.admin')

@section('title', 'Platform Settings — FixMate Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Platform System Configuration</h1>
        <p>Global parameters, commission structures, dispatch radius, and security limits.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge green">All Configurations Operational</span>
    </div>
</div>

@if(session('success'))
    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
        <span>✓ {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#166534;cursor:pointer;font-weight:700;">×</button>
    </div>
@endif

@if(session('error'))
    <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
        <span>⚠️ {{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#991B1B;cursor:pointer;font-weight:700;">×</button>
    </div>
@endif

<div class="adm-grid-2">

    <!-- Operational Settings -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Commission &amp; Dispatch Rules</h3>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="adm-field">
                <label>Platform Commission Rate (%)</label>
                <input type="number" step="0.5" name="platform_commission" value="{{ $settings['platform_commission'] }}" class="adm-input" required>
                <span style="font-size: 11.5px; color: var(--adm-muted); margin-top: 4px; display: block;">Standard commission withheld from completed jobs.</span>
            </div>

            <div class="adm-field">
                <label>Arrival Handshake OTP Expiry (Minutes)</label>
                <input type="number" name="otp_expiry_minutes" value="{{ $settings['otp_expiry_minutes'] }}" class="adm-input" required>
            </div>

            <div class="adm-field">
                <label>Maximum Technician Radar Dispatch Radius (KM)</label>
                <input type="number" name="max_service_radius_km" value="{{ $settings['max_service_radius_km'] }}" class="adm-input" required>
            </div>

            <div class="adm-field">
                <label>Automated Payout Frequency</label>
                <select name="payout_frequency" class="adm-select">
                    <option value="daily" {{ $settings['payout_frequency'] === 'daily' ? 'selected' : '' }}>Daily Batch (Midnight)</option>
                    <option value="weekly" {{ $settings['payout_frequency'] === 'weekly' ? 'selected' : '' }}>Weekly (Every Monday)</option>
                    <option value="biweekly" {{ $settings['payout_frequency'] === 'biweekly' ? 'selected' : '' }}>Bi-Weekly (1st &amp; 15th)</option>
                </select>
            </div>

            <button type="submit" class="adm-btn adm-btn-primary" style="margin-top: 10px;">
                Save Configuration Changes
            </button>
        </form>
    </div>

    <!-- Contact & Safety Parameters -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Support &amp; Safety Controls</h3>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="adm-field">
                <label>Customer Support Hotline</label>
                <input type="text" name="support_phone" value="{{ $settings['support_phone'] }}" class="adm-input" required>
            </div>

            <div class="adm-field">
                <label>Official Inquiries Email</label>
                <input type="email" name="support_email" value="{{ $settings['support_email'] }}" class="adm-input" required>
            </div>

            <div class="adm-field">
                <label>System Maintenance Mode</label>
                <select name="maintenance_mode" class="adm-select">
                    <option value="0" {{ ! $settings['maintenance_mode'] ? 'selected' : '' }}>Operational (Live)</option>
                    <option value="1" {{ $settings['maintenance_mode'] ? 'selected' : '' }}>Maintenance Mode (Read-only)</option>
                </select>
            </div>

            <div style="background: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 12px; padding: 16px; margin-top: 22px;">
                <strong style="display: block; font-size: 13.5px; color: var(--adm-ink); margin-bottom: 4px;">Single Administrator Security</strong>
                <span style="font-size: 12px; color: var(--adm-muted); line-height: 1.5; display: block;">All configuration changes are logged with audit timestamps and applied across customer and technician portals immediately.</span>
            </div>

            <button type="submit" class="adm-btn adm-btn-primary" style="margin-top: 18px;">
                Save Support Parameters
            </button>
        </form>
    </div>

</div>
@endsection
