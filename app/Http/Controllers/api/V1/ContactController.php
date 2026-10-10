<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ContactInquiryResource;
use App\Models\ContactInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends ApiController
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'department' => ['required', 'string', 'in:general,booking,emergency,escrow,technician,corporate,partnership'],
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        do {
            $ref = 'FM-INQ-'.strtoupper(Str::random(6));
        } while (ContactInquiry::where('reference_no', $ref)->exists());

        $inquiry = ContactInquiry::create([
            'reference_no' => $ref,
            'department' => $validated['department'],
            'name' => trim($validated['name']),
            'phone' => trim($validated['phone']),
            'email' => ! empty($validated['email']) ? strtolower(trim($validated['email'])) : null,
            'city' => trim($validated['city']),
            'message' => trim($validated['message']),
            'status' => 'new',
        ]);

        return $this->created(new ContactInquiryResource($inquiry), 'Your inquiry has been dispatched to our support team.');
    }

    public function track(Request $request): JsonResponse
    {
        $request->validate([
            'reference' => ['required', 'string', 'max:100'],
        ]);

        $term = trim($request->input('reference'));

        $inquiry = ContactInquiry::where('reference_no', $term)
            ->orWhere('reference_no', strtoupper($term))
            ->orWhere('phone', $term)
            ->latest()
            ->first();

        if (! $inquiry) {
            return $this->error("No support inquiry was found for '{$term}'. Please verify your reference code or phone number.", 404);
        }

        return $this->ok(new ContactInquiryResource($inquiry), 'Inquiry status retrieved.');
    }
}
