@extends('Frontend.layouts.master')

@section('title', 'How It Works — FixMate AI | 4 Simple Steps')
@section('meta_desc', 'Learn how FixMate AI works: describe your problem, get instant AI analysis, match with top-rated technicians, and track your service in real time.')

@section('content')
<div class="container" style="padding-top: 36px; padding-bottom: 70px;">

    <!-- Header (Mockup 1) -->
    <div style="text-align: center; max-width: 600px; margin: 0 auto 40px auto;">
        <span style="font-size: 13px; font-weight: 700; color: #8C6B00; background: #FFF9E6; border: 1px solid #FFECB3; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 12px;">
            Simple & Transparent
        </span>
        <h1 style="font-size: 32px; font-weight: 800; color: #111; margin-bottom: 8px;">How It Works</h1>
        <p style="font-size: 15px; color: #757575;">Get your home service done in 4 simple steps</p>
    </div>

    <!-- 4 Vertical / Large Step Cards (Mockup 1) -->
    <div style="max-width: 760px; margin: 0 auto 50px auto; display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Step 1 -->
        <div class="card-box" style="display: flex; gap: 24px; align-items: center; padding: 28px;">
            <div style="width: 58px; height: 58px; border-radius: 50%; background: #FFCC00; color: #000; font-size: 24px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(255,204,0,0.3);">
                1
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 4px;">Describe Your Problem</h3>
                <p style="font-size: 14px; color: #666; line-height: 1.5;">
                    Tell us what's wrong, add a photo or short video if needed. Our intuitive portal lets you pinpoint symptoms in seconds.
                </p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="card-box" style="display: flex; gap: 24px; align-items: center; padding: 28px;">
            <div style="width: 58px; height: 58px; border-radius: 50%; background: #FFCC00; color: #000; font-size: 24px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(255,204,0,0.3);">
                2
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 4px;">AI Analysis</h3>
                <p style="font-size: 14px; color: #666; line-height: 1.5;">
                    Our computer vision neural network identifies the root issue, estimates required parts and labor costs, and specifies the required trade skill.
                </p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="card-box" style="display: flex; gap: 24px; align-items: center; padding: 28px;">
            <div style="width: 58px; height: 58px; border-radius: 50%; background: #FFCC00; color: #000; font-size: 24px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(255,204,0,0.3);">
                3
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 4px;">Get Matched</h3>
                <p style="font-size: 14px; color: #666; line-height: 1.5;">
                    Find the best technicians based on location, verified customer ratings, background checks, and real-time availability.
                </p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="card-box" style="display: flex; gap: 24px; align-items: center; padding: 28px;">
            <div style="width: 58px; height: 58px; border-radius: 50%; background: #FFCC00; color: #000; font-size: 24px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(255,204,0,0.3);">
                4
            </div>
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 4px;">Book & Track</h3>
                <p style="font-size: 14px; color: #666; line-height: 1.5;">
                    Confirm booking, track arrival live on GPS map, share your 4-digit arrival OTP, and release escrow payment only after satisfaction.
                </p>
            </div>
        </div>

    </div>

    <!-- Bottom Illustration Banner (Mockup 1) -->
    <div style="background: #FFFDF0; border: 1px solid #FFECB3; border-radius: 24px; padding: 36px 44px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px; max-width: 900px; margin: 0 auto;">
        <div>
            <h3 style="font-size: 22px; font-weight: 800; color: #111; margin-bottom: 6px;">
                Smarter. Faster. More Reliable.
            </h3>
            <p style="font-size: 14.5px; color: #666; margin-bottom: 18px;">
                FixMate AI — Your Home, Our Priority.
            </p>
            <a href="{{ url('/describe-problem') }}" class="btn-yellow">
                Start AI Problem Scan
            </a>
        </div>
        <div style="max-width: 220px; border-radius: 16px; overflow: hidden; border: 2px solid #FFF;">
            <img src="{{ asset('assets/images/image_7.png') }}" alt="Home repair" style="width: 100%; height: 140px; object-fit: cover;">
        </div>
    </div>

</div>
@endsection
