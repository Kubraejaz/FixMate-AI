<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\MessageResource;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends TechnicianController
{
    public function threads(Request $request): JsonResponse
    {
        $user = $request->user();
        $pro = $this->professional();

        $assignedCustomerIds = Booking::where('professional_id', $pro->id)
            ->pluck('user_id')
            ->unique()
            ->filter()
            ->values();

        $customers = User::whereIn('id', $assignedCustomerIds)->get();

        $threads = $customers->map(function (User $customer) use ($user) {
            $last = Message::where(function ($q) use ($user, $customer) {
                $q->where('sender_id', $user->id)->where('receiver_id', $customer->id);
            })->orWhere(function ($q) use ($user, $customer) {
                $q->where('sender_id', $customer->id)->where('receiver_id', $user->id);
            })->latest()->first();

            $unread = Message::where('sender_id', $customer->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();

            return [
                'customer_id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'city' => $customer->city,
                'unread_count' => $unread,
                'last_message' => $last?->message,
                'last_message_at' => optional($last?->created_at)->toIso8601String(),
            ];
        })->values();

        return $this->ok($threads, 'Chat threads retrieved.');
    }

    public function messages(Request $request, User $customer): JsonResponse
    {
        $user = $request->user();

        $messages = Message::where(function ($q) use ($user, $customer) {
            $q->where('sender_id', $user->id)->where('receiver_id', $customer->id);
        })->orWhere(function ($q) use ($user, $customer) {
            $q->where('sender_id', $customer->id)->where('receiver_id', $user->id);
        })->oldest()->get();

        Message::where('sender_id', $customer->id)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return $this->ok(MessageResource::collection($messages), 'Messages retrieved.');
    }

    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'message' => ['required', 'string', 'max:1000'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
        ]);

        $user = $request->user();

        $msg = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $validated['receiver_id'],
            'booking_id' => $validated['booking_id'] ?? null,
            'message' => trim($validated['message']),
            'is_read' => false,
        ]);

        Notification::sendToUser(
            $validated['receiver_id'],
            'chat_message',
            "New Message from Technician {$user->name}",
            Str::limit($validated['message'], 100),
            null
        );

        return $this->created(new MessageResource($msg), 'Message dispatched to customer.');
    }
}
