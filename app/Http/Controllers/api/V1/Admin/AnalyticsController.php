<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\ProfessionResource;
use App\Models\CommunityIssue;
use App\Models\ContactInquiry;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends ApiController
{
    public function index(): JsonResponse
    {
        $professions = Profession::where('is_active', true)->withCount('professionals')->orderByDesc('professionals_count')->get();

        return $this->ok([
            'totals' => [
                'customers' => User::where('user_type', User::TYPE_CUSTOMER)->count(),
                'technicians' => Professional::count(),
                'verified_technicians' => Professional::where('is_verified', true)->count(),
                'inquiries' => ContactInquiry::count(),
                'resolved_issues' => CommunityIssue::where('status', 'resolved')->count(),
                'active_alerts' => CommunityIssue::where('status', 'alert_active')->count(),
            ],
            'by_city' => [
                'karachi' => User::where('city', 'like', '%Karachi%')->count(),
                'lahore' => User::where('city', 'like', '%Lahore%')->count(),
                'islamabad' => User::where('city', 'like', '%Islamabad%')->count(),
                'rawalpindi' => User::where('city', 'like', '%Rawalpindi%')->count(),
            ],
            'professions' => ProfessionResource::collection($professions),
        ], 'Analytics retrieved.');
    }
}
