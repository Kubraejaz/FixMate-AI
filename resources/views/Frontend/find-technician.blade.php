@extends('Frontend.layouts.master')

@section('title', 'Find a Technician — FixMate')
@section('meta_desc', 'Search and filter verified professionals in your area: plumbers, electricians, AC repair, and carpenters.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Header (Mockup 2) -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #111; margin-bottom: 4px;">Find a Technician</h1>
        <p style="font-size: 14px; color: #757575;">Search and filter to find the right verified professional for your needs.</p>
    </div>

    <!-- Search & Location Bar -->
    <div style="background: #FFFFFF; border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 18px 24px; margin-bottom: 24px; box-shadow: var(--shadow-sm); display: flex; gap: 16px; flex-wrap: wrap;">
        <div style="flex: 2; min-width: 240px; position: relative;">
            <input type="text" placeholder="Search technician by name or skill (e.g., Ali Khan, leak)..." style="width: 100%; border: 1px solid #E5E7EB; border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
        </div>
        <div style="flex: 1; min-width: 180px;">
            <select style="width: 100%; border: 1px solid #E5E7EB; border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none; background: #FFF;">
                <option>Karachi, Pakistan</option>
                <option>Lahore, Pakistan</option>
                <option>Islamabad, Pakistan</option>
            </select>
        </div>
        <button type="button" class="btn-yellow" style="padding: 12px 24px;" onclick="showToast('Search refreshed')">
            Search
        </button>
    </div>

    <!-- Service Category Pills (Mockup 2) -->
    <div style="margin-bottom: 24px;">
        <span style="font-size: 13px; font-weight: 700; color: #111; display: block; margin-bottom: 12px;">Service Category</span>
        <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 6px;">
            <button type="button" class="btn-yellow" style="font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                🚰 Plumber
            </button>
            <button type="button" class="btn-outline" style="font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                ⚡ Electrician
            </button>
            <button type="button" class="btn-outline" style="font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                ❄️ AC Technician
            </button>
            <button type="button" class="btn-outline" style="font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                🪚 Carpenter
            </button>
            <button type="button" class="btn-outline" style="font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                🧹 Cleaner
            </button>
            <button type="button" class="btn-outline" style="font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                🔧 Appliance Repair
            </button>
        </div>
    </div>

    <!-- Filter Strip (Mockup 2: Service, Distance, Rating, Price, Experience) -->
    <div style="background: #FAFAFA; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 16px 20px; margin-bottom: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)) auto; gap: 12px; align-items: center;">
        <div>
            <label style="display: block; font-size: 11px; font-weight: 700; color: #777; margin-bottom: 4px;">SERVICE</label>
            <select style="width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 6px 10px; font-size: 13px; outline: none; background: #FFF;">
                <option>All Services</option>
                <option>Pipe Repair</option>
                <option>Sink Leakage</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 11px; font-weight: 700; color: #777; margin-bottom: 4px;">DISTANCE</label>
            <select style="width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 6px 10px; font-size: 13px; outline: none; background: #FFF;">
                <option>Any Distance</option>
                <option>&lt; 5 km</option>
                <option>&lt; 10 km</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 11px; font-weight: 700; color: #777; margin-bottom: 4px;">RATING</label>
            <select style="width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 6px 10px; font-size: 13px; outline: none; background: #FFF;">
                <option>Any Rating</option>
                <option>4.5 & up</option>
                <option>4.8 & up</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 11px; font-weight: 700; color: #777; margin-bottom: 4px;">PRICE</label>
            <select style="width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 6px 10px; font-size: 13px; outline: none; background: #FFF;">
                <option>Any Price</option>
                <option>Budget (Rs. 500-800)</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 11px; font-weight: 700; color: #777; margin-bottom: 4px;">EXPERIENCE</label>
            <select style="width: 100%; border: 1px solid #D1D5DB; border-radius: 8px; padding: 6px 10px; font-size: 13px; outline: none; background: #FFF;">
                <option>Any Experience</option>
                <option>5+ Years</option>
            </select>
        </div>
        <div style="padding-top: 14px;">
            <button type="button" class="btn-yellow" style="padding: 7px 18px; font-size: 13px;" onclick="showToast('Filters applied!')">
                Apply Filters
            </button>
        </div>
    </div>

    <!-- Available Technicians List (Mockup 2) -->
    <div style="margin-bottom: 20px;">
        <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 16px;">Available Technicians (4)</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <!-- Tech 1 -->
            <div class="tech-card">
                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                    <img src="{{ asset('assets/images/image_1.png') }}" class="tech-avatar">
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <h4 style="font-size: 16px; font-weight: 800; color: #111;">Ali Khan</h4>
                            <span style="color: #10B981;">✓</span>
                        </div>
                        <span style="font-size: 13px; color: #555;">Plumber • 5 years exp</span>
                        <div style="font-size: 12px; font-weight: 700; color: #111;">★ 4.8 (247 jobs)</div>
                    </div>
                </div>
                <div style="font-size: 12px; color: #757575; margin-bottom: 16px;">
                    📍 3.2 km away • Karachi, DHA
                </div>
                <div style="display: flex; gap: 8px; margin-top: auto;">
                    <a href="{{ url('/technician-profile/ali-khan') }}" class="btn-outline" style="flex: 1; padding: 8px; font-size: 13px;">Profile</a>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="flex: 1; padding: 8px; font-size: 13px;">Book Now</a>
                </div>
            </div>

            <!-- Tech 2 -->
            <div class="tech-card">
                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                    <img src="{{ asset('assets/images/image_2.png') }}" class="tech-avatar">
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <h4 style="font-size: 16px; font-weight: 800; color: #111;">Riaz Ahmed</h4>
                            <span style="color: #10B981;">✓</span>
                        </div>
                        <span style="font-size: 13px; color: #555;">Electrician • 7 years exp</span>
                        <div style="font-size: 12px; font-weight: 700; color: #111;">★ 4.7 (189 jobs)</div>
                    </div>
                </div>
                <div style="font-size: 12px; color: #757575; margin-bottom: 16px;">
                    📍 4.1 km away • Karachi, Clifton
                </div>
                <div style="display: flex; gap: 8px; margin-top: auto;">
                    <a href="{{ url('/technician-profile/riaz-ahmed') }}" class="btn-outline" style="flex: 1; padding: 8px; font-size: 13px;">Profile</a>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="flex: 1; padding: 8px; font-size: 13px;">Book Now</a>
                </div>
            </div>

            <!-- Tech 3 -->
            <div class="tech-card">
                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                    <img src="{{ asset('assets/images/image_5.png') }}" class="tech-avatar">
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <h4 style="font-size: 16px; font-weight: 800; color: #111;">Imran Shah</h4>
                            <span style="color: #10B981;">✓</span>
                        </div>
                        <span style="font-size: 13px; color: #555;">AC Technician • 6 years exp</span>
                        <div style="font-size: 12px; font-weight: 700; color: #111;">★ 4.9 (312 jobs)</div>
                    </div>
                </div>
                <div style="font-size: 12px; color: #757575; margin-bottom: 16px;">
                    📍 2.8 km away • Karachi, Gulshan
                </div>
                <div style="display: flex; gap: 8px; margin-top: auto;">
                    <a href="{{ url('/technician-profile/imran-shah') }}" class="btn-outline" style="flex: 1; padding: 8px; font-size: 13px;">Profile</a>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="flex: 1; padding: 8px; font-size: 13px;">Book Now</a>
                </div>
            </div>

            <!-- Tech 4 -->
            <div class="tech-card">
                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 12px;">
                    <img src="{{ asset('assets/images/Cleaning_Professional.png') }}" class="tech-avatar">
                    <div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <h4 style="font-size: 16px; font-weight: 800; color: #111;">Usman Tariq</h4>
                            <span style="color: #10B981;">✓</span>
                        </div>
                        <span style="font-size: 13px; color: #555;">Cleaner • 4 years exp</span>
                        <div style="font-size: 12px; font-weight: 700; color: #111;">★ 4.6 (156 jobs)</div>
                    </div>
                </div>
                <div style="font-size: 12px; color: #757575; margin-bottom: 16px;">
                    📍 3.5 km away • Karachi, PECHS
                </div>
                <div style="display: flex; gap: 8px; margin-top: auto;">
                    <a href="{{ url('/technician-profile/usman-tariq') }}" class="btn-outline" style="flex: 1; padding: 8px; font-size: 13px;">Profile</a>
                    <a href="{{ url('/booking-page') }}" class="btn-yellow" style="flex: 1; padding: 8px; font-size: 13px;">Book Now</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
