<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the technician can reply to the review.
     */
    public function reply(User $user, Review $review): bool
    {
        if (! $user->isTechnician()) {
            return false;
        }

        $pro = $user->professional;
        return $pro && (int) $review->professional_id === (int) $pro->id;
    }

    /**
     * Determine whether the user can delete a review.
     */
    public function delete(User $user, Review $review): bool
    {
        return (int) $review->user_id === (int) $user->id;
    }
}
