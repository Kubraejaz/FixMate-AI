@extends('Frontend.layouts.customer')

@section('title', 'Dispute Resolution & Complaints — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Complaints & Dispute Resolution</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Submit an issue regarding a booking, request a warranty re-visit, or report misconduct.</p>
    </div>

    <!-- Active Dispute Policy Alert -->
    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; font-size: 13px; color: #1E40AF; display: flex; align-items: center; gap: 12px;">
        <span style="font-size: 20px;">🛡️</span>
        <div>
            <strong>FixMate 100% Protection Guarantee:</strong>
            Funds remain secured in escrow during active dispute review. A dedicated human support agent will mediate within 2 business hours.
        </div>
    </div>

    <!-- Submit Complaint Form -->
    <div class="portal-card" style="padding: 28px; background: #FFFFFF; margin-bottom: 28px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 18px;">File a New Dispute Ticket</h3>

        <form action="{{ url('/customer/complaints') }}" method="GET">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Select Booking ID</label>
                    <select class="form-input" style="padding: 9px 12px; font-size: 13.5px;">
                        <option>Booking #FM-10245 (Sink Repair — Ali Khan)</option>
                        <option>Booking #FM-10190 (AC Master Service — Imran Shah)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Complaint Reason</label>
                    <select class="form-input" style="padding: 9px 12px; font-size: 13.5px;">
                        <option>Issue not properly resolved (30-Day Warranty claim)</option>
                        <option>Technician delayed or unpunctual</option>
                        <option>Dispute on extra parts cost</option>
                        <option>Unprofessional behavior</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 18px;">
                <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Describe the Problem</label>
                <textarea class="form-input" rows="3" style="padding: 10px 12px; font-size: 13.5px;" placeholder="Please give specific details of what went wrong..."></textarea>
            </div>

            <button type="submit" class="btn-yellow" style="padding: 10px 24px; font-size: 13.5px; font-weight: 800;">
                Submit Ticket to Support Team
            </button>
        </form>
    </div>

    <!-- Prior Complaints List -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Past Support Tickets (0)</h3>
        <p style="font-size: 13px; color: #777; margin: 0; text-align: center; padding: 20px 0;">
            You have no active disputes or complaints. All your past bookings were resolved satisfactorily!
        </p>
    </div>

</div>
@endsection
