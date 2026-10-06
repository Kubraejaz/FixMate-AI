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
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px; display: block;">Primary Trade Category</label>
                <select name="profession_id" id="professionSelect" class="form-input" style="padding: 11px 14px; font-size: 14px; width: 100%;" onchange="updateSubCategories(this.value)">
                    @foreach($professions as $p)
                        <option value="{{ $p->id }}" {{ $pro->profession_id == $p->id ? 'selected' : '' }}>
                            {{ $p->display_icon }} {{ $p->name }} (Base Tariff: Rs. {{ number_format($p->base_price) }})
                        </option>
                    @endforeach
                </select>
                <span style="font-size: 12px; color: #666; margin-top: 4px; display: block;">
                    Platform dispatching assigns incoming customer requests matching your primary trade category.
                </span>
            </div>

            <!-- Sub-Categories Selection -->
            <div style="margin-bottom: 24px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 4px; display: block;">
                    Service Sub-Categories &amp; Specialized Capabilities
                </label>
                <span style="font-size: 12.5px; color: #64748B; margin-bottom: 12px; display: block;">
                    Select the specific sub-services you perform under your trade to receive targeted job requests.
                </span>

                @php
                    $savedSubs = is_array($pro->sub_categories) ? $pro->sub_categories : [];
                @endphp

                @foreach($professions as $p)
                    <div id="subcat-group-{{ $p->id }}" class="subcat-group" style="display: {{ $pro->profession_id == $p->id ? 'block' : 'none' }}; background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <strong style="font-size: 13.5px; color: #0F172A;">{{ $p->name }} Sub-Categories ({{ count($p->sub_categories_list) }})</strong>
                            <span style="font-size: 11.5px; color: #059669; font-weight: 700;">Select all that apply</span>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 10px;">
                            @foreach($p->sub_categories_list as $sub)
                                @php
                                    $isChecked = in_array($sub, $savedSubs) || empty($savedSubs);
                                @endphp
                                <label style="display: flex; align-items: flex-start; gap: 8px; font-size: 13px; color: #334155; background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 8px; padding: 10px 12px; cursor: pointer; transition: border-color 0.15s ease;">
                                    <input type="checkbox" name="sub_categories[]" value="{{ $sub }}" {{ $isChecked ? 'checked' : '' }} style="margin-top: 2px;">
                                    <span>{{ $sub }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-bottom: 22px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px; display: block;">Experience Level</label>
                <input type="text" name="experience" value="{{ old('experience', $pro->experience ?? '5 Years Experience') }}" required class="form-input" style="padding: 10px 14px; font-size: 14px; width: 100%;">
            </div>

            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px; margin-bottom: 24px;">
                <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">⚡ Dispatch Priority Booster</h4>
                <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.5;">
                    FixMate prioritizes technicians with comprehensive sub-category coverage and high response rates. Keep your capabilities updated to receive higher earnings.
                </p>
            </div>

            <button type="submit" class="btn-yellow" style="padding: 12px 28px; font-size: 14.5px; font-weight: 900; border: none; cursor: pointer; border-radius: 8px;">
                Save Skills &amp; Sub-Categories &rarr;
            </button>
        </form>
    </div>

</div>

@endsection

@section('extra_js')
<script>
    function updateSubCategories(professionId) {
        document.querySelectorAll('.subcat-group').forEach(function(el) {
            el.style.display = 'none';
        });
        var activeGroup = document.getElementById('subcat-group-' + professionId);
        if (activeGroup) {
            activeGroup.style.display = 'block';
        }
    }
</script>
@endsection
