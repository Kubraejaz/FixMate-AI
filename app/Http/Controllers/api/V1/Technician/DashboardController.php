<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\BookingResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ProfessionalResource;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends TechnicianController
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $pro = $this->professional();

        $today = now()->toDateString();
        $assignedJobQuery = Booking::where('professional_id', $pro->id);

        $todayJobsCount = (clone $assignedJobQuery)->whereDate('service_date', $today)->count();

        $todayEarnings = (int) round(
            Booking::where('professional_id', $pro->id)
                ->where('status', 'completed')
                ->whereDate('completed_at', $today)
                ->sum('total_price') * 0.90
        );

        $pendingEscrow = (int) round(
            (clone $assignedJobQuery)
                ->whereIn('status', ['confirmed', 'en_route', 'in_progress'])
                ->sum('total_price') * 0.90
        );

        $totalReviews = Review::where('professional_id', $pro->id)->count();
        $avgRating = $totalReviews > 0 ? (float) Review::where('professional_id', $pro->id)->avg('rating') : 0.0;
        $ratingFormatted = $totalReviews > 0 ? number_format($avgRating, 1) : 'New';

        $activeJob = (clone $assignedJobQuery)
            ->whereIn('status', ['en_route', 'in_progress'])
            ->with(['user', 'profession', 'professional.user'])
            ->first();

        $incomingJob = Booking::where(function ($q) use ($pro) {
            $q->where('professional_id', $pro->id)->where('status', 'pending');
        })->orWhere(function ($q) use ($pro) {
            $q->whereNull('professional_id')
                ->where('profession_id', $pro->profession_id)
                ->where('status', 'pending');
        })
            ->with(['user', 'profession'])
            ->latest()
            ->first();

        $recentCompletedJobs = (clone $assignedJobQuery)
            ->where('status', 'completed')
            ->with(['user', 'profession'])
            ->latest('completed_at')
            ->take(5)
            ->get();

        $nearJob = (clone $assignedJobQuery)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->whereNotNull('service_date')
            ->whereBetween('service_date', [now()->startOfDay()->toDateString(), now()->addDays(2)->endOfDay()->toDateString()])
            ->with(['user', 'profession'])
            ->orderBy('service_date', 'asc')
            ->first();

        if ($nearJob) {
            $dayLabel = $nearJob->getDateNearLabel() ?? 'Soon';
            $alreadyNotified = Notification::where('user_id', $user->id)
                ->where('type', 'job_reminder')
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (! $alreadyNotified) {
                Notification::sendToUser(
                    $user->id,
                    'job_reminder',
                    "Upcoming Job Alert: Scheduled {$dayLabel}",
                    "You have a scheduled job #{$nearJob->booking_number} ({$nearJob->service_title}) for {$dayLabel} at {$nearJob->service_time_slot}.",
                    null
                );
            }
        }

        return $this->ok([
            'user' => new \App\Http\Resources\UserResource($user),
            'professional' => new ProfessionalResource($pro->load('profession')),
            'stats' => [
                'today_jobs_count' => $todayJobsCount,
                'today_earnings' => $todayEarnings,
                'pending_escrow' => $pendingEscrow,
                'rating' => $ratingFormatted,
                'total_reviews' => $totalReviews,
            ],
            'active_job' => $activeJob ? new BookingResource($activeJob) : null,
            'incoming_job' => $incomingJob ? new BookingResource($incomingJob) : null,
            'near_job' => $nearJob ? new BookingResource($nearJob) : null,
            'recent_completed_jobs' => BookingResource::collection($recentCompletedJobs),
            'recent_notifications' => NotificationResource::collection($user->notifications()->latest()->take(5)->get()),
            'unread_notifications' => $user->notifications()->unread()->count(),
        ], 'Dashboard retrieved.');
    }
}
