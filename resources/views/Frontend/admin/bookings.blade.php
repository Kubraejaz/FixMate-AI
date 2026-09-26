@extends('Frontend.layouts.admin')

@section('title', 'Manage All Bookings — FixMate AI Admin')

@section('content')
<div>
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; color: #FFFFFF; margin-bottom: 4px;">All Platform Bookings</h1>
            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">Monitor live job dispatches, OTP handshakes, escrow releases, and disputes.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn-yellow" style="padding: 8px 16px; font-size: 13px; font-weight: 800;">Export CSV</button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; gap: 14px; align-items: center;">
        <input type="text" placeholder="Filter by Booking ID, customer or technician..." style="flex: 1; background: #262626; border: 1px solid #333; color: #FFF; padding: 8px 12px; border-radius: 8px; font-size: 13px; outline: none;">
        <select style="background: #262626; border: 1px solid #333; color: #FFF; padding: 8px 12px; border-radius: 8px; font-size: 13px; outline: none;">
            <option>All Statuses</option>
            <option>In Progress</option>
            <option>Pending</option>
            <option>Completed</option>
        </select>
    </div>

    <!-- Table -->
    <div style="background: #1C1C1C; border: 1px solid #2B2B2B; border-radius: 16px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; color: #FFFFFF;">
            <thead>
                <tr style="background: #151515; border-bottom: 1px solid #2B2B2B; color: #9CA3AF; font-size: 11px; text-transform: uppercase;">
                    <th style="padding: 14px 18px;">ID</th>
                    <th style="padding: 14px 14px;">Customer</th>
                    <th style="padding: 14px 14px;">Technician</th>
                    <th style="padding: 14px 14px;">Service</th>
                    <th style="padding: 14px 14px;">City / Area</th>
                    <th style="padding: 14px 14px;">Status</th>
                    <th style="padding: 14px 14px;">Amount</th>
                    <th style="padding: 14px 18px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <!-- FM-10245 -->
                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px; font-weight: 800; color: #FFCC00;">#FM-10245</td>
                    <td style="padding: 14px;">Ahmed Khan</td>
                    <td style="padding: 14px;">Ali Khan</td>
                    <td style="padding: 14px;">Plumbing (Sink Leak)</td>
                    <td style="padding: 14px;">Karachi (DHA)</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(254, 240, 138, 0.15); color: #F59E0B; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                            En Route (ETA 10m)
                        </span>
                    </td>
                    <td style="padding: 14px; font-weight: 700;">Rs. 800</td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="{{ url('/customer/tracking') }}" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Live Map</a>
                    </td>
                </tr>

                <!-- FM-10190 -->
                <tr style="border-bottom: 1px solid #2B2B2B;">
                    <td style="padding: 14px 18px; font-weight: 800; color: #FFCC00;">#FM-10190</td>
                    <td style="padding: 14px;">Bilal Tariq</td>
                    <td style="padding: 14px;">Imran Shah</td>
                    <td style="padding: 14px;">AC Master Service</td>
                    <td style="padding: 14px;">Karachi (Gulshan)</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(59, 130, 246, 0.15); color: #60A5FA; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                            Scheduled
                        </span>
                    </td>
                    <td style="padding: 14px; font-weight: 700;">Rs. 1,800</td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Details</a>
                    </td>
                </tr>

                <!-- FM-09942 -->
                <tr>
                    <td style="padding: 14px 18px; font-weight: 800; color: #FFCC00;">#FM-09942</td>
                    <td style="padding: 14px;">Sara Ahmed</td>
                    <td style="padding: 14px;">Riaz Ahmed</td>
                    <td style="padding: 14px;">Breaker Wiring</td>
                    <td style="padding: 14px;">Karachi (Clifton)</td>
                    <td style="padding: 14px;">
                        <span style="background: rgba(16, 185, 129, 0.15); color: #10B981; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                            ✓ Completed
                        </span>
                    </td>
                    <td style="padding: 14px; font-weight: 700;">Rs. 1,200</td>
                    <td style="padding: 14px 18px; text-align: right;">
                        <a href="#" style="color: #3B82F6; text-decoration: none; font-weight: 700;">Receipt</a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection
