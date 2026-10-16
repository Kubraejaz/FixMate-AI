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
     * Subscribe or renew FixMate Home Care VIP Pass.
     */
    public function upgrade(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan_name' => ['required', 'in:vip_monthly,vip_annual'],
            'payment_method' => ['required', 'in:jazzcash,easypaisa,card'],
            'phone_or_account' => ['nullable', 'string', 'max:50'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $planName = $validated['plan_name'];
        $price = $this->plans->customerPrice($planName);
        $txnRef = $this->plans->generateReference('TXN-VIP');
        $expiresAt = $this->plans->calculateExpiry($user->subscribed_until, $planName);

        $user->update([
            'subscription_plan' => $planName,
            'subscribed_until' => $expiresAt,
        ]);

        Notification::sendToUser(
            $user->id,
            'vip_activated',
            'FixMate VIP Home Care Pass Activated!',
            "Your VIP Home Care Pass is active until {$expiresAt->format('M d, Y')} (Ref: {$txnRef}). Enjoy waived booking fees and priority dispatch!",
            route('customer.dashboard')
        );

        Notification::notifyAdmins(
            'customer_vip_purchased',
            "New Customer VIP Member: {$user->name}",
            "Customer {$user->name} subscribed to {$planName} (Rs. {$price}) via {$validated['payment_method']} (Ref: {$txnRef}).",
            route('admin.payments')
        );

        return $this->created([
            'subscription' => [
                'plan_name' => $user->subscription_plan,
                'price' => $price,
                'payment_method' => $validated['payment_method'],
                'reference' => $txnRef,
                'is_vip' => true,
                'subscribed_until' => $expiresAt->toIso8601String(),
                'days_remaining' => max(0, (int) now()->diffInDays($expiresAt, false)),
            ],
        ], "Congratulations {$user->name}! Your FixMate Home Care VIP Pass is now active!");
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
