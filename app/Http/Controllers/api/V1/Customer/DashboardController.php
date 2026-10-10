<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\BookingResource;
use App\Http\Resources\CommunityIssueResource;
use App\Http\Resources\ProfessionResource;
use App\Http\Resources\ProfessionalResource;
use App\Models\CommunityIssue;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $stats = [
            'active' => $user->bookings()->whereIn('status', ['pending', 'confirmed', 'en_route', 'in_progress'])->count(),
            'upcoming' => $user->bookings()->where('service_date', '>=', now()->toDateString())
                ->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed' => $user->bookings()->where('status', 'completed')->count(),
            'pending' => $user->bookings()->where('status', 'pending')->count(),
        ];

        $recentBookings = $user->bookings()
            ->with(['professional.profession', 'profession'])
            ->latest()
            ->take(5)
            ->get();

        $recommendedTechnicians = Professional::with(['profession', 'user'])
            ->where('is_verified', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        if ($recommendedTechnicians->isEmpty()) {
            $recommendedTechnicians = Professional::with(['profession', 'user'])->take(3)->get();
        }

        $activeEnRouteBooking = $user->bookings()
            ->with(['professional.profession', 'profession'])
            ->whereIn('status', ['confirmed', 'en_route', 'in_progress'])
            ->latest()
            ->first();

        $quickTrades = Profession::where('is_active', true)->take(6)->get();

        $cityAlerts = CommunityIssue::where('city', 'like', '%'.($user->city ?? 'Karachi').'%')
            ->where('status', 'investigating')
            ->latest()
            ->take(2)
            ->get();

        $nearUpcomingBooking = $user->bookings()
            ->with(['professional.profession', 'profession'])
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->whereNotNull('service_date')
            ->whereBetween('service_date', [now()->startOfDay()->toDateString(), now()->addDays(2)->endOfDay()->toDateString()])
            ->orderBy('service_date', 'asc')
            ->first();

        if ($nearUpcomingBooking) {
            $dayLabel = $nearUpcomingBooking->getDateNearLabel() ?? 'Soon';
            $alreadyNotified = Notification::where('user_id', $user->id)
                ->where('type', 'booking_reminder')
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (! $alreadyNotified) {
                Notification::sendToUser(
                    $user->id,
                    'booking_reminder',
                    "⏰ Upcoming Service Alert: Scheduled {$dayLabel}",
                    "Your booking #{$nearUpcomingBooking->booking_number} ({$nearUpcomingBooking->service_title}) is scheduled for {$dayLabel} during {$nearUpcomingBooking->service_time_slot}.",
                    route('customer.bookings')
                );
            }
        }

        $unreadCount = $user->notifications()->unread()->count();

        return $this->ok([
            'user' => new \App\Http\Resources\UserResource($user),
            'stats' => $stats,
            'unread_notifications' => $unreadCount,
            'recent_bookings' => BookingResource::collection($recentBookings),
            'recommended_technicians' => ProfessionalResource::collection($recommendedTechnicians),
            'active_en_route_booking' => $activeEnRouteBooking ? new BookingResource($activeEnRouteBooking) : null,
            'quick_trades' => ProfessionResource::collection($quickTrades),
            'city_alerts' => CommunityIssueResource::collection($cityAlerts),
            'near_upcoming_booking' => $nearUpcomingBooking ? new BookingResource($nearUpcomingBooking) : null,
        ], 'Dashboard retrieved.');
    }
}
