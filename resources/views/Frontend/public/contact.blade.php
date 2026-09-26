@extends('Frontend.layouts.public')

@section('title', 'Contact Us — FixMate AI')

@section('content')
<div style="background: #FFFFFF; min-height: 80vh;">

    <!-- Clean Header -->
    <section style="padding: 40px 0 30px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 600px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: #92400E;">GET IN TOUCH</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 900; color: #0F172A; margin: 0 0 10px 0;">Contact Us</h1>
            <p style="font-size: 15px; color: #64748B; margin: 0;">We're here to help. Reach out to our support team anytime.</p>
        </div>
    </section>

    <!-- Contact Body -->
    <section style="padding: 48px 0;">
        <div class="container" style="max-width: 900px;">
            
            <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 40px;">
                
                <!-- Left: Support Info -->
                <div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0;">Customer Care</h3>
                    <p style="font-size: 14px; color: #64748B; line-height: 1.6; margin: 0 0 24px 0;">
                        Have a question regarding your booking or interested in registering as a service partner? Drop us a message or call directly.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 16px; font-size: 14px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-size: 18px;">📞</span>
                            <div>
                                <strong style="color: #0F172A; display: block;">Phone Support</strong>
                                <span style="color: #64748B;">+92 300 1234567 (Mon-Sat, 9AM-7PM)</span>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-size: 18px;">✉️</span>
                            <div>
                                <strong style="color: #0F172A; display: block;">Email Us</strong>
                                <span style="color: #64748B;">support@fixmate.ai</span>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-size: 18px;">📍</span>
                            <div>
                                <strong style="color: #0F172A; display: block;">Office Address</strong>
                                <span style="color: #64748B;">Islamabad, Pakistan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Clean Form -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 18px; padding: 28px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 16px 0;">Send us a message</h3>
                    
                    <form action="#" method="POST" onsubmit="alert('Message sent successfully! Our team will contact you shortly.'); return false;">
                        <div style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Your Name</label>
                            <input type="text" placeholder="Full name" required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 10px 14px; font-size: 14px; outline: none; background: #FFFFFF;">
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Email or Phone</label>
                            <input type="text" placeholder="Phone or email" required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 10px 14px; font-size: 14px; outline: none; background: #FFFFFF;">
                        </div>

                        <div style="margin-bottom: 18px;">
                            <label style="font-size: 12.5px; font-weight: 700; color: #475569; display: block; margin-bottom: 4px;">Message</label>
                            <textarea rows="4" placeholder="How can we help?" required style="width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 10px 14px; font-size: 14px; outline: none; background: #FFFFFF; font-family: inherit;"></textarea>
                        </div>

                        <button type="submit" style="width: 100%; background: #FFC107; border: none; padding: 12px 0; border-radius: 10px; font-size: 14px; font-weight: 800; color: #0F172A; cursor: pointer;">
                            Send Message
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </section>

</div>
@endsection
