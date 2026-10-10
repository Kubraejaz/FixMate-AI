<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobController extends TechnicianController
{
    public function index(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $query = Booking::query()
            ->where(function ($q) use ($pro) {
                $q->where('professional_id', $pro->id)
                    ->orWhere(function ($sub) use ($pro) {
                        $sub->whereNull('professional_id')
                            ->where('profession_id', $pro->profession_id);
                    });
            })
            ->with(['user', 'profession', 'professional.user', 'review', 'professional.profession']);

        $tab = $request->input('tab', $request->input('status', 'all'));

        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($tab === 'active') {
            $query->whereIn('status', ['confirmed', 'en_route', 'in_progress']);
        } elseif (in_array($tab, ['completed', 'cancelled'], true)) {
            $query->where('status', $tab);
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                    ->orWhere('service_title', 'like', "%{$search}%")
                    ->orWhere('service_address', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $baseCountQuery = Booking::where(function ($q) use ($pro) {
            $q->where('professional_id', $pro->id)
                ->orWhere(function ($sub) use ($pro) {
                    $sub->whereNull('professional_id')
                        ->where('profession_id', $pro->profession_id);
                });
        });

        $counts = [
            'all' => (clone $baseCountQuery)->count(),
            'pending' => (clone $baseCountQuery)->where('status', 'pending')->count(),
            'active' => (clone $baseCountQuery)->whereIn('status', ['confirmed', 'en_route', 'in_progress'])->count(),
            'completed' => (clone $baseCountQuery)->where('status', 'completed')->count(),
        ];

        $perPage = min((int) $request->input('per_page', 10), 50);
        $jobs = $query->latest()->paginate($perPage);

        return $this->ok(BookingResource::collection($jobs->items()), 'Jobs retrieved.', array_merge([
            'current_page' => $jobs->currentPage(),
            'per_page' => $jobs->perPage(),
            'total' => $jobs->total(),
            'last_page' => $jobs->lastPage(),
            'from' => $jobs->firstItem(),
            'to' => $jobs->lastItem(),
        ], ['counts' => $counts]));
    }

    public function show(Request $request, Booking $booking): JsonResponse
    {
        $pro = $this->professional();
        $this->authorizeAccess($booking, $pro->id, $pro->profession_id);

        $booking->load(['user', 'profession', 'professional.user', 'professional.profession', 'review']);

        return $this->ok([
            'booking' => new BookingResource($booking),
            'tech_payout' => (int) round($booking->total_price * 0.90),
        ], 'Job details retrieved.');
    }

    public function accept(Request $request, Booking $booking): JsonResponse
    {
        $user = $request->user();
        $pro = $this->professional();

        if ($user->is_active === false || $pro->verification_status === 'rejected') {
            return $this->error('Your technician profile has been blocked. Please contact the FixMate team for assistance.', 403);
        }

        if ($booking->professional_id && $booking->professional_id !== $pro->id) {
            return $this->error('This job has already been claimed by another technician.', 422);
        }

        $booking->update([
            'professional_id' => $pro->id,
            'status' => 'confirmed',
        ]);

        Notification::sendToUser(
            $booking->user_id,
            'booking_accepted',
            "Technician Confirmed: {$pro->name}",
            "Your technician {$pro->name} has accepted booking #{$booking->booking_number} and is preparing to dispatch.",
            null
        );

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'message' => "Assalam o Alaikum! I have accepted your booking #{$booking->booking_number}. I will be arriving during your requested slot: {$booking->service_time_slot}.",
            'is_read' => false,
        ]);

        $booking->load(['user', 'profession', 'professional.user']);

        return $this->ok(new BookingResource($booking), "Job #{$booking->booking_number} accepted! Customer has been notified.");
    }

    public function startRoute(Request $request, Booking $booking): JsonResponse
    {
        $pro = $this->professional();

        if ($booking->professional_id !== $pro->id) {
            return $this->error('Unauthorized booking operation.', 403);
        }

        $booking->update([
            'professional_id' => $pro->id,
            'status' => 'en_route',
        ]);

        Notification::sendToUser(
            $booking->user_id,
            'technician_en_route',
            'Technician En Route! (ETA < 20 Mins)',
            "{$pro->name} is now travelling to your address: {$booking->service_address}.",
            null
        );

        Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'message' => "I am now en route to {$booking->service_address}. Estimated arrival is within 20 minutes.",
            'is_read' => false,
        ]);

        $booking->load(['user', 'profession', 'professional.user']);

        return $this->ok(new BookingResource($booking), 'You are now En Route! Live status dispatched to customer.');
    }

    public function activeJob(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $booking = Booking::where('professional_id', $pro->id)
            ->whereIn('status', ['confirmed', 'en_route', 'in_progress'])
            ->with(['user', 'profession', 'professional.user', 'professional.profession'])
            ->latest()
            ->first();

        return $this->ok([
            'booking' => $booking ? new BookingResource($booking) : null,
            'tech_payout' => $booking ? (int) round($booking->total_price * 0.90) : 0,
        ], 'Active job retrieved.');
    }

    public function updateLocation(Request $request, Booking $booking): JsonResponse
    {
        $pro = $this->professional();

        if ($booking->professional_id !== $pro->id) {
            return $this->error('Unauthorized booking.', 403);
        }

        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'eta_minutes' => ['nullable', 'integer', 'min:0'],
        ]);

        $booking->update([
            'technician_latitude' => $validated['latitude'],
            'technician_longitude' => $validated['longitude'],
            'tracking_eta_minutes' => $validated['eta_minutes'] ?? $booking->tracking_eta_minutes,
            'location_updated_at' => now(),
        ]);

        return $this->ok($booking->getLiveTrackingPayload(), 'Location updated.');
    }

    public function verifyOtp(Request $request, Booking $booking): JsonResponse
    {
        $pro = $this->professional();

        if ($booking->professional_id !== $pro->id) {
            return $this->error('Unauthorized booking operation.', 403);
        }

        $validated = $request->validate([
            'otp' => ['nullable', 'string', 'max:10'],
            'digit_1' => ['nullable', 'numeric'],
            'digit_2' => ['nullable', 'numeric'],
            'digit_3' => ['nullable', 'numeric'],
            'digit_4' => ['nullable', 'numeric'],
        ]);

        $otp = $validated['otp'] ?? null;
        if (! $otp && $request->filled('digit_1')) {
            $otp = $request->input('digit_1').$request->input('digit_2').$request->input('digit_3').$request->input('digit_4');
        }

        $otp = trim((string) $otp);

        if ($otp !== (string) $booking->arrival_otp) {
            return $this->error("Invalid Arrival OTP '{$otp}'. Please check the 4-digit code shown on the customer's phone.", 422);
        }

        $booking->update(['status' => 'in_progress']);

        Notification::sendToUser(
            $booking->user_id,
            'service_started',
            'Service Begun: OTP Verified',
            "Technician {$pro->name} has verified your OTP and officially begun the repair work.",
            null
        );

        $booking->load(['user', 'profession', 'professional.user']);

        return $this->ok(new BookingResource($booking), 'Arrival OTP verified successfully! The job is now In Progress.');
    }

    public function complete(Request $request, Booking $booking): JsonResponse
    {
        $pro = $this->professional();

        if ($booking->professional_id !== $pro->id) {
            return $this->error('Unauthorized booking operation.', 403);
        }

        $booking->update([
            'status' => 'completed',
            'completed_at' => now(),
            'payment_status' => 'escrow_released',
        ]);

        $payout = (int) round($booking->total_price * 0.90);

        Notification::sendToUser(
            $booking->user_id,
            'job_completed',
            "Service Completed: #{$booking->booking_number}",
            "Your repair has been completed by {$pro->name}. Please review your experience!",
            null
        );

        Notification::notifyAdmins(
            'escrow_released',
            "Escrow Released: #{$booking->booking_number}",
            "Job completed by {$pro->name}. Payout Rs. {$payout} cleared.",
            null
        );

        $booking->load(['user', 'profession', 'professional.user']);

        return $this->ok([
            'booking' => new BookingResource($booking),
            'payout' => $payout,
        ], 'Service completed! Rs. '.number_format($payout).' has been credited to your wallet.');
    }

    private function authorizeAccess(Booking $booking, int $professionalId, ?int $professionId): void
    {
        $owns = $booking->professional_id === $professionalId;
        $open = $booking->professional_id === null && (int) $booking->profession_id === (int) $professionId;

        abort_unless($owns || $open, 403, 'Unauthorized booking access.');
    }
}
