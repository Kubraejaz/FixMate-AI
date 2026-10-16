<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Api\V1\ApiController;
use App\Models\Notification;
use App\Models\User;
use App\Services\SubscriptionPlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends ApiController
{
    public function __construct(private readonly SubscriptionPlanService $plans) {}

    /**
     * Get current customer subscription status and available Home Care VIP plans.
     */
    public function show(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $monthlyPrice = $this->plans->customerMonthlyPrice();
        $annualPrice = $this->plans->customerAnnualPrice();

        $plans = [
            [
                'id' => 'free',
                'name' => 'Standard Care',
                'price' => 0,
                'billing_period' => 'Pay Per Booking',
                'convenience_fee' => 'Rs. 150 per booking',
                'perks' => [
                    'Standard dispatch queue (30-45 mins)',
                    'Access to all verified technicians',
                    '7-day standard rework warranty',
                    'Standard customer support',
                ],
                'is_current' => ! $user->isVip(),
            ],
            [
                'id' => 'vip_monthly',
                'name' => 'FixMate Home Care VIP (Monthly)',
                'price' => $monthlyPrice,
                'billing_period' => 'Rs. '.number_format($monthlyPrice).' / month',
                'convenience_fee' => '0% Waived (Rs. 0 Forever)',
                'badge' => 'Most Popular',
                'perks' => [
                    '0% Convenience & Booking Fees — Unlimited Bookings',
                    'Priority 15-Minute Express Dispatch',
                    '100% Free Video Tele-Consultations',
                    '30-Day Extended Rework & Repair Warranty',
                    'Dedicated Priority Customer Support',
                ],
                'is_current' => $user->isVip() && $user->subscription_plan === 'vip_monthly',
            ],
            [
                'id' => 'vip_annual',
                'name' => 'FixMate Home Care VIP (Annual Pass)',
                'price' => $annualPrice,
                'billing_period' => 'Rs. '.number_format($annualPrice).' / year',
                'convenience_fee' => '0% Waived (Rs. 0 Forever)',
                'badge' => 'Best Value',
                'perks' => [
                    'All VIP Home Care perks for a full 12 months',
                    '2 Months Free with Annual Billing',
                    'Permanent VIP Badge on account profile',
                    'Complimentary annual home safety inspection',
                    'Direct Dedicated Care Concierge',
                ],
                'is_current' => $user->isVip() && $user->subscription_plan === 'vip_annual',
            ],
        ];

        return $this->ok([
            'current_subscription' => [
                'plan' => $user->subscription_plan ?? 'free',
                'is_vip' => $user->isVip(),
                'subscribed_until' => optional($user->subscribed_until)->toIso8601String(),
                'days_remaining' => $user->subscribed_until ? max(0, (int) now()->diffInDays($user->subscribed_until, false)) : 0,
            ],
            'available_plans' => $plans,
        ], 'Customer VIP subscription status retrieved.');
    }

    /**
     * Start a payment: dispatch a JazzCash / EasyPaisa OTP or tokenize a card so the
     * app can complete the charge in the follow-up `upgrade` call.
     */
    public function initiatePayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gateway' => ['required', 'in:jazzcash,easypaisa,card'],
            'plan_name' => ['required', 'in:vip_monthly,vip_annual'],
            'phone' => ['required', 'string', 'max:25'],
            'card_number' => ['nullable', 'string', 'max:30'],
            'card_expiry' => ['nullable', 'string', 'max:10'],
            'card_cvc' => ['nullable', 'string', 'max:6'],
        ]);

        /** @var User $user */
        $user = $request->user();
        $price = $this->plans->customerPrice($validated['plan_name']);
        $gateway = $validated['gateway'];

        if ($gateway === 'card') {
            if (! $this->cardDetailsPresent($validated)) {
                return $this->error('Please provide complete card details (number, expiry and CVC) to start card verification.', 422);
            }

            $result = app(\App\Services\CardPaymentService::class)->pay([
                'mobile' => $validated['phone'],
                'amount' => $price,
                'basket_id' => 'FM-VIP-' . $user->id . '-' . date('Ymd'),
                'description' => "FixMate Customer VIP {$validated['plan_name']}",
                'merchant_user_id' => (string) $user->id,
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
     * Subscribe or renew FixMate Home Care VIP Pass (charges a real gateway).
     */
    public function upgrade(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan_name' => ['required', 'in:vip_monthly,vip_annual'],
            'payment_method' => ['required', 'in:jazzcash,easypaisa,card'],
            'account' => ['nullable', 'string', 'max:25'],
            'otp' => ['nullable', 'string', 'max:10'],
            'card_number' => ['nullable', 'string', 'max:30'],
            'card_expiry' => ['nullable', 'string', 'max:10'],
            'card_cvc' => ['nullable', 'string', 'max:6'],
            'card_otp' => ['nullable', 'string', 'max:10'],
            'instrument_token' => ['nullable', 'string', 'max:100'],
            'transaction_id' => ['nullable', 'string', 'max:100'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $planName = $validated['plan_name'];
        $price = $this->plans->customerPrice($planName);
        $method = $validated['payment_method'];

        $txnRef = $this->chargeCustomerPayment($request, $user, $validated, $price, $planName, $method);
        if ($txnRef instanceof JsonResponse) {
            return $txnRef;
        }

        $expiresAt = $this->plans->calculateExpiry($user->subscribed_until, $planName);

        $user->update([
            'subscription_plan' => $planName,
            'subscribed_until' => $expiresAt,
        ]);

        $refNote = $txnRef ? " (Ref: {$txnRef})" : '';
        Notification::sendToUser(
            $user->id,
            'vip_activated',
            'FixMate VIP Home Care Pass Activated!',
            "Your VIP Home Care Pass is active until {$expiresAt->format('M d, Y')}{$refNote}. Enjoy waived booking fees and priority dispatch!",
            route('customer.dashboard')
        );

        Notification::notifyAdmins(
            'customer_vip_purchased',
            "New Customer VIP Member: {$user->name}",
            "Customer {$user->name} subscribed to {$planName} (Rs. {$price}) via {$method}{$refNote}.",
            route('admin.payments')
        );

        return $this->created([
            'subscription' => [
                'plan_name' => $user->subscription_plan,
                'price' => $price,
                'payment_method' => $method,
                'reference' => $txnRef,
                'is_vip' => true,
                'subscribed_until' => $expiresAt->toIso8601String(),
                'days_remaining' => max(0, (int) now()->diffInDays($expiresAt, false)),
            ],
        ], "Congratulations {$user->name}! Your FixMate Home Care VIP Pass is now active!");
    }

    /**
     * Run the selected gateway charge. Returns the gateway reference on success or a
     * ready-to-send JSON error response on failure.
     *
     * @param  array<string,mixed>  $validated
     * @return string|\Illuminate\Http\JsonResponse
     */
    private function chargeCustomerPayment(Request $request, User $user, array $validated, float $price, string $planName, string $method): string|\Illuminate\Http\JsonResponse
    {
        if ($method === 'jazzcash' || $method === 'easypaisa') {
            $account = trim((string) ($validated['account'] ?? ''));
            $otp = trim((string) ($validated['otp'] ?? ''));
            if ($account === '' || $otp === '') {
                return $this->error('Please request an OTP first (POST subscription/initiate-payment), then submit your account number together with the OTP.', 422);
            }

            $orderId = 'FM-VIP-' . $user->id . '-' . date('mdHis');
            $result = $method === 'jazzcash'
                ? app(\App\Services\JazzCashService::class)->processMobileAccountPayment($account, $price, $orderId, "FixMate Customer VIP {$planName}", $otp)
                : app(\App\Services\EasyPaisaService::class)->processMobileAccountPayment($account, $price, $orderId, $user->email ?? 'customer@fixmate.pk', $otp);

            if (! $result['success']) {
                return $this->error($result['message'] ?? ucfirst($method) . ' VIP subscription payment declined.', 422);
            }

            return (string) ($result['transaction_reference'] ?? '');
        }

        if ($method === 'card') {
            if (! $this->cardDetailsPresent($validated)) {
                return $this->error('Please provide complete card details (number, expiry and CVC).', 422);
            }

            $result = app(\App\Services\CardPaymentService::class)->pay([
                'mobile' => (string) ($validated['account'] ?? '') ?: ($user->phone ?? ''),
                'amount' => $price,
                'basket_id' => 'FM-VIP-' . $user->id . '-' . date('Ymd'),
                'description' => "FixMate Customer VIP {$planName}",
                'merchant_user_id' => (string) $user->id,
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

        return '';
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
     * Cancel VIP subscription (reverts to free tier).
     */
    public function cancel(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->update([
            'subscription_plan' => 'free',
            'subscribed_until' => null,
        ]);

        return $this->ok([
            'is_vip' => false,
            'subscription_plan' => 'free',
            'subscribed_until' => null,
        ], 'Your VIP Home Care Pass has been cancelled.');
    }
}
