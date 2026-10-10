<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityIssueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $meta = $this->category_meta;
        $statusBadge = $this->status_badge;

        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'user_id' => $this->user_id,
            'reporter_name' => $this->reporter_name,
            'reporter_role' => $this->reporter_role,
            'reporter_phone' => $this->reporter_phone,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'category_label' => $meta['label'] ?? null,
            'category_icon' => $meta['icon'] ?? null,
            'city' => $this->city,
            'location' => $this->location,
            'status' => $this->status,
            'status_label' => $statusBadge['label'] ?? null,
            'status_update' => $this->status_update,
            'priority' => $this->priority,
            'upvotes_count' => (int) $this->upvotes_count,
            'is_approved' => (bool) $this->is_approved,
            'is_upvoted' => $request->user() || $request->ip()
                ? $this->isUpvotedBy($request->user(), $request->ip())
                : false,
            'resolved_at' => optional($this->resolved_at)->toIso8601String(),
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
