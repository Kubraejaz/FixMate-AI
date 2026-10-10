<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowStepResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'step_number' => $this->step_number,
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->description,
            'badge_color' => $this->badge_color,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
