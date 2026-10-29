<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Intercept checks for administrators.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $booking->canBeManagedBy($user);
    }

    /**
     * Determine whether the user can create bookings.
     */
    public function create(User $user): bool
    {
        return $user->isCustomer();
    }

    /**
     * Determine whether the user can cancel the booking.
     */
    public function cancel(User $user, Booking $booking): bool
    {
        if (! $booking->isCustomer($user)) {
            return false;
        }

        return in_array($booking->status, ['pending', 'confirmed'], true);
    }

    /**
     * Determine whether the user can accept the job.
     */
    public function accept(User $user, Booking $booking): bool
    {
        if (! $user->isTechnician()) {
            return false;
        }

        $pro = $user->professional;
        if (! $pro || ! $pro->is_verified) {
            return false;
        }

        // Booking must be pending or unassigned
        return in_array($booking->status, ['pending', 'confirmed'], true)
            && ($booking->professional_id === null || $booking->professional_id === $pro->id);
    }

    /**
     * Determine whether the technician can start traveling towards customer.
     */
    public function startRoute(User $user, Booking $booking): bool
    {
        return $booking->isAssignedTechnician($user) && in_array($booking->status, ['confirmed'], true);
    }

    /**
     * Determine whether the technician can transmit real-time GPS locations.
     */
    public function updateLocation(User $user, Booking $booking): bool
    {
        return $booking->isAssignedTechnician($user) && in_array($booking->status, ['confirmed', 'en_route', 'in_progress'], true);
    }

    /**
     * Determine whether the technician can verify the customer's arrival OTP.
     */
    public function verifyArrivalOtp(User $user, Booking $booking): bool
    {
        return $booking->isAssignedTechnician($user) && in_array($booking->status, ['en_route', 'confirmed'], true);
    }

    /**
     * Determine whether the technician can mark job as completed.
     */
    public function complete(User $user, Booking $booking): bool
    {
        return $booking->isAssignedTechnician($user) && in_array($booking->status, ['in_progress', 'en_route'], true);
    }

    /**
     * Determine whether the customer can pay for the booking.
     */
    public function pay(User $user, Booking $booking): bool
    {
        return $booking->isCustomer($user);
    }

    /**
     * Determine whether the customer can review this booking.
     */
    public function review(User $user, Booking $booking): bool
    {
        return $booking->isCustomer($user) && $booking->status === 'completed';
    }
}
