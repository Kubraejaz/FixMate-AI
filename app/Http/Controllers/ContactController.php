<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Handle public contact form inquiry submission.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        // Generate unique inquiry reference code
        do {
            $ref = 'FM-INQ-' . strtoupper(Str::random(6));
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

        return redirect()->to(url('/contact') . '#inquiry-form')->with([
            'success_inquiry' => "Thank you, {$inquiry->name}! Your inquiry has been dispatched to our support team.",
            'inquiry_ref' => $inquiry->reference_no,
        ]);
    }
}
