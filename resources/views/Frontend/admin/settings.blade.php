@extends('Frontend.layouts.admin')

@section('title', 'Platform Settings — FixMate AI Admin')

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

<!-- Google Gemini Vision AI Engine Configuration -->
<div class="adm-card" style="margin-top: 24px; border: 2px solid #E0E7FF; background: #FFFFFF;">
    <div class="adm-card-head" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #EEF2F6; padding-bottom: 14px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #4F46E5, #06B6D4); display: flex; align-items: center; justify-content: center; color: #FFF; font-size: 20px;">
                ✨
            </div>
            <div>
                <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #1E293B;">Google Gemini Vision AI Engine</h3>
                <p style="margin: 2px 0 0 0; font-size: 12.5px; color: #64748B;">Multi-modal computer vision &amp; natural language defect diagnosis for customer scans.</p>
            </div>
        </div>
        <div>
            @if(!empty($settings['gemini_api_key']))
                <span class="adm-badge green">✓ Gemini Live Connected</span>
            @else
                <span class="adm-badge yellow">⚡ Using Local Neural Fallback Engine</span>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 28px; margin-top: 20px;">
        <!-- Left: API Key & Configuration Form -->
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="adm-field">
                <label style="font-weight: 700; color: #1E293B; display: flex; justify-content: space-between;">
                    <span>Google Gemini API Key</span>
                    <a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener noreferrer" style="color: #4F46E5; font-size: 11.5px; text-decoration: none;">Get Free Key from Google AI Studio →</a>
                </label>
                <div style="position: relative;">
                    <input type="password" id="gemini_key_input" name="gemini_api_key" value="{{ $settings['gemini_api_key'] }}" placeholder="AIzaSy..." class="adm-input" style="padding-right: 44px; font-family: monospace;">
                    <button type="button" onclick="const f = document.getElementById('gemini_key_input'); f.type = f.type === 'password' ? 'text' : 'password';" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748B; font-size: 14px;">
                        👁️
                    </button>
                </div>
                <span style="font-size: 11.5px; color: var(--adm-muted); margin-top: 4px; display: block;">Stored securely and used for multimodal damage inspection and cost estimation.</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="adm-field">
                    <label style="font-weight: 700; color: #1E293B;">Gemini Model</label>
                    <select name="gemini_model" class="adm-select">
                        <option value="gemini-1.5-flash" {{ ($settings['gemini_model'] ?? '') === 'gemini-1.5-flash' ? 'selected' : '' }}>Gemini 1.5 Flash (Recommended - Fastest)</option>
                        <option value="gemini-2.0-flash" {{ ($settings['gemini_model'] ?? '') === 'gemini-2.0-flash' ? 'selected' : '' }}>Gemini 2.0 Flash (Next-Gen Preview)</option>
                        <option value="gemini-1.5-pro" {{ ($settings['gemini_model'] ?? '') === 'gemini-1.5-pro' ? 'selected' : '' }}>Gemini 1.5 Pro (Deep Reasoning)</option>
                    </select>
                </div>

                <div class="adm-field">
                    <label style="font-weight: 700; color: #1E293B;">AI Engine Mode</label>
                    <select name="gemini_enabled" class="adm-select">
                        <option value="1" {{ ($settings['gemini_enabled'] ?? true) ? 'selected' : '' }}>Live Gemini AI Active</option>
                        <option value="0" {{ !($settings['gemini_enabled'] ?? true) ? 'selected' : '' }}>Local Heuristic Engine Only</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 14px;">
                <button type="submit" class="adm-btn adm-btn-primary">
                    Save Gemini Credentials
                </button>
            </div>
        </form>

        <!-- Right: Diagnostic Ping & Real-Time Test Console -->
        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <strong style="display: block; font-size: 13.5px; color: #0F172A; margin-bottom: 6px;">🔌 Live Connection Ping</strong>
                <p style="font-size: 12px; color: #64748B; margin: 0 0 14px 0; line-height: 1.45;">
                    Verify connectivity with Google's API servers before rolling out to live customers.
                </p>

                <div style="background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 8px; padding: 10px 12px; font-size: 12px; margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="color: #64748B;">Target Endpoint:</span>
                        <code style="color: #0F172A; font-weight: 600;">/v1beta/models</code>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B;">Fallback Safety:</span>
                        <span style="color: #10B981; font-weight: 700;">100% Guaranteed</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.test-gemini') }}">
                @csrf
                <input type="hidden" name="gemini_api_key" value="{{ $settings['gemini_api_key'] }}">
                <button type="submit" class="adm-btn" style="width: 100%; justify-content: center; background: #0F172A; color: #FFFFFF; font-weight: 700; border-radius: 8px; padding: 10px;">
                    ⚡ Test Gemini Connection
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
