@extends('Frontend.layouts.public')

@section('title', 'Customer Registration — FixMate AI')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 40px 0;">
    <div class="container" style="max-width: 520px;">
        
        <div class="portal-card" style="padding: 36px 32px; background: #FFFFFF; border-radius: 20px;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="display: inline-flex; width: 40px; height: 40px; border-radius: 10px; background: #FFCC00; align-items: center; justify-content: center; margin-bottom: 10px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    </svg>
                </div>
                <h1 style="font-size: 24px; font-weight: 900; color: #111; margin-bottom: 4px;">Create Customer Account</h1>
                <p style="font-size: 13.5px; color: #666; margin: 0;">Join FixMate AI for AI diagnosis and trusted technicians.</p>
            </div>

            <form action="{{ url('/verify-otp') }}" method="GET">
                <!-- Full Name -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Full Name</label>
                    <input type="text" class="form-input" placeholder="e.g. Ayesha Khan" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- Email or Phone -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Email or Phone Number</label>
                    <input type="text" class="form-input" placeholder="0300-1234567 or email@domain.com" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- Location -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">City & Area</label>
                    <select class="form-input" required style="padding: 10px 14px; font-size: 14px;">
                        <option value="">Select your city...</option>
                        <option>Karachi (DHA, Clifton, Gulshan, Nazimabad)</option>
                        <option>Lahore (Gulberg, DHA, Cantt, Johar Town)</option>
                        <option>Islamabad / Rawalpindi (F-Sectors, Bahria, Saddar)</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Password</label>
                    <input type="password" class="form-input" placeholder="At least 8 characters" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- Confirm Password -->
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Confirm Password</label>
                    <input type="password" class="form-input" placeholder="Re-enter password" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- Terms Checkbox -->
                <div style="display: flex; align-items: flex-start; gap: 8px; margin-bottom: 20px; font-size: 12.5px; color: #4B5563;">
                    <input type="checkbox" required style="margin-top: 3px; accent-color: #FFCC00;">
                    <span>I agree to the <a href="{{ url('/terms') }}" target="_blank" style="color: #111; font-weight: 700;">Terms & Conditions</a> and <a href="{{ url('/privacy-policy') }}" target="_blank" style="color: #111; font-weight: 700;">Privacy Policy</a>.</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px;">
                    Register
                </button>
            </form>

            <div style="text-align: center; margin-top: 20px; font-size: 13px; color: #666;">
                Already have an account? <a href="{{ url('/login') }}" style="color: #111; font-weight: 800; text-decoration: none;">Login</a>
            </div>
        </div>

    </div>
</div>
@endsection
