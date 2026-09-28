@extends('Frontend.layouts.admin')

@section('title', 'AI Diagnostic Logs — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>AI Diagnostic Logs</h1>
        <p>Inspect model classifications, confidence probabilities, and cost estimation logic.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge green">Model online &middot; Vision v2.4</span>
    </div>
</div>

<!-- Scans Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Scanned Image</th>
                    <th>Customer Problem</th>
                    <th>Detected Trade</th>
                    <th>Confidence</th>
                    <th>Predicted Cost</th>
                    <th>Matched Technician</th>
                    <th style="text-align: right;">Accuracy Flag</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="adm-media">
                            <img src="{{ asset('assets/images/image_6.png') }}" alt="Kitchen sink" style="border-color: var(--adm-accent);">
                        </div>
                    </td>
                    <td>
                        <div class="pname" style="font-weight: 700; color: var(--adm-ink);">Kitchen Sink Leakage</div>
                        <div class="pmeta" style="font-size: 11.5px; color: var(--adm-faint);">Ahmed Khan &middot; 10:00 AM</div>
                    </td>
                    <td>Plumbing (P-trap)</td>
                    <td><span class="adm-badge green">92% match</span></td>
                    <td><strong>Rs. 500 &ndash; 800</strong></td>
                    <td>Ali Khan</td>
                    <td style="text-align: right;"><span class="adm-badge green">Verified Accurate</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-media">
                            <img src="{{ asset('assets/images/image_5.png') }}" alt="Breaker panel">
                        </div>
                    </td>
                    <td>
                        <div class="pname" style="font-weight: 700; color: var(--adm-ink);">Breaker Tripping Issue</div>
                        <div class="pmeta" style="font-size: 11.5px; color: var(--adm-faint);">Sara Ahmed &middot; Yesterday</div>
                    </td>
                    <td>Electrical (Wiring)</td>
                    <td><span class="adm-badge green">96% match</span></td>
                    <td><strong>Rs. 1,000 &ndash; 1,500</strong></td>
                    <td>Riaz Ahmed</td>
                    <td style="text-align: right;"><span class="adm-badge green">Verified Accurate</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-media">
                            <img src="{{ asset('assets/images/image_7.png') }}" alt="AC coil">
                        </div>
                    </td>
                    <td>
                        <div class="pname" style="font-weight: 700; color: var(--adm-ink);">AC Gas Leak &amp; Low Cooling</div>
                        <div class="pmeta" style="font-size: 11.5px; color: var(--adm-faint);">Bilal Tariq &middot; Yesterday</div>
                    </td>
                    <td>AC &amp; Cooling</td>
                    <td><span class="adm-badge yellow">89% match</span></td>
                    <td><strong>Rs. 1,800 &ndash; 2,500</strong></td>
                    <td>Imran Shah</td>
                    <td style="text-align: right;"><span class="adm-badge red">Needs Review</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
