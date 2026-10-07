<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use App\Models\VideoMeeting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VideoMeetingController extends Controller
{
    /**
     * Start a new "Let's Talk" video meeting between customer and technician.
     */
    public function initiate(Request $request): JsonResponse|RedirectResponse
    {
        $caller = Auth::user();

        $bookingId = $request->input('booking_id');
        $receiverId = $request->input('receiver_id');
        $techId = $request->input('technician_id') ?: $request->input('tech_id') ?: $request->input('professional_id');
        $clientId = $request->input('client_id') ?: $request->input('customer_id');
        $booking = null;

        if ($bookingId) {
            $booking = Booking::with(['professional.user', 'user'])->find($bookingId);
            if ($booking) {
                if ($caller->id === $booking->user_id) {
                    $receiverId = $booking->professional?->user_id;
                } else {
                    $receiverId = $booking->user_id;
                }
            }
        }

        // If a technician ID was explicitly supplied
        if (! $receiverId && $techId) {
            $pro = is_numeric($techId)
                ? \App\Models\Professional::with('user')->find($techId)
                : \App\Models\Professional::with('user')->get()->first(fn($p) => strtolower(str_replace(' ', '-', $p->name)) === strtolower($techId));

            if ($pro && $pro->user_id) {
                $receiverId = $pro->user_id;
            } elseif (is_numeric($techId)) {
                $receiverId = (int) $techId;
            }
        }

        // If a client/customer ID was explicitly supplied
        if (! $receiverId && $clientId) {
            $receiverId = (int) $clientId;
        }

        // Check if receiverId is actually a Professional model ID rather than a User ID
        if ($receiverId && ! User::where('id', $receiverId)->exists()) {
            $pro = \App\Models\Professional::find($receiverId);
            if ($pro && $pro->user_id) {
                $receiverId = $pro->user_id;
            }
        }

        // Fallback for customer caller without specified receiver: find assigned or top verified technician
        if (! $receiverId) {
            if ($caller->isCustomer()) {
                $latestBooking = $caller->bookings()->whereNotNull('professional_id')->latest()->first();
                if ($latestBooking && $latestBooking->professional?->user_id) {
                    $receiverId = $latestBooking->professional->user_id;
                    $booking = $booking ?: $latestBooking;
                } else {
                    $verifiedPro = \App\Models\Professional::where('is_verified', true)->whereNotNull('user_id')->first();
                    $receiverId = $verifiedPro?->user_id;
                }
            } elseif ($caller->isTechnician()) {
                $pro = $caller->professional;
                if ($pro) {
                    $latestJob = Booking::where('professional_id', $pro->id)->latest()->first();
                    if ($latestJob && $latestJob->user_id) {
                        $receiverId = $latestJob->user_id;
                        $booking = $booking ?: $latestJob;
                    }
                }
            }
        }

        if (! $receiverId) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No technician or customer found to call.'], 422);
            }
            return back()->with('error', 'Unable to initiate call: no participant specified.');
        }

        $receiver = User::find($receiverId);
        if (! $receiver) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Participant user account not found.'], 404);
            }
            return back()->with('error', 'Participant user account not found.');
        }

        // Create or reuse an active meeting between these two users
        $meetingCode = 'FM-TALK-' . strtoupper(Str::random(8));

        $meeting = VideoMeeting::create([
            'meeting_code' => $meetingCode,
            'booking_id' => $booking?->id,
            'caller_id' => $caller->id,
            'receiver_id' => $receiver->id,
            'status' => 'initiated',
            'started_at' => now(),
        ]);

        $roomUrl = route('video-meeting.room', $meetingCode);

        // Notify receiver
        Notification::create([
            'user_id' => $receiver->id,
            'type' => 'video_meeting_invite',
            'title' => "📹 Incoming \"Let's Talk\" Video Call",
            'message' => "{$caller->name} wants to speak with you on live video to discuss the repair work.",
            'link' => $roomUrl,
            'is_read' => false,
        ]);

        // Insert message in conversation
        Message::create([
            'sender_id' => $caller->id,
            'receiver_id' => $receiver->id,
            'booking_id' => $booking?->id,
            'message' => "📹 [Let's Talk Video Call] Click to join live video meeting: " . $roomUrl,
            'is_read' => false,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'meeting_code' => $meetingCode,
                'room_url' => $roomUrl,
                'receiver_name' => $receiver->name,
            ]);
        }

        return redirect()->to($roomUrl);
    }

    /**
     * Join the interactive video meeting room.
     */
    public function room(string $code): View|RedirectResponse
    {
        $user = Auth::user();

        $meeting = VideoMeeting::where('meeting_code', $code)
            ->with(['caller', 'receiver', 'booking.profession'])
            ->firstOrFail();

        // Check permission: user must be caller, receiver, admin, or associated booking participant
        $isAuthorized = ($user->id === $meeting->caller_id || $user->id === $meeting->receiver_id || $user->isAdmin());
        if (! $isAuthorized && $meeting->booking) {
            if ($meeting->booking->user_id === $user->id || $meeting->booking->professional?->user_id === $user->id) {
                $isAuthorized = true;
                if ($user->id !== $meeting->caller_id && (! $meeting->receiver_id || $meeting->receiver_id === $meeting->caller_id)) {
                    $meeting->update(['receiver_id' => $user->id]);
                    $meeting->refresh();
                }
            }
        }

        if (! $isAuthorized) {
            abort(403, 'You are not authorized to join this private video meeting.');
        }

        // If receiver joins, transition status to connected
        if ($user->id === $meeting->receiver_id && $meeting->status === 'initiated') {
            $meeting->update([
                'status' => 'connected',
                'started_at' => $meeting->started_at ?? now(),
            ]);
        }

        $peer = ($user->id === $meeting->caller_id) ? $meeting->receiver : $meeting->caller;
        $booking = $meeting->booking;

        return view('Frontend.meeting.room', compact('meeting', 'peer', 'booking', 'user'));
    }

    /**
     * Poll status of the video meeting (peers, connection, duration).
     */
    public function pollStatus(string $code): JsonResponse
    {
        $meeting = VideoMeeting::where('meeting_code', $code)->firstOrFail();

        $durationSeconds = $meeting->started_at ? now()->diffInSeconds($meeting->started_at) : 0;

        return response()->json([
            'status' => $meeting->status,
            'started_at' => $meeting->started_at?->toIso8601String(),
            'ended_at' => $meeting->ended_at?->toIso8601String(),
            'duration_seconds' => $durationSeconds,
            'snapshot_url' => $meeting->snapshot_path ? asset($meeting->snapshot_path) : null,
        ]);
    }

    /**
     * Capture live defect screenshot from video stream.
     */
    public function saveSnapshot(Request $request, string $code): JsonResponse
    {
        $meeting = VideoMeeting::where('meeting_code', $code)->firstOrFail();

        $request->validate([
            'image' => ['required', 'string'],
        ]);

        $imageData = $request->input('image');

        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $data = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (! in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                return response()->json(['success' => false, 'message' => 'Invalid image format'], 422);
            }

            $decoded = base64_decode($data);
            if ($decoded === false) {
                return response()->json(['success' => false, 'message' => 'Base64 decode failed'], 422);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid image payload'], 422);
        }

        $dir = public_path('uploads/snapshots');
        if (! file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $fileName = 'defect_snapshot_' . time() . '_' . Str::random(6) . '.' . $type;
        file_put_contents($dir . '/' . $fileName, $decoded);
        $relativePath = 'uploads/snapshots/' . $fileName;

        $meeting->update([
            'snapshot_path' => $relativePath,
        ]);

        if ($meeting->booking && empty($meeting->booking->problem_image)) {
            $meeting->booking->update([
                'problem_image' => $relativePath,
            ]);
        }

        return response()->json([
            'success' => true,
            'snapshot_url' => asset($relativePath),
            'message' => 'Defect photo captured from video stream successfully!',
        ]);
    }

    /**
     * Terminate the video call.
     */
    public function endMeeting(string $code): JsonResponse|RedirectResponse
    {
        $meeting = VideoMeeting::where('meeting_code', $code)->firstOrFail();

        $meeting->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Call ended successfully.']);
        }

        $user = Auth::user();
        if ($user->isTechnician()) {
            return redirect()->route('technician.dashboard')->with('success', 'Video call ended.');
        }

        return redirect()->route('customer.dashboard')->with('success', 'Video call ended.');
    }
}
