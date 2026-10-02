@extends('Frontend.layouts.admin')

@section('title', 'AI Diagnostic Logs — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>AI Diagnostic Logs &amp; Neural Computer Vision</h1>
        <p>Inspect model classifications, defect bounding boxes, and real-time labor cost predictions.</p>
    </div>
    <div class="adm-page-actions">
        <span class="adm-badge green">Model online &middot; Vision v2.4 Multi-Head</span>
    </div>
</div>

<!-- Scans Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Scanned Image</th>
                    <th>Customer Defect Description</th>
                    <th>Detected Trade</th>
                    <th>Confidence</th>
                    <th>Predicted Cost Range</th>
                    <th>Matched Technician</th>
                    <th style="text-align: right;">Accuracy Validation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scans as $scan)
                    <tr>
                        <td>
                            <div class="adm-media">
                                <img src="{{ $scan['image'] }}" alt="{{ $scan['problem'] }}" style="border-color: var(--adm-accent); width: 56px; height: 44px; object-fit: cover; border-radius: 8px;">
                            </div>
                        </td>
                        <td>
                            <div class="pname" style="font-weight: 700; color: var(--adm-ink);">{{ $scan['problem'] }}</div>
                            <div class="pmeta" style="font-size: 11.5px; color: var(--adm-faint);">{{ $scan['customer_name'] }} &middot; {{ $scan['time_ago'] }}</div>
                        </td>
                        <td>
                            <strong style="color: var(--adm-ink);">{{ $scan['detected_trade'] }}</strong>
                        </td>
                        <td>
                            <span class="adm-badge {{ $scan['confidence_class'] }}">{{ $scan['confidence'] }} match</span>
                        </td>
                        <td><strong>{{ $scan['predicted_cost'] }}</strong></td>
                        <td>{{ $scan['matched_technician'] }}</td>
                        <td style="text-align: right;">
                            <span class="adm-badge {{ $scan['status_class'] }}">{{ $scan['status'] }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
