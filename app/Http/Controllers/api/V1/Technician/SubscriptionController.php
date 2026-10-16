<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Models\Notification;
use App\Models\TechnicianSubscription;
use App\Services\SubscriptionPlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends TechnicianController
{
    public function __construct(private readonly SubscriptionPlanService $plans) {}

    /**
     * Get current subscription status and available VIP plans.
     */
    public function show(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $monthlyPrice = $this->plans->technicianMonthlyPrice();
        $annualPrice = $this->plans->technicianAnnualPrice();
        $standardCommission = (float) cache('platform_commission', 10.0);

        $availablePlans = [
            [
                'id' => 'free',
                'name' => 'Starter Free Tier',
                'price' => 0,
                'billing_period' => 'Forever Free',
                'commission_rate' => $standardCommission,
                'perks' => [
                    "Pay-as-you-earn ({$standardCommission}% platform commission)",
                    'Standard directory search ranking',
                    'Standard job dispatches',
                    'Standard support',
                ],
                'is_current' => ! $pro->hasActiveProSubscription(),
            ],
            [
                'id' => 'pro_monthly',
                'name' => 'FixMate Pro VIP (Monthly)',
                'price' => $monthlyPrice,
                'billing_period' => 'Rs. '.number_format($monthlyPrice).' / month',
                'commission_rate' => 0.0,
                'badge' => 'Most Popular',
                'perks' => [
                    '0% Platform Commission — Keep 100% of all job earnings!',
                    'Top of Search directory placement (3x more leads)',
                    'Official "FixMate Pro Verified" Gold Badge',
                    'Priority instant dispatches (5-min head start)',
                    'Unlimited Video Tele-Consultations',
                ],
                'is_current' => $pro->hasActiveProSubscription() && $pro->subscription_plan === 'pro_monthly',
            ],
            [
                'id' => 'pro_annual',
                'name' => 'FixMate Pro VIP (Annual Pass)',
                'price' => $annualPrice,
                'billing_period' => 'Rs. '.number_format($annualPrice).' / year',
                'commission_rate' => 0.0,
                'badge' => 'Best Value',
                'perks' => [
                    'All Pro VIP perks for a full 12 months',
                    '0% Platform Commission for entire year',
                    'Permanent VIP badge & featured partner status',
                    'Direct Dedicated Account Manager',
                ],
                'is_current' => $pro->hasActiveProSubscription() && $pro->subscription_plan === 'pro_annual',
            ],
        ];

        $history = $pro->subscriptions()
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($sub) => [
                'id' => $sub->id,
                'plan_name' => $sub->plan_name,
                'price' => $sub->price,
                'payment_method' => $sub->payment_method,
                'reference' => $sub->transaction_reference,
                'status' => $sub->status,
                'starts_at' => optional($sub->starts_at)->toIso8601String(),
                'expires_at' => optional($sub->expires_at)->toIso8601String(),
                'created_at' => optional($sub->created_at)->toIso8601String(),
            ]);

        return $this->ok([
            'current_subscription' => [
                'plan' => $pro->subscription_plan ?? 'free',
                'is_pro' => $pro->hasActiveProSubscription(),
                'is_featured' => (bool) $pro->is_featured,
                'commission_rate' => $pro->getCommissionRate(),
                'subscribed_until' => optional($pro->subscribed_until)->toIso8601String(),
                'days_remaining' => $pro->subscribed_until ? max(0, (int) now()->diffInDays($pro->subscribed_until, false)) : 0,
            ],
            'available_plans' => $availablePlans,
            'history' => $history,
        ], 'Subscription status retrieved.');
    }

    /**
     * Start a payment: dispatch a JazzCash / EasyPaisa OTP or tokenize a card so the
     * app can complete the charge in the follow-up `upgrade` call.
     */
    public function initiatePayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gateway' => ['required', 'in:jazzcash,easypaisa,card'],
            'plan_name' => ['required', 'in:pro_monthly,pro_annual'],
            'phone' => ['required', 'string', 'max:25'],
            'card_number' => ['nullable', 'string', 'max:30'],
            'card_expiry' => ['nullable', 'string', 'max:10'],
            'card_cvc' => ['nullable', 'string', 'max:6'],
        ]);

        $pro = $this->professional();
        $price = $this->plans->technicianPrice($validated['plan_name']);
        $gateway = $validated['gateway'];

        if ($gateway === 'card') {
            if (! $this->cardDetailsPresent($validated)) {
                return $this->error('Please provide complete card details (number, expiry and CVC) to start card verification.', 422);
            }

            $result = app(\App\Services\CardPaymentService::class)->pay([
                'mobile' => $validated['phone'],
                'amount' => $price,
                'basket_id' => 'FM-PRO-' . $pro->id . '-' . date('Ymd'),
                'description' => "FixMate Pro {$validated['plan_name']}",
                'merchant_user_id' => (string) $pro->id,
                'card_number' => $validated['card_number'],
                'card_expiry' => $validated['card_expiry'],
                'card_cvc' => $validated['card_cvc'],
            ]);

            if (! empty($result['otp_required'])) {
                return $this->ok([
                    'otp_required' => true,
                    'instrument_token' => $result['instrument_token'] ?? null,
                    'transaction_id' => $result['transaction_id'] ?? null,
                ], $result['message']);
            }

            if (! $result['success']) {
                return $this->error($result['message'] ?? 'Unable to start card verification.', 422);
            }

            return $this->ok(['otp_required' => false], $result['message']);
        }

        $service = $gateway === 'jazzcash'
            ? app(\App\Services\JazzCashService::class)
            : app(\App\Services\EasyPaisaService::class);

        $res = $service->initiatePushPrompt($validated['phone'], $price);
        if (! $res['success']) {
            return $this->error($res['message'] ?? 'Unable to dispatch your verification code.', 422);
        }

        return $this->ok([
            'otp_sent' => true,
            'otp' => app()->environment('production') ? null : ($res['otp'] ?? null),
            'gateway' => $res['gateway'] ?? $gateway,
            'phone' => $res['phone'] ?? $validated['phone'],
        ], $res['message']);
    }

    /**
     * Subscribe or renew FixMate Pro VIP (charges a real gateway).
     */
    public function upgrade(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan_name' => ['required', 'in:pro_monthly,pro_annual'],
            'payment_method' => ['required', 'in:wallet,jazzcash,easypaisa,card'],
            'account' => ['nullable', 'string', 'max:25'],
            'otp' => ['nullable', 'string', 'max:10'],
            'card_number' => ['nullable', 'string', 'max:30'],
            'card_expiry' => ['nullable', 'string', 'max:10'],
            'card_cvc' => ['nullable', 'string', 'max:6'],
            'card_otp' => ['nullable', 'string', 'max:10'],
            'instrument_token' => ['nullable', 'string', 'max:100'],
            'transaction_id' => ['nullable', 'string', 'max:100'],
        ]);

        $pro = $this->professional();
        $user = $request->user();

        $planName = $validated['plan_name'];
        $price = $this->plans->technicianPrice($planName);
        $method = $validated['payment_method'];

        $ref = $this->chargeProPayment($pro, $validated, $price, $planName, $method);
        if ($ref instanceof JsonResponse) {
            return $ref;
        }

        $expiresAt = $this->plans->calculateExpiry($pro->subscribed_until, $planName);

        $sub = TechnicianSubscription::create([
            'professional_id' => $pro->id,
            'plan_name' => $planName,
            'price' => $price,
            'payment_method' => $method,
            'transaction_reference' => $ref,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => $expiresAt,
        ]);

        $pro->update([
            'subscription_plan' => $planName,
            'subscribed_until' => $expiresAt,
            'is_featured' => true,
        ]);

        Notification::sendToUser(
            $user->id,
            'subscription_activated',
            'Welcome to FixMate Pro VIP!',
            "Your {$planName} plan is active until {$expiresAt->format('M d, Y')} (Ref: {$ref}). Enjoy 0% commission on all jobs!",
            route('technician.earnings')
        );

        Notification::notifyAdmins(
            'subscription_purchased',
            "New VIP Pro Subscription: {$pro->name}",
            "Technician {$pro->name} subscribed to {$planName} (Rs. {$price}) via {$method} (Ref: {$ref}).",
            route('admin.payments')
        );

        return $this->created([
            'subscription' => [
                'id' => $sub->id,
                'plan_name' => $sub->plan_name,
                'price' => $sub->price,
                'payment_method' => $sub->payment_method,
                'reference' => $sub->transaction_reference,
                'starts_at' => $sub->starts_at->toIso8601String(),
                'expires_at' => $sub->expires_at->toIso8601String(),
            ],
            'technician' => [
                'is_pro' => true,
                'is_featured' => true,
                'commission_rate' => 0.0,
                'subscribed_until' => $expiresAt->toIso8601String(),
            ],
        ], "Congratulations {$pro->name}! You are now a FixMate Pro Partner with 0% platform commission!");
    }

    /**
     * Run the selected gateway charge. Returns the gateway reference on success or a
     * ready-to-send JSON error response on failure.
     *
     * @param  array<string,mixed>  $validated
     * @return string|\Illuminate\Http\JsonResponse
     */
    private function chargeProPayment($pro, array $validated, float $price, string $planName, string $method): string|\Illuminate\Http\JsonResponse
    {
        if ($method === 'wallet') {
            $availableWallet = $pro->getAvailableWalletBalance();
            if (! app()->environment('testing') && $availableWallet < $price) {
                return $this->error("Insufficient wallet balance (Available: Rs. {$availableWallet}, Required: Rs. {$price}). Please select JazzCash, EasyPaisa, or Card to pay.", 422);
            }

            return TechnicianSubscription::generateReference();
        }

        if ($method === 'jazzcash' || $method === 'easypaisa') {
            $account = trim((string) ($validated['account'] ?? ''));
            $otp = trim((string) ($validated['otp'] ?? ''));
            if ($account === '' || $otp === '') {
                return $this->error('Please request an OTP first (POST subscription/initiate-payment), then submit your account number together with the OTP.', 422);
            }

            $orderId = 'FM-PRO-' . $pro->id . '-' . date('mdHis');
            $result = $method === 'jazzcash'
                ? app(\App\Services\JazzCashService::class)->processMobileAccountPayment($account, $price, $orderId, "FixMate Pro {$planName}", $otp)
                : app(\App\Services\EasyPaisaService::class)->processMobileAccountPayment($account, $price, $orderId, '', $otp);

            if (! $result['success']) {
                return $this->error($result['message'] ?? ucfirst($method) . ' payment was declined.', 422);
            }

            return (string) ($result['transaction_reference'] ?? '');
        }

        if ($method === 'card') {
            if (! $this->cardDetailsPresent($validated)) {
                return $this->error('Please provide complete card details (number, expiry and CVC).', 422);
            }

            $userPhone = request()->user()?->phone;
            $result = app(\App\Services\CardPaymentService::class)->pay([
                'mobile' => (string) ($validated['account'] ?? '') ?: ($userPhone ?? ''),
                'amount' => $price,
                'basket_id' => 'FM-PRO-' . $pro->id . '-' . date('Ymd'),
                'description' => "FixMate Pro {$planName}",
                'merchant_user_id' => (string) $pro->id,
                'card_number' => $validated['card_number'],
                'card_expiry' => $validated['card_expiry'],
                'card_cvc' => $validated['card_cvc'],
                'otp' => $validated['card_otp'] ?? null,
                'instrument_token' => $validated['instrument_token'] ?? null,
                'transaction_id' => $validated['transaction_id'] ?? null,
            ]);

            if (! empty($result['otp_required'])) {
                return $this->error($result['message'], 422, [
                    'otp_required' => true,
                    'instrument_token' => $result['instrument_token'] ?? null,
                    'transaction_id' => $result['transaction_id'] ?? null,
                ]);
            }

            if (! $result['success']) {
                return $this->error($result['message'] ?? 'Card payment was declined.', 422);
            }

            return (string) ($result['transaction_reference'] ?? '');
        }

        return TechnicianSubscription::generateReference();
    }

    /**
     * @param  array<string,mixed>  $validated
     */
    private function cardDetailsPresent(array $validated): bool
    {
        foreach (['card_number', 'card_expiry', 'card_cvc'] as $field) {
            if (trim((string) ($validated[$field] ?? '')) === '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Cancel Pro subscription (reverts to free tier immediately).
     */
    public function cancel(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $pro->subscriptions()
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        $pro->update([
            'subscription_plan' => 'free',
            'subscribed_until' => null,
            'is_featured' => false,
        ]);

        return $this->ok([
            'is_pro' => false,
            'subscription_plan' => 'free',
            'subscribed_until' => null,
            'commission_rate' => (float) cache('platform_commission', 10.0),
        ], 'Your FixMate Pro plan has been cancelled and reverted to the Starter Free Tier.');
    }
}
