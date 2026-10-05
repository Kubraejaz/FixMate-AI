<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BecomeTechnicianController extends Controller
{
    /**
     * Display public technician partner landing page with live trade data.
     */
    public function index(): View
    {
        $professions = Profession::where('is_active', true)
            ->withCount('professionals')
            ->get();

        $totalVerifiedTechnicians = Professional::where('is_verified', true)->count();
        if ($totalVerifiedTechnicians === 0) {
            $totalVerifiedTechnicians = Professional::count();
        }

        $cities = [
            'Karachi',
            'Lahore',
            'Islamabad',
            'Rawalpindi',
            'Faisalabad',
            'Multan',
            'Peshawar',
        ];

        return view('Frontend.public.become-technician', [
            'professions' => $professions,
            'totalVerifiedTechnicians' => $totalVerifiedTechnicians,
            'cities' => $cities,
        ]);
    }

    /**
     * Handle submission of partner application form.
     */
    public function store(Request $request): RedirectResponse
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
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'phone.regex' => 'Please enter a valid mobile contact number.',
            'cnic_number.regex' => 'Please enter a valid 13-digit Pakistani CNIC number (e.g. 42101-1234567-1).',
            'experience_years.between' => 'Experience years must be between 0 and 50.',
        ]);

        do {
            $ref = 'FM-APP-' . rand(1000, 9999);
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
            'documents_list' => !empty($validated['documents_list']) ? trim($validated['documents_list']) : 'CNIC, Police Clearance',
            'status' => 'pending',
            'user_id' => $request->user()?->id,
        ]);

        \App\Models\Notification::notifyAdmins(
            'technician_registered',
            'New Technician KYC Registration: ' . $application->name,
            "{$application->name} has submitted KYC documents for review (Ref: #{$ref}, City: {$application->city}).",
            route('admin.technicians.verification')
        );

        if ($request->user()) {
            \App\Models\Notification::sendToUser(
                $request->user()->id,
                'kyc_submitted',
                'Technician Application Received! 📋',
                "Your partner verification application #{$ref} is in queue for document & biometric inspection.",
                route('technician.dashboard')
            );
        }

        return redirect()->route('become-technician')
            ->with('success_application', "Your technician partner application #{$ref} has been received! Our inspector team will contact you within 24 hours for skill & NADRA biometric scheduling.")
            ->with('app_ref', $ref);
    }
}
