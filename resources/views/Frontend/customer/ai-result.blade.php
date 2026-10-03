@extends('Frontend.layouts.customer')

@section('title', 'AI Analysis Result — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <!-- Title matching Mockup 1 & 2 -->
    <div style="margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
            <span style="background: #ECFDF5; color: #047857; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #A7F3D0;">
                ✓ Analysis Complete!
            </span>
            <span style="font-size: 12.5px; color: #666;">Deep Neural Vision v2.4</span>
        </div>
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0 0 6px 0;">AI Analysis Result</h1>
        <p style="font-size: 14.5px; color: #666; margin: 0;">Our AI has analyzed your reported defect. Confirm the diagnosis details below.</p>
    </div>

    <!-- Main Result Card matching Mockup 1 -->
    <div class="portal-card" style="padding: 32px; background: #FFFFFF; margin-bottom: 24px;">
        <div style="display: grid; grid-template-columns: 260px 1fr; gap: 32px; align-items: flex-start;">
            
            <!-- Left: Scanned Image with AI Bounding Box overlay -->
            <div>
                <div style="position: relative; border-radius: 16px; overflow: hidden; height: 260px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); border: 2px solid #FFCC00;">
                    <img src="{{ asset('assets/images/image_6.png') }}" alt="Analyzed defect" style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <!-- AI Detection Bounding Box Marker -->
                    <div style="position: absolute; top: 35%; left: 20%; width: 55%; height: 45%; border: 2px dashed #10B981; background: rgba(16, 185, 129, 0.15); border-radius: 8px; pointer-events: none;">
                        <span style="position: absolute; top: -18px; left: 4px; background: #10B981; color: #FFF; font-size: 9px; font-weight: 900; padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">
                            {{ $profession?->name ?? 'DEFECT' }} DETECTED
                        </span>
                    </div>

                    <div style="position: absolute; bottom: 8px; left: 8px; right: 8px; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); padding: 4px 8px; border-radius: 6px; font-size: 11px; color: #FFF; text-align: center;">
                        AI Diagnostic Scanner
                    </div>
                </div>
            </div>

            <!-- Right: Details matching Mockup 1 -->
            <div>
                
                <!-- Detected Service & Confidence -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
                    <div>
                        <span style="font-size: 11.5px; color: #777; text-transform: uppercase; font-weight: 700;">Detected Service</span>
                        <strong style="display: block; font-size: 22px; color: #111; font-weight: 900;">{{ $profession?->name ?? 'General Maintenance' }}</strong>
                    </div>
                    <span style="background: #ECFDF5; color: #047857; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; border: 1px solid #A7F3D0;">
                        {{ $matchedDefect['confidence'] ?? '96% Confidence' }}
                    </span>
                </div>

                <!-- Structured Properties Table -->
                <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
                    
                    <div>
                        <span style="font-size: 11.5px; color: #777; display: block;">Reported Issue</span>
                        <strong style="font-size: 14.5px; color: #111;">{{ $problemQuery ?: 'Customer described repair issue' }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 11.5px; color: #777; display: block;">Diagnosis & Root Cause</span>
                        <strong style="font-size: 14.5px; color: #111;">{{ $matchedDefect['title'] ?? 'Hardware defect and wear' }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 11.5px; color: #777; display: block;">Required Trade Toolset</span>
                        <span style="font-size: 13px; color: #555;">{{ $matchedDefect['tools'] ?? 'Standard calibrated instruments' }}</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #FFFDF0; border: 1px solid #FEF08A; padding: 12px 16px; border-radius: 12px;">
                        <div>
                            <span style="font-size: 11px; color: #B45309; text-transform: uppercase; font-weight: 700;">Base Inspection Fee</span>
                            <strong style="display: block; font-size: 14px; color: #111;">Rs. {{ number_format($profession?->base_price ?? 650) }}</strong>
                        </div>
                        <div>
                            <span style="font-size: 11px; color: #B45309; text-transform: uppercase; font-weight: 700;">Est. Parts & Labor Range</span>
                            <strong style="display: block; font-size: 16px; color: #047857;">Rs. {{ number_format($costEstimate['min']) }} – {{ number_format($costEstimate['max']) }}</strong>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Confirmation Prompt & Actions matching Mockup 1 -->
        <div style="border-top: 1px solid var(--border-color); padding-top: 24px; display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-size: 15px; color: #111;">Ready to book a verified professional?</strong>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('customer.diagnose') }}" class="btn-outline" style="padding: 10px 20px; font-size: 13.5px; text-decoration: none; border-radius: 8px;">
                    Rescan
                </a>
                <a href="{{ route('customer.booking', ['profession' => $profession?->slug, 'issue' => $matchedDefect['title']]) }}" class="btn-yellow" style="padding: 10px 26px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 8px;">
                    Book This Service →
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
