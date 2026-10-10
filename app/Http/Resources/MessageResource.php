<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $viewerId = optional($request->user())->id;

        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'booking_id' => $this->booking_id,
            'message' => $this->message,
            'is_read' => (bool) $this->is_read,
            'is_me' => $viewerId !== null ? $this->sender_id === $viewerId : null,
            'time' => optional($this->created_at)->format('h:i A'),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'sender' => new UserResource($this->whenLoaded('sender')),
            'receiver' => new UserResource($this->whenLoaded('receiver')),
        ];
    }
}
