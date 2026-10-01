<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InquiryController extends Controller
{
    /**
     * Display all contact inquiries with filters and stats.
     */
    public function index(Request $request): View
    {
        $query = ContactInquiry::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('reference_no', 'like', $term)
                  ->orWhere('name', 'like', $term)
                  ->orWhere('phone', 'like', $term)
                  ->orWhere('city', 'like', $term)
                  ->orWhere('message', 'like', $term);
            });
        }

        $inquiries = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => ContactInquiry::count(),
            'new' => ContactInquiry::where('status', 'new')->count(),
            'in_progress' => ContactInquiry::where('status', 'in_progress')->count(),
            'resolved' => ContactInquiry::where('status', 'resolved')->count(),
        ];

        return view('Frontend.admin.inquiries', compact('inquiries', 'stats'));
    }

    /**
     * Create an inquiry manually from admin console.
     */
    public function store(Request $request): RedirectResponse
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
            $ref = 'FM-INQ-' . strtoupper(Str::random(6));
        } while (ContactInquiry::where('reference_no', $ref)->exists());

        ContactInquiry::create([
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

        return redirect()->route('admin.inquiries')
            ->with('success', "Inquiry #{$ref} logged successfully!");
    }

    /**
     * Update status and notes for an inquiry.
     */
    public function update(Request $request, ContactInquiry $inquiry): RedirectResponse
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

        return redirect()->route('admin.inquiries')
            ->with('success', "Inquiry #{$inquiry->reference_no} updated successfully!");
    }

    /**
     * Delete an inquiry record.
     */
    public function destroy(ContactInquiry $inquiry): RedirectResponse
    {
        $ref = $inquiry->reference_no;
        $inquiry->delete();

        return redirect()->route('admin.inquiries')
            ->with('success', "Inquiry #{$ref} has been deleted.");
    }
}
