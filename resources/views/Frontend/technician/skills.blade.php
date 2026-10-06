@extends('Frontend.layouts.technician')

@section('title', 'Skills & Trade Specialties — FixMate Partner Portal')

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Skills & Trade Specialties</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Configure your primary trade and service capabilities for customer booking requests.</p>
    </div>

    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 24px;">
        <form action="{{ route('technician.skills.update') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 22px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px; display: block;">Primary Trade Profession</label>
                <select name="profession_id" class="form-input" style="padding: 11px 14px; font-size: 14px; width: 100%;">
                    @foreach($professions as $p)
                        <option value="{{ $p->id }}" {{ $pro->profession_id == $p->id ? 'selected' : '' }}>
                            {{ $p->name }} (Base Rate: Rs. {{ number_format($p->base_price) }})
                        </option>
                    @endforeach
                </select>
                <span style="font-size: 12px; color: #666; margin-top: 4px; display: block;">
                    Platform dispatching assigns incoming requests matching your primary trade.
                </span>
            </div>

            <div style="margin-bottom: 22px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px; display: block;">Experience Level</label>
                <input type="text" name="experience" value="{{ old('experience', $pro->experience ?? '5 Years Experience') }}" required class="form-input" style="padding: 10px 14px; font-size: 14px; width: 100%;">
            </div>

            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px; margin-bottom: 24px;">
                <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">⚡ Dispatch Priority Booster</h4>
                <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.5;">
                    FixMate prioritizes technicians with high response rates and verified trade badges. Keep your schedule updated to receive high-urgency nearby requests.
                </p>
            </div>

            <button type="submit" class="btn-yellow" style="padding: 12px 28px; font-size: 14.5px; font-weight: 900; border: none; cursor: pointer; border-radius: 8px;">
                Save Skills & Specialties &rarr;
            </button>
        </form>
    </div>

</div>
@endsection
