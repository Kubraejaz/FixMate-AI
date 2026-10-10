<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoMeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'meeting_code' => $this->meeting_code,
            'booking_id' => $this->booking_id,
            'caller_id' => $this->caller_id,
            'receiver_id' => $this->receiver_id,
            'status' => $this->status,
            'room_url' => route('video-meeting.room', $this->meeting_code),
            'started_at' => optional($this->started_at)->toIso8601String(),
            'ended_at' => optional($this->ended_at)->toIso8601String(),
            'duration_seconds' => $this->started_at ? now()->diffInSeconds($this->started_at) : 0,
            'snapshot_url' => $this->snapshot_path ? asset($this->snapshot_path) : null,
            'notes' => $this->notes,
            'caller' => new UserResource($this->whenLoaded('caller')),
            'receiver' => new UserResource($this->whenLoaded('receiver')),
        ];
    }
}
