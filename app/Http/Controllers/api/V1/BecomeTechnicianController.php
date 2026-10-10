<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\TechnicianApplicationResource;
use App\Models\Notification;
use App\Models\TechnicianApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BecomeTechnicianController extends ApiController
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'email' => ['required', 'email', 'max:255'],
            'cnic_number' => ['required', 'string', 'max:25', 'regex:/^\d{5}-?\d{7}-?\d{1}$/'],
            'profession_id' => ['required', 'exists:professions,id'],
            'city' => ['required', 'string', 'max:100'],
            'experience_years' => ['required', 'integer', 'between:0,50'],
            'workshop_type' => ['required', 'string', 'in:freelancer,independent_workshop,company_employed'],
            'tools_available' => ['required', 'string', 'in:has_own_tools,basic_tools,needs_tool_support'],
            'documents_list' => ['nullable', 'string', 'max:255'],
        ]);

        do {
            $ref = 'FM-APP-'.rand(1000, 9999);
        } while (TechnicianApplication::where('reference_no', $ref)->exists());

        $application = TechnicianApplication::create([
            'reference_no' => $ref,
            'profession_id' => $validated['profession_id'],
            'name' => trim($validated['name']),
            'phone' => trim($validated['phone']),
            'email' => strtolower(trim($validated['email'])),
            'cnic_number' => trim($validated['cnic_number']),
            'city' => $validated['city'],
            'experience_years' => $validated['experience_years'],
            'workshop_type' => $validated['workshop_type'],
            'tools_available' => $validated['tools_available'],
            'documents_list' => ! empty($validated['documents_list']) ? trim($validated['documents_list']) : 'CNIC, Police Clearance',
            'status' => 'pending',
            'user_id' => $request->user()?->id,
        ]);

        Notification::notifyAdmins(
            'technician_registered',
            'New Technician KYC Registration: '.$application->name,
            "{$application->name} has submitted KYC documents for review (Ref: #{$ref}, City: {$application->city}).",
            route('admin.technicians.verification')
        );

        if ($request->user()) {
            Notification::sendToUser(
                $request->user()->id,
                'kyc_submitted',
                'Technician Application Received! 📋',
                "Your partner verification application #{$ref} is in queue for document & biometric inspection.",
                route('technician.dashboard')
            );
        }

        return $this->created([
            'reference_no' => $ref,
            'application' => new TechnicianApplicationResource($application),
        ], 'Your technician partner application has been received.');
    }
}
