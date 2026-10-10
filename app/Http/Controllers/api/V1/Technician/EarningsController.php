<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EarningsController extends TechnicianController
{
    public function index(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $query = Booking::where('professional_id', $pro->id)
            ->where('status', 'completed')
            ->with('user')
            ->latest('completed_at');

        $lifetimeEarnings = (int) round(
            Booking::where('professional_id', $pro->id)->where('status', 'completed')->sum('total_price') * 0.90
        );

        $pendingEscrow = (int) round(
            Booking::where('professional_id', $pro->id)
                ->whereIn('status', ['confirmed', 'en_route', 'in_progress'])
                ->sum('total_price') * 0.90
        );

        $perPage = min((int) $request->input('per_page', 15), 50);
        $completedBookings = $query->paginate($perPage);

        return $this->ok([
            'summary' => [
                'lifetime_earnings' => $lifetimeEarnings,
                'pending_escrow' => $pendingEscrow,
                'available_withdrawal' => $lifetimeEarnings,
                'currency' => 'PKR',
            ],
            'transactions' => BookingResource::collection($completedBookings->items()),
        ], 'Earnings retrieved.', [
            'current_page' => $completedBookings->currentPage(),
            'per_page' => $completedBookings->perPage(),
            'total' => $completedBookings->total(),
            'last_page' => $completedBookings->lastPage(),
        ]);
    }
}
