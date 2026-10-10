<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomepageSettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'hero_badge' => $this->hero_badge,
            'hero_title_main' => $this->hero_title_main,
            'hero_title_highlight' => $this->hero_title_highlight,
            'hero_subtitle' => $this->hero_subtitle,
            'hero_image' => $this->hero_image ? asset($this->hero_image) : null,
            'hero_script_text' => $this->hero_script_text,
            'hero_trusted_tag' => $this->hero_trusted_tag,
            'guarantee_title' => $this->guarantee_title,
            'guarantee_subtitle' => $this->guarantee_subtitle,
            'warranty_days' => $this->warranty_days,
        ];
    }
}
