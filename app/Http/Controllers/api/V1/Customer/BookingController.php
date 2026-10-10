<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = $user->bookings()->with(['professional.user', 'profession', 'review']);

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->whereIn('status', ['pending', 'confirmed', 'en_route', 'in_progress']);
            } elseif (in_array($status, ['pending', 'confirmed', 'en_route', 'in_progress', 'completed', 'cancelled'], true)) {
                $query->where('status', $status);
            }
        }

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('booking_number', 'like', $term)
                    ->orWhere('service_title', 'like', $term)
                    ->orWhere('service_address', 'like', $term);
            });
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $bookings = $query->latest()->paginate($perPage);

        return $this->paginated($bookings, BookingResource::class, 'Bookings retrieved.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profession_id' => ['required', 'exists:professions,id'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'service_title' => ['nullable', 'string', 'max:150'],
            'service_date' => ['required', 'date', 'after_or_equal:today'],
            'service_time_slot' => ['required', 'string', 'max:100'],
            'service_address' => ['required', 'string', 'min:5', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'problem_description' => ['nullable', 'string', 'max:1000'],
            'problem_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'service_date.after_or_equal' => 'Appointment date cannot be scheduled in the past.',
            'service_address.min' => 'Please provide a complete street address with house/flat number.',
            'problem_image.max' => 'Defect photo must not exceed 5MB.',
        ]);

        $profession = Profession::findOrFail($validated['profession_id']);

        $imagePath = null;
        if ($request->hasFile('problem_image')) {
            $file = $request->file('problem_image');
            $fileName = 'defect_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $fileName);
            $imagePath = 'assets/images/'.$fileName;
        }

        $bookingNumber = Booking::generateBookingNumber();
        $arrivalOtp = Booking::generateOtp();
        $basePrice = $profession->base_price ?? 650;

        $booking = Booking::create([
            'booking_number' => $bookingNumber,
            'user_id' => $request->user()->id,
            'professional_id' => $validated['professional_id'] ?? null,
            'profession_id' => $profession->id,
            'service_title' => $validated['service_title'] ?: ($profession->name.' Service & Maintenance'),
            'problem_description' => $validated['problem_description'] ?? null,
            'problem_image' => $imagePath,
            'service_date' => $validated['service_date'],
            'service_time_slot' => $validated['service_time_slot'],
            'service_address' => $validated['service_address'],
            'city' => $validated['city'],
            'status' => 'pending',
            'arrival_otp' => $arrivalOtp,
            'base_price' => $basePrice,
            'total_price' => $basePrice,
            'payment_status' => 'escrow_held',
            'payment_method' => 'escrow',
        ]);

        Notification::sendToUser(
            $booking->user_id,
            'booking_created',
            "Booking #{$booking->booking_number} Confirmed!",
            "Your repair has been booked for {$booking->service_date->format('M d')}. Your Arrival OTP is {$arrivalOtp}.",
            route('customer.booking.confirm', $booking->id)
        );

        if ($booking->professional && $booking->professional->user_id) {
            Notification::sendToUser(
                $booking->professional->user_id,
                'booking_assigned',
                "New Booking Assigned: #{$booking->booking_number}",
                'Customer '.$request->user()->name." booked {$booking->service_title} in {$booking->city}.",
                route('technician.jobs.details', $booking->booking_number)
            );

            Message::create([
                'sender_id' => $booking->user_id,
                'receiver_id' => $booking->professional->user_id,
                'booking_id' => $booking->id,
                'message' => "Hello! I have booked '{$booking->service_title}' scheduled for {$booking->service_date->format('M d, Y')} ({$booking->service_time_slot}) at {$booking->service_address}, {$booking->city}.",
                'is_read' => false,
            ]);
        } else {
            $matchingPros = Professional::where('profession_id', $booking->profession_id)->get();
            foreach ($matchingPros as $pro) {
                if ($pro->user_id) {
                    Notification::sendToUser(
                        $pro->user_id,
                        'new_job_available',
                        "New Available Job: #{$booking->booking_number}",
                        "{$booking->service_title} in {$booking->city}. Tap to claim or view details.",
                        route('technician.jobs.details', $booking->booking_number)
                    );
                }
            }
        }

        Notification::notifyAdmins(
            'booking_dispatched',
            "New Booking: #{$booking->booking_number}",
            "Booking for {$profession->name} in {$booking->city} created by ".$request->user()->name,
            route('admin.bookings')
        );

        $booking->load(['professional.user', 'profession']);

        return $this->created([
            'booking' => new BookingResource($booking),
            'arrival_otp' => $arrivalOtp,
        ], "Booking #{$booking->booking_number} created successfully!");
    }

    public function show(Request $request, Booking $booking): JsonResponse
    {
        $this->authorizeOwnership($request, $booking);
        $booking->load(['professional.user', 'profession', 'review']);

        return $this->ok(new BookingResource($booking), 'Booking retrieved.');
    }

    public function cancel(Request $request, Booking $booking): JsonResponse
    {
        $this->authorizeOwnership($request, $booking);

        if ($booking->status === 'completed') {
            return $this->error('Completed bookings cannot be cancelled.', 422);
        }

        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'] ?? 'Cancelled by customer',
        ]);

        return $this->ok(new BookingResource($booking), "Booking #{$booking->booking_number} has been cancelled.");
    }

    public function tracking(Request $request, Booking $booking): JsonResponse
    {
        $this->authorizeOwnership($request, $booking);
        $booking->load(['professional.user', 'profession']);

        return $this->ok($booking->getLiveTrackingPayload(), 'Tracking data retrieved.');
    }

    public function processPayment(Request $request, Booking $booking): JsonResponse
    {
        $this->authorizeOwnership($request, $booking);

        $validated = $request->validate([
            'payment_method' => ['required', 'in:jazzcash,easypaisa,card,cash'],
            'card_number' => ['nullable', 'string', 'max:30'],
            'card_expiry' => ['nullable', 'string', 'max:10'],
            'card_cvc' => ['nullable', 'string', 'max:10'],
            'account_number' => ['nullable', 'string', 'max:30'],
        ], [
            'payment_method.in' => 'Please select a valid payment method (JazzCash, EasyPaisa, Debit/Credit Card, or Cash on Delivery).',
        ]);

        $status = $validated['payment_method'] === 'cash' ? 'cash_on_delivery' : 'escrow_held';

        $booking->update([
            'payment_method' => $validated['payment_method'],
            'payment_status' => $status,
        ]);

        return $this->ok(new BookingResource($booking), 'Payment method saved! Rs. '.number_format($booking->total_price).' is secured in FixMate Escrow.');
    }

    private function authorizeOwnership(Request $request, Booking $booking): void
    {
        if ($booking->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized booking access.');
        }
    }
}
