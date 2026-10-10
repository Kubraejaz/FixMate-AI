<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $completedBookings = $user->bookings()
            ->with(['professional', 'profession', 'review'])
            ->where('status', 'completed')
            ->latest()
            ->get();

        $myReviews = $user->reviews()->with(['booking', 'professional'])->latest()->get();

        return $this->ok([
            'reviewable_bookings' => BookingResource::collection($completedBookings),
            'my_reviews' => ReviewResource::collection($myReviews),
        ], 'Reviews retrieved.');
    }

    public function store(Request $request, Booking $booking): JsonResponse
    {
        if ($booking->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized booking access.');
        }

        if ($booking->status !== 'completed') {
            return $this->error('Only completed jobs can be reviewed.', 422);
        }

        if ($booking->review()->exists()) {
            return $this->error('You have already submitted a review for this booking.', 422);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'rating.between' => 'Rating must be between 1 and 5 stars.',
            'comment.min' => 'Please provide at least 3 characters in your review.',
        ]);

        $review = Review::create([
            'booking_id' => $booking->id,
            'user_id' => $request->user()->id,
            'professional_id' => $booking->professional_id,
            'rating' => $validated['rating'],
            'comment' => trim($validated['comment']),
            'is_approved' => true,
        ]);

        return $this->created(new ReviewResource($review), 'Thank you! Your verified review has been submitted.');
    }
}
