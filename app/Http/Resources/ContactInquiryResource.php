<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactInquiryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'department' => $this->department,
            'department_label' => $this->department_label,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'city' => $this->city,
            'message' => $this->message,
            'status' => $this->status,
            'status_label' => $this->status_badge['label'] ?? null,
            'admin_notes' => $this->admin_notes,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
