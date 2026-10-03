@extends('Frontend.layouts.customer')

@section('title', 'Dispute Resolution & Complaints — FixMate AI')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 4px;">Complaints & Dispute Resolution</h1>
        <p style="font-size: 14px; color: #666; margin: 0;">Submit an issue regarding a booking, request a warranty re-visit, or report misconduct.</p>
    </div>

    @if ($errors->any())
        <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

        <form action="{{ route('customer.complaints.store') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Subject / Booking Reference</label>
                <input type="text" name="subject" class="form-input" value="{{ old('subject', request('booking') ? 'Dispute for Booking #' . request('booking') : '') }}" placeholder="e.g. Issue not resolved on Booking #FM-10245" required style="padding: 10px 12px; font-size: 13.5px;">
            </div>

            <div class="form-group" style="margin-bottom: 18px;">
                <label class="form-label" style="font-size: 12.5px; font-weight: 700;">Describe the Problem in Detail</label>
                <textarea name="message" class="form-input" rows="4" required style="padding: 10px 12px; font-size: 13.5px;" placeholder="Please give specific details of what went wrong, technician conduct, or why a warranty re-visit is needed...">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="btn-yellow" style="padding: 10px 24px; font-size: 13.5px; font-weight: 800; border: none; cursor: pointer; border-radius: 8px;">
                Submit Ticket to Support Team
            </button>
        </form>
    </div>

    <!-- Prior Complaints List -->
    <div class="portal-card" style="padding: 24px; background: #FFFFFF;">
        <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-bottom: 16px;">Past Support Tickets ({{ $complaints->total() }})</h3>
        
        @forelse($complaints as $ticket)
            <div style="border-bottom: 1px solid var(--border-color); padding: 14px 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                    <strong style="font-size: 14.5px; color: #111;">{{ $ticket->subject }}</strong>
                    <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; {{ $ticket->status === 'resolved' ? 'background: #ECFDF5; color: #047857;' : 'background: #FFFBEB; color: #B45309;' }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
                <p style="font-size: 13px; color: #555; margin: 0 0 6px 0;">{{ $ticket->message }}</p>
                <span style="font-size: 11px; color: #888;">Submitted: {{ $ticket->created_at->format('M d, Y • h:i A') }}</span>
            </div>
        @empty
            <p style="font-size: 13px; color: #777; margin: 0; text-align: center; padding: 20px 0;">
                You have no active disputes or complaints. All your past bookings were resolved satisfactorily!
            </p>
        @endforelse

        <div style="margin-top: 16px;">
            {{ $complaints->links() }}
        </div>
    </div>

</div>
@endsection
