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
        $category = $request->input('category', 'all');
        $search = trim((string) $request->input('q', $request->input('search', '')));

        $baseQuery = $user->notifications();

        // Platform alert KPI counters
        $totalCount = (clone $baseQuery)->count();
        $unreadCount = (clone $baseQuery)->unread()->count();
        $readCount = max(0, $totalCount - $unreadCount);

        $kycCount = (clone $baseQuery)->where(function ($q) {
            $q->where('type', 'like', 'kyc%')
              ->orWhere('type', 'technician_registered');
        })->count();

        $bookingCount = (clone $baseQuery)->where(function ($q) {
            $q->where('type', 'like', 'booking%')
              ->orWhere('type', 'like', 'job%')
              ->orWhere('type', 'like', 'service%')
              ->orWhere('type', 'technician_en_route');
        })->count();

        $paymentCount = (clone $baseQuery)->where(function ($q) {
            $q->where('type', 'like', 'escrow%')
              ->orWhere('type', 'like', 'payment%')
              ->orWhere('type', 'like', 'payout%');
        })->count();

        $inquiryCount = (clone $baseQuery)->where(function ($q) {
            $q->where('type', 'like', 'inquiry%')
              ->orWhere('type', 'like', 'complaint%')
              ->orWhere('type', 'chat_message')
              ->orWhere('type', 'review_reply');
        })->count();

        $stats = [
            'total' => $totalCount,
            'unread' => $unreadCount,
            'read' => $readCount,
            'kyc' => $kycCount,
            'booking' => $bookingCount,
            'payment' => $paymentCount,
            'inquiry' => $inquiryCount,
        ];

        // Apply filters to feed
        $query = (clone $baseQuery)->latest();

        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->where('is_read', true);
        }

        if ($category && $category !== 'all') {
            if ($category === 'kyc') {
                $query->where(function ($q) {
                    $q->where('type', 'like', 'kyc%')
                      ->orWhere('type', 'technician_registered');
                });
            } elseif ($category === 'booking') {
                $query->where(function ($q) {
                    $q->where('type', 'like', 'booking%')
                      ->orWhere('type', 'like', 'job%')
                      ->orWhere('type', 'like', 'service%')
                      ->orWhere('type', 'technician_en_route');
                });
            } elseif ($category === 'payment') {
                $query->where(function ($q) {
                    $q->where('type', 'like', 'escrow%')
                      ->orWhere('type', 'like', 'payment%')
                      ->orWhere('type', 'like', 'payout%');
                });
            } elseif ($category === 'inquiry') {
                $query->where(function ($q) {
                    $q->where('type', 'like', 'inquiry%')
                      ->orWhere('type', 'like', 'complaint%')
                      ->orWhere('type', 'chat_message')
                      ->orWhere('type', 'review_reply');
                });
            }
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->paginate(15)->withQueryString();

        return view('Frontend.admin.notifications', compact(
            'user',
            'notifications',
            'unreadCount',
            'filter',
            'category',
            'search',
            'stats'
        ));
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
     * Mark single notification as unread
     */
    public function markNotificationUnread(Request $request, Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['is_read' => false]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unread_count' => auth()->user()->notifications()->unread()->count(),
            ]);
        }

        return back()->with('success', 'Notification marked as unread.');
    }

    /**
     * Delete single notification
     */
    public function deleteNotification(Request $request, Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->delete();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'unread_count' => auth()->user()->notifications()->unread()->count(),
            ]);
        }

        return back()->with('success', 'Notification deleted successfully.');
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

    /**
     * Clear all read notifications
     */
    public function clearReadNotifications(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->notifications()->where('is_read', true)->delete();

        return back()->with('success', 'All reviewed notifications have been cleared.');
    }
}
