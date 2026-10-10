<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ProfessionResource;
use App\Models\Booking;
use App\Models\Profession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Booking::with(['user', 'profession', 'professional.user', 'professional.profession', 'review']);

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('city') && $request->input('city') !== 'all') {
            $query->where('city', 'like', '%'.$request->input('city').'%');
        }

        if ($request->filled('profession_id')) {
            $query->where('profession_id', $request->input('profession_id'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                    ->orWhere('service_title', 'like', "%{$search}%")
                    ->orWhere('service_address', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('professional', fn ($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $bookings = $query->latest()->paginate($perPage);

        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'active' => Booking::whereIn('status', ['confirmed', 'en_route', 'in_progress'])->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'escrow_held' => (int) Booking::where('payment_status', 'escrow_held')->sum('total_price'),
            'total_completed_amount' => (int) Booking::where('status', 'completed')->sum('total_price'),
        ];

        return $this->ok(BookingResource::collection($bookings->items()), 'Bookings retrieved.', array_merge([
            'current_page' => $bookings->currentPage(),
            'per_page' => $bookings->perPage(),
            'total' => $bookings->total(),
            'last_page' => $bookings->lastPage(),
            'from' => $bookings->firstItem(),
            'to' => $bookings->lastItem(),
        ], ['stats' => $stats, 'professions' => ProfessionResource::collection(Profession::where('is_active', true)->get())]));
    }

    public function show(Booking $booking): JsonResponse
    {
        $booking->load(['user', 'profession', 'professional.user', 'professional.profession', 'review']);

        return $this->ok(new BookingResource($booking), 'Booking retrieved.');
    }
}
