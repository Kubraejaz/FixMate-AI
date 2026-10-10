<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'user_id' => $this->user_id,
            'profession_id' => $this->profession_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'city' => $this->city,
            'experience_years' => $this->experience_years,
            'workshop_type' => $this->workshop_type,
            'tools_available' => $this->tools_available,
            'documents_list' => $this->documents_list,
            'biometric_status' => $this->biometric_status,
            'rejection_reason' => $this->rejection_reason,
            'status' => $this->status,
            'status_label' => $this->status_badge['label'] ?? null,
            'admin_notes' => $this->admin_notes,
            'reviewed_at' => optional($this->reviewed_at)->toIso8601String(),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'profession' => new ProfessionResource($this->whenLoaded('profession')),
            'user' => new UserResource($this->whenLoaded('user')),
            'documents' => [
                'cnic_front' => $this->getDocumentUrl($this->cnic_front_path),
                'cnic_back' => $this->getDocumentUrl($this->cnic_back_path),
                'biometric_selfie' => $this->getDocumentUrl($this->biometric_selfie_path),
                'police_certificate' => $this->getDocumentUrl($this->police_certificate_path),
                'trade_license' => $this->getDocumentUrl($this->trade_license_path),
                'proof_of_address' => $this->getDocumentUrl($this->proof_of_address_path),
            ],
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
        ];
    }
}
