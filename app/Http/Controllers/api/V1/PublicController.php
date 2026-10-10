<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ProfessionResource;
use App\Http\Resources\ProfessionalResource;
use App\Http\Resources\TestimonialResource;
use App\Http\Resources\WorkflowStepResource;
use App\Models\CommunityIssue;
use App\Models\HomepageSetting;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\Testimonial;
use App\Models\WorkflowStep;
use Illuminate\Http\JsonResponse;

class PublicController extends ApiController
{
    public function home(): JsonResponse
    {
        $professions = Profession::where('is_active', true)->withCount('professionals')->get();

        $featuredProfessionals = Professional::with(['profession', 'user'])
            ->where('is_verified', true)
            ->latest()
            ->take(4)
            ->get();

        if ($featuredProfessionals->isEmpty()) {
            $featuredProfessionals = Professional::with(['profession', 'user'])->latest()->take(4)->get();
        }

        $totalTechs = Professional::count();
        $verifiedTechs = Professional::where('is_verified', true)->count();
        $settings = HomepageSetting::instance();
        $activeAlerts = CommunityIssue::where('status', 'alert_active')->count();
        $latestAlert = CommunityIssue::where('status', 'alert_active')->latest()->first();

        $stats = [
            'total_technicians' => $totalTechs > 0 ? $totalTechs : 2400,
            'verified_technicians' => $verifiedTechs > 0 ? $verifiedTechs : 2150,
            'total_professions' => $professions->count() > 0 ? $professions->count() : 6,
            'completed_jobs' => '18,500+',
            'avg_rating' => '4.9',
            'avg_arrival_mins' => 24,
            'warranty_days' => $settings->warranty_days ?? 30,
            'active_alerts' => $activeAlerts,
        ];

        $hero = [
            'badge' => $settings->hero_badge,
            'title_main' => $settings->hero_title_main,
            'title_highlight' => $settings->hero_title_highlight,
            'subtitle' => $settings->hero_subtitle,
            'image' => asset($settings->hero_image ?: 'assets/images/image_8.png'),
            'script_text' => $settings->hero_script_text,
            'trusted_tag' => $settings->hero_trusted_tag,
            'guarantee_title' => $settings->guarantee_title,
            'guarantee_subtitle' => $settings->guarantee_subtitle,
        ];

        $steps = WorkflowStep::where('is_active', true)->orderBy('step_number')->get();
        $workflowSteps = $steps->isNotEmpty()
            ? WorkflowStepResource::collection($steps)
            : $this->defaultSteps();

        $testimonials = Testimonial::where('is_featured', true)->orderBy('display_order')->get();

        return $this->ok([
            'hero' => $hero,
            'stats' => $stats,
            'professions' => ProfessionResource::collection($professions),
            'featured_technicians' => ProfessionalResource::collection($featuredProfessionals),
            'workflow_steps' => $workflowSteps,
            'testimonials' => TestimonialResource::collection($testimonials),
            'latest_alert' => $latestAlert ? new \App\Http\Resources\CommunityIssueResource($latestAlert) : null,
        ], 'Homepage content retrieved.');
    }

    public function about(): JsonResponse
    {
        $settings = HomepageSetting::instance();
        $professions = Profession::where('is_active', true)->withCount('professionals')->get();

        $featuredProfessionals = Professional::with(['profession', 'user'])
            ->where('is_verified', true)
            ->latest()
            ->take(4)
            ->get();

        if ($featuredProfessionals->isEmpty()) {
            $featuredProfessionals = Professional::with(['profession', 'user'])->latest()->take(4)->get();
        }

        $stats = [
            'total_technicians' => Professional::count() ?: 2400,
            'verified_technicians' => Professional::where('is_verified', true)->count() ?: 2150,
            'total_professions' => $professions->count() ?: 6,
            'satisfaction_rate' => '98.8%',
            'avg_arrival_mins' => 28,
            'warranty_days' => $settings->warranty_days ?? 30,
            'completed_jobs' => '18,500+',
            'resolved_issues' => CommunityIssue::where('status', 'resolved')->count() ?: 45,
        ];

        return $this->ok([
            'stats' => $stats,
            'professions' => ProfessionResource::collection($professions),
            'featured_technicians' => ProfessionalResource::collection($featuredProfessionals),
            'testimonials' => TestimonialResource::collection(
                Testimonial::where('is_featured', true)->orderBy('display_order')->get()
            ),
            'settings' => new \App\Http\Resources\HomepageSettingResource($settings),
        ], 'About content retrieved.');
    }

    public function howItWorks(): JsonResponse
    {
        $settings = HomepageSetting::instance();
        $professions = Profession::where('is_active', true)->withCount('professionals')->get();
        $steps = WorkflowStep::where('is_active', true)->orderBy('step_number')->get();

        $stats = [
            'total_technicians' => Professional::count() ?: 150,
            'total_professions' => Profession::where('is_active', true)->count() ?: 6,
            'avg_arrival_mins' => 24,
            'warranty_days' => $settings->warranty_days ?? 30,
            'community_issues_resolved' => CommunityIssue::where('status', 'resolved')->count() ?: 45,
        ];

        return $this->ok([
            'stats' => $stats,
            'professions' => ProfessionResource::collection($professions),
            'workflow_steps' => $steps->isNotEmpty() ? WorkflowStepResource::collection($steps) : $this->defaultSteps(),
            'settings' => new \App\Http\Resources\HomepageSettingResource($settings),
        ], 'How it works content retrieved.');
    }

    public function privacyPolicy(): JsonResponse
    {
        return $this->ok([
            'settings' => new \App\Http\Resources\HomepageSettingResource(HomepageSetting::instance()),
            'updated_at' => now()->toIso8601String(),
        ], 'Privacy policy retrieved.');
    }

    public function terms(): JsonResponse
    {
        return $this->ok([
            'settings' => new \App\Http\Resources\HomepageSettingResource(HomepageSetting::instance()),
            'updated_at' => now()->toIso8601String(),
        ], 'Terms and conditions retrieved.');
    }

    protected function defaultSteps(): array
    {
        return [
            ['step_number' => 1, 'icon' => '📷', 'title' => 'Describe Your Problem', 'description' => 'Share details or upload defect photos.', 'badge_color' => '#FFC107'],
            ['step_number' => 2, 'icon' => '🏷️', 'title' => 'Upfront Tariff Pricing', 'description' => 'Instant standard labor and parts cost estimate.', 'badge_color' => '#FFC107'],
            ['step_number' => 3, 'icon' => '🧑‍🔧', 'title' => 'Proximity Match', 'description' => 'Dispatches top nearby verified specialists.', 'badge_color' => '#FFC107'],
            ['step_number' => 4, 'icon' => '⏱️', 'title' => 'Fast Dispatch & Arrival', 'description' => 'Instant booking confirmation and dispatch notifications.', 'badge_color' => '#FFC107'],
            ['step_number' => 5, 'icon' => '✓', 'title' => 'Protected Escrow', 'description' => 'Approve arrival OTP & pay with 30-day warranty.', 'badge_color' => '#10B981'],
        ];
    }
}
