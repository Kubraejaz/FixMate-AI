@extends('Frontend.layouts.master')

@section('title', 'Register — FixMate')
@section('meta_desc', 'Create your FixMate account. Join thousands of homeowners receiving upfront pricing and trusted repair services.')

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 70px; display: flex; justify-content: center;">

    <!-- Register Card (Exact Layout from Mockup 1) -->
    <div class="card-box" style="width: 100%; max-width: 520px; padding: 40px; box-shadow: var(--shadow-md);">
        
        <div style="text-align: center; margin-bottom: 26px;">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" style="display: inline-block; margin-bottom: 16px; text-decoration: none;">
                <img src="{{ asset('assets/images/Logo.png') }}" alt="FixMate" style="height: 40px; width: auto; object-fit: contain; margin: 0 auto; display: block;">
            </a>

            <h1 style="font-size: 24px; font-weight: 800; color: #111; margin-bottom: 4px;">Create Your Account</h1>
            <p style="font-size: 13.5px; color: #757575;">Join FixMate today</p>
        </div>

        <form action="{{ url('/customer-dashboard') }}" method="GET">
            
            <!-- Full Name (Mockup 1) -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Full Name</label>
                <input type="text" required placeholder="Enter full name" value="Ahmed Khan" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
            </div>

            <!-- Email or Phone (Mockup 1) -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Email or Phone</label>
                <input type="text" required placeholder="Enter email or phone" value="ahmed.khan@example.com" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
            </div>

            <!-- Location (Mockup 1) -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Location</label>
                <select required style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none; background: #FFF;">
                    <option value="">Select Location</option>
                    <option selected>Karachi, Pakistan</option>
                    <option>Lahore, Pakistan</option>
                    <option>Islamabad, Pakistan</option>
                    <option>Rawalpindi, Pakistan</option>
                    <option>Peshawar, Pakistan</option>
                </select>
            </div>

            <!-- Password -->
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Password</label>
                <input type="password" required placeholder="Password" value="••••••••••••" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
            </div>

            <!-- Confirm Password -->
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Confirm Password</label>
                <input type="password" required placeholder="Password" value="••••••••••••" style="width: 100%; border: 1px solid var(--border-subtle); border-radius: 12px; padding: 12px 14px; font-size: 14px; outline: none;">
            </div>

            <!-- Terms & Conditions Checkbox (Mockup 1) -->
            <div style="margin-bottom: 22px; font-size: 12.5px;">
                <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer; color: #555;">
                    <input type="checkbox" checked required style="accent-color: #FFCC00; margin-top: 3px;">
                    <span>I agree to the <a href="#" style="text-decoration: underline; color: #111;">Terms & Conditions</a> and <a href="#" style="text-decoration: underline; color: #111;">Privacy Policy</a></span>
                </label>
            </div>

            <!-- Register Button (Yellow) -->
            <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px; font-size: 15px; margin-bottom: 18px; border-radius: 12px;">
                Register
            </button>

            <!-- Login Link -->
            <p style="text-align: center; font-size: 13px; color: #666;">
                Already have an account? <a href="{{ url('/login') }}" style="color: #111; font-weight: 700; text-decoration: underline;">Login</a>
            </p>

        </form>

    </div>

</div>
@endsection
