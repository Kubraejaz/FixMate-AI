<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\ProfessionResource;
use App\Http\Resources\TechnicianApplicationResource;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TechnicianVerificationController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = TechnicianApplication::with(['profession', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('profession_id')) {
            $query->where('profession_id', $request->input('profession_id'));
        }

        if ($request->filled('search')) {
            $term = '%'.trim($request->input('search')).'%';
            $query->where(function ($q) use ($term) {
                $q->where('reference_no', 'like', $term)
                    ->orWhere('name', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('cnic_number', 'like', $term)
                    ->orWhere('email', 'like', $term);
            });
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $applications = $query->latest()->paginate($perPage);

        $stats = [
            'total' => TechnicianApplication::count(),
            'pending' => TechnicianApplication::where('status', 'pending')->count(),
            'under_review' => TechnicianApplication::where('status', 'under_review')->count(),
            'approved' => TechnicianApplication::where('status', 'approved')->count(),
            'returned' => TechnicianApplication::where('status', 'returned')->count(),
            'rejected' => TechnicianApplication::where('status', 'rejected')->count(),
        ];

        return $this->ok(TechnicianApplicationResource::collection($applications->items()), 'Applications retrieved.', [
            'current_page' => $applications->currentPage(),
            'per_page' => $applications->perPage(),
            'total' => $applications->total(),
            'last_page' => $applications->lastPage(),
            'stats' => $stats,
            'professions' => ProfessionResource::collection(Profession::where('is_active', true)->get()),
        ]);
    }

    public function approve(Request $request, TechnicianApplication $application): JsonResponse
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
            Notification::sendToUser(
                $techUserId,
                'kyc_approved',
                'Technician Credentials Approved!',
                "Congratulations {$application->name}! Your FixMate technician profile and biometrics are officially verified. You can now accept customer jobs and receive payouts.",
                null
            );
        }

        return $this->ok(
            new TechnicianApplicationResource($application->fresh(['profession', 'user'])),
            "Technician {$application->name} (#{$application->reference_no}) approved as verified partner!"
        );
    }

    public function returnApplication(Request $request, TechnicianApplication $application): JsonResponse
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
            $techUserId = User::where('email', $application->email)
                ->orWhere('phone', $application->phone)
                ->first()?->id;
        }

        if ($techUserId) {
            User::where('id', $techUserId)->update(['is_verified' => false, 'is_active' => true]);
            Professional::where('user_id', $techUserId)->update([
                'is_verified' => false,
                'verification_status' => 'returned',
                'rejection_reason' => $reason,
            ]);

            Notification::sendToUser(
                $techUserId,
                'kyc_returned',
                'Verification Returned for Revision',
                "Your application #{$application->reference_no} was returned for revision: {$reason}. Please review the feedback, update your documents, and resubmit.",
                null
            );
        }

        return $this->ok(
            new TechnicianApplicationResource($application->fresh(['profession', 'user'])),
            "Application #{$application->reference_no} returned to technician for document revision."
        );
    }

    public function reject(Request $request, TechnicianApplication $application): JsonResponse
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
            $techUserId = User::where('email', $application->email)
                ->orWhere('phone', $application->phone)
                ->first()?->id;
        }

        if ($techUserId) {
            User::where('id', $techUserId)->update(['is_verified' => false, 'is_active' => false]);
            Professional::where('user_id', $techUserId)->update([
                'is_verified' => false,
                'verification_status' => 'rejected',
                'biometric_status' => 'rejected',
                'rejection_reason' => $reason,
            ]);

            Notification::sendToUser(
                $techUserId,
                'kyc_rejected',
                'Profile Blocked: Verification Rejected',
                "Your technician profile (#{$application->reference_no}) has been blocked. Reason: {$reason}. Please contact the FixMate team for assistance.",
                null
            );
        }

        return $this->ok(
            new TechnicianApplicationResource($application->fresh(['profession', 'user'])),
            "Application #{$application->reference_no} rejected and technician profile has been blocked."
        );
    }

    public function review(TechnicianApplication $application): JsonResponse
    {
        $application->update(['status' => 'under_review']);

        return $this->ok(
            new TechnicianApplicationResource($application->fresh(['profession', 'user'])),
            "Application #{$application->reference_no} moved to Under Review."
        );
    }
}
