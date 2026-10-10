<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->display_icon,
            'description' => $this->description,
            'headline' => $this->headline,
            'base_price' => $this->base_price,
            'formatted_price' => $this->formatted_price,
            'price_unit' => $this->price_unit,
            'estimated_duration' => $this->estimated_duration,
            'image' => $this->image ? asset($this->image) : null,
            'warranty_text' => $this->warranty_text,
            'sub_categories' => $this->sub_categories_list,
            'feature_points' => $this->feature_points_list,
            'included_items' => $this->included_list,
            'excluded_items' => $this->excluded_list,
            'is_active' => (bool) $this->is_active,
            'professionals_count' => $this->when(isset($this->professionals_count), fn () => (int) $this->professionals_count),
            'professionals' => ProfessionalResource::collection($this->whenLoaded('professionals')),
        ];
    }
}
