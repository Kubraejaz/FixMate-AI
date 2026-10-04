@extends('Frontend.layouts.technician')

@section('title', 'Technician Profile & Partner Settings — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Partner Profile & Settings</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Manage your marketplace presence, contact details, operational area, and skills.</p>
    </div>

    <!-- Header Card -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="position: relative;">
                <img src="{{ asset($user->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $user->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                @if($user->is_verified)
                    <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 2px solid #FFF;">✓</span>
                @endif
            </div>
            <div>
                <h2 style="font-size: 22px; font-weight: 900; color: #111; margin: 0 0 4px 0;">{{ $user->name }}</h2>
                <span style="font-size: 14px; color: #666; display: block; margin-bottom: 6px;">
                    {{ $pro->profession?->name ?? 'Professional Technician' }} &bull; {{ $user->experience ?? '5 Years Experience' }}
                </span>
                <span style="background: {{ $user->is_verified ? '#ECFDF5' : '#FFFBEB' }}; color: {{ $user->is_verified ? '#047857' : '#B45309' }}; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; border: 1px solid {{ $user->is_verified ? '#A7F3D0' : '#FDE68A' }};">
                    {{ $user->is_verified ? '✓ Verified Partner Pro' : 'KYC Verification Pending' }}
                </span>
            </div>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('technician.verification') }}" class="btn-outline" style="padding: 8px 16px; font-size: 13px; text-decoration: none;">
                KYC Verification
            </a>
            <a href="{{ route('technician.skills') }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px; font-weight: 800; text-decoration: none;">
                Trade Skills
            </a>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <h3 style="font-size: 17px; font-weight: 800; color: #111; margin-bottom: 20px;">Contact & Operational Details</h3>

        <form action="{{ route('technician.profile.update') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input" style="padding: 10px 12px; font-size: 13.5px;">
                </div>
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">Contact Phone (SMS & OTP alerts)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="form-input" style="padding: 10px 12px; font-size: 13.5px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">Operational City</label>
                    <input type="text" name="city" value="{{ old('city', $user->city ?? 'Karachi') }}" required class="form-input" style="padding: 10px 12px; font-size: 13.5px;">
                </div>
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">Neighborhood / Coverage Area</label>
                    <input type="text" name="area" value="{{ old('area', $user->area ?? 'DHA, Clifton, PECHS') }}" class="form-input" style="padding: 10px 12px; font-size: 13.5px;">
                </div>
            </div>

            <div style="margin-bottom: 22px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 4px; display: block;">Experience Bio</label>
                <input type="text" name="experience" value="{{ old('experience', $user->experience ?? $pro->experience) }}" class="form-input" style="padding: 10px 12px; font-size: 13.5px;">
            </div>

            <button type="submit" class="btn-yellow" style="padding: 11px 26px; font-size: 14px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                Save Profile Changes &rarr;
            </button>
        </form>
    </div>

</div>
@endsection
