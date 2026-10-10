<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\ContactInquiryResource;
use App\Models\ContactInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InquiryController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = ContactInquiry::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('reference_no', 'like', $term)
                    ->orWhere('name', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('city', 'like', $term)
                    ->orWhere('message', 'like', $term);
            });
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $inquiries = $query->latest()->paginate($perPage);

        return $this->ok(ContactInquiryResource::collection($inquiries->items()), 'Inquiries retrieved.', [
            'current_page' => $inquiries->currentPage(),
            'per_page' => $inquiries->perPage(),
            'total' => $inquiries->total(),
            'last_page' => $inquiries->lastPage(),
            'stats' => [
                'total' => ContactInquiry::count(),
                'new' => ContactInquiry::where('status', 'new')->count(),
                'in_progress' => ContactInquiry::where('status', 'in_progress')->count(),
                'resolved' => ContactInquiry::where('status', 'resolved')->count(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'department' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:3000'],
            'status' => ['required', 'string', 'in:new,in_progress,resolved,closed'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
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
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return $this->created(new ContactInquiryResource($inquiry), "Inquiry #{$ref} logged successfully!");
    }

    public function update(Request $request, ContactInquiry $inquiry): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,in_progress,resolved,closed'],
            'admin_notes' => ['nullable', 'string', 'max:3000'],
            'department' => ['nullable', 'string', 'max:50'],
        ]);

        $inquiry->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'department' => $validated['department'] ?? $inquiry->department,
        ]);

        return $this->ok(new ContactInquiryResource($inquiry->fresh()), "Inquiry #{$inquiry->reference_no} updated successfully!");
    }

    public function destroy(ContactInquiry $inquiry): JsonResponse
    {
        $ref = $inquiry->reference_no;
        $inquiry->delete();

        return $this->ok(null, "Inquiry #{$ref} has been deleted.");
    }
}
