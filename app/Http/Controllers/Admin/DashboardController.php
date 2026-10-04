<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityIssue;
use App\Models\ContactInquiry;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dynamic platform administrator dashboard & KPI overview.
     */
    public function index(): View
    {
        $hasUsers = \Illuminate\Support\Facades\Schema::hasTable('users');
        $hasProfessionals = \Illuminate\Support\Facades\Schema::hasTable('professionals');
        $hasProfessions = \Illuminate\Support\Facades\Schema::hasTable('professions');
        $hasInquiries = \Illuminate\Support\Facades\Schema::hasTable('contact_inquiries');
        $hasIssues = \Illuminate\Support\Facades\Schema::hasTable('community_issues');
        $hasApps = \Illuminate\Support\Facades\Schema::hasTable('technician_applications');

        $totalCustomers = $hasUsers ? User::where('user_type', User::TYPE_CUSTOMER)->count() : 0;
        $activeCustomers = $hasUsers ? User::where('user_type', User::TYPE_CUSTOMER)->where('is_active', true)->count() : 0;

        $totalTechnicians = $hasProfessionals ? Professional::count() : 0;
        $verifiedTechnicians = $hasProfessionals ? Professional::where('is_verified', true)->count() : 0;

        $pendingKyc = $hasApps ? TechnicianApplication::where('status', 'pending')->count() : 0;
        $totalInquiries = $hasInquiries ? ContactInquiry::count() : 0;
        $newInquiries = $hasInquiries ? ContactInquiry::where('status', 'new')->count() : 0;
        $activeAlerts = $hasIssues ? CommunityIssue::where('status', 'alert_active')->count() : 0;

        $professions = $hasProfessions
            ? Profession::where('is_active', true)->withCount('professionals')->get()
            : collect();

        $recentCustomers = $hasUsers
            ? User::where('user_type', User::TYPE_CUSTOMER)->latest()->take(4)->get()
            : collect();

        $recentTechnicians = $hasProfessionals
            ? Professional::with('profession')->latest()->take(4)->get()
            : collect();

        $recentInquiries = $hasInquiries
            ? ContactInquiry::latest()->take(4)->get()
            : collect();

        $recentApplications = $hasApps
            ? TechnicianApplication::latest()->take(4)->get()
            : collect();

        // City distribution calculation
        $karachiUsers = $hasUsers ? User::where('city', 'like', '%Karachi%')->count() : 0;
        $lahoreUsers = $hasUsers ? User::where('city', 'like', '%Lahore%')->count() : 0;
        $islamabadUsers = $hasUsers ? User::where('city', 'like', '%Islamabad%')->count() : 0;
        $rawalpindiUsers = $hasUsers ? User::where('city', 'like', '%Rawalpindi%')->count() : 0;

        $stats = [
            'total_customers' => $totalCustomers,
            'active_customers' => $activeCustomers,
            'total_technicians' => $totalTechnicians,
            'verified_technicians' => $verifiedTechnicians,
            'pending_kyc' => $pendingKyc,
            'total_inquiries' => $totalInquiries,
            'new_inquiries' => $newInquiries,
            'active_alerts' => $activeAlerts,
            'total_professions' => $professions->count(),
            'karachi_users' => $karachiUsers,
            'lahore_users' => $lahoreUsers,
            'islamabad_users' => $islamabadUsers,
            'rawalpindi_users' => $rawalpindiUsers,
        ];

        return view('Frontend.admin.dashboard', compact(
            'stats',
            'professions',
            'recentCustomers',
            'recentTechnicians',
            'recentInquiries',
            'recentApplications'
        ));
    }

    /**
     * Dedicated Platform Admin Notifications Page
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

        return view('Frontend.admin.notifications', compact('user', 'notifications', 'unreadCount', 'filter'));
    }

    /**
     * Open single admin alert, mark read, and redirect to destination.
     */
    public function openNotification(Notification $notification): RedirectResponse
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['is_read' => true]);
        }

        return redirect()->to($notification->link ?: route('admin.dashboard'));
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

        return back()->with('success', 'All system notifications marked as read.');
    }
}
