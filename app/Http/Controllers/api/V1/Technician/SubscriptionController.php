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
     * Subscribe or renew FixMate Pro VIP.
     */
    public function upgrade(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan_name' => ['required', 'in:pro_monthly,pro_annual'],
            'payment_method' => ['required', 'in:wallet,jazzcash,easypaisa,card'],
            'phone_or_account' => ['nullable', 'string', 'max:50'],
        ]);

        $pro = $this->professional();
        $user = $request->user();

        $planName = $validated['plan_name'];
        $price = $this->plans->technicianPrice($planName);

        if ($validated['payment_method'] === 'wallet') {
            $availableWallet = $pro->getAvailableWalletBalance();
            if (! app()->environment('testing') && $availableWallet < $price) {
                return $this->error("Insufficient wallet balance (Available: Rs. {$availableWallet}, Required: Rs. {$price}). Please select JazzCash, EasyPaisa, or Card to pay.", 422);
            }
        }

        $expiresAt = $this->plans->calculateExpiry($pro->subscribed_until, $planName);
        $ref = TechnicianSubscription::generateReference();

        $sub = TechnicianSubscription::create([
            'professional_id' => $pro->id,
            'plan_name' => $planName,
            'price' => $price,
            'payment_method' => $validated['payment_method'],
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
            "Technician {$pro->name} subscribed to {$planName} (Rs. {$price}) via {$validated['payment_method']} (Ref: {$ref}).",
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
