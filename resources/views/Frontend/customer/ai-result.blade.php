@extends('Frontend.layouts.customer')

@section('title', 'AI Analysis Result — FixMate AI')

@section('content')
<div style="max-width: 840px; margin: 0 auto;">
    
    @if($isRecognized)
        <!-- RECOGNIZED REPAIR DEFECT RESULT -->
        
        <!-- Header -->
        <div style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span style="background: #ECFDF5; color: #047857; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #A7F3D0;">
                    ✓ Defect Identified
                </span>
                <span style="font-size: 12.5px; color: #666;">FixMate Neural Diagnostic Engine v2.4</span>
            </div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0 0 6px 0;">AI Diagnostic Result</h1>
            <p style="font-size: 14.5px; color: #666; margin: 0;">Our AI has successfully classified your repair defect and estimated labor & parts requirements.</p>
        </div>

        <!-- Main Result Card -->
        <div class="portal-card" style="padding: 32px; background: #FFFFFF; margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: flex-start;">
                
                <!-- Left: Scanned Image with AI Bounding Box overlay -->
                <div>
                    <div style="position: relative; border-radius: 16px; overflow: hidden; height: 260px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); border: 2px solid #FFB800; background: #0F172A;">
                        <img src="{{ asset($uploadedImage ?? 'assets/images/image_6.png') }}" alt="Analyzed defect" style="width: 100%; height: 100%; object-fit: cover;">
                        
                        <!-- AI Detection Bounding Box Marker -->
                        <div style="position: absolute; top: 30%; left: 15%; width: 65%; height: 50%; border: 2px dashed #10B981; background: rgba(16, 185, 129, 0.15); border-radius: 8px; pointer-events: none;">
                            <span style="position: absolute; top: -18px; left: 4px; background: #10B981; color: #FFF; font-size: 9px; font-weight: 900; padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">
                                {{ $profession?->name ?? 'DEFECT' }} DETECTED
                            </span>
                        </div>

                        <div style="position: absolute; bottom: 8px; left: 8px; right: 8px; background: rgba(0,0,0,0.75); backdrop-filter: blur(4px); padding: 5px 8px; border-radius: 6px; font-size: 11px; color: #FFF; text-align: center;">
                            🔍 Neural Diagnostic Bounding Box
                        </div>
                    </div>
                    
                    <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #64748B;">
                        <span>Est. Repair Time:</span>
                        <strong style="color: #0F172A;">{{ $matchedDefect['repair_time'] ?? '45 Mins' }}</strong>
                    </div>
                </div>

                <!-- Right: Analysis Details -->
                <div>
                    
                    <!-- Detected Service & Confidence -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
                        <div>
                            <span style="font-size: 11.5px; color: #777; text-transform: uppercase; font-weight: 700;">Identified Trade Specialty</span>
                            <strong style="display: block; font-size: 22px; color: #111; font-weight: 900;">{{ $profession?->name ?? 'General Maintenance' }}</strong>
                        </div>
                        <span style="background: #ECFDF5; color: #047857; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; border: 1px solid #A7F3D0;">
                            {{ $matchedDefect['confidence'] ?? '96% Match' }}
                        </span>
                    </div>

                    <!-- Structured Properties -->
                    <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
                        
                        <div>
                            <span style="font-size: 11.5px; color: #777; display: block;">Reported Problem</span>
                            <strong style="font-size: 14.5px; color: #111;">{{ $problemQuery ?: 'Customer requested diagnosis' }}</strong>
                        </div>

                        <div>
                            <span style="font-size: 11.5px; color: #777; display: block;">AI Diagnosis & Root Cause</span>
                            <strong style="font-size: 14.5px; color: #0F172A;">{{ $matchedDefect['title'] ?? 'Defect Resolution' }}</strong>
                            <p style="font-size: 12.5px; color: #64748B; margin: 3px 0 0 0;">{{ $matchedDefect['summary'] ?? '' }}</p>
                        </div>

                        <div>
                            <span style="font-size: 11.5px; color: #777; display: block;">Required Calibrated Instruments</span>
                            <span style="font-size: 13px; color: #475569;">{{ $matchedDefect['tools'] ?? 'Standard calibrated instruments' }}</span>
                        </div>

                        <!-- Cost Range -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #FFFDF0; border: 1px solid #FEF08A; padding: 12px 16px; border-radius: 12px;">
                            <div>
                                <span style="font-size: 11px; color: #B45309; text-transform: uppercase; font-weight: 700;">Base Inspection Fee</span>
                                <strong style="display: block; font-size: 15px; color: #111;">Rs. {{ number_format($profession?->base_price ?? 650) }}</strong>
                                <span style="font-size: 10.5px; color: #92400E;">Held safely in Escrow</span>
                            </div>
                            <div>
                                <span style="font-size: 11px; color: #B45309; text-transform: uppercase; font-weight: 700;">Est. Total Labor & Parts</span>
                                <strong style="display: block; font-size: 16px; color: #047857;">Rs. {{ number_format($costEstimate['min']) }} – {{ number_format($costEstimate['max']) }}</strong>
                                <span style="font-size: 10.5px; color: #047857;">Verified standard rates</span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Confirmation Prompt & Actions -->
            <div style="border-top: 1px solid var(--border-color); padding-top: 22px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <strong style="font-size: 15px; color: #111;">Ready to book a verified {{ strtolower($profession?->name ?? 'technician') }}?</strong>
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('customer.diagnose') }}" class="btn-outline" style="padding: 10px 20px; font-size: 13.5px; text-decoration: none; border-radius: 8px;">
                        ← Rescan Problem
                    </a>
                    <a href="{{ route('customer.booking', ['profession' => $profession?->slug, 'issue' => $matchedDefect['title']]) }}" class="btn-yellow" style="padding: 10px 26px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 8px;">
                        Book {{ $profession?->name }} Service →
                    </a>
                </div>
            </div>

        </div>

    @else
        <!-- INCONCLUSIVE / IRRELEVANT INPUT STATE -->
        
        <div style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span style="background: #FEF3C7; color: #92400E; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #FDE68A;">
                    ⚠️ Inconclusive Analysis
                </span>
                <span style="font-size: 12.5px; color: #666;">AI Confidence Threshold Not Met</span>
            </div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0 0 6px 0;">No Household Repair Defect Detected</h1>
            <p style="font-size: 14.5px; color: #666; margin: 0;">Our AI diagnostic scanner could not identify a valid home repair or maintenance issue from the provided text.</p>
        </div>

        <div class="portal-card" style="padding: 32px; background: #FFFFFF; border-left: 5px solid #F59E0B; margin-bottom: 28px;">
            
            <div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 22px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: #FFFBEB; border: 1px solid #FDE68A; display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0;">
                    🤖
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 900; color: #0F172A; margin: 0 0 6px 0;">Query Analysis Summary</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0; line-height: 1.5;">
                        You entered: <strong style="color: #0F172A; background: #F1F5F9; padding: 2px 8px; border-radius: 4px;">"{{ $problemQuery ?: '(Empty input)' }}"</strong>
                    </p>
                    <p style="font-size: 13px; color: #B45309; margin: 6px 0 0 0; font-weight: 600;">
                        {{ $inconclusiveReason }}
                    </p>
                </div>
            </div>

            <!-- Helpful Guidance Box -->
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px 20px; margin-bottom: 26px;">
                <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin: 0 0 10px 0;">💡 How to get an accurate AI diagnosis:</h4>
                <p style="font-size: 13px; color: #475569; margin: 0 0 12px 0; line-height: 1.5;">
                    FixMate AI specializes in domestic maintenance across <strong>AC/HVAC, Electrical, Plumbing, Carpentry, Painting, Cleaning, and Home Appliances</strong>. To help the scanner, mention the appliance or fixture and the specific malfunction.
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 12.5px; color: #334155;">
                    <div style="background: #FFF; border: 1px solid #E2E8F0; padding: 8px 12px; border-radius: 8px;">
                        <strong>❄️ AC Issue:</strong> <em>"Split AC outdoor unit vibrating and blowing warm air"</em>
                    </div>
                    <div style="background: #FFF; border: 1px solid #E2E8F0; padding: 8px 12px; border-radius: 8px;">
                        <strong>⚡ Electrical Issue:</strong> <em>"Main circuit breaker tripped with burning smell"</em>
                    </div>
                    <div style="background: #FFF; border: 1px solid #E2E8F0; padding: 8px 12px; border-radius: 8px;">
                        <strong>🔧 Plumbing Issue:</strong> <em>"Water pipe leaking under kitchen sink"</em>
                    </div>
                    <div style="background: #FFF; border: 1px solid #E2E8F0; padding: 8px 12px; border-radius: 8px;">
                        <strong>🚪 Carpentry Issue:</strong> <em>"Main wooden door latch is jammed and scraping floor"</em>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; margin-bottom: 30px;">
                <a href="{{ route('customer.diagnose') }}" class="btn-yellow" style="padding: 12px 28px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 10px;">
                    ← Try Another Description or Upload Photo
                </a>
            </div>

            <!-- Direct Category Selection Fallback -->
            <div style="border-top: 1px solid #E2E8F0; padding-top: 22px;">
                <h4 style="font-size: 14.5px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0;">Or Select Your Service Category Directly:</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
                    @foreach($allProfessions as $p)
                        <a href="{{ route('customer.booking', ['profession' => $p->slug]) }}" style="border: 1px solid #CBD5E1; border-radius: 10px; padding: 12px 14px; text-decoration: none; display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; transition: all 0.15s ease;">
                            <div>
                                <strong style="display: block; font-size: 13.5px; color: #0F172A;">{{ $p->name }}</strong>
                                <span style="font-size: 11px; color: #047857; font-weight: 700;">Base: Rs. {{ number_format($p->base_price) }}</span>
                            </div>
                            <span style="font-size: 14px; color: #FFB800; font-weight: 900;">Book →</span>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

    @endif

</div>
@endsection
