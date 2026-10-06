@extends('Frontend.layouts.customer')

@section('title', 'My Profile & Saved Addresses — FixMate')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">My Profile</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Manage personal details, saved address, and preferences.</p>
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

    <!-- Profile Header Card matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 18px;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: #111; color: #FFCC00; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 900; border: 3px solid #FFCC00; text-transform: uppercase;">
                {{ mb_substr($user->name, 0, 2) }}
            </div>
            <div>
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin: 0 0 4px 0;">{{ $user->name }}</h2>
                <span style="font-size: 13.5px; color: #666; display: block;">{{ $user->email }} • {{ $user->phone ?? 'No phone added' }}</span>
                <span style="font-size: 11px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 2px 8px; border-radius: 10px; margin-top: 4px; display: inline-block;">
                    ✓ FixMate Verified Customer
                </span>
            </div>
        </div>
        <a href="{{ route('customer.settings') }}" class="btn-outline" style="padding: 8px 16px; font-size: 13px; text-decoration: none;">Security Settings</a>
    </div>

    <!-- Personal Info Form -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">Personal Information</h3>

        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Full Name</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required style="padding: 9px 12px; font-size: 13.5px;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Phone Number</label>
                    <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" required style="padding: 9px 12px; font-size: 13.5px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Email Address</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required style="padding: 9px 12px; font-size: 13.5px;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Primary City</label>
                    <input type="text" name="city" class="form-input" value="{{ old('city', $user->city ?? 'Karachi') }}" placeholder="e.g. Karachi, Lahore, Islamabad" style="padding: 9px 12px; font-size: 13.5px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Default Area / Street Address</label>
                <input type="text" name="area" class="form-input" value="{{ old('area', $user->area ?? 'Phase 6, DHA') }}" placeholder="Street, block, and neighborhood" style="padding: 9px 12px; font-size: 13.5px;">
            </div>

            <button type="submit" class="btn-yellow" style="padding: 10px 26px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                Save Profile Changes
            </button>
        </form>
    </div>

    <!-- Saved Addresses matching Mockup 2 & 3 -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="font-size: 16px; font-weight: 800; color: #111; margin: 0;">Saved Service Address</h3>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <strong style="font-size: 14px; color: #111;">🏠 Home (Primary)</strong>
                        <span style="font-size: 10px; background: #ECFDF5; color: #047857; font-weight: 800; padding: 1px 6px; border-radius: 4px;">Default</span>
                    </div>
                    <span style="font-size: 13px; color: #666;">{{ $user->address ?? 'House 42-B, Street 18, Phase 6, DHA' }}, {{ $user->city ?? 'Karachi' }}</span>
                </div>
                <a href="#name" class="btn-outline" style="padding: 5px 12px; font-size: 12px; text-decoration: none;">Edit Above</a>
            </div>
        </div>
    </div>

</div>
@endsection
