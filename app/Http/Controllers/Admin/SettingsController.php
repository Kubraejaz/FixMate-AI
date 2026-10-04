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
        $fields = [
            'platform_commission',
            'otp_expiry_minutes',
            'max_service_radius_km',
            'maintenance_mode',
            'payout_frequency',
            'support_email',
            'support_phone',
            'gemini_api_key',
            'gemini_model',
            'gemini_enabled',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                cache()->forever($field, $request->input($field));
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
