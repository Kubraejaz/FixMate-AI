<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display Platform Settings configuration console.
     */
    public function settings(): View
    {
        $settings = [
            'platform_commission' => cache('platform_commission', 12.0),
            'otp_expiry_minutes' => cache('otp_expiry_minutes', 10),
            'max_service_radius_km' => cache('max_service_radius_km', 25),
            'maintenance_mode' => cache('maintenance_mode', false),
            'payout_frequency' => cache('payout_frequency', 'weekly'),
            'support_email' => cache('support_email', 'support@fixmate.ai'),
            'support_phone' => cache('support_phone', '+92 300 1234567'),
            'gemini_api_key' => cache('gemini_api_key', config('services.gemini.api_key', env('GEMINI_API_KEY', ''))),
            'gemini_model' => cache('gemini_model', config('services.gemini.model', env('GEMINI_MODEL', 'gemini-1.5-flash'))),
            'gemini_enabled' => cache('gemini_enabled', true),
        ];

        return view('Frontend.admin.settings', compact('settings'));
    }

    /**
     * Save Platform Settings.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform_commission' => ['nullable', 'numeric', 'between:0,100'],
            'otp_expiry_minutes' => ['nullable', 'integer', 'between:1,60'],
            'max_service_radius_km' => ['nullable', 'numeric', 'between:1,200'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'payout_frequency' => ['nullable', 'string', 'in:daily,weekly,bi-weekly,monthly'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'support_phone' => ['nullable', 'string', 'max:30'],
            'gemini_api_key' => ['nullable', 'string', 'max:255'],
            'gemini_model' => ['nullable', 'string', 'max:100'],
            'gemini_enabled' => ['nullable', 'boolean'],
        ], [
            'platform_commission.between' => 'Platform commission percentage must be between 0% and 100%.',
            'otp_expiry_minutes.between' => 'OTP expiry duration must be between 1 and 60 minutes.',
            'support_email.email' => 'Please enter a valid support email address.',
        ]);

        foreach ($validated as $field => $value) {
            if ($value !== null) {
                cache()->forever($field, $value);
            }
        }

        return back()->with('success', 'Platform settings saved successfully.');
    }

    /**
     * Test connection to Google Gemini API.
     */
    public function testGemini(Request $request): RedirectResponse
    {
        $apiKey = $request->input('gemini_api_key') ?: cache('gemini_api_key') ?: config('services.gemini.api_key');
        
        $gemini = app(\App\Services\GeminiAiService::class);
        $result = $gemini->testConnection($apiKey);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Display Escrow & Settlements financial console.
     */
    public function payments(): View
    {
        $totalCustomers = User::where('user_type', User::TYPE_CUSTOMER)->count();
        $totalTechnicians = Professional::count();

        $escrowHeld = 8600;
        $settledThisMonth = 425000;
        $netCommission = round($settledThisMonth * 0.12);

        $transactions = collect([
            [
                'reference' => 'TX-90281',
                'booking_id' => '#FM-09942',
                'type' => 'Escrow Release',
                'amount' => 3200,
                'fee' => 384,
                'technician' => 'Imran Shah',
                'customer' => 'Dr. Kamran Malik',
                'status' => 'Settled',
                'date' => 'Yesterday, 4:15 PM',
            ],
            [
                'reference' => 'TX-90240',
                'booking_id' => '#FM-09750',
                'type' => 'Escrow Release',
                'amount' => 1500,
                'fee' => 180,
                'technician' => 'Riaz Ahmed',
                'customer' => 'Ayesha Khan',
                'status' => 'Settled',
                'date' => '3 days ago',
            ],
            [
                'reference' => 'TX-90199',
                'booking_id' => '#FM-10245',
                'type' => 'Escrow Hold',
                'amount' => 1200,
                'fee' => 144,
                'technician' => 'Ali Khan',
                'customer' => 'Ayesha Khan',
                'status' => 'Held in Escrow',
                'date' => 'Today, 10:30 AM',
            ],
        ]);

        return view('Frontend.admin.payments', compact(
            'escrowHeld',
            'settledThisMonth',
            'netCommission',
            'transactions',
            'totalCustomers',
            'totalTechnicians'
        ));
    }
}
