@extends('Frontend.layouts.admin')

@section('title', 'AI Computer Vision Diagnostic Logs — FixMate AI Admin')

@section('content')
<div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">AI Diagnostic Logs & Computer Vision Scans</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Inspect model classifications, defect bounding boxes, confidence probabilities, and cost estimation logic.</p>
        </div>
        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
            ● Model Online (Deep Neural Vision v2.4)
        </span>
    </div>

    <!-- Scans Table with Images -->
    <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; color: #FFFFFF;">
            <thead>
                <tr style="background: #151515; border-bottom: 1px solid #2B2B2B; color: #9CA3AF; font-size: 11px; text-transform: uppercase;">
                    <th style="padding: 14px 18px;">Scanned Image</th>
                    <th style="padding: 14px 14px;">Customer Problem</th>
                    <th style="padding: 14px 14px;">Detected Trade</th>
                    <th style="padding: 14px 14px;">Confidence</th>
                    <th style="padding: 14px 14px;">Predicted Cost</th>
                    <th style="padding: 14px 14px;">Matched Technician</th>
                    <th style="padding: 14px 18px; text-align: right;">Accuracy Flag</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- Scan 1: Sink -->
                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px;">
                        <img src="{{ asset('assets/images/image_6.png') }}" style="width: 60px; height: 45px; border-radius: 6px; object-fit: cover; border: 1px solid #FFCC00;">
                    </td>
                    <td style="padding: 14px;">
                        <strong style="color: #FFF; display: block;">Kitchen Sink Leakage</strong>
                        <span style="font-size: 11px; color: #888;">Ahmed Khan • 10:00 AM</span>
                    </td>
                    <td style="padding: 14px;">Plumbing (P-trap)</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-weight: 800; font-size: 11px; padding: 2px 7px; border-radius: 4px;">
                            92% Match
                        </span>
                    </td>
                    <td style="padding: 14px; font-weight: 700; color: #FFCC00;">Rs. 500 – 800</td>
                    <td style="padding: 14px;">Ali Khan</td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <span style="color: #10B981; font-weight: 700;">✓ Verified Accurate</span>
                    </td>
                </tr>

                <!-- Scan 2: Wiring -->
                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px;">
                        <img src="{{ asset('assets/images/image_5.png') }}" style="width: 60px; height: 45px; border-radius: 6px; object-fit: cover; border: 1px solid #333;">
                    </td>
                    <td style="padding: 14px;">
                        <strong style="color: #FFF; display: block;">Breaker Tripping Issue</strong>
                        <span style="font-size: 11px; color: #888;">Sara Ahmed • Yesterday</span>
                    </td>
                    <td style="padding: 14px;">Electrical (Wiring)</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-weight: 800; font-size: 11px; padding: 2px 7px; border-radius: 4px;">
                            96% Match
                        </span>
                    </td>
                    <td style="padding: 14px; font-weight: 700; color: #FFCC00;">Rs. 1,000 – 1,500</td>
                    <td style="padding: 14px;">Riaz Ahmed</td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <span style="color: #10B981; font-weight: 700;">✓ Verified Accurate</span>
                    </td>
                </tr>

                <!-- Scan 3: AC Coil -->
                <tr>
                    <td style="padding: 14px 18px;">
                        <img src="{{ asset('assets/images/image_7.png') }}" style="width: 60px; height: 45px; border-radius: 6px; object-fit: cover; border: 1px solid #333;">
                    </td>
                    <td style="padding: 14px;">
                        <strong style="color: #FFF; display: block;">AC Gas Leak & Cooling Low</strong>
                        <span style="font-size: 11px; color: #888;">Bilal Tariq • Yesterday</span>
                    </td>
                    <td style="padding: 14px;">AC & Cooling</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-weight: 800; font-size: 11px; padding: 2px 7px; border-radius: 4px;">
                            89% Match
                        </span>
                    </td>
                    <td style="padding: 14px; font-weight: 700; color: #FFCC00;">Rs. 1,800 – 2,500</td>
                    <td style="padding: 14px;">Imran Shah</td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <span style="color: #10B981; font-weight: 700;">✓ Verified Accurate</span>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection
