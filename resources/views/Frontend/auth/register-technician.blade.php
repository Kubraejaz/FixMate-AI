@extends('Frontend.layouts.public')

@section('title', 'Technician Registration — FixMate AI Partner Onboarding')

@section('content')
<div class="site-wrapper" style="background: #FAFAFA; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 40px 0;">
    <div class="container" style="max-width: 540px;">
        
        <div class="portal-card" style="padding: 36px 32px; background: #FFFFFF; border-radius: 20px;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="display: inline-flex; width: 40px; height: 40px; border-radius: 10px; background: #FFCC00; align-items: center; justify-content: center; margin-bottom: 10px;">
                    🛠️
                </div>
                <h1 style="font-size: 24px; font-weight: 900; color: #111; margin-bottom: 4px;">Become a Technician</h1>
                <p style="font-size: 13.5px; color: #666; margin: 0;">Join our network of verified professionals & earn fairly.</p>
            </div>

            <form action="{{ url('/verify-otp?role=technician') }}" method="GET">
                <!-- Full Name -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Full Legal Name (as on CNIC)</label>
                    <input type="text" class="form-input" placeholder="e.g. Ali Khan" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- Phone Number -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Mobile Number (for OTP & Job Alerts)</label>
                    <input type="text" class="form-input" placeholder="0300-1234567" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- CNIC Number -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">National Identity Card (CNIC)</label>
                    <input type="text" class="form-input" placeholder="42201-1234567-1" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- Primary Trade / Skill -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Primary Trade / Specialization</label>
                    <select class="form-input" required style="padding: 10px 14px; font-size: 14px;">
                        <option value="">Select your skill trade...</option>
                        <option>Plumbing (Pipes, Sanitary, Sinks, Motors)</option>
                        <option>Electrical (Wiring, Breakers, DB boxes)</option>
                        <option>AC & Refrigeration (Inverter, Gas refill)</option>
                        <option>Carpentry & Locksmith</option>
                        <option>Deep Cleaning & Sanitation</option>
                        <option>Home Appliances (Washing machine, Microwave)</option>
                    </select>
                </div>

                <!-- Experience Years -->
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Years of Hands-on Experience</label>
                    <select class="form-input" required style="padding: 10px 14px; font-size: 14px;">
                        <option>1 - 2 Years</option>
                        <option>3 - 5 Years</option>
                        <option selected>5 - 8 Years</option>
                        <option>8+ Years</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="form-group" style="margin-bottom: 18px;">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #374151;">Create Password</label>
                    <input type="password" class="form-input" placeholder="At least 8 characters" required style="padding: 10px 14px; font-size: 14px;">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-yellow" style="width: 100%; padding: 12px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px;">
                    Register & Continue to Verification
                </button>
            </form>

            <div style="text-align: center; margin-top: 20px; font-size: 13px; color: #666;">
                Already registered as a partner? <a href="{{ url('/login') }}" style="color: #111; font-weight: 800; text-decoration: none;">Login</a>
            </div>
        </div>

    </div>
</div>
@endsection
