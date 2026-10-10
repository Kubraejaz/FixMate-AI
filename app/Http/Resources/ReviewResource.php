<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'user_id' => $this->user_id,
            'professional_id' => $this->professional_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'technician_reply' => $this->technician_reply,
            'technician_replied_at' => optional($this->technician_replied_at)->toIso8601String(),
            'is_approved' => (bool) $this->is_approved,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'customer' => new UserResource($this->whenLoaded('user')),
            'professional' => new ProfessionalResource($this->whenLoaded('professional')),
            'booking' => new BookingResource($this->whenLoaded('booking')),
        ];
    }
}
