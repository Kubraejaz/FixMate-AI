@extends('Frontend.layouts.master')

@section('title', 'Become a Technician — FixMate')
@section('meta_desc', 'Join Pakistan\'s leading network of verified home maintenance professionals. Steady job dispatches, fast payouts, and professional growth.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px; display: flex; justify-content: center;">

    <!-- Split / Card Layout (Mockup 1) -->
    <div style="width: 100%; max-width: 600px;">
        
        <!-- Registration Form Card -->
        <div id="techRegCard" class="card-box" style="padding: 40px; box-shadow: var(--shadow-md);">
            <div style="text-align: center; margin-bottom: 24px;">
                <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 16px; text-decoration: none;">
                    <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 40px; width: auto; object-fit: contain; margin: 0 auto; display: block;">
                </a>

                <h1 style="font-size: 24px; font-weight: 800; color: #111; margin-bottom: 4px;">Become a Technician</h1>
                <p style="font-size: 13.5px; color: #757575;">Join our network of verified professionals</p>
            </div>

            <form onsubmit="handleTechRegister(event)">
                
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Full Name</label>
                    <input type="text" required placeholder="Enter full name" value="Ali Khan" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Phone Number</label>
                    <input type="tel" required placeholder="Enter phone number" value="+92 300 1234567" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Primary Trade Skill</label>
                    <select required style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none; background: #FFF;">
                        <option selected>Plumber (Pipe & Sanitary)</option>
                        <option>Electrician (Wiring & Circuit)</option>
                        <option>AC & Cooling Technician</option>
                        <option>Carpentry Specialist</option>
                        <option>Cleaning Professional</option>
                    </select>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">CNIC & Trade Documents</label>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <div style="background: #FAFAFA; border: 1px solid #E5E7EB; border-radius: 10px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                            <span>📄 CNIC Verification</span>
                            <span style="color: #10B981; font-weight: 700;">Uploaded ✓</span>
                        </div>
                        <div style="background: #FAFAFA; border: 1px solid #E5E7EB; border-radius: 10px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                            <span>📷 Profile Photo</span>
                            <span style="color: #10B981; font-weight: 700;">Uploaded ✓</span>
                        </div>
                        <div style="background: #FAFAFA; border: 1px solid #E5E7EB; border-radius: 10px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                            <span>📜 Certificates / Licenses</span>
                            <span style="color: #10B981; font-weight: 700;">Uploaded ✓</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px; font-size: 15px; margin-bottom: 18px; border-radius: 12px;">
                    Register as Technician
                </button>

                <p style="text-align: center; font-size: 13px; color: #666;">
                    Already have an account? <a href="{{ url('/login') }}" style="color: #111; font-weight: 700; text-decoration: underline;">Login</a>
                </p>

            </form>
        </div>

        <!-- Verification Status Card (Matching Mockup 1) -->
        <div id="techStatusCard" class="card-box" style="padding: 40px; text-align: center; display: none;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #FFF9E6; border: 2px solid #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px auto;">
                ⏳
            </div>
            <h2 style="font-size: 22px; font-weight: 800; color: #111; margin-bottom: 6px;">Verification Pending</h2>
            <p style="font-size: 13.5px; color: #757575; line-height: 1.5; margin-bottom: 24px;">
                Your documents are being reviewed by our Trust & Safety team. You'll be notified via SMS and email once verified (typically &lt; 24 hours).
            </p>

            <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 14px; padding: 18px; text-align: left; margin-bottom: 24px; font-size: 13px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>CNIC Verification:</span>
                    <strong style="color: #10B981;">Submitted</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>Profile Photo:</span>
                    <strong style="color: #10B981;">Submitted</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Trade Certificates:</span>
                    <strong style="color: #10B981;">Submitted</strong>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="{{ url('/provider') }}" class="btn-yellow" style="flex: 1; padding: 11px;">
                    Open Technician Portal
                </a>
                <a href="{{ url('/contact') }}" class="btn-outline" style="flex: 1; padding: 11px;">
                    Contact Support
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

@section('extra_js')
<script>
    function handleTechRegister(e) {
        e.preventDefault();
        document.getElementById('techRegCard').style.display = 'none';
        document.getElementById('techStatusCard').style.display = 'block';
        showToast("Application submitted! Verification in progress.");
    }
</script>
@endsection
