@extends('Frontend.layouts.customer')

@section('title', 'Schedule Service Booking — FixMate')

@section('content')
<div style="max-width: 880px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Confirm Your Booking</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Select your trade category, date, preferred time slot and service address.</p>
    </div>

    @if ($errors->any())
        <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px;">
            <strong style="display: block; margin-bottom: 4px;">Please correct the errors below:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.booking.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1.25fr 0.75fr; gap: 24px; align-items: flex-start;">
            
            <!-- Left: Schedule & Address Form -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- Selected Professional / Trade Card -->
                @if($selectedTechnician)
                    <input type="hidden" name="professional_id" value="{{ $selectedTechnician->id }}">
                    <input type="hidden" name="profession_id" value="{{ $selectedTechnician->profession_id }}">
                    <div class="portal-card" style="padding: 20px; background: #FFFFFF; display: flex; align-items: center; gap: 16px; border: 2px solid #FFCC00;">
                        <img src="{{ asset($selectedTechnician->profile_image ?: 'assets/images/image_1.png') }}" alt="{{ $selectedTechnician->name }}" style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                        <div style="flex: 1;">
                            <strong style="display: block; font-size: 15px; color: #111;">{{ $selectedTechnician->name }}</strong>
                            <span style="font-size: 12.5px; color: #666;">{{ $selectedTechnician->profession->name ?? 'Specialist' }} • ★ {{ number_format($selectedTechnician->rating ?? 4.9, 1) }} ({{ $selectedTechnician->jobs_completed ?? 45 }} jobs)</span>
                        </div>
                        <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 10px;">Assigned Pro</span>
                    </div>
                @else
                    <!-- Select Profession Dropdown -->
                    <div class="portal-card" style="padding: 20px; background: #FFFFFF;">
                        <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px;">Select Service Profession</label>
                        <select name="profession_id" id="profession_select" class="form-input" style="padding: 10px 14px; font-size: 14px; font-weight: 600;" required onchange="updateSummary(this)">
                            @foreach($professions as $prof)
                                <option value="{{ $prof->id }}" data-price="{{ $prof->base_price }}" data-name="{{ $prof->name }}" {{ ($selectedProfession && $selectedProfession->id === $prof->id) || (! $selectedProfession && $loop->first) ? 'selected' : '' }}>
                                    {{ $prof->name }} (Inspection from Rs. {{ number_format($prof->base_price) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Service Title & Problem Description -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Service Specifics</h3>

                    <div class="form-group" style="margin-bottom: 14px;">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Issue Title / Job Summary</label>
                        <input type="text" name="service_title" class="form-input" placeholder="e.g. Kitchen Sink Leakage & P-trap Replacement" value="{{ old('service_title', request('issue', 'General Inspection & Repair')) }}" style="padding: 10px 12px; font-size: 13.5px;">
                    </div>

                    <div class="form-group" style="margin-bottom: 14px;">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Detailed Problem Description (Optional)</label>
                        <textarea name="problem_description" class="form-input" rows="3" placeholder="Provide extra details to help the technician arrive with the right spare parts..." style="padding: 10px 12px; font-size: 13.5px;">{{ old('problem_description', request('q')) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Upload Photo (Optional)</label>
                        <input type="file" name="problem_image" class="form-input" accept="image/*" style="padding: 8px 12px; font-size: 12.5px;">
                    </div>
                </div>

                <!-- Select Date & Time Slot (Matching Mockup 2 & 3) -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Select Date & Time</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                        <div>
                            <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Preferred Date</label>
                            <input type="date" name="service_date" min="{{ now()->toDateString() }}" value="{{ old('service_date', now()->toDateString()) }}" class="form-input" required style="padding: 10px 12px; font-size: 13.5px;">
                        </div>

                        <div>
                            <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Time Slot</label>
                            <select name="service_time_slot" class="form-input" required style="padding: 10px 12px; font-size: 13.5px;">
                                <option value="Morning (9:00 AM - 12:00 PM)" {{ old('service_time_slot') == 'Morning (9:00 AM - 12:00 PM)' ? 'selected' : '' }}>Morning (9:00 AM - 12:00 PM)</option>
                                <option value="Afternoon (12:00 PM - 3:00 PM)" {{ old('service_time_slot') == 'Afternoon (12:00 PM - 3:00 PM)' ? 'selected' : '' }}>Afternoon (12:00 PM - 3:00 PM)</option>
                                <option value="Evening (3:00 PM - 6:00 PM)" {{ old('service_time_slot', 'Evening (3:00 PM - 6:00 PM)') == 'Evening (3:00 PM - 6:00 PM)' ? 'selected' : '' }}>Evening (3:00 PM - 6:00 PM)</option>
                                <option value="Night (6:00 PM - 9:00 PM)" {{ old('service_time_slot') == 'Night (6:00 PM - 9:00 PM)' ? 'selected' : '' }}>Night (6:00 PM - 9:00 PM)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Service Address -->
                <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 14px;">Service Address</h3>
                    
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px; margin-bottom: 12px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Street & House Number</label>
                            <input type="text" name="service_address" class="form-input" value="{{ old('service_address', $user->address ?? 'House 42-B, Street 18, Phase 6, DHA') }}" required style="padding: 10px 12px; font-size: 13.5px;">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size: 12.5px; font-weight: 700;">City</label>
                            <input type="text" name="city" class="form-input" value="{{ old('city', $user->city ?? 'Karachi') }}" required style="padding: 10px 12px; font-size: 13.5px;">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary -->
            <div class="portal-card" style="padding: 24px; background: #FFFFFF; position: sticky; top: 100px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Booking Summary</h3>

                @php
                    $initPrice = $selectedTechnician ? ($selectedTechnician->profession->base_price ?? 650) : ($selectedProfession->base_price ?? ($professions->first()?->base_price ?? 650));
                    $initName = $selectedTechnician ? ($selectedTechnician->profession->name ?? 'Professional') : ($selectedProfession->name ?? ($professions->first()?->name ?? 'General Service'));
                @endphp

                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13.5px; margin-bottom: 18px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Service Trade</span>
                        <strong id="summary_service_name" style="color: #111;">{{ $initName }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Diagnosis Severity</span>
                        <strong style="color: #047857;">Standard FixMate Visit</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Inspection Base Rate</span>
                        <strong id="summary_base_price" style="color: #111;">Rs. {{ number_format($initPrice) }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Platform Trust Fee</span>
                        <strong style="color: #10B981;">FREE (Rs. 0)</strong>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 14px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-size: 14px; font-weight: 800; color: #111;">Estimated Initial</span>
                        <strong id="summary_total_price" style="font-size: 20px; font-weight: 900; color: #047857;">Rs. {{ number_format($initPrice) }}</strong>
                    </div>
                    <span style="font-size: 11px; color: #888; display: block; margin-top: 4px;">Secured in Escrow until Arrival OTP is verified</span>
                </div>

                <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px 0; font-size: 14.5px; font-weight: 800; border-radius: 10px; margin-bottom: 12px; cursor: pointer; border: none;">
                    Confirm & Dispatch Booking →
                </button>

                <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 11.5px; color: #059669;">
                    <span>🛡️ FixMate 100% Protection Guarantee</span>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
function updateSummary(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || 650;
    const name = selectedOption.getAttribute('data-name') || 'Home Repair';

    const formatted = new Intl.NumberFormat('en-PK').format(price);
    document.getElementById('summary_service_name').textContent = name;
    document.getElementById('summary_base_price').textContent = 'Rs. ' + formatted;
    document.getElementById('summary_total_price').textContent = 'Rs. ' + formatted;
}
</script>
@endsection
