<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $documents = [
            'cnic_front' => $this->getDocumentUrl($this->cnic_front_path),
            'cnic_back' => $this->getDocumentUrl($this->cnic_back_path),
            'biometric_selfie' => $this->getDocumentUrl($this->biometric_selfie_path),
            'police_certificate' => $this->getDocumentUrl($this->police_certificate_path),
            'trade_license' => $this->getDocumentUrl($this->trade_license_path),
            'proof_of_address' => $this->getDocumentUrl($this->proof_of_address_path),
        ];

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'profession_id' => $this->profession_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'experience' => $this->experience,
            'description' => $this->description,
            'sub_categories' => $this->sub_categories,
            'is_verified' => (bool) $this->is_verified,
            'verification_status' => $this->verification_status,
            'biometric_status' => $this->biometric_status,
            'rejection_reason' => $this->rejection_reason,
            'rating' => $this->reviews_avg_rating ? round((float) $this->reviews_avg_rating, 1) : null,
            'reviews_count' => (int) ($this->reviews_count ?? 0),
            'is_online' => $this->isOnline(),
            'profession' => new ProfessionResource($this->whenLoaded('profession')),
            'user' => new UserResource($this->whenLoaded('user')),
            'documents' => $documents,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
