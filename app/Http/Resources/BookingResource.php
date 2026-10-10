<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_number' => $this->booking_number,
            'user_id' => $this->user_id,
            'professional_id' => $this->professional_id,
            'profession_id' => $this->profession_id,
            'service_title' => $this->service_title,
            'problem_description' => $this->problem_description,
            'problem_image' => $this->problem_image ? asset($this->problem_image) : null,
            'service_date' => optional($this->service_date)->toDateString(),
            'service_time_slot' => $this->service_time_slot,
            'service_address' => $this->service_address,
            'city' => $this->city,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'status_badge' => $this->status_badge,
            'arrival_otp' => $this->arrival_otp,
            'base_price' => $this->base_price,
            'total_price' => $this->total_price,
            'formatted_total' => $this->formatted_total,
            'platform_fee' => $this->platform_fee ?? (int) round(($this->total_price * 10) / 100),
            'technician_payout' => $this->technician_payout ?: (int) round($this->total_price * 0.90),
            'commission_rate' => (float) ($this->commission_rate ?? 10.0),
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'cancellation_reason' => $this->cancellation_reason,
            'tracking_eta_minutes' => $this->tracking_eta_minutes,
            'location_updated_at' => optional($this->location_updated_at)->toIso8601String(),
            'is_date_near' => $this->isDateNear(),
            'date_near_label' => $this->getDateNearLabel(),
            'completed_at' => optional($this->completed_at)->toIso8601String(),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'profession' => new ProfessionResource($this->whenLoaded('profession')),
            'professional' => new ProfessionalResource($this->whenLoaded('professional')),
            'customer' => new UserResource($this->whenLoaded('user')),
            'review' => new ReviewResource($this->whenLoaded('review')),
            'tracking' => $this->when(
                $request->boolean('with_tracking') && $this->relationLoaded('professional'),
                fn () => $this->getLiveTrackingPayload()
            ),
        ];
    }
}
