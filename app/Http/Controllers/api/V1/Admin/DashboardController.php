<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\CommunityIssueResource;
use App\Http\Resources\ContactInquiryResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ProfessionalResource;
use App\Http\Resources\TechnicianApplicationResource;
use App\Http\Resources\UserResource;
use App\Models\CommunityIssue;
use App\Models\ContactInquiry;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $stats = [
            'total_customers' => User::where('user_type', User::TYPE_CUSTOMER)->count(),
            'active_customers' => User::where('user_type', User::TYPE_CUSTOMER)->where('is_active', true)->count(),
            'total_technicians' => Professional::count(),
            'verified_technicians' => Professional::where('is_verified', true)->count(),
            'pending_kyc' => TechnicianApplication::where('status', 'pending')->count(),
            'total_inquiries' => ContactInquiry::count(),
            'new_inquiries' => ContactInquiry::where('status', 'new')->count(),
            'active_alerts' => CommunityIssue::where('status', 'alert_active')->count(),
            'total_professions' => Profession::where('is_active', true)->count(),
            'karachi_users' => User::where('city', 'like', '%Karachi%')->count(),
            'lahore_users' => User::where('city', 'like', '%Lahore%')->count(),
            'islamabad_users' => User::where('city', 'like', '%Islamabad%')->count(),
            'rawalpindi_users' => User::where('city', 'like', '%Rawalpindi%')->count(),
        ];

        return $this->ok([
            'stats' => $stats,
            'recent_customers' => UserResource::collection(
                User::where('user_type', User::TYPE_CUSTOMER)->latest()->take(4)->get()
            ),
            'recent_technicians' => ProfessionalResource::collection(
                Professional::with('profession')->latest()->take(4)->get()
            ),
            'recent_inquiries' => ContactInquiryResource::collection(
                ContactInquiry::latest()->take(4)->get()
            ),
            'recent_applications' => TechnicianApplicationResource::collection(
                TechnicianApplication::with(['profession', 'user'])->latest()->take(4)->get()
            ),
        ], 'Admin dashboard retrieved.');
    }

    public function notifications(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = $user->notifications()->latest();

        if ($request->input('filter') === 'unread') {
            $query->unread();
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $notifications = $query->paginate($perPage);

        return $this->ok(NotificationResource::collection($notifications->items()), 'Notifications retrieved.', [
            'current_page' => $notifications->currentPage(),
            'per_page' => $notifications->perPage(),
            'total' => $notifications->total(),
            'last_page' => $notifications->lastPage(),
            'unread_count' => $user->notifications()->unread()->count(),
        ]);
    }

    public function markNotificationRead(Request $request, Notification $notification): JsonResponse
    {
        if ($notification->user_id === $request->user()->id) {
            $notification->update(['is_read' => true]);
        }

        return $this->ok([
            'unread_count' => $request->user()->notifications()->unread()->count(),
        ], 'Notification marked as read.');
    }

    public function markAllNotificationsRead(Request $request): JsonResponse
    {
        $request->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return $this->ok(['unread_count' => 0], 'All system notifications marked as read.');
    }
}
