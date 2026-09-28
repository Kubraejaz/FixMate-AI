@extends('Frontend.layouts.admin')

@section('title', 'Technicians Pool — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Registered Technicians</h1>
        <p>1,203 providers &middot; monitor ratings, trade licenses, and dispatch activity.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ url('/admin/technicians/verification') }}" class="adm-btn adm-btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            Review Pending KYC (3)
        </a>
    </div>
</div>

<!-- Table -->
<div class="adm-card" style="padding-top: 8px;">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Technician</th>
                    <th>Specialization</th>
                    <th>Experience</th>
                    <th>Rating &amp; Jobs</th>
                    <th>KYC Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="border-color: var(--adm-accent);">
                            <div>
                                <div class="pname">Ali Khan</div>
                                <div class="pmeta">Karachi (DHA)</div>
                            </div>
                        </div>
                    </td>
                    <td>Plumbing (Master)</td>
                    <td>8 Years</td>
                    <td><span style="color: #D97706; font-weight: 700;">&#9733; 4.9</span> &middot; 247 jobs</td>
                    <td><span class="adm-badge green">Verified</span></td>
                    <td style="text-align: right;"><a href="{{ url('/technicians/ali-khan') }}" target="_blank" class="adm-card-link">Public Profile</a></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_2.png') }}" alt="Riaz Ahmed" style="border-color: var(--adm-accent);">
                            <div>
                                <div class="pname">Riaz Ahmed</div>
                                <div class="pmeta">Karachi (Clifton)</div>
                            </div>
                        </div>
                    </td>
                    <td>Electrical</td>
                    <td>6 Years</td>
                    <td><span style="color: #D97706; font-weight: 700;">&#9733; 4.8</span> &middot; 189 jobs</td>
                    <td><span class="adm-badge green">Verified</span></td>
                    <td style="text-align: right;"><a href="{{ url('/technicians/riaz-ahmed') }}" target="_blank" class="adm-card-link">Public Profile</a></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="border-color: var(--adm-accent);">
                            <div>
                                <div class="pname">Imran Shah</div>
                                <div class="pmeta">Karachi (Gulshan)</div>
                            </div>
                        </div>
                    </td>
                    <td>HVAC &amp; AC</td>
                    <td>7 Years</td>
                    <td><span style="color: #D97706; font-weight: 700;">&#9733; 4.9</span> &middot; 312 jobs</td>
                    <td><span class="adm-badge green">Verified</span></td>
                    <td style="text-align: right;"><a href="{{ url('/technicians/imran-shah') }}" target="_blank" class="adm-card-link">Public Profile</a></td>
                </tr>
                <tr>
                    <td>
                        <div class="adm-person">
                            <img src="{{ asset('assets/images/image_4.png') }}" alt="Umar Tariq">
                            <div>
                                <div class="pname">Umar Tariq</div>
                                <div class="pmeta">Lahore (Gulberg)</div>
                            </div>
                        </div>
                    </td>
                    <td>Carpentry &amp; Locksmith</td>
                    <td>5 Years</td>
                    <td><span style="color: #D97706; font-weight: 700;">&#9733; 4.6</span> &middot; 96 jobs</td>
                    <td><span class="adm-badge yellow">Pending Review</span></td>
                    <td style="text-align: right;"><a href="{{ url('/admin/technicians/verification') }}" class="adm-card-link">Review</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
