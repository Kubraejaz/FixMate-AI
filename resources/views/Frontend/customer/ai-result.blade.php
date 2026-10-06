@extends('Frontend.layouts.customer')

@section('title', 'Service Request Summary — FixMate')

@section('content')
<div style="max-width: 840px; margin: 0 auto;">
    
    @if($isRecognized)
        <!-- RECOGNIZED SERVICE REQUEST SUMMARY -->
        
        <!-- Header -->
        <div style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                <span style="background: #ECFDF5; color: #047857; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #A7F3D0;">
                    ✓ Service Matched
                </span>
                <span style="background: #FFF9E6; color: #92400E; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #FEF08A;">
                    🏷️ Upfront Standard Tariff
                </span>
                <span style="font-size: 12.5px; color: #666;">FixMate Service Network</span>
            </div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0 0 6px 0;">Service Request Summary</h1>
            <p style="font-size: 14.5px; color: #666; margin: 0;">Review your reported issue, standard labor estimates, and available verified technicians.</p>
        </div>

        <!-- Main Result Card -->
        <div class="portal-card" style="padding: 32px; background: #FFFFFF; margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: flex-start;">
                
                <!-- Left: Problem / Defect Photo -->
                <div>
                    <div style="position: relative; border-radius: 16px; overflow: hidden; height: 240px; box-shadow: 0 4px 14px rgba(0,0,0,0.08); border: 2px solid #E2E8F0; background: #F8FAFC;">
                        <img src="{{ asset($uploadedImage ?? 'assets/images/image_6.png') }}" alt="Service Problem" style="width: 100%; height: 100%; object-fit: cover;">

                        <div style="position: absolute; bottom: 8px; left: 8px; right: 8px; background: rgba(15,23,42,0.85); backdrop-filter: blur(4px); padding: 5px 8px; border-radius: 6px; font-size: 11px; color: #FFF; text-align: center; font-weight: 600;">
                            📷 Attached Photo for Technician
                        </div>
                    </div>
                    
                    <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #64748B;">
                        <span>Estimated Service Time:</span>
                        <strong style="color: #0F172A;">{{ $matchedDefect['repair_time'] ?? '45 Mins' }}</strong>
                    </div>
                </div>

                <!-- Right: Service Details -->
                <div>
                    
                    <!-- Detected Service -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
                        <div>
                            <span style="font-size: 11.5px; color: #777; text-transform: uppercase; font-weight: 700;">Selected Trade Discipline</span>
                            <strong style="display: block; font-size: 22px; color: #111; font-weight: 900;">{{ $profession?->name ?? 'General Maintenance' }}</strong>
                        </div>
                        <span style="background: #ECFDF5; color: #047857; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; border: 1px solid #A7F3D0;">
                            Verified Trade
                        </span>
                    </div>

                    <!-- Structured Properties -->
                    <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 24px;">
                        
                        <div>
                            <span style="font-size: 11.5px; color: #777; display: block;">Reported Problem Description</span>
                            <strong style="font-size: 14.5px; color: #111;">{{ $problemQuery ?: 'Standard Service Inspection' }}</strong>
                        </div>

                        <div>
                            <span style="font-size: 11.5px; color: #777; display: block;">Service Scope</span>
                            <strong style="font-size: 14.5px; color: #0F172A;">{{ $matchedDefect['title'] ?? 'Inspection & Repair' }}</strong>
                            <p style="font-size: 12.5px; color: #64748B; margin: 3px 0 0 0;">{{ $matchedDefect['summary'] ?? 'Standard diagnostic check, repair execution, and testing.' }}</p>
                        </div>

                        <div>
                            <span style="font-size: 11.5px; color: #777; display: block;">Tools &amp; Equipment Required</span>
                            <span style="font-size: 13px; color: #475569;">{{ $matchedDefect['tools'] ?? 'Standard trade equipment and replacement consumables' }}</span>
                        </div>

                        @if(!empty($safetyAlert))
                            <div style="background: #FEF2F2; border-left: 4px solid #DC2626; border-radius: 8px; padding: 12px 16px; margin: 4px 0;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 3px;">
                                    <span style="font-size: 14px;">⚠️</span>
                                    <strong style="font-size: 12.5px; color: #991B1B; text-transform: uppercase; letter-spacing: 0.5px;">Safety Advisory</strong>
                                </div>
                                <p style="font-size: 12.5px; color: #7F1D1D; margin: 0; line-height: 1.45;">{{ $safetyAlert }}</p>
                            </div>
                        @endif

                        <!-- Cost Range -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #FFFDF0; border: 1px solid #FEF08A; padding: 12px 16px; border-radius: 12px;">
                            <div>
                                <span style="font-size: 11px; color: #B45309; text-transform: uppercase; font-weight: 700;">Base Inspection Fee</span>
                                <strong style="display: block; font-size: 15px; color: #111;">Rs. {{ number_format($profession?->base_price ?? 650) }}</strong>
                                <span style="font-size: 10.5px; color: #92400E;">Adjusted against repair bill</span>
                            </div>
                            <div>
                                <span style="font-size: 11px; color: #B45309; text-transform: uppercase; font-weight: 700;">Est. Total Labor &amp; Parts</span>
                                <strong style="display: block; font-size: 16px; color: #047857;">Rs. {{ number_format($costEstimate['min']) }} – {{ number_format($costEstimate['max']) }}</strong>
                                <span style="font-size: 10.5px; color: #047857;">Standardized tariff rates</span>
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
                        ← Edit Details
                    </a>
                    <a href="{{ route('customer.booking', ['profession' => $profession?->slug, 'issue' => $matchedDefect['title']]) }}" class="btn-yellow" style="padding: 10px 26px; font-size: 14px; font-weight: 800; text-decoration: none; border-radius: 8px;">
                        Book {{ $profession?->name }} Service →
                    </a>
                </div>
            </div>

        </div>

    @else
        <!-- INCONCLUSIVE / FALLBACK STATE -->
        
        <div style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <span style="background: #FEF3C7; color: #92400E; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 20px; border: 1px solid #FDE68A;">
                    ℹ️ Select Your Service Category
                </span>
            </div>
            <h1 style="font-size: 26px; font-weight: 900; color: #111; margin: 0 0 6px 0;">Please Select a Service Category</h1>
            <p style="font-size: 14.5px; color: #666; margin: 0;">We couldn't automatically determine the trade from your description. Please choose a trade category below to continue booking.</p>
        </div>

        <div class="portal-card" style="padding: 32px; background: #FFFFFF; border-left: 5px solid #F59E0B; margin-bottom: 28px;">
            
            <div style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 22px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: #FFFBEB; border: 1px solid #FDE68A; display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0;">
                    🛠️
                </div>
                <div>
                    <h3 style="font-size: 17px; font-weight: 900; color: #0F172A; margin: 0 0 6px 0;">Search Query</h3>
                    <p style="font-size: 13.5px; color: #64748B; margin: 0; line-height: 1.5;">
                        You entered: <strong style="color: #0F172A; background: #F1F5F9; padding: 2px 8px; border-radius: 4px;">"{{ $problemQuery ?: '(No description entered)' }}"</strong>
                    </p>
                </div>
            </div>

            <!-- Direct Category Selection Fallback -->
            <div style="border-top: 1px solid #E2E8F0; padding-top: 22px;">
                <h4 style="font-size: 14.5px; font-weight: 800; color: #0F172A; margin: 0 0 14px 0;">Select Your Trade Discipline Directly:</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
                    @foreach($allProfessions as $p)
                        <a href="{{ route('customer.booking', ['profession' => $p->slug]) }}" style="border: 1px solid #CBD5E1; border-radius: 10px; padding: 12px 14px; text-decoration: none; display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; transition: all 0.15s ease;">
                            <div>
                                <strong style="display: block; font-size: 13.5px; color: #0F172A;">{{ $p->name }}</strong>
                                <span style="font-size: 11px; color: #047857; font-weight: 700;">Starting Rs. {{ number_format($p->base_price) }}</span>
                            </div>
                            <span style="font-size: 14px; color: #FFB800; font-weight: 900;">Book →</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div style="margin-top: 24px;">
                <a href="{{ route('customer.diagnose') }}" class="btn-outline" style="padding: 10px 20px; font-size: 13.5px; text-decoration: none; border-radius: 8px;">
                    ← Back to Request Form
                </a>
            </div>

        </div>

    @endif

</div>
@endsection
