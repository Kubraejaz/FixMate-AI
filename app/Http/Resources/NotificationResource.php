<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'link' => $this->link,
            'is_read' => (bool) $this->is_read,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'created_at_human' => optional($this->created_at)->diffForHumans(),
        ];
    }
}
