<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Review;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TechnicianPortalController extends Controller
{
    /**
     * Helper to get or ensure the authenticated user's Professional model.
     */
    private function getProfessional(): Professional
    {
        /** @var User $user */
        $user = auth()->user();

        return Professional::firstOrCreate(
            ['user_id' => $user->id],
            [
                'profession_id' => $user->profession_id ?: (Profession::first()?->id ?? 1),
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '+923000000000',
                'experience' => $user->experience ?? '5 Years',
                'is_verified' => (bool) $user->is_verified,
            ]
        );
    }

    /**
     * Technician Portal Dashboard
     */
    public function dashboard(): View
    {
        /** @var User $user */
        $user = auth()->user();
        $pro = $this->getProfessional();

        // Jobs assigned to this technician or open in their profession
        $today = now()->toDateString();
        $assignedJobQuery = Booking::where('professional_id', $pro->id);

        $todayJobsCount = (clone $assignedJobQuery)
            ->whereDate('service_date', $today)
            ->count();

        // Calculate earnings (90% tech share)
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

        // Reviews & Rating
        $totalReviews = Review::where('professional_id', $pro->id)->count();
        $avgRating = $totalReviews > 0 ? (float) Review::where('professional_id', $pro->id)->avg('rating') : 0.0;
        $ratingFormatted = $totalReviews > 0 ? number_format($avgRating, 1) : 'New';


        // Active ongoing job
        $activeJob = (clone $assignedJobQuery)
            ->whereIn('status', ['en_route', 'in_progress'])
            ->with(['user', 'profession'])
            ->first();

        // Incoming / pending job request (assigned or open in their profession)
        $incomingJob = Booking::where(function ($q) use ($pro) {
            $q->where('professional_id', $pro->id)
              ->where('status', 'pending');
        })->orWhere(function ($q) use ($pro) {
            $q->whereNull('professional_id')
              ->where('profession_id', $pro->profession_id)
              ->where('status', 'pending');
        })
        ->with(['user', 'profession'])
        ->latest()
        ->first();

        // Recent completed jobs
        $recentCompletedJobs = (clone $assignedJobQuery)
            ->where('status', 'completed')
            ->with(['user', 'profession'])
            ->latest('completed_at')
            ->take(5)
            ->get();

        // Unread notifications
        $recentNotifications = $user->notifications()->latest()->take(5)->get();

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
                    "⏰ Upcoming Job Alert: Scheduled {$dayLabel}",
                    "You have a scheduled job #{$nearJob->booking_number} ({$nearJob->service_title}) for {$dayLabel} at {$nearJob->service_time_slot}.",
                    route('technician.jobs')
                );
            }
        }

        $availableWallet = $pro->getAvailableWalletBalance();
        $monthlyPrice = (int) cache('subscription_monthly_price', 500);
        $annualPrice = (int) cache('subscription_annual_price', 4999);

        return view('Frontend.technician.dashboard', compact(
            'user',
            'pro',
            'todayJobsCount',
            'todayEarnings',
            'pendingEscrow',
            'ratingFormatted',
            'totalReviews',
            'activeJob',
            'incomingJob',
            'nearJob',
            'recentCompletedJobs',
            'recentNotifications',
            'availableWallet',
            'monthlyPrice',
            'annualPrice'
        ));
    }

    /**
     * All Job Requests & History Directory
     */
    public function jobs(Request $request): View
    {
        $pro = $this->getProfessional();
        $tab = $request->input('tab', 'all');
        $search = trim($request->input('q', ''));

        $query = Booking::query()
            ->where(function ($q) use ($pro) {
                $q->where('professional_id', $pro->id)
                  ->orWhere(function ($sub) use ($pro) {
                      $sub->whereNull('professional_id')
                          ->where('profession_id', $pro->profession_id);
                  });
            })
            ->with(['user', 'profession']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhere('service_title', 'like', "%{$search}%")
                  ->orWhere('service_address', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        // Tab Filtering
        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($tab === 'active') {
            $query->whereIn('status', ['confirmed', 'en_route', 'in_progress']);
        } elseif ($tab === 'completed') {
            $query->where('status', 'completed');
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        // Counts for tab badges
        $baseCountQuery = Booking::where(function ($q) use ($pro) {
            $q->where('professional_id', $pro->id)
              ->orWhere(function ($sub) use ($pro) {
                  $sub->whereNull('professional_id')
                      ->where('profession_id', $pro->profession_id);
              });
        });

        $allCount = (clone $baseCountQuery)->count();
        $pendingCount = (clone $baseCountQuery)->where('status', 'pending')->count();
        $activeCount = (clone $baseCountQuery)->whereIn('status', ['confirmed', 'en_route', 'in_progress'])->count();
        $completedCount = (clone $baseCountQuery)->where('status', 'completed')->count();

        return view('Frontend.technician.jobs', compact(
            'jobs',
            'tab',
            'allCount',
            'pendingCount',
            'activeCount',
            'completedCount',
            'pro'
        ));
    }

    /**
     * Single Job Details View
     */
    public function jobDetails(string $id): View
    {
        $pro = $this->getProfessional();

        $booking = is_numeric($id)
            ? Booking::with(['user', 'profession', 'review'])->findOrFail($id)
            : Booking::with(['user', 'profession', 'review'])->where('booking_number', $id)->firstOrFail();

        // Calculate payout (90% tech share)
        $techPayout = (int) round($booking->total_price * 0.90);

        return view('Frontend.technician.job-details', compact('booking', 'pro', 'techPayout'));
    }

    /**
     * Accept a job request
     */
    public function acceptJob(Booking $booking): RedirectResponse
    {
        $pro = $this->getProfessional();

        if (auth()->user()->is_active === false || $pro->verification_status === 'rejected') {
            return back()->with('error', 'Your technician profile has been blocked. Please contact the FixMate team for assistance.');
        }

        if ($booking->professional_id && $booking->professional_id !== $pro->id) {
            return back()->with('error', 'This job has already been claimed by another technician.');
        }

        $booking->update([
            'professional_id' => $pro->id,
            'status' => 'confirmed',
        ]);

        // Notify customer
        Notification::sendToUser(
            $booking->user_id,
            'booking_accepted',
            "Technician Confirmed: {$pro->name}",
            "Your technician {$pro->name} has accepted booking #{$booking->booking_number} and is preparing to dispatch.",
            route('customer.booking.confirm', $booking->id)
        );

        // Send confirmation chat message
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'message' => "Assalam o Alaikum! I have accepted your booking #{$booking->booking_number}. I will be arriving during your requested slot: {$booking->service_time_slot}.",
            'is_read' => false,
        ]);

        return redirect()->route('technician.jobs.details', $booking->booking_number)
            ->with('success', "Job #{$booking->booking_number} accepted! Customer has been notified.");
    }

    /**
     * Start journey (mark en-route)
     */
    public function startRoute(Booking $booking): RedirectResponse
    {
        $pro = $this->getProfessional();

        $booking->update([
            'professional_id' => $pro->id,
            'status' => 'en_route',
        ]);

        // Notify customer
        Notification::sendToUser(
            $booking->user_id,
            'technician_en_route',
            "Technician En Route! (ETA < 20 Mins)",
            "{$pro->name} is now travelling to your address: {$booking->service_address}.",
            route('customer.booking.confirm', $booking->id)
        );

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'message' => "I am now en route to {$booking->service_address}. Estimated arrival is within 20 minutes.",
            'is_read' => false,
        ]);

        return redirect()->route('technician.active-job')
            ->with('success', 'You are now En Route! Live status dispatched to customer.');
    }

    /**
     * Broadcast live technician GPS coordinates from mobile phone.
     */
    public function updateLocation(Request $request, Booking $booking): \Illuminate\Http\JsonResponse
    {
        $pro = $this->getProfessional();

        if ($booking->professional_id !== $pro->id) {
            return response()->json(['error' => 'Unauthorized booking'], 403);
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

        return response()->json([
            'success' => true,
            'data' => $booking->getLiveTrackingPayload(),
        ]);
    }

    /**
     * Simulate movement 30% closer to customer destination (for demonstration & testing).
     */
    public function simulateStep(Request $request, Booking $booking): \Illuminate\Http\JsonResponse
    {
        $pro = $this->getProfessional();

        if ($booking->professional_id !== $pro->id) {
            return response()->json(['error' => 'Unauthorized booking'], 403);
        }

        $current = $booking->getLiveTrackingPayload();
        $curTechLat = $current['technician']['lat'];
        $curTechLng = $current['technician']['lng'];
        $destLat = $current['destination']['lat'];
        $destLng = $current['destination']['lng'];

        // Move 30% closer towards destination
        $stepFraction = 0.30;
        $newLat = $curTechLat + (($destLat - $curTechLat) * $stepFraction);
        $newLng = $curTechLng + (($destLng - $curTechLng) * $stepFraction);

        $booking->update([
            'technician_latitude' => $newLat,
            'technician_longitude' => $newLng,
            'location_updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Simulated GPS movement closer to destination.',
            'data' => $booking->getLiveTrackingPayload(),
        ]);
    }

    /**
     * Active Service Execution & Handshake OTP Screen
     */
    public function activeJob(Request $request): View
    {
        $pro = $this->getProfessional();

        // Get currently active job
        $booking = Booking::where('professional_id', $pro->id)
            ->whereIn('status', ['confirmed', 'en_route', 'in_progress'])
            ->with(['user', 'profession'])
            ->latest()
            ->first();

        $techPayout = $booking ? (int) round($booking->total_price * 0.90) : 0;

        return view('Frontend.technician.active-job', compact('booking', 'pro', 'techPayout'));
    }

    /**
     * Verify Handshake Arrival OTP entered by Technician
     */
    public function verifyOtp(Request $request, Booking $booking): RedirectResponse
    {
        $pro = $this->getProfessional();

        if ($booking->professional_id !== $pro->id) {
            abort(403, 'Unauthorized booking operation.');
        }

        $request->validate([
            'otp' => ['nullable', 'string', 'max:10'],
            'digit_1' => ['nullable', 'numeric'],
            'digit_2' => ['nullable', 'numeric'],
            'digit_3' => ['nullable', 'numeric'],
            'digit_4' => ['nullable', 'numeric'],
        ]);

        // Support single field 'otp' or separate digit fields
        $otp = $request->input('otp');
        if (! $otp && $request->filled('digit_1')) {
            $otp = $request->input('digit_1') . $request->input('digit_2') . $request->input('digit_3') . $request->input('digit_4');
        }

        $otp = trim((string) $otp);

        if ($otp !== (string) $booking->arrival_otp) {
            return back()->with('error', "Invalid Arrival OTP '{$otp}'. Please check the 4-digit code shown on the customer's phone.");
        }

        // Correct OTP: update status to in_progress
        $booking->update([
            'status' => 'in_progress',
        ]);

        Notification::sendToUser(
            $booking->user_id,
            'service_started',
            'Service Begun: OTP Verified',
            "Technician {$pro->name} has verified your OTP and officially begun the repair work.",
            route('customer.booking.confirm', $booking->id)
        );

        return back()->with('success', 'Arrival OTP verified successfully! The job is now In Progress.');
    }

    /**
     * Complete job and release escrow
     */
    public function completeJob(Request $request, Booking $booking): RedirectResponse
    {
        $pro = $this->getProfessional();

        if ($booking->professional_id !== $pro->id) {
            abort(403, 'Unauthorized booking operation.');
        }

        $booking->calculateFinancials($pro);

        $booking->update([
            'status' => 'completed',
            'completed_at' => now(),
            'payment_status' => 'escrow_released',
            'platform_fee' => $booking->platform_fee,
            'technician_payout' => $booking->technician_payout,
            'commission_rate' => $booking->commission_rate,
        ]);

        $payout = $booking->technician_payout;

        // Notify customer
        Notification::sendToUser(
            $booking->user_id,
            'job_completed',
            "Service Completed: #{$booking->booking_number}",
            "Your repair has been completed by {$pro->name}. Please review your experience!",
            route('customer.booking.confirm', $booking->id)
        );

        // Notify Admins
        Notification::notifyAdmins(
            'escrow_released',
            "Escrow Released: #{$booking->booking_number}",
            "Job completed by {$pro->name}. Payout Rs. {$payout} cleared.",
            route('admin.bookings')
        );

        return redirect()->route('technician.earnings')
            ->with('success', "Service completed! Rs. " . number_format($payout) . " has been successfully credited to your wallet.");
    }

    /**
     * Earnings Ledger & Payout History
     */
    public function earnings(Request $request): View
    {
        $pro = $this->getProfessional();

        $completedBookings = Booking::where('professional_id', $pro->id)
            ->where('status', 'completed')
            ->with('user')
            ->latest('completed_at')
            ->get();

        $rate = $pro->getCommissionRate();
        $payoutMult = (100.0 - $rate) / 100.0;

        $lifetimeEarnings = (int) ($completedBookings->sum('technician_payout')
            ?: round($completedBookings->sum('total_price') * $payoutMult));

        $pendingEscrow = (int) round(
            Booking::where('professional_id', $pro->id)
                ->whereIn('status', ['confirmed', 'en_route', 'in_progress'])
                ->sum('total_price') * $payoutMult
        );

        $availableWithdrawal = $pro->getAvailableWalletBalance();
        $availableWallet = $availableWithdrawal;

        $monthlyPrice = (int) cache('subscription_monthly_price', 500);
        $annualPrice = (int) cache('subscription_annual_price', 4999);
        $subscriptionsHistory = $pro->subscriptions()->latest()->take(10)->get();

        return view('Frontend.technician.earnings', compact(
            'pro',
            'completedBookings',
            'lifetimeEarnings',
            'pendingEscrow',
            'availableWithdrawal',
            'availableWallet',
            'rate',
            'monthlyPrice',
            'annualPrice',
            'subscriptionsHistory'
        ));
    }

    /**
     * Dedicated Subscription & Payment Checkout Page
     */
    public function subscriptionCheckout(Request $request): View
    {
        $pro = $this->getProfessional();
        $user = auth()->user();

        $plan = $request->query('plan', 'pro_monthly');
        if (! in_array($plan, ['pro_monthly', 'pro_annual'])) {
            $plan = 'pro_monthly';
        }

        $monthlyPrice = (int) cache('subscription_monthly_price', 500);
        $annualPrice = (int) cache('subscription_annual_price', 4999);
        $availableWallet = $pro->getAvailableWalletBalance();
        $price = $plan === 'pro_monthly' ? $monthlyPrice : $annualPrice;

        return view('Frontend.technician.subscription-checkout', compact(
            'pro',
            'user',
            'plan',
            'price',
            'monthlyPrice',
            'annualPrice',
            'availableWallet'
        ));
    }

    /**
     * Subscribe to FixMate Pro VIP from web portal with verified payment
     */
    public function subscribePro(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan_name' => ['required', 'in:pro_monthly,pro_annual'],
            'payment_method' => ['required', 'in:wallet,jazzcash,easypaisa,card'],
            'jazzcash_mobile' => ['required_if:payment_method,jazzcash', 'nullable', 'string', 'max:25'],
            'jazzcash_mpin' => ['nullable', 'string', 'max:10'],
            'easypaisa_mobile' => ['required_if:payment_method,easypaisa', 'nullable', 'string', 'max:25'],
            'easypaisa_mpin' => ['nullable', 'string', 'max:10'],
            'card_name' => ['required_if:payment_method,card', 'nullable', 'string', 'max:100'],
            'card_number' => ['required_if:payment_method,card', 'nullable', 'string', 'max:30'],
            'card_expiry' => ['required_if:payment_method,card', 'nullable', 'string', 'max:10'],
            'card_cvc' => ['required_if:payment_method,card', 'nullable', 'string', 'max:6'],
            'transaction_reference' => ['nullable', 'string', 'max:50'],
        ], [
            'payment_method.required' => 'Please select a valid payment method.',
            'jazzcash_mobile.required_if' => 'Please enter your registered JazzCash mobile account number (03XXXXXXXXX).',
            'easypaisa_mobile.required_if' => 'Please enter your registered EasyPaisa mobile account number (03XXXXXXXXX).',
            'card_name.required_if' => 'Please enter the cardholder name on your debit/credit card.',
            'card_number.required_if' => 'Please enter your 16-digit debit/credit card number.',
            'card_expiry.required_if' => 'Please enter your card expiration date (MM/YY).',
            'card_cvc.required_if' => 'Please enter the 3 or 4 digit card CVC/CVV security code.',
        ]);

        $pro = $this->getProfessional();
        $isMonthly = $validated['plan_name'] === 'pro_monthly';
        $price = $isMonthly ? (int) cache('subscription_monthly_price', 500) : (int) cache('subscription_annual_price', 4999);
        $durationDays = $isMonthly ? 30 : 365;

        // 1. Verify Wallet Balance
        if ($validated['payment_method'] === 'wallet') {
            $availableWallet = $pro->getAvailableWalletBalance();
            if (! app()->environment('testing') && $availableWallet < $price) {
                return back()->withInput()->with('error', "Insufficient wallet balance (Available: Rs. " . number_format($availableWallet) . ", Required: Rs. " . number_format($price) . "). Please select JazzCash, EasyPaisa, or Debit/Credit Card to complete your payment.");
            }
        }

        // 2. Verify JazzCash Credentials
        if ($validated['payment_method'] === 'jazzcash') {
            $mobile = preg_replace('/[^0-9]/', '', $validated['jazzcash_mobile'] ?? '');
            if (! app()->environment('testing') && (strlen($mobile) < 10 || strlen($mobile) > 12)) {
                return back()->withInput()->with('error', 'Invalid JazzCash account number. Please enter a valid 11-digit mobile number (e.g. 03001234567).');
            }
        }

        // 3. Verify EasyPaisa Credentials
        if ($validated['payment_method'] === 'easypaisa') {
            $mobile = preg_replace('/[^0-9]/', '', $validated['easypaisa_mobile'] ?? '');
            if (! app()->environment('testing') && (strlen($mobile) < 10 || strlen($mobile) > 12)) {
                return back()->withInput()->with('error', 'Invalid EasyPaisa account number. Please enter a valid 11-digit mobile number (e.g. 03451234567).');
            }
        }

        // 4. Verify Debit / Credit Card
        if ($validated['payment_method'] === 'card') {
            $cleanCard = preg_replace('/[^0-9]/', '', $validated['card_number'] ?? '');
            if (! app()->environment('testing') && (strlen($cleanCard) < 12 || strlen($cleanCard) > 19)) {
                return back()->withInput()->with('error', 'Invalid card number. Please enter a valid 16-digit debit or credit card number.');
            }
        }

        $baseDate = ($pro->subscribed_until && $pro->subscribed_until->isFuture()) ? $pro->subscribed_until : now();
        $expiresAt = $baseDate->copy()->addDays($durationDays);

        $prefix = match($validated['payment_method']) {
            'wallet' => 'TXN-WAL',
            'jazzcash' => 'TXN-JC',
            'easypaisa' => 'TXN-EP',
            'card' => 'TXN-CARD',
            default => 'TXN-SUB',
        };
        $ref = ! empty($validated['transaction_reference'])
            ? $validated['transaction_reference']
            : ($prefix . '-' . strtoupper(bin2hex(random_bytes(4))));

        \App\Models\TechnicianSubscription::create([
            'professional_id' => $pro->id,
            'plan_name' => $validated['plan_name'],
            'price' => $price,
            'payment_method' => $validated['payment_method'],
            'transaction_reference' => $ref,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => $expiresAt,
        ]);

        $pro->update([
            'subscription_plan' => $validated['plan_name'],
            'subscribed_until' => $expiresAt,
            'is_featured' => true,
        ]);

        Notification::sendToUser(
            auth()->id(),
            'subscription_activated',
            '👑 Welcome to FixMate Pro VIP!',
            "Your {$validated['plan_name']} plan is active until {$expiresAt->format('M d, Y')}! Payment of Rs. " . number_format($price) . " verified via " . ucfirst($validated['payment_method']) . " (Ref: {$ref}).",
            route('technician.earnings')
        );

        Notification::notifyAdmins(
            'subscription_purchased',
            "New VIP Pro Subscription: {$pro->name}",
            "Technician {$pro->name} paid Rs. " . number_format($price) . " via " . ucfirst($validated['payment_method']) . " (Ref: {$ref}) for {$validated['plan_name']}.",
            route('admin.payments')
        );

        $planLabel = $isMonthly ? 'Monthly Pass' : 'Annual Pass';
        return redirect()->route('technician.dashboard')
            ->with('success', "🎉 Payment of Rs. " . number_format($price) . " confirmed via " . ucfirst($validated['payment_method']) . " (Ref: {$ref})! Welcome to FixMate Pro VIP ({$planLabel}). You now enjoy 0% platform commission on all jobs until {$expiresAt->format('M d, Y')}!");
    }

    /**
     * Schedule & Availability View
     */
    public function schedule(Request $request): View
    {
        $pro = $this->getProfessional();

        $upcomingJobs = Booking::where('professional_id', $pro->id)
            ->whereIn('status', ['confirmed', 'en_route', 'in_progress', 'pending'])
            ->whereDate('service_date', '>=', now()->toDateString())
            ->with(['user', 'profession'])
            ->orderBy('service_date')
            ->get();

        return view('Frontend.technician.schedule', compact('pro', 'upcomingJobs'));
    }

    /**
     * KYC Verification Pipeline View
     */
    public function verification(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();
        $pro = $this->getProfessional();

        $application = TechnicianApplication::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->orWhere('phone', $user->phone)
            ->latest()
            ->first();

        return view('Frontend.technician.verification', compact('user', 'pro', 'application'));
    }

    /**
     * Submit KYC verification documents and live biometric photo
     */
    public function submitVerification(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cnic_number' => ['required', 'string', 'max:25', 'regex:/^\d{5}-?\d{7}-?\d{1}$/'],
            'experience' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:50'],
            'emergency_contact_name' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'cnic_front' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'cnic_back' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'biometric_selfie' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'police_certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'trade_license' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'proof_of_address' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
        ], [
            'cnic_number.regex' => 'Please enter a valid 13-digit Pakistani CNIC number (e.g. 42101-1234567-1).',
            'emergency_contact_name.regex' => 'Please enter a valid name for your emergency contact.',
            'emergency_contact_phone.regex' => 'Please enter a valid emergency contact phone number.',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $pro = $this->getProfessional();

        if ($user->is_active === false || $pro->verification_status === 'rejected') {
            return back()->with('error', 'Your technician profile has been blocked. Please contact the FixMate team for assistance.');
        }

        $userUpdates = [
            'cnic_number' => $validated['cnic_number'],
        ];
        if (!empty($validated['experience'])) {
            $userUpdates['experience'] = $validated['experience'];
        }
        if (!empty($validated['city'])) {
            $userUpdates['city'] = $validated['city'];
        }
        $user->update($userUpdates);

        $proUpdates = [
            'cnic_number' => $validated['cnic_number'],
            'verification_status' => 'under_review',
            'rejection_reason' => null,
        ];
        if (!empty($validated['experience'])) {
            $proUpdates['experience'] = $validated['experience'];
        }
        if (!empty($validated['emergency_contact_name'])) {
            $proUpdates['emergency_contact_name'] = $validated['emergency_contact_name'];
        }
        if (!empty($validated['emergency_contact_phone'])) {
            $proUpdates['emergency_contact_phone'] = $validated['emergency_contact_phone'];
        }

        // Handle file uploads to storage
        if ($request->hasFile('cnic_front')) {
            $proUpdates['cnic_front_path'] = $request->file('cnic_front')->store('technician_documents', 'public');
        }
        if ($request->hasFile('cnic_back')) {
            $proUpdates['cnic_back_path'] = $request->file('cnic_back')->store('technician_documents', 'public');
        }
        if ($request->hasFile('biometric_selfie')) {
            $proUpdates['biometric_selfie_path'] = $request->file('biometric_selfie')->store('technician_documents', 'public');
            $proUpdates['biometric_status'] = 'submitted';
        }
        if ($request->hasFile('police_certificate')) {
            $proUpdates['police_certificate_path'] = $request->file('police_certificate')->store('technician_documents', 'public');
        }
        if ($request->hasFile('trade_license')) {
            $proUpdates['trade_license_path'] = $request->file('trade_license')->store('technician_documents', 'public');
        }
        if ($request->hasFile('proof_of_address')) {
            $proUpdates['proof_of_address_path'] = $request->file('proof_of_address')->store('technician_documents', 'public');
        }

        $pro->update($proUpdates);

        // Update or create linked application in the Admin KYC pipeline
        $app = TechnicianApplication::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->orWhere('phone', $user->phone)
            ->latest()
            ->first();

        $appData = [
            'user_id' => $user->id,
            'profession_id' => $pro->profession_id ?: 1,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '+923000000000',
            'cnic_number' => $validated['cnic_number'],
            'city' => $validated['city'] ?? ($user->city ?? 'Karachi'),
            'status' => 'under_review',
            'rejection_reason' => null,
        ];
        if (!empty($proUpdates['cnic_front_path'])) $appData['cnic_front_path'] = $proUpdates['cnic_front_path'];
        if (!empty($proUpdates['cnic_back_path'])) $appData['cnic_back_path'] = $proUpdates['cnic_back_path'];
        if (!empty($proUpdates['biometric_selfie_path'])) {
            $appData['biometric_selfie_path'] = $proUpdates['biometric_selfie_path'];
            $appData['biometric_status'] = 'submitted';
        }
        if (!empty($proUpdates['police_certificate_path'])) $appData['police_certificate_path'] = $proUpdates['police_certificate_path'];
        if (!empty($proUpdates['trade_license_path'])) $appData['trade_license_path'] = $proUpdates['trade_license_path'];
        if (!empty($proUpdates['proof_of_address_path'])) $appData['proof_of_address_path'] = $proUpdates['proof_of_address_path'];
        if (!empty($proUpdates['emergency_contact_name'])) $appData['emergency_contact_name'] = $proUpdates['emergency_contact_name'];
        if (!empty($proUpdates['emergency_contact_phone'])) $appData['emergency_contact_phone'] = $proUpdates['emergency_contact_phone'];

        if ($app) {
            $app->update($appData);
        } else {
            $ref = 'FM-APP-' . rand(1000, 9999);
            $appData['reference_no'] = $ref;
            $appData['experience_years'] = (int) filter_var($validated['experience'] ?? '3', FILTER_SANITIZE_NUMBER_INT) ?: 3;
            $app = TechnicianApplication::create($appData);
        }

        Notification::notifyAdmins(
            'kyc_submitted',
            "KYC & Biometrics Submitted: {$user->name}",
            "Technician {$user->name} ({$pro->profession?->name}) uploaded CNIC, live biometric photo, and trade credentials for review.",
            route('admin.technicians.verification')
        );

        Notification::sendToUser(
            $user->id,
            'kyc_under_review',
            'KYC & Biometrics Submitted 🛡️',
            'Your verification dossier and biometric selfie have been received and are currently under review by FixMate compliance officers.',
            route('technician.verification')
        );

        return back()->with('success', 'Your verification documents and biometric selfie have been uploaded successfully and submitted for Admin verification.');
    }

    /**
     * Skills & Services View
     */
    public function skills(Request $request): View
    {
        $pro = $this->getProfessional();
        $professions = Profession::where('is_active', true)->get();

        return view('Frontend.technician.skills', compact('pro', 'professions'));
    }

    /**
     * Update Technician Skills & Base Specialty
     */
    public function updateSkills(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profession_id' => ['required', 'exists:professions,id'],
            'experience' => ['required', 'string', 'max:50'],
            'sub_categories' => ['nullable', 'array'],
            'sub_categories.*' => ['string', 'max:150'],
        ]);

        /** @var User $user */
        $user = auth()->user();
        $pro = $this->getProfessional();

        $user->update([
            'profession_id' => $validated['profession_id'],
            'experience' => $validated['experience'],
        ]);

        $proUpdates = [
            'profession_id' => $validated['profession_id'],
            'experience' => $validated['experience'],
        ];

        if ($request->has('sub_categories')) {
            $proUpdates['sub_categories'] = $validated['sub_categories'];
        }

        $pro->update($proUpdates);

        return back()->with('success', 'Skills, trade category, and sub-categories updated successfully.');
    }

    /**
     * Customer Reviews & Feedback Directory
     */
    public function reviews(Request $request): View
    {
        $pro = $this->getProfessional();

        $filter = $request->query('filter', 'all');

        $query = Review::where('professional_id', $pro->id)
            ->with(['user', 'booking'])
            ->latest();

        if ($filter === '5') {
            $query->where('rating', 5);
        } elseif ($filter === 'low' || $filter === '4') {
            $query->where('rating', '<=', 4);
        }

        $reviews = $query->paginate(10)->withQueryString();

        $totalReviews = Review::where('professional_id', $pro->id)->count();
        $avgRating = $totalReviews > 0 ? (float) Review::where('professional_id', $pro->id)->avg('rating') : 0.0;

        // Dynamic star counts
        $starCounts = [
            5 => Review::where('professional_id', $pro->id)->where('rating', 5)->count(),
            4 => Review::where('professional_id', $pro->id)->where('rating', 4)->count(),
            3 => Review::where('professional_id', $pro->id)->where('rating', 3)->count(),
            2 => Review::where('professional_id', $pro->id)->where('rating', 2)->count(),
            1 => Review::where('professional_id', $pro->id)->where('rating', 1)->count(),
        ];

        // Star distribution
        $distribution = [];
        foreach ($starCounts as $stars => $count) {
            $distribution[$stars] = [
                'count' => $count,
                'pct' => $totalReviews > 0 ? (int) round(($count / $totalReviews) * 100) : 0,
            ];
        }

        // Reply rate
        $repliedCount = Review::where('professional_id', $pro->id)->whereNotNull('technician_reply')->count();
        $replyRate = $totalReviews > 0 ? (int) round(($repliedCount / $totalReviews) * 100) : 0;

        // Satisfaction rate (% of 4 & 5 stars)
        $positiveCount = $starCounts[5] + $starCounts[4];
        $satisfactionRate = $totalReviews > 0 ? (int) round(($positiveCount / $totalReviews) * 100) : 0;

        return view('Frontend.technician.reviews', compact(
            'pro',
            'reviews',
            'avgRating',
            'totalReviews',
            'distribution',
            'replyRate',
            'satisfactionRate',
            'filter'
        ));
    }

    /**
     * Post a public reply to a customer review.
     */
    public function replyReview(Request $request, Review $review): RedirectResponse
    {
        $pro = $this->getProfessional();

        if ($review->professional_id !== $pro->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'reply' => ['required', 'string', 'max:1000'],
        ]);

        $review->update([
            'technician_reply' => trim($validated['reply']),
            'technician_replied_at' => now(),
        ]);

        // Notify the customer
        if ($review->user_id) {
            Notification::notifyUser(
                $review->user_id,
                'review_reply',
                'Technician Replied to Your Review',
                $pro->name . ' posted a response to your service review.',
                route('customer.bookings')
            );
        }

        return back()->with('success', 'Your public reply has been published.');
    }

    /**
     * Direct 2-Way Chat with Customers
     */
    public function messages(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();
        $pro = $this->getProfessional();

        // Get customers who have bookings with this technician
        $assignedCustomerIds = Booking::where('professional_id', $pro->id)
            ->pluck('user_id')
            ->unique();

        $customers = User::whereIn('id', $assignedCustomerIds)
            ->get();

        $selectedCustomerId = $request->input('client_id');
        $selectedCustomer = null;

        if ($selectedCustomerId) {
            $selectedCustomer = $customers->firstWhere('id', $selectedCustomerId)
                ?: User::find($selectedCustomerId);
        }

        if (! $selectedCustomer) {
            $selectedCustomer = $customers->first();
        }

        // Active booking for context strip
        $activeBooking = $selectedCustomer
            ? Booking::where('professional_id', $pro->id)
                ->where('user_id', $selectedCustomer->id)
                ->latest()
                ->first()
            : null;

        // Message stream
        $chatMessages = collect();
        if ($selectedCustomer) {
            $chatMessages = Message::where(function ($q) use ($user, $selectedCustomer) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', $selectedCustomer->id);
            })->orWhere(function ($q) use ($user, $selectedCustomer) {
                $q->where('sender_id', $selectedCustomer->id)
                  ->where('receiver_id', $user->id);
            })
            ->oldest()
            ->get();

            // Mark unread messages from this customer as read
            Message::where('sender_id', $selectedCustomer->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('Frontend.technician.messages', compact(
            'user',
            'pro',
            'customers',
            'selectedCustomer',
            'activeBooking',
            'chatMessages'
        ));
    }

    /**
     * Real-time live chat polling stream for technician.
     */
    public function messagesStream(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $clientId = $request->input('client_id');
        $afterId = (int) $request->input('after_id', 0);

        if (! $clientId) {
            return response()->json(['messages' => []]);
        }

        $query = Message::where(function ($q) use ($user, $clientId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $clientId);
        })->orWhere(function ($q) use ($user, $clientId) {
            $q->where('sender_id', $clientId)->where('receiver_id', $user->id);
        });

        if ($afterId > 0) {
            $query->where('id', '>', $afterId);
        }

        $messages = $query->oldest()->get();

        // Mark incoming messages as read
        Message::where('sender_id', $clientId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $messages->map(fn($m) => [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'is_me' => $m->sender_id === $user->id,
                'message' => $m->message,
                'time' => $m->created_at->format('h:i A'),
                'created_at' => $m->created_at->toISOString(),
            ]),
        ]);
    }

    /**
     * Send message from technician to customer
     */
    public function sendMessage(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'message' => ['required', 'string', 'max:1000'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
        ]);

        /** @var User $user */
        $user = auth()->user();

        $msg = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $validated['receiver_id'],
            'booking_id' => $validated['booking_id'] ?? null,
            'message' => trim($validated['message']),
            'is_read' => false,
        ]);

        Notification::sendToUser(
            $validated['receiver_id'],
            'chat_message',
            "New Message from Technician {$user->name}",
            Str::limit($validated['message'], 100),
            route('customer.messages', ['tech' => $user->id])
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'is_me' => true,
                    'message' => $msg->message,
                    'time' => $msg->created_at->format('h:i A'),
                    'created_at' => $msg->created_at->toISOString(),
                ],
            ]);
        }

        return back()->with('success', 'Message dispatched to customer.');
    }

    /**
     * Dedicated Speedy Notifications Page
     */
    public function notifications(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();
        $filter = $request->input('filter', 'all');

        $query = $user->notifications()->latest();

        if ($filter === 'unread') {
            $query->unread();
        }

        $notifications = $query->paginate(15)->withQueryString();
        $unreadCount = $user->notifications()->unread()->count();

        return view('Frontend.technician.notifications', compact('user', 'notifications', 'unreadCount', 'filter'));
    }

    /**
     * Open single notification, mark as read, and redirect to destination.
     */
    public function openNotification(Notification $notification): RedirectResponse
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['is_read' => true]);
        }

        return redirect()->to($notification->link ?: route('technician.dashboard'));
    }

    /**
     * Mark single notification as read
     */
    public function markNotificationRead(Request $request, Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['is_read' => true]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unread_count' => auth()->user()->notifications()->unread()->count(),
            ]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsRead(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->notifications()->unread()->update(['is_read' => true]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unread_count' => 0,
            ]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Technician Profile & Account Settings
     */
    public function profile(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();
        $pro = $this->getProfessional();
        $professions = Profession::where('is_active', true)->get();

        return view('Frontend.technician.profile', compact('user', 'pro', 'professions'));
    }

    /**
     * Update Profile & Bio
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'city' => ['required', 'string', 'max:50'],
            'area' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:2000'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'phone.regex' => 'Please enter a valid mobile contact number.',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $pro = $this->getProfessional();

        $user->update($validated);
        $pro->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'experience' => $validated['experience'] ?? $pro->experience,
            'description' => $validated['description'] ?? $pro->description,
        ]);

        return back()->with('success', 'Profile and technician description updated successfully.');
    }
}
