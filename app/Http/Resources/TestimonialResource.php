<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'trade' => $this->trade,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'avatar_url' => $this->avatar_url,
            'is_featured' => (bool) $this->is_featured,
            'display_order' => $this->display_order,
        ];
    }
}
