@extends('Frontend.layouts.customer')

@section('title', 'Recommended Technicians — FixMate')

@section('content')
<div style="max-width: 880px; margin: 0 auto;">
    
    <!-- Title & Subtitle matching Mockup 1 & 2 -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 6px;">Recommended Technicians</h1>
        <p style="font-size: 14.5px; color: #666; margin: 0;">Verified, background-checked trade professionals ranked by rating, proximity and customer trust.</p>
    </div>

    <!-- Filter Bar & Search -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('customer.technicians') }}" class="{{ !request('profession') ? 'btn-yellow' : 'btn-outline' }}" style="padding: 6px 16px; font-size: 12.5px; border-radius: 20px; text-decoration: none;">
                All Trades
            </a>
            @foreach($professions as $prof)
                <a href="{{ route('customer.technicians', ['profession' => $prof->id]) }}" class="{{ request('profession') == $prof->id ? 'btn-yellow' : 'btn-outline' }}" style="padding: 6px 16px; font-size: 12.5px; border-radius: 20px; text-decoration: none;">
                    {{ $prof->name }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('customer.technicians') }}" method="GET" style="display: flex; gap: 8px;">
            @if(request('profession'))
                <input type="hidden" name="profession" value="{{ request('profession') }}">
            @endif
            <input type="text" name="search" placeholder="Search technician name..." value="{{ request('search') }}" class="form-input" style="padding: 6px 12px; font-size: 13px; width: 200px; border-radius: 8px;">
            <button type="submit" class="btn-outline" style="padding: 6px 14px; font-size: 13px; border-radius: 8px; cursor: pointer;">Search</button>
        </form>
    </div>

    <!-- Technicians List Cards matching Mockup 1 -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
        
        @forelse($technicians as $tech)
            <div class="portal-card" style="padding: 24px; background: #FFFFFF; display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center;">
                <div style="position: relative;">
                    <img src="{{ asset($tech->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $tech->name }}" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #FFCC00;">
                    @if($tech->is_verified)
                        <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;" title="NADRA Verified Pro">✓</span>
                    @endif
                </div>

                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                        <h3 style="font-size: 18px; font-weight: 800; color: #111; margin: 0;">{{ $tech->name }}</h3>
                        <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 12px; border: 1px solid #A7F3D0;">
                            {{ $tech->is_verified ? 'Verified Pro' : 'Certified' }}
                        </span>
                        <span style="font-size: 12px; color: #777;">• 📍 ~2-4 km away</span>
                    </div>
                    <span style="font-size: 13.5px; color: #666; font-weight: 600; display: block; margin-bottom: 8px;">
                        {{ $tech->profession->name ?? 'Professional' }} • {{ $tech->experience ?? '5+ years' }} exp
                    </span>

                    <div style="display: flex; align-items: center; gap: 14px; font-size: 12.5px; color: #666; margin-bottom: 8px;">
                        <span style="color: #F59E0B;">★ <strong style="color: #111;">{{ number_format($tech->rating ?? 4.9, 1) }}</strong> ({{ $tech->jobs_completed ?? 45 }} jobs)</span>
                        <span style="color: #059669; font-weight: 700;">● Completed {{ $tech->jobs_completed ?? 30 }}+ verified repairs</span>
                    </div>

                    <div style="display: flex; gap: 6px;">
                        <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">{{ $tech->profession->name ?? 'General' }}</span>
                        <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">30-Day Warranty</span>
                        <span style="background: #F3F4F6; color: #4B5563; font-size: 11px; padding: 2px 7px; border-radius: 4px;">Arrival OTP Handshake</span>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                    <div style="text-align: right; line-height: 1.2;">
                        <span style="font-size: 11px; color: #888;">Base Inspection Fee</span>
                        <strong style="display: block; font-size: 16px; color: #111;">Rs. {{ number_format($tech->profession?->base_price ?? 650) }}</strong>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('technician-profile', $tech->id) }}" class="btn-outline" style="padding: 8px 14px; font-size: 12.5px; text-decoration: none; border-radius: 8px;">View Profile</a>
                        <a href="{{ route('customer.booking', ['tech_id' => $tech->id]) }}" class="btn-yellow" style="padding: 8px 18px; font-size: 13px; text-decoration: none; border-radius: 8px;">Book Now</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="portal-card" style="padding: 48px; text-align: center; background: #FFFFFF;">
                <span style="font-size: 36px; display: block; margin-bottom: 8px;">🔍</span>
                <strong style="display: block; font-size: 16px; color: #111; margin-bottom: 4px;">No technicians matched your search</strong>
                <p style="font-size: 13.5px; color: #666; margin-bottom: 16px;">Try adjusting your trade filters or search keyword.</p>
                <a href="{{ route('customer.technicians') }}" class="btn-yellow" style="padding: 8px 20px; font-size: 13px; text-decoration: none; border-radius: 8px;">
                    View All Technicians
                </a>
            </div>
        @endforelse

    </div>

    <div style="margin-top: 24px;">
        {{ $technicians->links() }}
    </div>

</div>
@endsection
