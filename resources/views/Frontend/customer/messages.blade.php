@extends('Frontend.layouts.customer')

@section('title', 'Direct Messages & Chat — FixMate AI')

@section('content')
<div style="height: 640px; display: grid; grid-template-columns: 280px 1fr; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden;">
    
    <!-- Left Conversation List -->
    <div style="border-right: 1px solid var(--border-color); display: flex; flex-direction: column;">
        <div style="padding: 16px; border-bottom: 1px solid var(--border-color);">
            <strong style="font-size: 16px; color: #111; display: block; margin-bottom: 8px;">Messages</strong>
            <input type="text" placeholder="Search chats..." class="form-input" style="padding: 7px 10px; font-size: 12.5px;">
        </div>

        <div style="overflow-y: auto; flex: 1;">
            
            <!-- Conversation 1 (Ali Khan - Active) -->
            <div style="padding: 14px 16px; border-bottom: 1px solid var(--border-color); background: #FFFDF0; cursor: pointer; display: flex; gap: 12px; align-items: center;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                        <strong style="font-size: 13.5px; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Ali Khan (Plumber)</strong>
                        <span style="font-size: 10px; color: #B45309; font-weight: 700;">2:35 PM</span>
                    </div>
                    <p style="font-size: 12px; color: #555; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        I am around the corner on Street 18 now.
                    </p>
                </div>
            </div>

            <!-- Conversation 2 (Imran Shah) -->
            <div style="padding: 14px 16px; border-bottom: 1px solid var(--border-color); cursor: pointer; display: flex; gap: 12px; align-items: center;">
                <img src="{{ asset('assets/images/image_3.png') }}" alt="Imran Shah" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                        <strong style="font-size: 13.5px; color: #111;">Imran Shah</strong>
                        <span style="font-size: 10px; color: #888;">Yesterday</span>
                    </div>
                    <p style="font-size: 12px; color: #777; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        Confirmed for Oct 1st afternoon visit.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Right Chat Area -->
    <div style="display: flex; flex-direction: column; background: #FAFAFA;">
        
        <!-- Chat Header -->
        <div style="padding: 14px 20px; background: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="{{ asset('assets/images/image_1.png') }}" alt="Ali Khan" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #FFCC00;">
                <div>
                    <strong style="font-size: 14px; color: #111; display: block;">Ali Khan</strong>
                    <span style="font-size: 11px; color: #10B981; font-weight: 700;">● Online • En Route to Your Address</span>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="tel:03001234567" class="btn-outline" style="padding: 6px 12px; font-size: 12px;">📞 Call</a>
                <a href="{{ url('/customer/tracking') }}" class="btn-yellow" style="padding: 6px 12px; font-size: 12px;">📍 Live Route</a>
            </div>
        </div>

        <!-- Chat Stream -->
        <div style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px;">
            
            <!-- Message from Technician -->
            <div style="display: flex; gap: 10px; max-width: 70%;">
                <div style="background: #FFFFFF; border: 1px solid var(--border-color); padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13.5px; color: #111; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    Assalam o Alaikum Ahmed sb, I have accepted your sink repair job. I have the replacement P-trap pipes and sealing rubber with me.
                    <span style="display: block; font-size: 10px; color: #888; margin-top: 4px; text-align: right;">2:30 PM</span>
                </div>
            </div>

            <!-- Message from Customer (Me) -->
            <div style="display: flex; gap: 10px; max-width: 70%; align-self: flex-end;">
                <div style="background: #FFCC00; color: #111; font-weight: 500; padding: 12px 16px; border-radius: 14px 14px 2px 14px; font-size: 13.5px; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                    Walaikum Assalam Ali bhai. Gate 2 is unlocked, please ring the main kitchen doorbell.
                    <span style="display: block; font-size: 10px; color: #555; margin-top: 4px; text-align: right;">2:32 PM ✓✓</span>
                </div>
            </div>

            <!-- Message from Technician -->
            <div style="display: flex; gap: 10px; max-width: 70%;">
                <div style="background: #FFFFFF; border: 1px solid var(--border-color); padding: 12px 16px; border-radius: 14px 14px 14px 2px; font-size: 13.5px; color: #111; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    Understood. I am just crossing the main roundabout on Street 18 now. See you in 5 minutes!
                    <span style="display: block; font-size: 10px; color: #888; margin-top: 4px; text-align: right;">2:35 PM</span>
                </div>
            </div>

        </div>

        <!-- Chat Input Bar -->
        <div style="padding: 14px 20px; background: #FFFFFF; border-top: 1px solid var(--border-color); display: flex; gap: 10px; align-items: center;">
            <button style="border: none; background: transparent; font-size: 18px; cursor: pointer; color: #666;" title="Attach photo">📷</button>
            <input type="text" placeholder="Type a message to Ali Khan..." class="form-input" style="flex: 1; padding: 10px 14px; font-size: 13.5px;">
            <button class="btn-yellow" style="padding: 10px 20px; font-size: 13.5px; font-weight: 800;">Send</button>
        </div>

    </div>

</div>
@endsection
