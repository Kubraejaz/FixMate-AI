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

        $rate = $pro->getCommissionRate();
        $payoutMultiplier = (100.0 - $rate) / 100.0;

        $completedSum = Booking::where('professional_id', $pro->id)->where('status', 'completed');
        $lifetimeGross = (int) $completedSum->sum('total_price');
        $lifetimeEarnings = (int) ($completedSum->sum('technician_payout') ?: round($lifetimeGross * $payoutMultiplier));
        $totalPlatformFees = (int) ($completedSum->sum('platform_fee') ?: round($lifetimeGross * ($rate / 100.0)));

        $pendingSum = Booking::where('professional_id', $pro->id)->whereIn('status', ['confirmed', 'en_route', 'in_progress']);
        $pendingGross = (int) $pendingSum->sum('total_price');
        $pendingEscrow = (int) ($pendingSum->sum('technician_payout') ?: round($pendingGross * $payoutMultiplier));

        $perPage = min((int) $request->input('per_page', 15), 50);
        $completedBookings = $query->paginate($perPage);

        return $this->ok([
            'summary' => [
                'lifetime_earnings' => $lifetimeEarnings,
                'lifetime_gross' => $lifetimeGross,
                'total_platform_fees_deducted' => $totalPlatformFees,
                'pending_escrow' => $pendingEscrow,
                'available_withdrawal' => $lifetimeEarnings,
                'currency' => 'PKR',
                'subscription' => [
                    'plan' => $pro->subscription_plan ?? 'free',
                    'is_pro' => $pro->isPro(),
                    'subscribed_until' => optional($pro->subscribed_until)->toIso8601String(),
                    'commission_rate' => $rate,
                    'commission_rate_label' => $rate <= 0 ? '0% (VIP Pro Plan Active)' : "{$rate}% Standard Fee",
                ],
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
