<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Models\Booking;
use App\Models\Professional;
use App\Models\User;
use App\Services\GeminiAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends ApiController
{
    public function settings(): JsonResponse
    {
        return $this->ok([
            'platform_commission' => cache('platform_commission', 12.0),
            'otp_expiry_minutes' => cache('otp_expiry_minutes', 10),
            'max_service_radius_km' => cache('max_service_radius_km', 25),
            'maintenance_mode' => (bool) cache('maintenance_mode', false),
            'payout_frequency' => cache('payout_frequency', 'weekly'),
            'support_email' => cache('support_email', 'support@fixmate.ai'),
            'support_phone' => cache('support_phone', '+92 300 1234567'),
            'gemini_model' => cache('gemini_model', config('services.gemini.model', env('GEMINI_MODEL', 'gemini-1.5-flash'))),
            'gemini_enabled' => (bool) cache('gemini_enabled', true),
            'has_gemini_key' => ! empty(cache('gemini_api_key', config('services.gemini.api_key', env('GEMINI_API_KEY', '')))),
        ], 'Settings retrieved.');
    }

    public function updateSettings(Request $request): JsonResponse
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

        return $this->ok(null, 'Platform settings saved successfully.');
    }

    public function testGemini(Request $request): JsonResponse
    {
        $apiKey = $request->input('gemini_api_key') ?: cache('gemini_api_key') ?: config('services.gemini.api_key');

        $result = app(GeminiAiService::class)->testConnection($apiKey);

        if (! ($result['success'] ?? false)) {
            return $this->error($result['message'] ?? 'Gemini connection failed.', 422);
        }

        return $this->ok($result, $result['message'] ?? 'Gemini connection successful.');
    }

    public function payments(): JsonResponse
    {
        $escrowHeld = (int) Booking::whereIn('payment_status', ['escrow_held', 'cash_on_delivery'])
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->sum('total_price');

        $settledThisMonth = (int) Booking::where('status', 'completed')
            ->whereBetween('completed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_price');

        $commissionRate = (float) cache('platform_commission', 12.0);
        $netCommission = (int) round($settledThisMonth * ($commissionRate / 100));

        $transactions = Booking::with(['professional', 'user'])
            ->whereIn('payment_status', ['escrow_held', 'cash_on_delivery', 'escrow_released'])
            ->latest()
            ->take(20)
            ->get()
            ->map(fn (Booking $b) => [
                'booking_number' => $b->booking_number,
                'type' => $b->payment_status === 'escrow_released' ? 'Escrow Release' : 'Escrow Hold',
                'amount' => (int) $b->total_price,
                'fee' => (int) round($b->total_price * ($commissionRate / 100)),
                'technician' => $b->professional?->name,
                'customer' => $b->user?->name,
                'status' => $b->payment_status,
                'date' => optional($b->updated_at)->toIso8601String(),
            ]);

        return $this->ok([
            'summary' => [
                'escrow_held' => $escrowHeld,
                'settled_this_month' => $settledThisMonth,
                'net_commission' => $netCommission,
                'commission_rate' => $commissionRate,
                'total_customers' => User::where('user_type', User::TYPE_CUSTOMER)->count(),
                'total_technicians' => Professional::count(),
            ],
            'transactions' => $transactions,
        ], 'Payments retrieved.');
    }
}
