<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactInquiry;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CustomerPortalController extends Controller
{
    /**
     * Customer Dashboard with live statistics, recommended technicians, and active bookings.
     */
    public function dashboard(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $activeBookingsCount = $user->bookings()
            ->whereIn('status', ['pending', 'confirmed', 'en_route', 'in_progress'])
            ->count();

        $upcomingBookingsCount = $user->bookings()
            ->where('service_date', '>=', now()->toDateString())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        $completedBookingsCount = $user->bookings()
            ->where('status', 'completed')
            ->count();

        $pendingRequestsCount = $user->bookings()
            ->where('status', 'pending')
            ->count();

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
            $recommendedTechnicians = Professional::with(['profession', 'user'])
                ->take(3)
                ->get();
        }

        $stats = [
            'active' => $activeBookingsCount,
            'upcoming' => $upcomingBookingsCount,
            'completed' => $completedBookingsCount,
            'pending' => $pendingRequestsCount,
        ];

        return view('Frontend.customer.dashboard', compact('user', 'stats', 'recentBookings', 'recommendedTechnicians'));
    }

    /**
     * AI Defect Diagnosis Scanner.
     */
    public function diagnose(Request $request): View
    {
        $professions = Profession::where('is_active', true)->get();
        $queryText = $request->input('q', '');

        return view('Frontend.customer.diagnose', compact('professions', 'queryText'));
    }

    /**
     * AI Analysis Diagnostic Result with dynamic cost estimation and recommendation.
     */
    public function aiResult(Request $request): View
    {
        $categorySlug = $request->input('category', 'electrical');
        $problemQuery = $request->input('issue', $request->input('q', ''));

        $profession = Profession::where('slug', $categorySlug)
            ->orWhere('name', 'like', "%{$categorySlug}%")
            ->first();

        if (! $profession) {
            $profession = Profession::where('is_active', true)->first();
        }

        $defectTypes = [
            'plumber' => ['title' => 'High-Pressure Pipe Leak & Gasket Wear', 'confidence' => '94% Confidence', 'tools' => 'Ultrasonic Leak Detector, Slip Joint Wrench, Teflon Seal'],
            'electrician' => ['title' => 'Burned Main Breaker & Neutral Overheat', 'confidence' => '97% Confidence', 'tools' => 'Digital Multimeter, Thermal Gun, Insulated Screwdrivers'],
            'ac-refrigeration' => ['title' => 'Indoor Evaporator Fin Mold & Gas Pressure Drop', 'confidence' => '95% Confidence', 'tools' => 'High-Pressure Jet Washer, R410a Gauge, Ammeter'],
            'deep-cleaning' => ['title' => 'Deep Residue & Grout Contamination', 'confidence' => '98% Confidence', 'tools' => 'Steam Extraction Extractor, Antibacterial Disinfectant'],
            'carpenter' => ['title' => 'Sagging Door Hinge & Mortise Misalignment', 'confidence' => '93% Confidence', 'tools' => 'Wood Planer, Hydraulic Chisel, Smart Lock Router'],
            'painter' => ['title' => 'Wall Dampness Seepage & Efflorescence', 'confidence' => '96% Confidence', 'tools' => 'Moisture Meter, Chemical Elastomeric Sealer, Wall Putty Scraper'],
            'home-appliances' => ['title' => 'Drain Pump Blockage & Motor Stalling', 'confidence' => '95% Confidence', 'tools' => 'Multimeter, Socket Wrench Set, Replacement Capacitor'],
        ];

        $matchedDefect = $defectTypes[$profession?->slug] ?? [
            'title' => 'Hardware Calibration & Defect Resolution',
            'confidence' => '95% Confidence',
            'tools' => 'Standard Diagnostic Multimeter, Specialized Trade Toolset',
        ];

        $baseRate = $profession?->base_price ?? 750;
        $costEstimate = [
            'min' => $baseRate + 450,
            'max' => $baseRate + 1200,
        ];

        return view('Frontend.customer.ai-result', compact('profession', 'matchedDefect', 'costEstimate', 'problemQuery'));
    }

    /**
     * Recommended Technicians directory inside customer portal.
     */
    public function technicians(Request $request): View
    {
        $professions = Profession::where('is_active', true)->get();

        $query = Professional::with(['profession', 'user']);

        if ($request->filled('profession')) {
            $query->where('profession_id', $request->input('profession'));
        }

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('experience', 'like', $term)
                  ->orWhereHas('profession', function ($pq) use ($term) {
                      $pq->where('name', 'like', $term);
                  });
            });
        }

        $technicians = $query->paginate(9)->withQueryString();

        return view('Frontend.customer.technicians', compact('technicians', 'professions'));
    }

    /**
     * Service Booking Form with dynamic pre-selection.
     */
    public function bookingForm(Request $request): View
    {
        $professions = Profession::where('is_active', true)->get();

        $selectedProfession = null;
        if ($request->filled('profession')) {
            $selectedProfession = Profession::where('slug', $request->input('profession'))->first();
        }

        $selectedTechnician = null;
        if ($request->filled('tech_id') || $request->filled('tech')) {
            $identifier = $request->input('tech_id') ?: $request->input('tech');
            $selectedTechnician = is_numeric($identifier)
                ? Professional::with('profession')->find($identifier)
                : Professional::with('profession')->where('name', 'like', '%' . str_replace('-', ' ', $identifier) . '%')->first();

            if ($selectedTechnician && ! $selectedProfession) {
                $selectedProfession = $selectedTechnician->profession;
            }
        }

        $user = auth()->user();

        return view('Frontend.customer.booking', compact('professions', 'selectedProfession', 'selectedTechnician', 'user'));
    }

    /**
     * Store a real booking in the database.
     */
    public function storeBooking(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profession_id' => ['required', 'exists:professions,id'],
            'professional_id' => ['nullable', 'exists:professionals,id'],
            'service_title' => ['nullable', 'string', 'max:150'],
            'service_date' => ['required', 'date', 'after_or_equal:today'],
            'service_time_slot' => ['required', 'string', 'max:100'],
            'service_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'problem_description' => ['nullable', 'string', 'max:1000'],
            'problem_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $profession = Profession::findOrFail($validated['profession_id']);

        $imagePath = null;
        if ($request->hasFile('problem_image')) {
            $file = $request->file('problem_image');
            $fileName = 'defect_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $fileName);
            $imagePath = 'assets/images/' . $fileName;
        }

        $bookingNumber = Booking::generateBookingNumber();
        $arrivalOtp = Booking::generateOtp();
        $basePrice = $profession->base_price ?? 650;

        $booking = Booking::create([
            'booking_number' => $bookingNumber,
            'user_id' => auth()->id(),
            'professional_id' => $validated['professional_id'] ?? null,
            'profession_id' => $profession->id,
            'service_title' => $validated['service_title'] ?: ($profession->name . ' Service & Maintenance'),
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

        return redirect()->route('customer.booking.confirm', $booking->id)
            ->with('success', "Booking #{$booking->booking_number} created successfully! Your arrival OTP is {$arrivalOtp}.");
    }

    /**
     * Booking confirmation page with Arrival OTP and details.
     */
    public function bookingConfirm(Booking $booking): View
    {
        $this->authorizeBookingOwnership($booking);

        $booking->load(['professional.user', 'profession']);

        return view('Frontend.customer.confirmation', compact('booking'));
    }

    /**
     * Customer all bookings list with status filters.
     */
    public function bookings(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();

        $query = $user->bookings()->with(['professional.user', 'profession']);

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->whereIn('status', ['pending', 'confirmed', 'en_route', 'in_progress']);
            } elseif ($status === 'completed') {
                $query->where('status', 'completed');
            } elseif ($status === 'cancelled') {
                $query->where('status', 'cancelled');
            }
        }

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('booking_number', 'like', $term)
                  ->orWhere('service_title', 'like', $term)
                  ->orWhere('service_address', 'like', $term);
            });
        }

        $bookings = $query->latest()->paginate(8)->withQueryString();

        return view('Frontend.customer.bookings', compact('bookings'));
    }

    /**
     * Live Tracking page for a specific or latest active booking.
     */
    public function tracking(Request $request, ?Booking $booking = null): View
    {
        /** @var User $user */
        $user = auth()->user();

        if (! $booking) {
            $booking = $user->bookings()
                ->with(['professional.user', 'profession'])
                ->whereIn('status', ['pending', 'confirmed', 'en_route', 'in_progress'])
                ->latest()
                ->first();

            if (! $booking) {
                $booking = $user->bookings()->with(['professional.user', 'profession'])->latest()->first();
            }
        } else {
            $this->authorizeBookingOwnership($booking);
            $booking->load(['professional.user', 'profession']);
        }

        return view('Frontend.customer.tracking', compact('booking'));
    }

    /**
     * Cancel an active booking.
     */
    public function cancelBooking(Request $request, Booking $booking): RedirectResponse
    {
        $this->authorizeBookingOwnership($booking);

        if ($booking->status === 'completed') {
            return back()->with('error', 'Completed bookings cannot be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->input('cancellation_reason', 'Cancelled by customer'),
        ]);

        return back()->with('success', "Booking #{$booking->booking_number} has been cancelled.");
    }

    /**
     * Customer reviews page: rate completed jobs.
     */
    public function reviews(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $completedBookings = $user->bookings()
            ->with(['professional', 'profession', 'review'])
            ->where('status', 'completed')
            ->latest()
            ->get();

        $myReviews = $user->reviews()->with(['booking', 'professional'])->latest()->get();

        return view('Frontend.customer.reviews', compact('completedBookings', 'myReviews'));
    }

    /**
     * Submit a rating and review for a completed booking.
     */
    public function storeReview(Request $request, Booking $booking): RedirectResponse
    {
        $this->authorizeBookingOwnership($booking);

        if ($booking->status !== 'completed') {
            return back()->with('error', 'Only completed jobs can be reviewed.');
        }

        if ($booking->review()->exists()) {
            return back()->with('error', 'You have already submitted a review for this booking.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'professional_id' => $booking->professional_id,
            'rating' => $validated['rating'],
            'comment' => trim($validated['comment']),
            'is_approved' => true,
        ]);

        return back()->with('success', 'Thank you! Your verified review has been submitted.');
    }

    /**
     * Customer Profile view.
     */
    public function profile(): View
    {
        $user = auth()->user();
        return view('Frontend.customer.profile', compact('user'));
    }

    /**
     * Update customer profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone,' . $user->id],
            'city' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Your profile has been updated successfully!');
    }

    /**
     * Customer Settings view.
     */
    public function settings(): View
    {
        $user = auth()->user();
        return view('Frontend.customer.settings', compact('user'));
    }

    /**
     * Update customer account password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Complaints & Dispute Center.
     */
    public function complaints(): View
    {
        $user = auth()->user();

        $complaints = ContactInquiry::where('email', $user->email)
            ->latest()
            ->paginate(10);

        return view('Frontend.customer.complaints', compact('complaints', 'user'));
    }

    /**
     * Submit a new customer complaint or arbitration ticket.
     */
    public function storeComplaint(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        do {
            $ref = 'FM-DIS-' . strtoupper(Str::random(6));
        } while (ContactInquiry::where('reference_no', $ref)->exists());

        ContactInquiry::create([
            'reference_no' => $ref,
            'department' => 'escrow',
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '+923000000000',
            'city' => $user->city ?? 'Karachi',
            'message' => '[' . $validated['subject'] . '] ' . $validated['message'],
            'status' => 'new',
        ]);

        return back()->with('success', 'Your complaint/inquiry ticket has been dispatched to FixMate arbitration supervisors.');
    }

    /**
     * Helper to verify booking ownership.
     */
    private function authorizeBookingOwnership(Booking $booking): void
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized booking access.');
        }
    }
}
