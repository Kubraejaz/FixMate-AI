<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends ApiController
{
    public function threads(Request $request): JsonResponse
    {
        $user = $request->user();

        $technicians = Professional::with(['profession', 'user'])
            ->whereIn('id', function ($query) use ($user) {
                $query->select('professional_id')
                    ->from('bookings')
                    ->where('user_id', $user->id)
                    ->whereNotNull('professional_id');
            })
            ->get();

        if ($technicians->isEmpty()) {
            $technicians = Professional::with(['profession', 'user'])
                ->where('is_verified', true)
                ->take(3)
                ->get();
        }

        $threads = $technicians->map(function (Professional $tech) use ($user) {
            $otherId = $tech->user_id;

            $last = Message::where(function ($q) use ($user, $otherId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $otherId);
            })->orWhere(function ($q) use ($user, $otherId) {
                $q->where('sender_id', $otherId)->where('receiver_id', $user->id);
            })->latest()->first();

            $unread = Message::where('sender_id', $otherId)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();

            return [
                'technician_id' => $tech->id,
                'name' => $tech->name,
                'profession' => $tech->profession?->name,
                'user_id' => $otherId,
                'unread_count' => $unread,
                'last_message' => $last?->message,
                'last_message_at' => optional($last?->created_at)->toIso8601String(),
            ];
        })->values();

        return $this->ok($threads, 'Chat threads retrieved.');
    }

    public function messages(Request $request, Professional $technician): JsonResponse
    {
        $user = $request->user();
        $otherId = $technician->user_id;

        if (! $otherId) {
            return $this->ok([], 'No conversation available.');
        }

        $messages = Message::where(function ($q) use ($user, $otherId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $otherId);
        })->orWhere(function ($q) use ($user, $otherId) {
            $q->where('sender_id', $otherId)->where('receiver_id', $user->id);
        })->oldest()->get();

        Message::where('sender_id', $otherId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return $this->ok(MessageResource::collection($messages), 'Messages retrieved.');
    }

    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'technician_id' => ['required', 'exists:professionals,id'],
            'message' => ['required', 'string', 'max:1000'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
        ]);

        $professional = Professional::findOrFail($validated['technician_id']);

        $msg = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $professional->user_id,
            'booking_id' => $validated['booking_id'] ?? null,
            'message' => trim($validated['message']),
            'is_read' => false,
        ]);

        if ($professional->user_id) {
            Notification::sendToUser(
                $professional->user_id,
                'chat_message',
                'New Message from '.$request->user()->name,
                Str::limit($validated['message'], 100),
                route('technician.messages')
            );
        }

        return $this->created(new MessageResource($msg), 'Message dispatched to technician.');
    }
}
