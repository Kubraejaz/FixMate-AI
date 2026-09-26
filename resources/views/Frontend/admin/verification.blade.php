@extends('Frontend.layouts.admin')

@section('title', 'Provider KYC Verification Pipeline — FixMate AI Admin')

@section('content')
<div>
    
    <!-- Title -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">Provider KYC Verification Pipeline</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Review government CNIC documents, trade licenses, and background police verification certificates.</p>
        </div>
        <span style="background: rgba(255, 204, 0, 0.2); color: #FFCC00; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
            3 Applications Pending Review
        </span>
    </div>

    <!-- Verification Table Card -->
    <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
            <thead>
                <tr style="background: #151515; border-bottom: 1px solid #2B2B2B; color: #9CA3AF; font-size: 11.5px; text-transform: uppercase;">
                    <th style="padding: 14px 20px;">Technician</th>
                    <th style="padding: 14px 16px;">Trade / Skill</th>
                    <th style="padding: 14px 16px;">CNIC Number</th>
                    <th style="padding: 14px 16px;">Documents Attached</th>
                    <th style="padding: 14px 16px;">Status</th>
                    <th style="padding: 14px 20px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- Row 1: Ali Khan -->
                <tr style="border-bottom: 1px solid #2B2B2B; color: #FFFFFF;">
                    <td style="padding: 16px 20px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="{{ asset('assets/images/image_1.png') }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                            <div>
                                <strong style="display: block; font-size: 14px; color: #FFF;">Ali Khan</strong>
                                <span style="font-size: 11px; color: #888;">Karachi (DHA) • 0300-1234567</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 16px;">Plumbing (8 yrs exp)</td>
                    <td style="padding: 16px; font-family: monospace; color: #FFCC00;">42201-1234567-1</td>
                    <td style="padding: 16px;">
                        <span style="font-size: 11px; background: #262626; color: #DDD; padding: 2px 7px; border-radius: 4px;">CNIC</span>
                        <span style="font-size: 11px; background: #262626; color: #DDD; padding: 2px 7px; border-radius: 4px;">Diploma</span>
                        <span style="font-size: 11px; background: #262626; color: #DDD; padding: 2px 7px; border-radius: 4px;">Police Cert</span>
                    </td>
                    <td style="padding: 16px;">
                        <span style="background: rgba(254, 240, 138, 0.15); color: #F59E0B; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                            Pending Review
                        </span>
                    </td>
                    <td style="padding: 16px 20px; text-align: right;">
                        <div style="display: inline-flex; gap: 6px;">
                            <button class="btn-yellow" style="padding: 5px 12px; font-size: 12px;">Approve</button>
                            <button class="btn-outline" style="border-color: #EF4444; color: #EF4444; padding: 5px 10px; font-size: 12px;">Reject</button>
                        </div>
                    </td>
                </tr>

                <!-- Row 2: Riaz Ahmed -->
                <tr style="border-bottom: 1px solid #2B2B2B; color: #FFFFFF;">
                    <td style="padding: 16px 20px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="{{ asset('assets/images/image_2.png') }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                            <div>
                                <strong style="display: block; font-size: 14px; color: #FFF;">Riaz Ahmed</strong>
                                <span style="font-size: 11px; color: #888;">Karachi (Clifton) • 0321-9876543</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 16px;">Electrical (6 yrs exp)</td>
                    <td style="padding: 16px; font-family: monospace; color: #FFCC00;">42301-7654321-3</td>
                    <td style="padding: 16px;">
                        <span style="font-size: 11px; background: #262626; color: #DDD; padding: 2px 7px; border-radius: 4px;">CNIC</span>
                        <span style="font-size: 11px; background: #262626; color: #DDD; padding: 2px 7px; border-radius: 4px;">License</span>
                    </td>
                    <td style="padding: 16px;">
                        <span style="background: rgba(16, 185, 129, 0.15); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                            ✓ Approved
                        </span>
                    </td>
                    <td style="padding: 16px 20px; text-align: right;">
                        <button class="btn-outline" style="border-color: #333; color: #AAA; padding: 5px 12px; font-size: 12px;">View Dossier</button>
                    </td>
                </tr>

                <!-- Row 3: Imran Shah -->
                <tr style="color: #FFFFFF;">
                    <td style="padding: 16px 20px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="{{ asset('assets/images/image_3.png') }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                            <div>
                                <strong style="display: block; font-size: 14px; color: #FFF;">Imran Shah</strong>
                                <span style="font-size: 11px; color: #888;">Karachi (Gulshan) • 0333-5551234</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 16px;">HVAC & AC (7 yrs exp)</td>
                    <td style="padding: 16px; font-family: monospace; color: #FFCC00;">42101-9988776-5</td>
                    <td style="padding: 16px;">
                        <span style="font-size: 11px; background: #262626; color: #DDD; padding: 2px 7px; border-radius: 4px;">CNIC</span>
                        <span style="font-size: 11px; background: #262626; color: #DDD; padding: 2px 7px; border-radius: 4px;">HVAC Cert</span>
                    </td>
                    <td style="padding: 16px;">
                        <span style="background: rgba(16, 185, 129, 0.15); color: #10B981; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                            ✓ Approved
                        </span>
                    </td>
                    <td style="padding: 16px 20px; text-align: right;">
                        <button class="btn-outline" style="border-color: #333; color: #AAA; padding: 5px 12px; font-size: 12px;">View Dossier</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection
