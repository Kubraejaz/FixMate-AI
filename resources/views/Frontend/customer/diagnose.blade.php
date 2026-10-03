@extends('Frontend.layouts.customer')

@section('title', 'AI Problem Diagnosis — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <!-- Title matching Mockup 1 & 2 -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 6px;">Describe Your Problem</h1>
        <p style="font-size: 14.5px; color: #666; margin: 0;">Tell us what's wrong and upload photos. Our AI will analyze the issue and recommend the right service and technician.</p>
    </div>

    <div class="portal-card" style="padding: 32px; background: #FFFFFF;">
        <form action="{{ route('customer.ai-result') }}" method="GET">
            
            <!-- Category / Trade Selection -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px;">Select Trade Category (Optional)</label>
                <select name="category" class="form-input" style="font-size: 13.5px; padding: 10px 14px;">
                    @foreach($professions as $prof)
                        <option value="{{ $prof->slug }}" {{ request('category') == $prof->slug ? 'selected' : '' }}>
                            {{ $prof->name }} (Base: Rs. {{ number_format($prof->base_price) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- What problem are you facing? matching Mockup 1 -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px;">What problem are you facing?</label>
                <textarea name="issue" class="form-input" rows="4" style="font-size: 14px; line-height: 1.6; padding: 12px 14px;" placeholder="e.g. My kitchen sink is leaking and water is coming from the pipe under the cabinet whenever the faucet is turned on...">{{ old('issue', request('q', $queryText ?: 'My kitchen sink is leaking and water is coming from the pipe under the cabinet whenever the tap is running.')) }}</textarea>
            </div>

            <!-- Upload Photos (Drag & Drop + Real Image preview matching Mockup 1) -->
            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px;">Upload Photos / Video (AI Scanner)</label>
                
                <div style="display: grid; grid-template-columns: 180px 140px 140px; gap: 14px; align-items: center;">
                    
                    <!-- Upload Dropzone -->
                    <div style="border: 2px dashed #D1D5DB; border-radius: 14px; padding: 24px 14px; text-align: center; background: #F9FAFB; cursor: pointer;">
                        <div style="font-size: 26px; margin-bottom: 6px;">📷</div>
                        <strong style="display: block; font-size: 12px; color: #111;">Upload Photos</strong>
                        <span style="font-size: 11px; color: #888;">or drag and drop</span>
                    </div>

                    <!-- Photo 1 preview using real image_6.png (Kitchen sink pipe leak) -->
                    <div style="position: relative; border-radius: 14px; overflow: hidden; height: 110px; border: 2px solid #FFCC00; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
                        <img src="{{ asset('assets/images/image_6.png') }}" alt="Leaking sink" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,0.6); color: #FFF; width: 18px; height: 18px; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer;">✕</span>
                        <span style="position: absolute; bottom: 4px; left: 4px; background: #10B981; color: #FFF; font-size: 9px; font-weight: 800; padding: 1px 6px; border-radius: 4px;">Photo 1</span>
                    </div>

                    <!-- Photo 2 preview using real image_7.png -->
                    <div style="position: relative; border-radius: 14px; overflow: hidden; height: 110px; border: 1px solid var(--border-color);">
                        <img src="{{ asset('assets/images/image_7.png') }}" alt="Cabinet interior" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,0.6); color: #FFF; width: 18px; height: 18px; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer;">✕</span>
                        <span style="position: absolute; bottom: 4px; left: 4px; background: #6B7280; color: #FFF; font-size: 9px; font-weight: 800; padding: 1px 6px; border-radius: 4px;">Photo 2</span>
                    </div>

                </div>
            </div>

            <!-- Two Selects: Location & Urgency matching Mockup 1 -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 800; color: #111; margin-bottom: 6px;">Select Location</label>
                    <select name="city" class="form-input" style="font-size: 13.5px; padding: 10px 14px;">
                        <option value="Karachi">Karachi, Pakistan (DHA Phase 6)</option>
                        <option value="Karachi">Karachi, Clifton Block 4</option>
                        <option value="Lahore">Lahore, Gulberg III</option>
                        <option value="Islamabad">Islamabad, Sector F-8/2</option>
                    </select>
                </div>

                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 800; color: #111; margin-bottom: 6px;">Urgency Level</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <label style="border: 2px solid #FFCC00; background: #FFFDF0; padding: 9px 12px; border-radius: 10px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="urgency" value="normal" checked style="accent-color: #FFCC00;">
                            <div>
                                <strong style="font-size: 13px; color: #111; display: block;">Normal</strong>
                                <span style="font-size: 10.5px; color: #777;">Within 24 Hours</span>
                            </div>
                        </label>
                        <label style="border: 1px solid var(--border-color); background: #FFF; padding: 9px 12px; border-radius: 10px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="urgency" value="urgent" style="accent-color: #FFCC00;">
                            <div>
                                <strong style="font-size: 13px; color: #DC2626; display: block;">Urgent</strong>
                                <span style="font-size: 10.5px; color: #777;">Within 30 Mins</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit CTA matching Mockup 1 -->
            <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px 0; font-size: 15px; font-weight: 900; border-radius: 12px; border: none; cursor: pointer;">
                Analyze My Problem With AI
            </button>
        </form>
    </div>

</div>
@endsection
