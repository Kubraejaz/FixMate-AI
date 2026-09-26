@extends('Frontend.layouts.public')

@section('title', 'Find Technicians — FixMate AI | Verified Professionals')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">VERIFIED PROS</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Find a Technician</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">Top-rated background-checked professionals ready to help you with your home needs.</p>
        </div>
    </section>

    <!-- Search & Filter Bar -->
    <section style="padding: 30px 0;">
        <div class="container">
            
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 14px 20px; display: flex; gap: 14px; align-items: center; margin-bottom: 32px;">
                <div style="flex: 1; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 18px; color: #94A3B8;">🔍</span>
                    <input type="text" placeholder="Search technician name or skill..." style="width: 100%; border: none; background: transparent; outline: none; font-size: 14px; font-family: inherit;">
                </div>
                <div style="border-left: 1px solid #CBD5E1; padding-left: 14px;">
                    <select style="border: none; background: transparent; outline: none; font-size: 13.5px; font-weight: 600; color: #0F172A; cursor: pointer;">
                        <option>All Services</option>
                        <option>Plumbing</option>
                        <option>Electrical</option>
                        <option>AC Repair</option>
                        <option>Cleaning</option>
                        <option>Carpentry</option>
                    </select>
                </div>
                <div style="border-left: 1px solid #CBD5E1; padding-left: 14px;">
                    <select style="border: none; background: transparent; outline: none; font-size: 13.5px; font-weight: 600; color: #0F172A; cursor: pointer;">
                        <option>Karachi, Pakistan</option>
                        <option>Lahore, Pakistan</option>
                        <option>Islamabad, Pakistan</option>
                    </select>
                </div>
                <button style="background: #FFC107; border: none; outline: none; padding: 10px 22px; border-radius: 10px; font-size: 13.5px; font-weight: 800; color: #0F172A; cursor: pointer;">
                    Search
                </button>
            </div>

            <!-- Technicians Grid matching Featured Technicians on Index -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                
                <!-- Ali Khan -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="position: relative; width: 72px; height: 72px; margin: 0 auto 12px auto;">
                        <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #FFC107;">
                        <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;">✓</span>
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Ali Khan</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 8px;">Master Plumber • 8 yrs exp</span>
                    <div style="font-size: 12px; color: #64748B; margin-bottom: 14px;">
                        <span style="color: #F59E0B; font-weight: 700;">★ 4.8</span> (120 jobs) • 📍 3.2 km
                    </div>
                    <a href="{{ url('/technicians/ali-khan') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 13px; padding: 8px 0; border-radius: 10px; text-decoration: none; display: block;">
                        Book Now
                    </a>
                </div>

                <!-- Rida Ahmed -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="position: relative; width: 72px; height: 72px; margin: 0 auto 12px auto;">
                        <img src="{{ asset('assets/images/image_2.png') }}" alt="Rida Ahmed" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #FFC107;">
                        <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;">✓</span>
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Rida Ahmed</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 8px;">Electrician • 6 yrs exp</span>
                    <div style="font-size: 12px; color: #64748B; margin-bottom: 14px;">
                        <span style="color: #F59E0B; font-weight: 700;">★ 4.7</span> (98 jobs) • 📍 2.5 km
                    </div>
                    <a href="{{ url('/technicians/rida-ahmed') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 13px; padding: 8px 0; border-radius: 10px; text-decoration: none; display: block;">
                        Book Now
                    </a>
                </div>

                <!-- Imran Shah -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="position: relative; width: 72px; height: 72px; margin: 0 auto 12px auto;">
                        <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #FFC107;">
                        <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;">✓</span>
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Imran Shah</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 8px;">AC Technician • 7 yrs exp</span>
                    <div style="font-size: 12px; color: #64748B; margin-bottom: 14px;">
                        <span style="color: #F59E0B; font-weight: 700;">★ 4.6</span> (87 jobs) • 📍 4.1 km
                    </div>
                    <a href="{{ url('/technicians/imran-shah') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 13px; padding: 8px 0; border-radius: 10px; text-decoration: none; display: block;">
                        Book Now
                    </a>
                </div>

                <!-- Umar Tariq -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 22px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="position: relative; width: 72px; height: 72px; margin: 0 auto 12px auto;">
                        <img src="{{ asset('assets/images/image_4.png') }}" alt="Umar Tariq" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid #FFC107;">
                        <span style="position: absolute; bottom: 0; right: 0; background: #10B981; color: #FFF; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 2px solid #FFF;">✓</span>
                    </div>
                    <strong style="display: block; font-size: 16px; color: #0F172A; margin-bottom: 2px;">Umar Tariq</strong>
                    <span style="font-size: 12px; color: #64748B; display: block; margin-bottom: 8px;">Carpenter • 5 yrs exp</span>
                    <div style="font-size: 12px; color: #64748B; margin-bottom: 14px;">
                        <span style="color: #F59E0B; font-weight: 700;">★ 4.5</span> (76 jobs) • 📍 5.8 km
                    </div>
                    <a href="{{ url('/technicians/umar-tariq') }}" style="background: #FFC107; color: #0F172A; font-weight: 800; font-size: 13px; padding: 8px 0; border-radius: 10px; text-decoration: none; display: block;">
                        Book Now
                    </a>
                </div>

            </div>

        </div>
    </section>

</div>
@endsection
