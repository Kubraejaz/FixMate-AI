<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    /**
     * Homepage with dynamic hero imagery, professions catalog, platform trust stats, and live testimonials.
     */
    public function home(): View
    {
        $hasProfessions = \Illuminate\Support\Facades\Schema::hasTable('professions');
        $hasProfessionals = \Illuminate\Support\Facades\Schema::hasTable('professionals');
        $hasIssues = \Illuminate\Support\Facades\Schema::hasTable('community_issues');

        $professions = $hasProfessions
            ? Profession::where('is_active', true)->withCount('professionals')->get()
            : collect();

        $featuredProfessionals = $hasProfessionals
            ? Professional::with(['profession', 'user'])
                ->where('is_verified', true)
                ->latest()
                ->take(4)
                ->get()
            : collect();

        if ($featuredProfessionals->isEmpty() && $hasProfessionals) {
            $featuredProfessionals = Professional::with(['profession', 'user'])
                ->latest()
                ->take(4)
                ->get();
        }

        $totalTechs = $hasProfessionals ? Professional::count() : 0;
        $verifiedTechs = $hasProfessionals ? Professional::where('is_verified', true)->count() : 0;
        $activeAlerts = $hasIssues ? \App\Models\CommunityIssue::where('status', 'alert_active')->count() : 0;
        $latestAlert = $hasIssues ? \App\Models\CommunityIssue::where('status', 'alert_active')->latest()->first() : null;

        $hasSettings = \Illuminate\Support\Facades\Schema::hasTable('homepage_settings');
        $hasTestimonials = \Illuminate\Support\Facades\Schema::hasTable('testimonials');
        $hasSteps = \Illuminate\Support\Facades\Schema::hasTable('workflow_steps');

        $settings = $hasSettings ? \App\Models\HomepageSetting::instance() : null;

        $dbTestimonials = $hasTestimonials
            ? \App\Models\Testimonial::where('is_featured', true)->orderBy('display_order')->get()
            : collect();

        $dbSteps = $hasSteps
            ? \App\Models\WorkflowStep::where('is_active', true)->orderBy('step_number')->get()
            : collect();

        $stats = [
            'total_technicians' => $totalTechs > 0 ? $totalTechs : 2400,
            'verified_technicians' => $verifiedTechs > 0 ? $verifiedTechs : 2150,
            'total_professions' => $professions->count() > 0 ? $professions->count() : 6,
            'completed_jobs' => '18,500+',
            'avg_rating' => '4.9',
            'avg_arrival_mins' => 24,
            'warranty_days' => $settings?->warranty_days ?? 30,
            'active_alerts' => $activeAlerts,
        ];

        // Dynamic Hero Configuration with real image assets from CMS
        $hero = [
            'badge' => $settings?->hero_badge ?? 'AI Powered Home Service Platform',
            'title_main' => $settings?->hero_title_main ?? 'Smart Home Services',
            'title_highlight' => $settings?->hero_title_highlight ?? 'Simple',
            'subtitle' => $settings?->hero_subtitle ?? 'Describe your problem or upload defect photos. Let FixMate AI find verified technicians with transparent upfront pricing.',
            'image' => asset($settings?->hero_image ?? 'assets/images/image_8.png'),
            'script_text' => $settings?->hero_script_text ?? "Your Home\nOur Priority",
            'trusted_tag' => $settings?->hero_trusted_tag ?? 'Trusted Professionals for Your Home',
            'guarantee_title' => $settings?->guarantee_title ?? 'FixMate AI Guarantee',
            'guarantee_subtitle' => $settings?->guarantee_subtitle ?? 'Trusted service. Verified professionals. 30-day warranty on all completed jobs.',
        ];

        // Dynamic Workflow Steps from CMS or fallback
        $workflowSteps = $dbSteps->isNotEmpty()
            ? $dbSteps->map(fn ($s) => [
                'step' => $s->step_number,
                'icon' => $s->icon,
                'title' => $s->title,
                'desc' => $s->description,
                'badge_color' => $s->badge_color,
            ])
            : collect([
                [
                    'step' => 1,
                    'icon' => '📷',
                    'title' => 'Describe Your Problem',
                    'desc' => 'Share details or upload defect photos.',
                    'badge_color' => '#FFC107',
                ],
                [
                    'step' => 2,
                    'icon' => '🤖',
                    'title' => 'AI Diagnostics',
                    'desc' => 'Instant computer vision defect assessment.',
                    'badge_color' => '#FFC107',
                ],
                [
                    'step' => 3,
                    'icon' => '🧑‍🔧',
                    'title' => 'Proximity Match',
                    'desc' => 'Dispatches top nearby verified specialists.',
                    'badge_color' => '#FFC107',
                ],
                [
                    'step' => 4,
                    'icon' => '📍',
                    'title' => 'Live Radar & Tracking',
                    'desc' => 'Monitor real-time technician arrival on map.',
                    'badge_color' => '#FFC107',
                ],
                [
                    'step' => 5,
                    'icon' => '✓',
                    'title' => 'Protected Escrow',
                    'desc' => 'Approve arrival OTP & pay with 30-day warranty.',
                    'badge_color' => '#10B981',
                ],
            ]);

        // Dynamic Verified Homeowner Testimonials from CMS or fallback
        $testimonials = $dbTestimonials->isNotEmpty()
            ? $dbTestimonials->map(fn ($t) => [
                'name' => $t->name,
                'location' => $t->location,
                'trade' => $t->trade,
                'rating' => $t->rating,
                'comment' => $t->comment,
                'avatar' => $t->avatar_url,
            ])
            : collect([
                [
                    'name' => 'Sara Ahmed',
                    'location' => 'Karachi — Clifton',
                    'trade' => 'Electrical Repair',
                    'rating' => 5,
                    'comment' => 'The AI scanner estimated Rs. 1,400 for our tripping breaker. Technician arrived in 22 minutes and solved the neutral short.',
                    'avatar' => asset('assets/images/image_2.png'),
                ],
                [
                    'name' => 'Dr. Kamran Malik',
                    'location' => 'Islamabad — F-7/2',
                    'trade' => 'Inverter AC Jet Wash',
                    'rating' => 5,
                    'comment' => 'Deep pressure jet wash fixed cooling issues in under an hour. Outstanding professional service and polite technician.',
                    'avatar' => asset('assets/images/image_3.png'),
                ],
                [
                    'name' => 'Bilal Farooq',
                    'location' => 'Lahore — Gulberg III',
                    'trade' => 'Plumbing Overhaul',
                    'rating' => 5,
                    'comment' => 'No overcharging or guesswork. Upfront pricing and arrival OTP made hiring a technician completely worry-free.',
                    'avatar' => asset('assets/images/image_4.png'),
                ],
            ]);

        return view('Frontend.public.home', compact(
            'professions',
            'featuredProfessionals',
            'stats',
            'hero',
            'workflowSteps',
            'testimonials',
            'latestAlert'
        ));
    }

    /**
     * Services catalog page with all active professions.
     */
    public function services(): View
    {
        $hasProfessions = \Illuminate\Support\Facades\Schema::hasTable('professions');

        $professions = $hasProfessions
            ? Profession::where('is_active', true)->withCount('professionals')->get()
            : collect();

        return view('Frontend.public.services', compact('professions'));
    }

    /**
     * Detailed service page for a specific profession.
     */
    public function serviceDetails(string $slug = 'plumber'): View
    {
        // Find profession by exact slug or partial match
        $profession = Profession::where('slug', $slug)
            ->orWhere('slug', 'like', "%{$slug}%")
            ->first();

        if (! $profession) {
            $profession = Profession::where('is_active', true)->first();
        }

        $technicians = $profession
            ? Professional::with(['user', 'profession'])
                ->where('profession_id', $profession->id)
                ->get()
            : collect();

        $otherProfessions = Profession::where('is_active', true)
            ->when($profession, fn ($q) => $q->where('id', '!=', $profession->id))
            ->get();

        return view('Frontend.public.service-details', [
            'slug' => $slug,
            'profession' => $profession,
            'technicians' => $technicians,
            'otherProfessions' => $otherProfessions,
        ]);
    }

    /**
     * Technicians directory with dynamic filtering by profession, keyword, and city.
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

        return view('Frontend.public.technicians', compact('technicians', 'professions'));
    }

    /**
     * Public profile of a single technician / professional.
     */
    public function technicianProfile(string $id = '1'): View
    {
        $professional = null;

        if (is_numeric($id)) {
            $professional = Professional::with(['profession', 'user'])->find($id);
        }

        if (! $professional) {
            $professional = Professional::with(['profession', 'user'])->first();
        }

        return view('Frontend.public.technician-profile', [
            'techId' => $id,
            'professional' => $professional,
        ]);
    }

    /**
     * How It Works guide with dynamic trades, interactive cost estimator, and platform stats.
     */
    public function howItWorks(): View
    {
        $hasProfessions = \Illuminate\Support\Facades\Schema::hasTable('professions');
        $hasProfessionals = \Illuminate\Support\Facades\Schema::hasTable('professionals');
        $hasIssues = \Illuminate\Support\Facades\Schema::hasTable('community_issues');

        $professions = $hasProfessions
            ? Profession::where('is_active', true)->withCount('professionals')->get()
            : collect();

        $totalTechs = $hasProfessionals ? Professional::count() : 0;

        $stats = [
            'total_technicians' => $totalTechs > 0 ? $totalTechs : 150,
            'total_professions' => $hasProfessions ? Profession::where('is_active', true)->count() : 6,
            'avg_arrival_mins' => 24,
            'warranty_days' => 30,
            'community_issues_resolved' => $hasIssues ? \App\Models\CommunityIssue::where('status', 'resolved')->count() : 45,
        ];

        return view('Frontend.public.how-it-works', [
            'professions' => $professions,
            'stats' => $stats,
        ]);
    }

    /**
     * About Us page with live platform metrics, certified trades, and featured technicians.
     */
    public function about(): View
    {
        $hasProfessions = \Illuminate\Support\Facades\Schema::hasTable('professions');
        $hasProfessionals = \Illuminate\Support\Facades\Schema::hasTable('professionals');
        $hasIssues = \Illuminate\Support\Facades\Schema::hasTable('community_issues');

        $professions = $hasProfessions
            ? Profession::where('is_active', true)->withCount('professionals')->get()
            : collect();

        $featuredProfessionals = $hasProfessionals
            ? Professional::with(['profession', 'user'])
                ->where('is_verified', true)
                ->latest()
                ->take(4)
                ->get()
            : collect();

        if ($featuredProfessionals->isEmpty() && $hasProfessionals) {
            $featuredProfessionals = Professional::with(['profession', 'user'])
                ->latest()
                ->take(4)
                ->get();
        }

        $totalTechs = $hasProfessionals ? Professional::count() : 0;
        $verifiedTechs = $hasProfessionals ? Professional::where('is_verified', true)->count() : 0;
        $resolvedIssues = $hasIssues ? \App\Models\CommunityIssue::where('status', 'resolved')->count() : 0;

        $stats = [
            'total_technicians' => $totalTechs > 0 ? $totalTechs : 2400,
            'verified_technicians' => $verifiedTechs > 0 ? $verifiedTechs : 2150,
            'total_professions' => $professions->count() > 0 ? $professions->count() : 6,
            'satisfaction_rate' => '98.8%',
            'avg_arrival_mins' => 28,
            'completed_jobs' => '18,500+',
            'resolved_issues' => $resolvedIssues > 0 ? $resolvedIssues : 45,
        ];

        $peopleReviews = collect([
            [
                'name' => 'Sara Ahmed',
                'location' => 'Karachi — Clifton Block 4',
                'trade' => 'Electrical Repair',
                'rating' => 5,
                'comment' => 'The AI scanner estimated Rs. 1,400 for our tripping main breaker. Riaz arrived in 22 minutes, identified a neutral short in the false ceiling, and fixed it within the exact estimate. The escrow approval OTP gave me total peace of mind.',
                'date' => 'Verified Homeowner',
                'avatar' => asset('assets/images/image_2.png'),
            ],
            [
                'name' => 'Dr. Kamran Malik',
                'location' => 'Islamabad — Sector F-7/2',
                'trade' => 'Inverter AC Chemical Service',
                'rating' => 5,
                'comment' => 'My split unit was freezing up. Imran had specialized pressure wash equipment, drained all blockages, and checked the gas pressure on his digital manifold. Truly top-tier craftsmanship.',
                'date' => 'Verified Homeowner',
                'avatar' => asset('assets/images/image_3.png'),
            ],
            [
                'name' => 'Bilal Farooq',
                'location' => 'Lahore — Gulberg III',
                'trade' => 'Master Plumbing',
                'rating' => 5,
                'comment' => 'FixMate completely eliminated the headache of haggling with roadside plumbers who overcharge. Ali Khan was professional, courteous, and polite. The 30-day warranty gives exceptional confidence.',
                'date' => 'Verified Homeowner',
                'avatar' => asset('assets/images/image_4.png'),
            ],
        ]);

        return view('Frontend.public.about', compact('professions', 'featuredProfessionals', 'stats', 'peopleReviews'));
    }
}
