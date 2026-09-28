@extends('Frontend.layouts.admin')

@section('title', 'Customer Accounts — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Registered Customers</h1>
        <p>2,548 accounts &middot; manage profiles, address books, and dispute histories.</p>
    </div>
    <div class="adm-page-actions">
        <input type="text" class="adm-input" style="width: 250px;" placeholder="Search customer name or phone...">
    </div>
</div>

<!-- Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>City / Primary Address</th>
                    <th>Total Bookings</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_1.png') }}" alt="Ahmed Khan">
                            <div>
                                <div class="pname">Ahmed Khan</div>
                                <div class="pmeta">Joined Aug 2026</div>
                            </div>
                        </div>
                    </td>
                    <td>+92 300 1234567</td>
                    <td>Karachi &middot; DHA Phase 6</td>
                    <td><strong>14 bookings</strong></td>
                    <td><span class="adm-badge green">Active</span></td>
                    <td style="text-align: right;"><a href="#" class="adm-card-link">View Profile</a></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_2.png') }}" alt="Sara Ahmed">
                            <div>
                                <div class="pname">Sara Ahmed</div>
                                <div class="pmeta">Joined Jul 2026</div>
                            </div>
                        </div>
                    </td>
                    <td>+92 321 4455667</td>
                    <td>Karachi &middot; Clifton Block 4</td>
                    <td><strong>8 bookings</strong></td>
                    <td><span class="adm-badge green">Active</span></td>
                    <td style="text-align: right;"><a href="#" class="adm-card-link">View Profile</a></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_3.png') }}" alt="Dr. Ayesha K.">
                            <div>
                                <div class="pname">Dr. Ayesha K.</div>
                                <div class="pmeta">Joined Sep 2026</div>
                            </div>
                        </div>
                    </td>
                    <td>+92 333 7788990</td>
                    <td>Islamabad &middot; Sector F-7/2</td>
                    <td><strong>3 bookings</strong></td>
                    <td><span class="adm-badge green">Active</span></td>
                    <td style="text-align: right;"><a href="#" class="adm-card-link">View Profile</a></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_4.png') }}" alt="Bilal Tariq">
                            <div>
                                <div class="pname">Bilal Tariq</div>
                                <div class="pmeta">Joined Jun 2026</div>
                            </div>
                        </div>
                    </td>
                    <td>+92 345 1122334</td>
                    <td>Lahore &middot; Gulberg III</td>
                    <td><strong>21 bookings</strong></td>
                    <td><span class="adm-badge yellow">Under Review</span></td>
                    <td style="text-align: right;"><a href="#" class="adm-card-link">View Profile</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
