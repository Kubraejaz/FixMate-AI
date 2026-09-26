@extends('Frontend.layouts.customer')

@section('title', 'My Profile & Saved Addresses — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Profile</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Manage personal details, saved addresses, and preferences.</p>
    </div>

    <!-- Profile Header Card matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 18px;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 900; border: 3px solid #FFCC00;">
                AK
            </div>
            <div>
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin: 0 0 4px 0;">Ahmed Khan</h2>
                <span style="font-size: 13.5px; color: #666; display: block;">ahmed.khan@email.com • +92 300 1234567</span>
                <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 8px; border-radius: 10px; margin-top: 4px; display: inline-block;">
                    ✓ Phone Verified
                </span>
            </div>
        </div>
        <button class="btn-outline" style="padding: 8px 16px; font-size: 13px;">Change Photo</button>
    </div>

    <!-- Personal Info Form -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Personal Information</h3>

        <form action="{{ url('/customer/profile') }}" method="GET">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Full Name</label>
                    <input type="text" class="form-input" value="Ahmed Khan" style="padding: 9px 12px; font-size: 13.5px;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Phone Number</label>
                    <input type="text" class="form-input" value="+92 300 1234567" style="padding: 9px 12px; font-size: 13.5px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Email Address</label>
                    <input type="email" class="form-input" value="ahmed.khan@email.com" style="padding: 9px 12px; font-size: 13.5px;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Preferred Language</label>
                    <select class="form-input" style="padding: 9px 12px; font-size: 13.5px;">
                        <option>English (Pakistan)</option>
                        <option>اردو (Urdu)</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-yellow" style="padding: 9px 24px; font-size: 13.5px; font-weight: 800;">
                Save Changes
            </button>
        </form>
    </div>

    <!-- Saved Addresses matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Saved Service Addresses</h3>
            <button class="btn-outline" style="padding: 6px 14px; font-size: 12.5px;">+ Add New Address</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <strong style="font-size: 14px; color: #111;">🏠 Home (Primary)</strong>
                        <span style="font-size: 10px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 1px 6px; border-radius: 4px;">Default</span>
                    </div>
                    <span style="font-size: 13px; color: #666;">House 42-B, Street 18, Phase 6, DHA, Karachi</span>
                </div>
                <button class="btn-outline" style="padding: 5px 12px; font-size: 12px;">Edit</button>
            </div>

            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <strong style="font-size: 14px; color: #111;">🏢 Office</strong>
                    </div>
                    <span style="font-size: 13px; color: #666;">Suite 401, Executive Tower, Clifton Block 4, Karachi</span>
                </div>
                <button class="btn-outline" style="padding: 5px 12px; font-size: 12px;">Edit</button>
            </div>
        </div>
    </div>

</div>
@endsection
