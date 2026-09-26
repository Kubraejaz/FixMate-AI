@extends('Frontend.layouts.admin')

@section('title', 'Registered Customers — FixMate AI Admin')

@section('content')
<div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">Registered Customers (2,548)</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Manage customer profiles, address books, and dispute histories.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <input type="text" placeholder="Search customer name or phone..." style="background: #262626; border: 1px solid #333; color: #FFF; padding: 8px 14px; border-radius: 8px; font-size: 13px; outline: none; width: 240px;">
        </div>
    </div>

    <!-- Table -->
    <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; color: #FFFFFF;">
            <thead>
                <tr style="background: #151515; border-bottom: 1px solid #2B2B2B; color: #9CA3AF; font-size: 11px; text-transform: uppercase;">
                    <th style="padding: 14px 18px;">Customer</th>
                    <th style="padding: 14px 14px;">Contact</th>
                    <th style="padding: 14px 14px;">City / Primary Address</th>
                    <th style="padding: 14px 14px;">Total Bookings</th>
                    <th style="padding: 14px 14px;">Status</th>
                    <th style="padding: 14px 18px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px;">
                        <strong style="color: #FFF; display: block;">Ahmed Khan</strong>
                        <span style="font-size: 11px; color: #888;">Joined Aug 2026</span>
                    </td>
                    <td style="padding: 14px;">+92 300 1234567</td>
                    <td style="padding: 14px;">Karachi • DHA Phase 6</td>
                    <td style="padding: 14px; font-weight: 700; color: #FFCC00;">14 Bookings</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 4px;">Active</span>
                    </td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">View Profile</a>
                    </td>
                </tr>

                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px;">
                        <strong style="color: #FFF; display: block;">Sara Ahmed</strong>
                        <span style="font-size: 11px; color: #888;">Joined Jul 2026</span>
                    </td>
                    <td style="padding: 14px;">+92 321 4455667</td>
                    <td style="padding: 14px;">Karachi • Clifton Block 4</td>
                    <td style="padding: 14px; font-weight: 700; color: #FFCC00;">8 Bookings</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 4px;">Active</span>
                    </td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">View Profile</a>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 14px 18px;">
                        <strong style="color: #FFF; display: block;">Dr. Ayesha K.</strong>
                        <span style="font-size: 11px; color: #888;">Joined Sep 2026</span>
                    </td>
                    <td style="padding: 14px;">+92 333 7788990</td>
                    <td style="padding: 14px;">Islamabad • Sector F-7/2</td>
                    <td style="padding: 14px; font-weight: 700; color: #FFCC00;">3 Bookings</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16,185,129,0.2); color: #10B981; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 4px;">Active</span>
                    </td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">View Profile</a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection
