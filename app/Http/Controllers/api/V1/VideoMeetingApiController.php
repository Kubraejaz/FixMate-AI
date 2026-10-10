<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\VideoMeetingResource;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Professional;
use App\Models\User;
use App\Models\VideoMeeting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoMeetingApiController extends ApiController
{
    public function initiate(Request $request): JsonResponse
    {
        $caller = $request->user();

        if ($caller->isTechnician()) {
            $isVerified = (bool) ($caller->is_verified
                || $caller->professional?->is_verified
                || $caller->professional?->verification_status === 'verified');

            if (! $isVerified) {
                return $this->error('Technician account requires admin approval before starting video consultations.', 403);
            }
        }

        $bookingId = $request->input('booking_id');
        $receiverId = $request->input('receiver_id');
        $techId = $request->input('technician_id') ?: $request->input('tech_id') ?: $request->input('professional_id');
        $clientId = $request->input('client_id') ?: $request->input('customer_id');
        $booking = null;

        if ($bookingId) {
            $booking = Booking::with(['professional.user', 'user'])->find($bookingId);
            if ($booking) {
                $receiverId = $caller->id === $booking->user_id
                    ? $booking->professional?->user_id
                    : $booking->user_id;
            }
        }

        if (! $receiverId && $techId) {
            $pro = is_numeric($techId)
                ? Professional::with('user')->find($techId)
                : Professional::with('user')->get()->first(fn ($p) => strtolower(str_replace(' ', '-', $p->name)) === strtolower($techId));

            $receiverId = $pro?->user_id ?? (is_numeric($techId) ? (int) $techId : null);
        }

        if (! $receiverId && $clientId) {
            $receiverId = (int) $clientId;
        }

        if ($receiverId && ! User::where('id', $receiverId)->exists()) {
            $pro = Professional::find($receiverId);
            if ($pro?->user_id) {
                $receiverId = $pro->user_id;
            }
        }

        if (! $receiverId) {
            if ($caller->isCustomer()) {
                $latestBooking = $caller->bookings()->whereNotNull('professional_id')->latest()->first();
                if ($latestBooking?->professional?->user_id) {
                    $receiverId = $latestBooking->professional->user_id;
                    $booking = $booking ?: $latestBooking;
                } else {
                    $receiverId = Professional::where('is_verified', true)->whereNotNull('user_id')->first()?->user_id;
                }
            } elseif ($caller->isTechnician()) {
                $pro = $caller->professional;
                if ($pro) {
                    $latestJob = Booking::where('professional_id', $pro->id)->latest()->first();
                    if ($latestJob?->user_id) {
                        $receiverId = $latestJob->user_id;
                        $booking = $booking ?: $latestJob;
                    }
                }
            }
        }

        if (! $receiverId) {
            return $this->error('No technician or customer found to call.', 422);
        }

        $receiver = User::find($receiverId);
        if (! $receiver) {
            return $this->error('Participant user account not found.', 404);
        }

        $meetingCode = 'FM-TALK-'.strtoupper(Str::random(8));

        $meeting = VideoMeeting::create([
            'meeting_code' => $meetingCode,
            'booking_id' => $booking?->id,
            'caller_id' => $caller->id,
            'receiver_id' => $receiver->id,
            'status' => 'initiated',
            'started_at' => now(),
        ]);

        $roomUrl = route('video-meeting.room', $meetingCode);

        Notification::create([
            'user_id' => $receiver->id,
            'type' => 'video_meeting_invite',
            'title' => 'Incoming "Let\'s Talk" Video Call',
            'message' => "{$caller->name} wants to speak with you on live video to discuss the repair work.",
            'link' => $roomUrl,
            'is_read' => false,
        ]);

        Message::create([
            'sender_id' => $caller->id,
            'receiver_id' => $receiver->id,
            'booking_id' => $booking?->id,
            'message' => "[Let's Talk Video Call] Join live video meeting: ".$roomUrl,
            'is_read' => false,
        ]);

        return $this->created([
            'meeting' => new VideoMeetingResource($meeting->load(['caller', 'receiver'])),
            'meeting_code' => $meetingCode,
            'room_url' => $roomUrl,
            'receiver_name' => $receiver->name,
        ], 'Video meeting initiated.');
    }

    public function status(Request $request, string $code): JsonResponse
    {
        $meeting = VideoMeeting::where('meeting_code', $code)
            ->with(['caller', 'receiver', 'booking'])
            ->firstOrFail();

        $this->authorizeParticipant($request, $meeting);

        return $this->ok(new VideoMeetingResource($meeting), 'Meeting status retrieved.');
    }

    public function join(Request $request, string $code): JsonResponse
    {
        $meeting = VideoMeeting::where('meeting_code', $code)
            ->with(['caller', 'receiver', 'booking'])
            ->firstOrFail();

        $user = $request->user();
        $isCallerOrReceiver = in_array($user->id, [$meeting->caller_id, $meeting->receiver_id], true);

        if (! $isCallerOrReceiver && $meeting->booking) {
            $associated = $meeting->booking->user_id === $user->id
                || $meeting->booking->professional?->user_id === $user->id;

            if ($associated && $user->id !== $meeting->caller_id) {
                $meeting->update(['receiver_id' => $user->id]);
                $meeting->refresh();
                $isCallerOrReceiver = true;
            }
        }

        if (! $isCallerOrReceiver && ! $user->isAdmin()) {
            return $this->error('You are not authorized to join this private video meeting.', 403);
        }

        if ($user->id === $meeting->receiver_id && $meeting->status === 'initiated') {
            $meeting->update([
                'status' => 'connected',
                'started_at' => $meeting->started_at ?? now(),
            ]);
        }

        return $this->ok([
            'meeting' => new VideoMeetingResource($meeting->fresh(['caller', 'receiver', 'booking'])),
            'room_url' => route('video-meeting.room', $meeting->meeting_code),
        ], 'Joined video meeting.');
    }

    public function snapshot(Request $request, string $code): JsonResponse
    {
        $meeting = VideoMeeting::where('meeting_code', $code)->firstOrFail();

        $this->authorizeParticipant($request, $meeting);

        $request->validate(['image' => ['required', 'string']]);

        $imageData = $request->input('image');

        if (! preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            return $this->error('Invalid image payload.', 422);
        }

        $extension = strtolower($type[1]);
        if (! in_array($extension, ['jpg', 'jpeg', 'gif', 'png', 'webp'], true)) {
            return $this->error('Invalid image format.', 422);
        }

        $decoded = base64_decode(substr($imageData, strpos($imageData, ',') + 1));
        if ($decoded === false) {
            return $this->error('Base64 decode failed.', 422);
        }

        $dir = public_path('uploads/snapshots');
        if (! file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $fileName = 'defect_snapshot_'.time().'_'.Str::random(6).'.'.$extension;
        file_put_contents($dir.'/'.$fileName, $decoded);
        $relativePath = 'uploads/snapshots/'.$fileName;

        $meeting->update(['snapshot_path' => $relativePath]);

        if ($meeting->booking && empty($meeting->booking->problem_image)) {
            $meeting->booking->update(['problem_image' => $relativePath]);
        }

        return $this->ok([
            'snapshot_url' => asset($relativePath),
        ], 'Defect photo captured from video stream successfully!');
    }

    public function end(Request $request, string $code): JsonResponse
    {
        $meeting = VideoMeeting::where('meeting_code', $code)->firstOrFail();

        $this->authorizeParticipant($request, $meeting);

        $meeting->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        return $this->ok(new VideoMeetingResource($meeting->fresh(['caller', 'receiver'])), 'Call ended successfully.');
    }

    private function authorizeParticipant(Request $request, VideoMeeting $meeting): void
    {
        $user = $request->user();

        if (in_array($user->id, [$meeting->caller_id, $meeting->receiver_id], true) || $user->isAdmin()) {
            return;
        }

        abort(403, 'You are not authorized to access this private video meeting.');
    }
}
