@extends('Frontend.layouts.master')

@section('title', 'AI Analysis Result — FixMate AI')
@section('meta_desc', 'AI diagnosis complete: Kitchen sink leakage identified with 92% confidence. Recommended trade: Certified Plumber.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px; display: flex; justify-content: center;">

    <!-- AI Analysis Result Card (Exact Layout from Mockup 1 & 2) -->
    <div class="card-box" style="width: 100%; max-width: 680px; padding: 36px; border: 2px solid #FFECB3;">
        
        <!-- Header -->
        <div style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span style="font-size: 12px; font-weight: 700; color: #047857; background: #ECFDF5; border: 1px solid #A7F3D0; padding: 3px 10px; border-radius: 12px;">
                    ✓ Analysis Complete!
                </span>
                <span style="font-size: 12px; color: #757575;">Step 2 of 3</span>
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #111; margin-bottom: 4px;">AI Analysis Result</h1>
            <p style="font-size: 13.5px; color: #757575;">
                Our AI has analyzed your problem. Please confirm the details below to view matched technicians.
            </p>
        </div>

        <!-- Split Grid: Photo Thumbnail + Analysis Details -->
        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 24px; margin-bottom: 28px; background: #FFFDF0; border: 1px solid #FFE082; border-radius: 20px; padding: 22px;">
            
            <!-- Photo Thumbnail (Using user's image_3.png) -->
            <div>
                <div style="border-radius: 14px; overflow: hidden; border: 2px solid #FFF; box-shadow: 0 4px 12px rgba(0,0,0,0.08); height: 160px;">
                    <img src="{{ asset('assets/images/image_3.png') }}" alt="Analyzed problem" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span style="display: block; text-align: center; font-size: 11px; color: #757575; margin-top: 6px;">
                    Target: Kitchen Sink Joint
                </span>
            </div>

            <!-- Detected Parameters Table -->
            <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13.5px;">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #FFECB3; padding-bottom: 8px;">
                    <span style="color: #666;">Detected Service:</span>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <strong style="color: #111; font-size: 15px;">Plumbing</strong>
                        <span style="background: #10B981; color: #FFF; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 6px;">Confidence 92%</span>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #FFECB3; padding-bottom: 8px;">
                    <span style="color: #666;">Problem Type:</span>
                    <strong style="color: #111;">Kitchen Sink Leakage</strong>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #FFECB3; padding-bottom: 8px;">
                    <span style="color: #666;">Required Professional:</span>
                    <strong style="color: #B45309;">Plumber</strong>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #FFECB3; padding-bottom: 8px;">
                    <span style="color: #666;">Suggested Service:</span>
                    <strong style="color: #111;">Sink/Pipe Repair</strong>
                </div>

                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #FFECB3; padding-bottom: 8px;">
                    <span style="color: #666;">Urgency:</span>
                    <span style="color: #111; font-weight: 700;">Normal</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding-top: 2px;">
                    <span style="color: #666;">Estimated Cost:</span>
                    <strong style="color: #111; font-size: 16px;">Rs. 500 – 800 ($75)</strong>
                </div>
            </div>

        </div>

        <!-- Confirmation Prompt & Action Buttons (From Mockup 1 & 2) -->
        <div style="border-top: 1px solid var(--border-color); padding-top: 22px;">
            <p style="font-size: 14px; font-weight: 700; color: #111; margin-bottom: 14px;">
                Is this correct?
            </p>

            <div style="display: flex; gap: 14px;">
                <a href="{{ url('/recommended-technicians') }}" class="btn-yellow" style="flex: 2; padding: 13px; font-size: 14.5px;">
                    Yes, Continue to Technicians
                </a>
                <a href="{{ url('/services') }}" class="btn-outline" style="flex: 1; padding: 13px; font-size: 14px;">
                    Change Service
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
