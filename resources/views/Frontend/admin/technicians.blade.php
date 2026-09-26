@extends('Frontend.layouts.admin')

@section('title', 'Registered Technicians — FixMate AI Admin')

@section('content')
<div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">Registered Technicians (1,203)</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Monitor verified service providers, ratings, trade licenses, and dispatch activity.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="{{ url('/admin/technicians/verification') }}" class="btn-yellow" style="padding: 8px 16px; font-size: 13px; font-weight: 800;">
                Review Pending KYC (3)
            </a>
        </div>
    </div>

    <!-- Table -->
    <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; color: #FFFFFF;">
            <thead>
                <tr style="background: #151515; border-bottom: 1px solid #2B2B2B; color: #9CA3AF; font-size: 11px; text-transform: uppercase;">
                    <th style="padding: 14px 18px;">Technician</th>
                    <th style="padding: 14px 14px;">Specialization</th>
                    <th style="padding: 14px 14px;">Experience</th>
                    <th style="padding: 14px 14px;">Rating & Jobs</th>
                    <th style="padding: 14px 14px;">KYC Status</th>
                    <th style="padding: 14px 18px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- Ali Khan -->
                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="{{ asset('assets/images/image_1.png') }}" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                            <div>
                                <strong style="color: #FFF; display: block;">Ali Khan</strong>
                                <span style="font-size: 11px; color: #888;">Karachi (DHA)</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px;">Plumbing (Master)</td>
                    <td style="padding: 14px;">8 Years</td>
                    <td style="padding: 14px;">
                        <span style="color: #F59E0B; font-weight: 700;">★ 4.9</span> (247 jobs)
                    </td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 4px;">✓ Verified</span>
                    </td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="{{ url('/technicians/ali-khan') }}" target="_blank" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Public Profile</a>
                    </td>
                </tr>

                <!-- Riaz Ahmed -->
                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="{{ asset('assets/images/image_2.png') }}" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                            <div>
                                <strong style="color: #FFF; display: block;">Riaz Ahmed</strong>
                                <span style="font-size: 11px; color: #888;">Karachi (Clifton)</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px;">Electrical</td>
                    <td style="padding: 14px;">6 Years</td>
                    <td style="padding: 14px;">
                        <span style="color: #F59E0B; font-weight: 700;">★ 4.8</span> (189 jobs)
                    </td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 4px;">✓ Verified</span>
                    </td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="{{ url('/technicians/riaz-ahmed') }}" target="_blank" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Public Profile</a>
                    </td>
                </tr>

                <!-- Imran Shah -->
                <tr>
                    <td style="padding: 14px 18px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="{{ asset('assets/images/image_3.png') }}" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                            <div>
                                <strong style="color: #FFF; display: block;">Imran Shah</strong>
                                <span style="font-size: 11px; color: #888;">Karachi (Gulshan)</span>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px;">HVAC & AC</td>
                    <td style="padding: 14px;">7 Years</td>
                    <td style="padding: 14px;">
                        <span style="color: #F59E0B; font-weight: 700;">★ 4.9</span> (312 jobs)
                    </td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 4px;">✓ Verified</span>
                    </td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="{{ url('/technicians/imran-shah') }}" target="_blank" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Public Profile</a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection
