<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\ProfessionalResource;
use App\Http\Resources\TechnicianApplicationResource;
use App\Http\Resources\UserResource;
use App\Models\Notification;
use App\Models\TechnicianApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends TechnicianController
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $pro = $this->professional();

        $application = TechnicianApplication::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->orWhere('phone', $user->phone)
            ->latest()
            ->first();

        return $this->ok([
            'user' => new UserResource($user),
            'professional' => new ProfessionalResource($pro->load('profession')),
            'application' => $application ? new TechnicianApplicationResource($application->load(['profession', 'user'])) : null,
            'verification_status' => $pro->verification_status ?? 'pending',
            'is_verified' => (bool) ($user->is_verified || $pro->is_verified),
        ], 'Verification status retrieved.');
    }

    public function submit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cnic_number' => ['required', 'string', 'max:25', 'regex:/^\d{5}-?\d{7}-?\d{1}$/'],
            'experience' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:50'],
            'emergency_contact_name' => ['nullable', 'string', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'cnic_front' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'cnic_back' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'biometric_selfie' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'police_certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'trade_license' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'proof_of_address' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
        ], [
            'cnic_number.regex' => 'Please enter a valid 13-digit Pakistani CNIC number (e.g. 42101-1234567-1).',
            'emergency_contact_name.regex' => 'Please enter a valid name for your emergency contact.',
            'emergency_contact_phone.regex' => 'Please enter a valid emergency contact phone number.',
        ]);

        $user = $request->user();
        $pro = $this->professional();

        if ($user->is_active === false || $pro->verification_status === 'rejected') {
            return $this->error('Your technician profile has been blocked. Please contact the FixMate team for assistance.', 403);
        }

        $userUpdates = ['cnic_number' => $validated['cnic_number']];
        if (! empty($validated['experience'])) {
            $userUpdates['experience'] = $validated['experience'];
        }
        if (! empty($validated['city'])) {
            $userUpdates['city'] = $validated['city'];
        }
        $user->update($userUpdates);

        $proUpdates = [
            'cnic_number' => $validated['cnic_number'],
            'verification_status' => 'under_review',
            'rejection_reason' => null,
        ];
        if (! empty($validated['experience'])) {
            $proUpdates['experience'] = $validated['experience'];
        }
        if (! empty($validated['emergency_contact_name'])) {
            $proUpdates['emergency_contact_name'] = $validated['emergency_contact_name'];
        }
        if (! empty($validated['emergency_contact_phone'])) {
            $proUpdates['emergency_contact_phone'] = $validated['emergency_contact_phone'];
        }

        $fileMap = [
            'cnic_front' => 'cnic_front_path',
            'cnic_back' => 'cnic_back_path',
            'biometric_selfie' => 'biometric_selfie_path',
            'police_certificate' => 'police_certificate_path',
            'trade_license' => 'trade_license_path',
            'proof_of_address' => 'proof_of_address_path',
        ];

        foreach ($fileMap as $field => $column) {
            if ($request->hasFile($field)) {
                $proUpdates[$column] = $request->file($field)->store('technician_documents', 'public');
            }
        }

        if (! empty($proUpdates['biometric_selfie_path'])) {
            $proUpdates['biometric_status'] = 'submitted';
        }

        $pro->update($proUpdates);

        $app = TechnicianApplication::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->orWhere('phone', $user->phone)
            ->latest()
            ->first();

        $appData = [
            'user_id' => $user->id,
            'profession_id' => $pro->profession_id ?: 1,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '+923000000000',
            'cnic_number' => $validated['cnic_number'],
            'city' => $validated['city'] ?? ($user->city ?? 'Karachi'),
            'status' => 'under_review',
            'rejection_reason' => null,
        ];

        foreach ($fileMap as $column) {
            if (! empty($proUpdates[$column])) {
                $appData[$column] = $proUpdates[$column];
            }
        }
        if (! empty($proUpdates['biometric_status'])) {
            $appData['biometric_status'] = $proUpdates['biometric_status'];
        }
        if (! empty($proUpdates['emergency_contact_name'])) {
            $appData['emergency_contact_name'] = $proUpdates['emergency_contact_name'];
        }
        if (! empty($proUpdates['emergency_contact_phone'])) {
            $appData['emergency_contact_phone'] = $proUpdates['emergency_contact_phone'];
        }

        if ($app) {
            $app->update($appData);
        } else {
            $appData['reference_no'] = 'FM-APP-'.rand(1000, 9999);
            $appData['experience_years'] = (int) filter_var($validated['experience'] ?? '3', FILTER_SANITIZE_NUMBER_INT) ?: 3;
            $app = TechnicianApplication::create($appData);
        }

        Notification::notifyAdmins(
            'kyc_submitted',
            "KYC & Biometrics Submitted: {$user->name}",
            "Technician {$user->name} ({$pro->profession?->name}) uploaded CNIC, live biometric photo, and trade credentials for review.",
            null
        );

        Notification::sendToUser(
            $user->id,
            'kyc_under_review',
            'KYC & Biometrics Submitted',
            'Your verification dossier and biometric selfie have been received and are currently under review by FixMate compliance officers.',
            null
        );

        return $this->ok([
            'professional' => new ProfessionalResource($pro->fresh('profession')),
            'application' => new TechnicianApplicationResource($app->fresh(['profession', 'user'])),
        ], 'Your verification documents have been uploaded and submitted for Admin verification.');
    }
}
