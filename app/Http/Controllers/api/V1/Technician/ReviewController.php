<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\ReviewResource;
use App\Models\Notification;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends TechnicianController
{
    public function index(Request $request): JsonResponse
    {
        $pro = $this->professional();
        $filter = $request->query('filter', 'all');

        $query = Review::where('professional_id', $pro->id)
            ->with(['user', 'booking', 'professional'])
            ->latest();

        if ($filter === '5') {
            $query->where('rating', 5);
        } elseif ($filter === 'low' || $filter === '4') {
            $query->where('rating', '<=', 4);
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $reviews = $query->paginate($perPage);

        $totalReviews = Review::where('professional_id', $pro->id)->count();
        $avgRating = $totalReviews > 0 ? (float) Review::where('professional_id', $pro->id)->avg('rating') : 0.0;

        $starCounts = [];
        for ($stars = 5; $stars >= 1; $stars--) {
            $starCounts[$stars] = Review::where('professional_id', $pro->id)->where('rating', $stars)->count();
        }

        $distribution = [];
        foreach ($starCounts as $stars => $count) {
            $distribution[$stars] = [
                'count' => $count,
                'pct' => $totalReviews > 0 ? (int) round(($count / $totalReviews) * 100) : 0,
            ];
        }

        $repliedCount = Review::where('professional_id', $pro->id)->whereNotNull('technician_reply')->count();
        $positiveCount = $starCounts[5] + $starCounts[4];

        return $this->ok(ReviewResource::collection($reviews->items()), 'Reviews retrieved.', [
            'current_page' => $reviews->currentPage(),
            'per_page' => $reviews->perPage(),
            'total' => $reviews->total(),
            'last_page' => $reviews->lastPage(),
            'avg_rating' => round($avgRating, 1),
            'total_reviews' => $totalReviews,
            'distribution' => $distribution,
            'reply_rate' => $totalReviews > 0 ? (int) round(($repliedCount / $totalReviews) * 100) : 0,
            'satisfaction_rate' => $totalReviews > 0 ? (int) round(($positiveCount / $totalReviews) * 100) : 0,
        ]);
    }

    public function reply(Request $request, Review $review): JsonResponse
    {
        $pro = $this->professional();

        if ($review->professional_id !== $pro->id) {
            return $this->error('Unauthorized action.', 403);
        }

        $validated = $request->validate([
            'reply' => ['required', 'string', 'max:1000'],
        ]);

        $review->update([
            'technician_reply' => trim($validated['reply']),
            'technician_replied_at' => now(),
        ]);

        if ($review->user_id) {
            Notification::notifyUser(
                $review->user_id,
                'review_reply',
                'Technician Replied to Your Review',
                $pro->name.' posted a response to your service review.',
                null
            );
        }

        return $this->ok(new ReviewResource($review->fresh(['user', 'booking', 'professional'])), 'Your public reply has been published.');
    }
}
