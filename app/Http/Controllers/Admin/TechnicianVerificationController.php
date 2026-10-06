<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechnicianVerificationController extends Controller
{
    /**
     * Display KYC verification pipeline.
     */
    public function index(Request $request): View
    {
        $query = TechnicianApplication::with(['profession', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('profession_id')) {
            $query->where('profession_id', $request->input('profession_id'));
        }

        if ($request->filled('search')) {
            $term = '%' . trim($request->input('search')) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('reference_no', 'like', $term)
                  ->orWhere('name', 'like', $term)
                  ->orWhere('phone', 'like', $term)
                  ->orWhere('cnic_number', 'like', $term)
                  ->orWhere('email', 'like', $term);
            });
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => TechnicianApplication::count(),
            'pending' => TechnicianApplication::where('status', 'pending')->count(),
            'under_review' => TechnicianApplication::where('status', 'under_review')->count(),
            'approved' => TechnicianApplication::where('status', 'approved')->count(),
            'returned' => TechnicianApplication::where('status', 'returned')->count(),
            'rejected' => TechnicianApplication::where('status', 'rejected')->count(),
        ];

        $professions = Profession::where('is_active', true)->get();

        return view('Frontend.admin.verification', [
            'applications' => $applications,
            'stats' => $stats,
            'professions' => $professions,
        ]);
    }

    /**
     * Approve technician partner application and verify user credentials.
     */
    public function approve(Request $request, TechnicianApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $application->update([
            'status' => 'approved',
            'biometric_status' => 'verified',
            'rejection_reason' => null,
            'admin_notes' => $validated['admin_notes'] ?? 'NADRA biometric and skill inspection completed successfully.',
            'reviewed_at' => now(),
        ]);

        // If a linked user or professional exists with matching phone/email, mark verified and active
        $techUserId = $application->user_id;
        if ($application->user_id) {
            User::where('id', $application->user_id)->update(['is_verified' => true, 'is_active' => true]);
            Professional::where('user_id', $application->user_id)->update([
                'is_verified' => true,
                'verification_status' => 'verified',
                'biometric_status' => 'verified',
                'rejection_reason' => null,
            ]);
        } else {
            $matchedUser = User::where('email', $application->email)
                ->orWhere('phone', $application->phone)
                ->first();

            if ($matchedUser) {
                $matchedUser->update(['is_verified' => true, 'is_active' => true]);
                Professional::where('user_id', $matchedUser->id)->update([
                    'is_verified' => true,
                    'verification_status' => 'verified',
                    'biometric_status' => 'verified',
                    'rejection_reason' => null,
                ]);
                $application->update(['user_id' => $matchedUser->id]);
                $techUserId = $matchedUser->id;
            }
        }

        if ($techUserId) {
            \App\Models\Notification::sendToUser(
                $techUserId,
                'kyc_approved',
                'Technician Credentials Approved! 🎉',
                "Congratulations {$application->name}! Your FixMate technician profile and biometrics are officially verified. You can now accept customer jobs and receive payouts.",
                route('technician.dashboard')
            );
        }

        \App\Models\Notification::notifyAdmins(
            'kyc_approved_admin',
            'Technician Approved: ' . $application->name,
            "Application #{$application->reference_no} verified by " . (auth()->user()?->name ?? 'Admin'),
            route('admin.technicians.verification')
        );

        return redirect()->route('admin.technicians.verification')
            ->with('success', "Technician {$application->name} (#{$application->reference_no}) approved as verified partner!");
    }

    /**
     * Return technician application for revision/correction (data goes back to technician to fix).
     */
    public function returnApplication(Request $request, TechnicianApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'reason.min' => 'Please provide at least 5 characters explaining what needs revision.',
        ]);

        $reason = trim($validated['reason']);

        $application->update([
            'status' => 'returned',
            'rejection_reason' => $reason,
            'admin_notes' => $reason,
            'reviewed_at' => now(),
        ]);

        $techUserId = $application->user_id;
        if (! $techUserId) {
            $matchedUser = User::where('email', $application->email)
                ->orWhere('phone', $application->phone)
                ->first();
            $techUserId = $matchedUser?->id;
        }

        if ($techUserId) {
            // Keep user active so they can access their portal to update documents and resubmit
            User::where('id', $techUserId)->update([
                'is_verified' => false,
                'is_active' => true,
            ]);
            Professional::where('user_id', $techUserId)->update([
                'is_verified' => false,
                'verification_status' => 'returned',
                'rejection_reason' => $reason,
            ]);

            \App\Models\Notification::sendToUser(
                $techUserId,
                'kyc_returned',
                'Verification Returned for Revision ⚠️',
                "Your application #{$application->reference_no} was returned for revision: {$reason}. Please review the feedback, update your documents, and resubmit.",
                route('technician.verification')
            );
        }

        \App\Models\Notification::notifyAdmins(
            'kyc_returned_admin',
            'Technician Application Returned: ' . $application->name,
            "Application #{$application->reference_no} returned to candidate for revision: {$reason}",
            route('admin.technicians.verification')
        );

        return redirect()->route('admin.technicians.verification')
            ->with('success', "Application #{$application->reference_no} returned to technician for document revision.");
    }

    /**
     * Reject technician partner application and block their profile.
     */
    public function reject(Request $request, TechnicianApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'reason.min' => 'Please provide at least 5 characters explaining why the application is being rejected.',
        ]);

        $reason = trim($validated['reason']);

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'biometric_status' => 'rejected',
            'admin_notes' => $reason,
            'reviewed_at' => now(),
        ]);

        $techUserId = $application->user_id;
        if (! $techUserId) {
            $matchedUser = User::where('email', $application->email)
                ->orWhere('phone', $application->phone)
                ->first();
            $techUserId = $matchedUser?->id;
        }

        if ($techUserId) {
            // Block technician profile
            User::where('id', $techUserId)->update([
                'is_verified' => false,
                'is_active' => false,
            ]);
            Professional::where('user_id', $techUserId)->update([
                'is_verified' => false,
                'verification_status' => 'rejected',
                'biometric_status' => 'rejected',
                'rejection_reason' => $reason,
            ]);

            \App\Models\Notification::sendToUser(
                $techUserId,
                'kyc_rejected',
                'Profile Blocked: Verification Rejected 🚫',
                "Your technician profile (#{$application->reference_no}) has been blocked. Reason: {$reason}. Please contact the FixMate team for assistance.",
                route('contact')
            );
        }

        \App\Models\Notification::notifyAdmins(
            'kyc_rejected_admin',
            'Technician Profile Blocked: ' . $application->name,
            "Application #{$application->reference_no} rejected and profile blocked: {$reason}",
            route('admin.technicians.verification')
        );

        return redirect()->route('admin.technicians.verification')
            ->with('success', "Application #{$application->reference_no} rejected and technician profile has been blocked.");
    }

    /**
     * Mark application under review.
     */
    public function review(TechnicianApplication $application): RedirectResponse
    {
        $application->update([
            'status' => 'under_review',
        ]);

        return redirect()->route('admin.technicians.verification')
            ->with('success', "Application #{$application->reference_no} moved to Under Review.");
    }
}
