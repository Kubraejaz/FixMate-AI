@extends('Frontend.layouts.technician')

@section('title', 'Messages — FixMate AI')

@section('content')
<div style="height: 640px; display: grid; grid-template-columns: 280px 1fr; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden;">

    <!-- Left Conversation List -->
    <div style="border-right: 1px solid var(--border-color); display: flex; flex-direction: column;">
        <div style="padding: 16px; border-bottom: 1px solid var(--border-color);">
            <strong style="font-size: 16px; color: #111; display: block; margin-bottom: 8px;">Customer Messages</strong>
            <input type="text" placeholder="Search customers..." class="form-input" style="padding: 7px 10px; font-size: 12.5px;">
        </div>

        <div style="overflow-y: auto; flex: 1;">

            <!-- Conversation 1 (Ahmed Raza - Active) -->
            <div style="padding: 14px 16px; border-bottom: 1px solid var(--border-color); background: #FFFDF0; cursor: pointer; display: flex; gap: 12px; align-items: center;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ahmed Raza" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px; gap: 8px;">
                        <strong style="font-size: 13.5px; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Ahmed Raza</strong>
                        <span style="font-size: 10px; color: #B45309; font-weight: 700;">2:35 PM</span>
                    </div>
                    <p style="font-size: 12px; color: #555; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Gate 2 is unlocked, ring the kitchen bell.
                    </p>
                </div>
            </div>

            <!-- Conversation 2 (Sana Malik) -->
            <div style="padding: 14px 16px; border-bottom: 1px solid var(--border-color); cursor: pointer; display: flex; gap: 12px; align-items: center;">
                <img src="{{ asset('assets/images/image_3.png') }}" alt="Sana Malik" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px; gap: 8px;">
                        <strong style="font-size: 13.5px; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sana Malik</strong>
                        <span style="font-size: 10px; color: #888;">Yesterday</span>
                    </div>
                    <p style="font-size: 12px; color: #777; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Confirmed for tomorrow afternoon, AC service.
                    </p>
                </div>
            </div>

            <!-- Conversation 3 (Bilal Ahmed) -->
            <div style="padding: 14px 16px; border-bottom: 1px solid var(--border-color); cursor: pointer; display: flex; gap: 12px; align-items: center;">
                <img src="{{ asset('assets/images/image_5.png') }}" alt="Bilal Ahmed" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px; gap: 8px;">
                        <strong style="font-size: 13.5px; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Bilal Ahmed</strong>
                        <span style="font-size: 10px; color: #888;">Mon</span>
                    </div>
                    <p style="font-size: 12px; color: #777; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Sent the revised quote for the wall repair.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Right Chat Area -->
    <div style="display: flex; flex-direction: column; background: #FAFAFA;">

        <!-- Chat Header -->
        <div style="padding: 14px 20px; background: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ahmed Raza" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                <div style="min-width: 0;">
                    <strong style="font-size: 14px; color: #111; display: block;">Ahmed Raza</strong>
                    <span style="font-size: 11px; color: #10B981; font-weight: 700;">● Online &middot; Job FM-10245</span>
                </div>
            </div>
            <div style="display: flex; gap: 8px; flex-shrink: 0;">
                <a href="tel:03001234567" class="btn-outline" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    Call
                </a>
                <a href="{{ url('/technician/active-job') }}" class="btn-yellow" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    View Job
                </a>
            </div>
        </div>

        <!-- Job Context Strip -->
        <div style="padding: 9px 20px; background: #FFFBEB; border-bottom: 1px solid #FDE68A; font-size: 12px; color: #92400E; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span style="font-weight: 800;">FM-10245</span>
            <span style="color: #D97706;">&bull;</span>
            <span>Kitchen Sink Leak &mdash; P-trap Replacement</span>
            <span style="color: #D97706;">&bull;</span>
            <span>House 42-B, Street 18, Phase 6</span>
        </div>

        <!-- Chat Stream -->
        <div style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px;">

            <!-- Message from Customer -->
            <div style="display: flex; gap: 10px; max-width: 70%;">
                <div style="background: #FFFFFF; border: 1px solid var(--border-color); padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13.5px; color: #111; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    Assalam o Alaikum Ali bhai, are you still on the way? The leak got a little worse.
                    <span style="display: block; font-size: 10px; color: #888; margin-top: 4px; text-align: right;">2:31 PM</span>
                </div>
            </div>

            <!-- Message from Technician (Me) -->
            <div style="display: flex; gap: 10px; max-width: 70%; align-self: flex-end;">
                <div style="background: #FFCC00; color: #111; font-weight: 500; padding: 12px 16px; border-radius: 14px 14px 2px 14px; font-size: 13.5px; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                    Walaikum Assalam, yes I am 5 minutes away. I have the replacement P-trap and sealing rubber with me.
                    <span style="display: block; font-size: 10px; color: #555; margin-top: 4px; text-align: right;">2:33 PM ✓✓</span>
                </div>
            </div>

            <!-- Message from Customer -->
            <div style="display: flex; gap: 10px; max-width: 70%;">
                <div style="background: #FFFFFF; border: 1px solid var(--border-color); padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13.5px; color: #111; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    Perfect. Gate 2 is unlocked, please ring the main kitchen doorbell.
                    <span style="display: block; font-size: 10px; color: #888; margin-top: 4px; text-align: right;">2:35 PM</span>
                </div>
            </div>

        </div>

        <!-- Chat Input Bar -->
        <div style="padding: 14px 20px; background: #FFFFFF; border-top: 1px solid var(--border-color); display: flex; gap: 10px; align-items: center;">
            <button type="button" style="border: none; background: transparent; cursor: pointer; color: #666; display: inline-flex; align-items: center;" title="Attach photo" aria-label="Attach photo">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
            </button>
            <input type="text" placeholder="Type a message to Ahmed Raza..." class="form-input" style="flex: 1; padding: 10px 14px; font-size: 13.5px;">
            <button type="button" class="btn-yellow" style="padding: 10px 20px; font-size: 13.5px; font-weight: 800;">Send</button>
        </div>

    </div>

</div>
@endsection
