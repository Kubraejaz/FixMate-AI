<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display public contact page with optional tracking lookup and user inquiry history.
     */
    public function index(Request $request): View
    {
        $trackedInquiry = null;
        $trackError = null;

        if ($request->filled('track_ref')) {
            $term = trim($request->input('track_ref'));

            $trackedInquiry = ContactInquiry::where('reference_no', $term)
                ->orWhere('reference_no', strtoupper($term))
                ->orWhere('phone', $term)
                ->latest()
                ->first();

            if (! $trackedInquiry) {
                $trackError = "No support inquiry was found for '{$term}'. Please verify your reference code (e.g. FM-INQ-XXXXXX) or registered phone number.";
            }
        }

        $userInquiries = collect();
        if (auth()->check()) {
            $user = auth()->user();
            $userInquiries = ContactInquiry::where(function ($q) use ($user) {
                if (! empty($user->email)) {
                    $q->orWhere('email', strtolower($user->email));
                }
                if (! empty($user->phone)) {
                    $q->orWhere('phone', $user->phone);
                }
            })->latest()->take(6)->get();
        }

        return view('Frontend.public.contact', compact('trackedInquiry', 'trackError', 'userInquiries'));
    }

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

        return redirect()->to(route('contact') . '#inquiry-form')->with([
            'success_inquiry' => "Thank you, {$inquiry->name}! Your inquiry has been dispatched to our support team.",
            'inquiry_ref' => $inquiry->reference_no,
        ]);
    }
}
