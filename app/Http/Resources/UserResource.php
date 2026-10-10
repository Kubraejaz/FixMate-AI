<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'user_type' => $this->user_type,
            'role' => match ((int) ($this->user_type ?? 2)) {
                1 => 'admin',
                3 => 'technician',
                default => 'customer',
            },
            'city' => $this->city,
            'area' => $this->area,
            'is_active' => (bool) $this->is_active,
            'is_verified' => (bool) $this->is_verified,
            'profession_id' => $this->profession_id,
            'experience' => $this->experience,
            'notification_settings' => $this->notification_settings,
            'last_login_at' => optional($this->last_login_at)->toIso8601String(),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'professional' => new ProfessionalResource($this->whenLoaded('professional')),
        ];
    }
}
