@extends('Frontend.layouts.customer')

@section('title', 'Account Settings — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Account Settings</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Security credentials, notification preferences, and privacy controls.</p>
    </div>

    <!-- Security & Password -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Security & Password</h3>

        <form action="{{ url('/customer/settings') }}" method="GET">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Current Password</label>
                    <input type="password" class="form-input" placeholder="••••••••" style="padding: 9px 12px; font-size: 13.5px;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">New Password</label>
                    <input type="password" class="form-input" placeholder="New password" style="padding: 9px 12px; font-size: 13.5px;">
                </div>
            </div>

            <button type="submit" class="btn-yellow" style="padding: 9px 24px; font-size: 13.5px; font-weight: 800;">
                Update Password
            </button>
        </form>
    </div>

    <!-- Notification Toggles -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Notifications</h3>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            <label style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                <div>
                    <strong style="font-size: 14px; color: #111; display: block;">SMS Job Updates</strong>
                    <span style="font-size: 12px; color: #666;">Receive SMS arrival OTP and technician ETA warnings</span>
                </div>
                <input type="checkbox" checked style="accent-color: #FFCC00; transform: scale(1.3);">
            </label>

            <label style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                <div>
                    <strong style="font-size: 14px; color: #111; display: block;">WhatsApp Alerts</strong>
                    <span style="font-size: 12px; color: #666;">Get digital invoice PDF and warranty certificate on WhatsApp</span>
                </div>
                <input type="checkbox" checked style="accent-color: #FFCC00; transform: scale(1.3);">
            </label>
        </div>
    </div>

</div>
@endsection
