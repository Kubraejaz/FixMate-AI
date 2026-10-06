@extends('Frontend.layouts.customer')

@section('title', 'Account Settings — FixMate')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Account Settings</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Security credentials, multi-channel notification preferences, and privacy controls.</p>
    </div>

    @if ($errors->any())
        <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Multi-Channel Notification Preferences -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <div>
                <h3 style="font-size: 17px; font-weight: 800; color: #111; margin: 0 0 4px 0;">Notification Channels & Alerts</h3>
                <p style="font-size: 13px; color: #666; margin: 0;">Manage how FixMate alerts you regarding technician arrivals, OTP codes, and KYC verification.</p>
            </div>
            <span style="background: #FFFBEB; color: #B45309; border: 1px solid #FDE68A; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                Real-Time Dispatch
            </span>
        </div>

        <form action="{{ route('customer.settings.notifications') }}" method="POST">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px;">
                
                <!-- SMS Alerts -->
                <label style="display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; cursor: pointer;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span style="font-size: 22px;">📱</span>
                        <div>
                            <strong style="font-size: 14px; color: #111; display: block;">SMS Critical Job Updates</strong>
                            <span style="font-size: 12px; color: #64748B;">Receive 4-digit arrival OTP, technician ETA, and urgent booking dispatches on {{ $user->phone ?? 'your registered mobile' }}.</span>
                        </div>
                    </div>
                    <input type="checkbox" name="sms_alerts" value="1" {{ $user->getNotificationPref('sms_alerts', true) ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.4); cursor: pointer;">
                </label>

                <!-- WhatsApp Alerts -->
                <label style="display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; cursor: pointer;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span style="font-size: 22px;">💬</span>
                        <div>
                            <strong style="font-size: 14px; color: #111; display: block;">WhatsApp Alerts & Escrow Invoices</strong>
                            <span style="font-size: 12px; color: #64748B;">Instant WhatsApp messages with escrow payment receipt PDF, technician profile link, and service warranties.</span>
                        </div>
                    </div>
                    <input type="checkbox" name="whatsapp_alerts" value="1" {{ $user->getNotificationPref('whatsapp_alerts', true) ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.4); cursor: pointer;">
                </label>

                <!-- Booking Status In-App & Push -->
                <label style="display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; cursor: pointer;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span style="font-size: 22px;">🔔</span>
                        <div>
                            <strong style="font-size: 14px; color: #111; display: block;">In-App Bell & Booking Update Notifications</strong>
                            <span style="font-size: 12px; color: #64748B;">Updates when technician is dispatched, arrived, or finishes job inspection.</span>
                        </div>
                    </div>
                    <input type="checkbox" name="booking_updates" value="1" {{ $user->getNotificationPref('booking_updates', true) ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.4); cursor: pointer;">
                </label>

                <!-- Email Receipts -->
                <label style="display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; cursor: pointer;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span style="font-size: 22px;">📧</span>
                        <div>
                            <strong style="font-size: 14px; color: #111; display: block;">Email Receipts & Billing Summary</strong>
                            <span style="font-size: 12px; color: #64748B;">Detailed invoice sent to {{ $user->email }} upon job completion and escrow release.</span>
                        </div>
                    </div>
                    <input type="checkbox" name="email_receipts" value="1" {{ $user->getNotificationPref('email_receipts', true) ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.4); cursor: pointer;">
                </label>

                <!-- Promotions & Community Alerts -->
                <label style="display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; cursor: pointer;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <span style="font-size: 22px;">📢</span>
                        <div>
                            <strong style="font-size: 14px; color: #111; display: block;">Local Civic Hazard & Seasonal Maintenance Alerts</strong>
                            <span style="font-size: 12px; color: #64748B;">Alerts regarding seasonal AC servicing specials, power grid outages, or plumbing safety advisories.</span>
                        </div>
                    </div>
                    <input type="checkbox" name="promotions" value="1" {{ $user->getNotificationPref('promotions', false) ? 'checked' : '' }} style="accent-color: #FFB800; transform: scale(1.4); cursor: pointer;">
                </label>

            </div>

            <button type="submit" class="btn-yellow" style="padding: 10px 26px; font-size: 14px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                Save Notification Preferences
            </button>
        </form>
    </div>

    <!-- Security & Password -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Security & Password</h3>

        <form action="{{ route('customer.password.update') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Current Password</label>
                <input type="password" name="current_password" class="form-input" placeholder="••••••••" required style="padding: 9px 12px; font-size: 13.5px; max-width: 380px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">New Password</label>
                    <input type="password" name="password" class="form-input" placeholder="At least 8 characters" required style="padding: 9px 12px; font-size: 13.5px;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Re-type new password" required style="padding: 9px 12px; font-size: 13.5px;">
                </div>
            </div>

            <button type="submit" class="btn-yellow" style="padding: 10px 24px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                Update Password
            </button>
        </form>
    </div>

</div>
@endsection
