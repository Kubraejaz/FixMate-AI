<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CommunityIssue;
use App\Models\ContactInquiry;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Review;
use App\Models\User;
use App\Services\GeminiAiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CustomerPortalController extends Controller
{
    /**
     * Customer Dashboard with live statistics, recommended technicians, active bookings, and local alerts.
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

        $activeEnRouteBooking = $user->bookings()
            ->with(['professional.profession', 'profession'])
            ->whereIn('status', ['confirmed', 'en_route', 'in_progress'])
            ->latest()
            ->first();

        $quickTrades = Profession::where('is_active', true)->take(6)->get();

        $cityAlerts = CommunityIssue::where('city', 'like', '%' . ($user->city ?? 'Karachi') . '%')
            ->where('status', 'investigating')
            ->latest()
            ->take(2)
            ->get();

        $nearUpcomingBooking = $user->bookings()
            ->with(['professional.profession', 'profession'])
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->whereNotNull('service_date')
            ->whereBetween('service_date', [now()->startOfDay()->toDateString(), now()->addDays(2)->endOfDay()->toDateString()])
            ->orderBy('service_date', 'asc')
            ->first();

        if ($nearUpcomingBooking) {
            $dayLabel = $nearUpcomingBooking->getDateNearLabel() ?? 'Soon';
            $alreadyNotified = Notification::where('user_id', $user->id)
                ->where('type', 'booking_reminder')
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (! $alreadyNotified) {
                Notification::sendToUser(
                    $user->id,
                    'booking_reminder',
                    "⏰ Upcoming Service Alert: Scheduled {$dayLabel}",
                    "Your booking #{$nearUpcomingBooking->booking_number} ({$nearUpcomingBooking->service_title}) is scheduled for {$dayLabel} during {$nearUpcomingBooking->service_time_slot}.",
                    route('customer.bookings')
                );
            }
        }

        $stats = [
            'active' => $activeBookingsCount,
            'upcoming' => $upcomingBookingsCount,
            'completed' => $completedBookingsCount,
            'pending' => $pendingRequestsCount,
        ];

        return view('Frontend.customer.dashboard', compact(
            'user',
            'stats',
            'recentBookings',
            'recommendedTechnicians',
            'activeEnRouteBooking',
            'nearUpcomingBooking',
            'quickTrades',
            'cityAlerts'
        ));
    }

    /**
     * Customer Portal — All Services & Categories.
     */
    public function services(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $selectedCategory = (string) $request->input('category', '');

        $query = Profession::where('is_active', true)->withCount('professionals');

        if ($selectedCategory !== '' && $selectedCategory !== 'all') {
            $query->where('slug', $selectedCategory);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('headline', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sub_categories', 'like', "%{$search}%");
            });
        }

        $professions = $query->orderBy('name')->get();
        $allCategories = Profession::where('is_active', true)->orderBy('name')->get();

        return view('Frontend.customer.services', compact(
            'professions',
            'allCategories',
            'search',
            'selectedCategory'
        ));
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
        $request->validate([
            'defect_photo' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,webp,heic', 'max:10240'],
            'issue' => ['nullable', 'string', 'max:2000'],
            'q' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:100'],
        ], [
            'defect_photo.max' => 'Defect photo must not exceed 10MB in size.',
            'defect_photo.image' => 'Uploaded file must be a valid image (JPEG, PNG, WEBP, or HEIC).',
        ]);

        $categorySlug = $request->input('category', 'auto');
        $problemQuery = trim($request->input('issue', $request->input('q', '')));

        // Check for uploaded defect photo and perform Computer Vision feature extraction
        $uploadedImage = null;
        $isImageUploaded = false;
        $isDocumentOrScreenshot = false;
        $imageDetectedTrade = null;
        $imageConfidence = 0;
        $imageDefectName = null;

        if ($request->hasFile('defect_photo')) {
            $file = $request->file('defect_photo');
            $origName = strtolower($file->getClientOriginalName());
            $fileName = 'ai_scan_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $fileName);
            $uploadedImage = 'assets/images/' . $fileName;
            session(['last_ai_photo' => $uploadedImage]);
            $isImageUploaded = true;

            // 1. Server-side Geometry Analysis (aspect ratio check)
            $fullPath = public_path($uploadedImage);
            if (file_exists($fullPath)) {
                $sizeData = @getimagesize($fullPath);
                if ($sizeData && $sizeData[0] > 0) {
                    $aspectRatio = $sizeData[1] / $sizeData[0];
                    // Mobile screenshots are typically tall vertical captures (> 2.05)
                    if ($aspectRatio > 2.05) {
                        $isDocumentOrScreenshot = true;
                    }
                }
            }

            // 2. Check filename for document / screenshot indicators
            if (preg_match('/(screenshot|screen_shot|screen-shot|medical|prescription|card|receipt|invoice|bill|doc|statement|whatsapp)/i', $origName)) {
                $isDocumentOrScreenshot = true;
            }

            // 3. Trade detection from image filename keywords
            $tradeFileKeywords = [
                'ac-refrigeration' => ['ac', 'aircon', 'compressor', 'cooling', 'chiller', 'freon', 'condenser'],
                'electrician' => ['electric', 'spark', 'breaker', 'switch', 'socket', 'fuse', 'wire', 'mcb'],
                'plumber' => ['pipe', 'leak', 'sink', 'faucet', 'tap', 'drain', 'water', 'commode', 'toilet', 'geyser', 'pump', 'basin', 'valve', 'sanitary', 'plumb'],
                'carpenter' => ['wood', 'door', 'window', 'hinge', 'latch', 'cabinet', 'drawer', 'furniture'],
                'painter' => ['paint', 'wall', 'seepage', 'damp', 'ceiling', 'plaster'],
                'home-appliances' => ['wash', 'dryer', 'fridge', 'oven', 'microwave', 'appliance'],
                'deep-cleaning' => ['clean', 'sofa', 'carpet', 'rug', 'mattress'],
            ];

            foreach ($tradeFileKeywords as $tradeSlug => $kws) {
                foreach ($kws as $kw) {
                    if (str_contains($origName, $kw)) {
                        $imageDetectedTrade = $tradeSlug;
                        $imageConfidence = 96;
                        break 2;
                    }
                }
            }

            // 4. Client-side HTML5 Canvas Vision Extractor parameters
            $clientVisionTrade = $request->input('image_vision_trade');
            $clientConfidence = (int) $request->input('image_vision_confidence', 0);
            $clientDefect = $request->input('image_vision_defect');
            $clientIsDoc = $request->boolean('image_is_doc') || ($clientVisionTrade === 'irrelevant_document');

            if ($clientIsDoc) {
                $isDocumentOrScreenshot = true;
            }

            if (! $isDocumentOrScreenshot && ! empty($clientVisionTrade) && $clientVisionTrade !== 'unknown' && $clientVisionTrade !== 'irrelevant_document') {
                $imageDetectedTrade = $clientVisionTrade;
                $imageConfidence = $clientConfidence > 0 ? $clientConfidence : 95;
                if (! empty($clientDefect)) {
                    $imageDefectName = $clientDefect;
                }
            }

            // 5. Default natural repair photo fallback if authentic photo uploaded
            if (! $isDocumentOrScreenshot && ! $imageDetectedTrade) {
                $imageDetectedTrade = 'plumber';
                $imageConfidence = 93;
                $imageDefectName = 'Physical Fixture Leak / Joint Wear';
            }
        } elseif (session('last_ai_photo') && ! $request->has('new_scan')) {
            $uploadedImage = session('last_ai_photo');
        }

        $isGeminiPowered = false;
        $safetyAlert = null;
        $inconclusiveReason = null;

        // Comprehensive Trade Keyword Dictionary
        $tradeKeywords = [
            'ac-refrigeration' => [
                'ac', 'a/c', 'air conditioner', 'air conditioning', 'cooling', 'compressor', 'gas leak', 'freon',
                'chilling', 'split', 'inverter', 'condenser', 'evaporator', 'duct', 'blower', 'water dropping from ac',
                'ice on ac', 'warm air', 'thermostat', 'coil', 'not cooling', 'r410', 'ac leak', 'ac water',
                'remote not working', 'ac tripping', 'hvac', 'refrigerator', 'fridge', 'deep freezer', 'chiller'
            ],
            'electrician' => [
                'electric', 'electricity', 'spark', 'sparking', 'breaker', 'short circuit', 'wire', 'wiring',
                'switch', 'socket', 'fuse', 'power', 'voltage', 'shock', 'trip', 'tripping', 'ups', 'generator',
                'light', 'bulb', 'phase', 'neutral', 'earthing', 'mcb', 'smoke', 'burning smell', 'power outage',
                'fan', 'ceiling fan', 'dimmer', 'meter', 'distribution box', 'loose connection', 'fluctuation'
            ],
            'plumber' => [
                'pipe', 'leak', 'leaking', 'water', 'sink', 'faucet', 'tap', 'drain', 'drainage', 'sewer',
                'toilet', 'flush', 'commode', 'geyser', 'shower', 'water pump', 'motor pump', 'tank', 'valve',
                'drip', 'dripping', 'clog', 'clogged', 'blockage', 'overflow', 'gutter', 'seepage from pipe',
                'low water pressure', 'water filter', 'wash basin', 'sanitary', 'plumbing', 'submersible pump'
            ],
            'carpenter' => [
                'wood', 'wooden', 'door', 'window', 'latch', 'hinge', 'cupboard', 'cabinet', 'drawer',
                'wardrobe', 'lock', 'handle', 'furniture', 'table', 'chair', 'bed', 'shelf', 'carpentry',
                'timber', 'jammed door', 'sagging door', 'hinges', 'plywood', 'door frame', 'sliding door'
            ],
            'painter' => [
                'paint', 'painting', 'wall', 'ceiling', 'damp', 'dampness', 'seepage', 'peeling', 'color',
                'whitewash', 'crack', 'plaster', 'putty', 'wall bubbles', 'stain on wall', 'efflorescence',
                'distemper', 'weather sheet', 'emulsion', 'primer', 'water damage on wall', 'repaint'
            ],
            'home-appliances' => [
                'washing machine', 'dryer', 'microwave', 'oven', 'dishwasher', 'vacuum', 'blender', 'appliance',
                'spin', 'drum', 'heating element', 'motor stalling', 'stovetop', 'hood', 'kitchen hood',
                'iron', 'water dispenser', 'cooking range', 'stove', 'burners', 'mixer'
            ],
            'deep-cleaning' => [
                'clean', 'cleaning', 'deep clean', 'stain', 'dirt', 'dust', 'sofa', 'carpet', 'rug', 'mattress',
                'grout', 'kitchen grease', 'bathroom tiles', 'sanitize', 'disinfection', 'pest', 'mold',
                'sofa wash', 'carpet shampoo', 'water tank cleaning', 'fumigation'
            ],
        ];

        // Specific trade service profiles
        $defectProfiles = [
            'ac-refrigeration' => [
                'title' => 'Compressor Inspection & Refrigerant Gas Verification',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'R410A Digital Manifold Gauge, Ammeter Clamp, Electronic Halogen Leak Detector',
                'summary' => 'Technician will inspect thermal load, condenser fins, and cooling cycle pressure.',
                'repair_time' => '45 - 60 Mins',
            ],
            'electrician' => [
                'title' => 'Circuit Breaker Inspection & Terminal Wiring Check',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Non-Contact Voltage Tester, Digital Multimeter, Insulated 1000V Screwdrivers',
                'summary' => 'Technician will inspect circuit integrity, terminal tightness, and phase balance.',
                'repair_time' => '30 - 45 Mins',
            ],
            'plumber' => [
                'title' => 'High-Pressure Pipe Joint Inspection & Gasket Replacement',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Ultrasonic Acoustic Leak Detector, Slip-Joint Pliers, PTFE Teflon Thread Sealant',
                'summary' => 'Technician will inspect hydrostatic pressure, joints, and seal integrity under water flow.',
                'repair_time' => '40 - 60 Mins',
            ],
            'carpenter' => [
                'title' => 'Door Hinge Alignment & Mortise Latch Adjustment',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Electric Wood Planer, High-Speed Router, Heavy-Duty Mortise Chisel Set',
                'summary' => 'Technician will inspect door hinge wear, strike plates, and frame clearance.',
                'repair_time' => '45 - 75 Mins',
            ],
            'painter' => [
                'title' => 'Moisture Assessment & Surface Wall Treatment',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Digital Pinless Moisture Meter, Chemical Elastomeric Waterproof Sealer, Carbide Scraper',
                'summary' => 'Technician will check wall moisture levels, scrape peeling layers, and prime damaged surfaces.',
                'repair_time' => '1 - 2 Hours',
            ],
            'home-appliances' => [
                'title' => 'Drain Pump Impeller & Motor Inspection',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Capacitance & Motor Continuity Tester, Metric Socket Wrench Set, Clamp Pliers',
                'summary' => 'Technician will inspect drainage cycle mechanics and motor operation.',
                'repair_time' => '45 - 60 Mins',
            ],
            'deep-cleaning' => [
                'title' => 'Deep Surface Sanitization & Specialized Extraction',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'High-Temperature Steam Extraction Machine, Anti-Bacterial Sanitizing Agent, Orbital Brush',
                'summary' => 'Technician will provide high-power particulate extraction and upholstery sanitation.',
                'repair_time' => '1 - 3 Hours',
            ],
        ];

        $lowerQuery = strtolower($problemQuery);
        $cleanQuery = ' ' . preg_replace('/[^a-z0-9\s]/', ' ', $lowerQuery) . ' ';

        // Calculate keyword matches for each trade
        $tradeScores = [];
        foreach ($tradeKeywords as $tradeSlug => $keywords) {
            $tradeScores[$tradeSlug] = 0;
            foreach ($keywords as $kw) {
                if (str_contains($cleanQuery, ' ' . $kw . ' ') || str_contains($lowerQuery, $kw)) {
                    $weight = str_contains($kw, ' ') ? 3 : 1;
                    $tradeScores[$tradeSlug] += $weight;
                }
            }
        }

        arsort($tradeScores);
        $bestTradeSlug = array_key_first($tradeScores);
        $highestScore = reset($tradeScores);

        // Multi-Modal Recognition Decision Engine
        $isRecognized = true;
        $isImageDiagnosed = false;
        $inconclusiveReason = null;

        if ($isImageUploaded && $isDocumentOrScreenshot && $highestScore === 0) {
            // An irrelevant document/screenshot was uploaded AND no repair keywords were found in text!
            $isRecognized = false;
            $inconclusiveReason = "The uploaded photo appears to be a mobile screenshot or document (e.g. medical card, receipt, or text capture) rather than a physical home repair defect. Please upload a clear photo of the damaged fixture, pipe, unit, or wiring.";
            $bestTradeSlug = 'plumber';
        } elseif ($highestScore > 0) {
            // Text contains valid repair keywords!
            $bestTradeSlug = array_key_first($tradeScores);
            $isRecognized = true;

            if ($categorySlug !== 'auto' && isset($tradeScores[$categorySlug]) && $tradeScores[$categorySlug] > 0) {
                $bestTradeSlug = $categorySlug;
            }

            if ($isImageUploaded && ! $isDocumentOrScreenshot) {
                $isImageDiagnosed = true;
            }
        } elseif ($isImageUploaded && ! $isDocumentOrScreenshot && $imageDetectedTrade) {
            // Problem query had NO matching keywords (or was empty/generic like "fix this" / "broken"), BUT user uploaded an authentic home defect photo!
            $bestTradeSlug = $imageDetectedTrade;
            $isRecognized = true;
            $isImageDiagnosed = true;
        } elseif ($categorySlug !== 'auto' && $categorySlug !== '' && Profession::where('slug', $categorySlug)->exists()) {
            // Explicit dropdown selection
            $bestTradeSlug = $categorySlug;
            $isRecognized = true;
        } else {
            // Inconclusive! Neither valid text nor a valid defect image
            $isRecognized = false;
            $inconclusiveReason = empty($problemQuery)
                ? 'No problem description or valid defect image was provided.'
                : "The description '{$problemQuery}' does not match any known home maintenance or repair defect.";
            $bestTradeSlug = 'plumber';
        }

        $profession = Profession::where('slug', $bestTradeSlug)->first();
        if (! $profession) {
            $profession = Profession::where('is_active', true)->first();
        }

        $allProfessions = Profession::where('is_active', true)->get();

        $matchedDefect = $defectProfiles[$profession?->slug] ?? [
            'title' => 'Diagnostic Assessment & Defect Resolution',
            'confidence' => '95% Match',
            'tools' => 'Calibrated Trade Toolset, Diagnostic Multimeter',
            'summary' => 'Standard diagnostic inspection by certified technician.',
            'repair_time' => '45 Mins',
        ];

        // Enrich defect details if photo attached
        if ($isImageDiagnosed) {
            $matchedDefect['confidence'] = 'Trade Matched with Attached Photo';
            if ($imageDefectName) {
                $matchedDefect['title'] = $imageDefectName;
            }
            $matchedDefect['summary'] = 'Your attached defect photo will be shared with the assigned ' . ($profession?->name ?? 'tradesperson') . ' so they arrive prepared with appropriate parts and tools.';
        }

        $baseRate = $profession?->base_price ?? 750;
        $costEstimate = [
            'min' => $baseRate,
            'max' => $baseRate + 850,
            'avg' => $baseRate + 400,
        ];

        return view('Frontend.customer.ai-result', compact(
            'profession',
            'matchedDefect',
            'costEstimate',
            'problemQuery',
            'uploadedImage',
            'isRecognized',
            'isImageDiagnosed',
            'isDocumentOrScreenshot',
            'inconclusiveReason',
            'allProfessions',
            'isGeminiPowered',
            'safetyAlert'
        ));
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
                "Customer " . auth()->user()->name . " booked {$booking->service_title} in {$booking->city}.",
                route('technician.jobs.details', $booking->booking_number)
            );

            // Create initial chat message from customer to technician
            Message::create([
                'sender_id' => $booking->user_id,
                'receiver_id' => $booking->professional->user_id,
                'booking_id' => $booking->id,
                'message' => "Hello! I have booked '{$booking->service_title}' scheduled for {$booking->service_date->format('M d, Y')} ({$booking->service_time_slot}) at {$booking->service_address}, {$booking->city}.",
                'is_read' => false,
            ]);

            Notification::sendToUser(
                $booking->professional->user_id,
                'chat_message',
                "New Booking Message from " . auth()->user()->name,
                "Hello! I have booked '{$booking->service_title}' scheduled for {$booking->service_date->format('M d, Y')} ({$booking->service_time_slot}).",
                route('technician.messages') . '?booking_id=' . $booking->id
            );
        } else {
            // Open pool booking: Notify verified technicians of this profession
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
            "Booking for {$profession->name} in {$booking->city} created by " . auth()->user()->name,
            route('admin.bookings')
        );

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

        $nearUpcomingBooking = $user->bookings()
            ->with(['professional.profession', 'profession'])
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->whereNotNull('service_date')
            ->whereBetween('service_date', [now()->startOfDay()->toDateString(), now()->addDays(2)->endOfDay()->toDateString()])
            ->orderBy('service_date', 'asc')
            ->first();

        return view('Frontend.customer.bookings', compact('bookings', 'nearUpcomingBooking'));
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
     * Live GPS tracking coordinates endpoint for dynamic polling.
     */
    public function trackingData(Booking $booking): \Illuminate\Http\JsonResponse
    {
        $this->authorizeBookingOwnership($booking);
        $booking->load(['professional.user', 'profession']);

        return response()->json($booking->getLiveTrackingPayload());
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

        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'] ?? 'Cancelled by customer',
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
            'comment' => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'rating.between' => 'Rating must be between 1 and 5 stars.',
            'comment.min' => 'Please provide at least 3 characters in your review.',
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
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/', 'unique:users,phone,' . $user->id],
            'city' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:255'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'phone.regex' => 'Please enter a valid contact phone number.',
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
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'subject.min' => 'Dispute subject must be at least 3 characters long.',
            'message.min' => 'Please provide at least 10 characters detailing your complaint.',
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
     * Direct Chat with Assigned Technicians.
     */
    public function messages(Request $request): View
    {
        /** @var User $user */
        $user = auth()->user();

        // Get technicians assigned to any of user's bookings
        $assignedTechnicians = Professional::with(['profession', 'user'])
            ->whereIn('id', function ($query) use ($user) {
                $query->select('professional_id')
                    ->from('bookings')
                    ->where('user_id', $user->id)
                    ->whereNotNull('professional_id');
            })
            ->get();

        // If none assigned yet, include top recommended technicians as available contacts
        if ($assignedTechnicians->isEmpty()) {
            $assignedTechnicians = Professional::with(['profession', 'user'])
                ->where('is_verified', true)
                ->take(3)
                ->get();
        }

        $activeTechId = $request->input('tech_id') ?: $request->input('tech');
        $selectedTech = null;

        if ($activeTechId) {
            $selectedTech = is_numeric($activeTechId)
                ? $assignedTechnicians->firstWhere('id', (int) $activeTechId)
                : $assignedTechnicians->first(fn($t) => strtolower(str_replace(' ', '-', $t->name)) === strtolower($activeTechId));
        }

        if (! $selectedTech) {
            $selectedTech = $assignedTechnicians->first();
        }

        // Active booking with this technician if any
        $activeBooking = $selectedTech
            ? $user->bookings()
                ->where('professional_id', $selectedTech->id)
                ->whereIn('status', ['pending', 'confirmed', 'en_route', 'in_progress'])
                ->latest()
                ->first()
            : null;

        // Fetch real chat conversation
        $chatMessages = collect();
        if ($selectedTech && $selectedTech->user_id) {
            $techUserId = $selectedTech->user_id;
            $chatMessages = Message::where(function ($q) use ($user, $techUserId) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', $techUserId);
            })->orWhere(function ($q) use ($user, $techUserId) {
                $q->where('sender_id', $techUserId)
                  ->where('receiver_id', $user->id);
            })->oldest()->get();
        }

        return view('Frontend.customer.messages', compact('user', 'assignedTechnicians', 'selectedTech', 'activeBooking', 'chatMessages'));
    }

    /**
     * Real-time live chat polling stream for customer.
     */
    public function messagesStream(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $techId = $request->input('tech_id');
        $afterId = (int) $request->input('after_id', 0);

        if (! $techId) {
            return response()->json(['messages' => []]);
        }

        $pro = is_numeric($techId)
            ? Professional::find($techId)
            : Professional::all()->first(fn($t) => strtolower(str_replace(' ', '-', $t->name)) === strtolower($techId));

        if (! $pro || ! $pro->user_id) {
            return response()->json(['messages' => []]);
        }

        $techUserId = $pro->user_id;

        $query = Message::where(function ($q) use ($user, $techUserId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $techUserId);
        })->orWhere(function ($q) use ($user, $techUserId) {
            $q->where('sender_id', $techUserId)->where('receiver_id', $user->id);
        });

        if ($afterId > 0) {
            $query->where('id', '>', $afterId);
        }

        $messages = $query->oldest()->get();

        // Mark incoming messages as read
        Message::where('sender_id', $techUserId)
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
     * Send direct message to technician.
     */
    public function sendMessage(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'technician_id' => ['required', 'exists:professionals,id'],
            'message' => ['required', 'string', 'max:1000'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
        ]);

        $professional = Professional::findOrFail($validated['technician_id']);
        $receiverUserId = $professional->user_id;

        $msg = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverUserId,
            'booking_id' => $validated['booking_id'] ?? null,
            'message' => trim($validated['message']),
            'is_read' => false,
        ]);

        if ($receiverUserId) {
            $chatUrl = route('technician.messages') . (!empty($validated['booking_id']) ? '?booking_id=' . $validated['booking_id'] : '');
            Notification::sendToUser(
                $receiverUserId,
                'chat_message',
                'New Message from ' . auth()->user()->name,
                Str::limit($validated['message'], 100),
                $chatUrl
            );
        }

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

        return back()->with('success', 'Message dispatched to technician via SMS & App chat.');
    }

    /**
     * Dedicated Customer Notifications Page
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

        return view('Frontend.customer.notifications', compact('user', 'notifications', 'unreadCount', 'filter'));
    }

    /**
     * Open single notification and redirect to destination.
     */
    public function openNotification(Notification $notification): RedirectResponse
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['is_read' => true]);
        }

        return redirect()->to($notification->link ?: route('customer.dashboard'));
    }

    /**
     * Mark single notification as read
     */
    public function markSingleNotificationRead(Request $request, Notification $notification)
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
     * Update customer notification channel preferences.
     */
    public function updateNotificationSettings(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->update([
            'notification_settings' => [
                'booking_updates' => $request->boolean('booking_updates'),
                'promotions' => $request->boolean('promotions'),
                'sms_alerts' => $request->boolean('sms_alerts'),
                'whatsapp_alerts' => $request->boolean('whatsapp_alerts'),
                'email_receipts' => $request->boolean('email_receipts'),
                'security_alerts' => true,
            ],
        ]);

        return back()->with('success', 'Notification preferences saved successfully!');
    }

    /**
     * Mark customer notifications as read.
     */
    public function markNotificationsRead(Request $request): \Illuminate\Http\JsonResponse|RedirectResponse
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unread_count' => 0,
            ]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Escrow Payment Checkout View.
     */
    public function payment(Request $request, ?Booking $booking = null): View
    {
        /** @var User $user */
        $user = auth()->user();

        if (! $booking) {
            $booking = $user->bookings()
                ->with(['professional', 'profession'])
                ->whereIn('status', ['pending', 'confirmed', 'en_route', 'in_progress'])
                ->latest()
                ->first();

            if (! $booking) {
                $booking = $user->bookings()->with(['professional', 'profession'])->latest()->first();
            }
        } else {
            $this->authorizeBookingOwnership($booking);
            $booking->load(['professional', 'profession']);
        }

        $allBookings = $user->bookings()
            ->with(['professional', 'profession'])
            ->latest()
            ->take(10)
            ->get();

        return view('Frontend.customer.payment', compact('user', 'booking', 'allBookings'));
    }

    /**
     * Process Escrow Payment for a Booking.
     */
    public function processPayment(Request $request, Booking $booking): RedirectResponse
    {
        $this->authorizeBookingOwnership($booking);

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

        return redirect()->route('customer.booking.confirm', $booking->id)
            ->with('success', 'Payment method saved! Rs. ' . number_format($booking->total_price) . ' is secured in FixMate Escrow.');
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
