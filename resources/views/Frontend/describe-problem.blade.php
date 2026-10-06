@extends('Frontend.layouts.master')

@section('title', 'Describe Your Problem — FixMate')
@section('meta_desc', 'Tell us what is wrong and upload a photo. FixMate will match you with the right verified technician with upfront pricing.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px; display: flex; justify-content: center;">

    <!-- Describe Problem Card (Exact matching Mockup 1 & 2) -->
    <div class="card-box" style="width: 100%; max-width: 620px; padding: 36px;">
        
        <div style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span style="font-size: 12px; font-weight: 700; color: #8C6B00; background: #FFF9E6; border: 1px solid #FFECB3; padding: 2px 8px; border-radius: 6px;">STEP 1 OF 3</span>
                <span style="font-size: 12px; color: #777;">AI Problem Scanner</span>
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #111; margin-bottom: 4px;">Describe Your Problem</h1>
            <p style="font-size: 13.5px; color: #757575;">
                Tell us what's wrong and upload photos. Our AI will analyze the issue and recommend the right service and technicians.
            </p>
        </div>

        <form action="{{ url('/ai-analysis-result') }}" method="GET">
            
            <!-- What problem are you facing? -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13.5px; font-weight: 700; color: #111; margin-bottom: 8px;">
                    What problem are you facing?
                </label>
                <textarea name="problem" rows="4" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 14px 16px; font-size: 14px; outline: none; line-height: 1.5; color: #111;" placeholder="e.g. My kitchen sink is leaking and water is coming from the pipe underneath...">My kitchen sink is leaking and water is coming from the pipe underneath. Water pools whenever the tap runs.</textarea>
            </div>

            <!-- Upload Photos (Optional) with user's uploaded image -->
            <div style="margin-bottom: 22px;">
                <label style="display: block; font-size: 13.5px; font-weight: 700; color: #111; margin-bottom: 8px;">
                    Upload Photos (Optional)
                </label>
                
                <div style="border: 2px dashed #D1D5DB; border-radius: var(--radius-md); padding: 20px; background: #FAFAFA; text-align: center; position: relative;">
                    <!-- Thumbnails row matching mockup -->
                    <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                        <div style="position: relative; width: 80px; height: 80px; border-radius: 10px; overflow: hidden; border: 1.5px solid #FFCC00; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
                            <img src="{{ asset('assets/images/image_3.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <span style="position: absolute; top: 2px; right: 2px; background: rgba(0,0,0,0.6); color: #FFF; width: 18px; height: 18px; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center;">✕</span>
                        </div>
                        <div style="position: relative; width: 80px; height: 80px; border-radius: 10px; overflow: hidden; border: 1.5px solid #E5E7EB;">
                            <img src="{{ asset('assets/images/image_5.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <span style="position: absolute; top: 2px; right: 2px; background: rgba(0,0,0,0.6); color: #FFF; width: 18px; height: 18px; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center;">✕</span>
                        </div>
                        <div style="width: 80px; height: 80px; border-radius: 10px; border: 2px dashed #9CA3AF; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #6B7280; cursor: pointer;">
                            <span style="font-size: 22px; line-height: 1;">+</span>
                            <span style="font-size: 10px; font-weight: 600;">Add Photo</span>
                        </div>
                    </div>
                    <p style="font-size: 12px; color: #6B7280;">Drop photos or click to add more (Max 5 photos)</p>
                </div>
            </div>

            <!-- Select Location -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13.5px; font-weight: 700; color: #111; margin-bottom: 8px;">
                    Select Location
                </label>
                <div style="position: relative;">
                    <select name="location" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 12px 14px; font-size: 14px; outline: none; background: #FFF; color: #111;">
                        <option>Karachi, Pakistan (Current Location)</option>
                        <option>Lahore, Pakistan</option>
                        <option>Islamabad, Pakistan</option>
                        <option>Rawalpindi, Pakistan</option>
                        <option>Abbottabad, Mansehra</option>
                    </select>
                </div>
            </div>

            <!-- Urgency Level Toggle (Normal / Urgent) -->
            <div style="margin-bottom: 28px;">
                <label style="display: block; font-size: 13.5px; font-weight: 700; color: #111; margin-bottom: 8px;">
                    Urgency Level
                </label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <label style="border: 2px solid #FFCC00; background: #FFF9E6; padding: 12px; border-radius: var(--radius-md); display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="radio" name="urgency" value="normal" checked>
                        <div>
                            <strong style="font-size: 13.5px; color: #111; display: block;">Normal</strong>
                            <span style="font-size: 11px; color: #777;">Standard dispatch today</span>
                        </div>
                    </label>
                    <label style="border: 1px solid var(--border-subtle); background: #FFFFFF; padding: 12px; border-radius: var(--radius-md); display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="radio" name="urgency" value="urgent">
                        <div>
                            <strong style="font-size: 13.5px; color: #111; display: block;">⚡ Urgent</strong>
                            <span style="font-size: 11px; color: #777;">Immediate emergency (&lt;30m)</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Submit Button (Yellow Button from Mockup) -->
            <button type="submit" class="btn-yellow" style="width: 100%; padding: 14px; font-size: 15px; border-radius: var(--radius-md);">
                Analyze My Problem
            </button>

        </form>

    </div>

</div>
@endsection
