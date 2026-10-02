<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    /**
     * Homepage with dynamic professions and featured professionals.
     */
    public function home(): View
    {
        $hasProfessions = \Illuminate\Support\Facades\Schema::hasTable('professions');
        $hasProfessionals = \Illuminate\Support\Facades\Schema::hasTable('professionals');

        $professions = $hasProfessions
            ? Profession::where('is_active', true)->withCount('professionals')->get()
            : collect();

        $featuredProfessionals = $hasProfessionals
            ? Professional::with('profession')->latest()->take(4)->get()
            : collect();

        return view('Frontend.public.home', compact('professions', 'featuredProfessionals'));
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

        return view('Frontend.public.about', compact('professions', 'featuredProfessionals', 'stats'));
    }
}
