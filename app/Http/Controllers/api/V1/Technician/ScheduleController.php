<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends TechnicianController
{
    public function index(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $query = Booking::where('professional_id', $pro->id)
            ->whereIn('status', ['confirmed', 'en_route', 'in_progress', 'pending'])
            ->with(['user', 'profession', 'professional.user'])
            ->orderBy('service_date');

        if ($request->input('scope') === 'upcoming' || ! $request->filled('include_past')) {
            $query->whereDate('service_date', '>=', now()->toDateString());
        }

        $jobs = $query->get();

        return $this->ok([
            'upcoming_jobs' => BookingResource::collection($jobs),
            'count' => $jobs->count(),
        ], 'Schedule retrieved.');
    }
}
