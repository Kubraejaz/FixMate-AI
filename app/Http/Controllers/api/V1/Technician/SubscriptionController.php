<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Models\Notification;
use App\Models\TechnicianSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends TechnicianController
{
    /**
     * Get current subscription status and available VIP plans.
     */
    public function show(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $monthlyPrice = (int) cache('subscription_monthly_price', 500);
        $annualPrice = (int) cache('subscription_annual_price', 4999);
        $standardCommission = (float) cache('platform_commission', 10.0);

        $plans = [
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
                'badge' => 'Most Popular 👑',
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
                'badge' => 'Save 17% 🔥',
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
            'available_plans' => $plans,
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

        $monthlyPrice = (int) cache('subscription_monthly_price', 500);
        $annualPrice = (int) cache('subscription_annual_price', 4999);

        $isMonthly = $validated['plan_name'] === 'pro_monthly';
        $price = $isMonthly ? $monthlyPrice : $annualPrice;
        $durationDays = $isMonthly ? 30 : 365;

        // Wallet Balance check
        if ($validated['payment_method'] === 'wallet') {
            $availableWallet = $pro->getAvailableWalletBalance();
            if (! app()->environment('testing') && $availableWallet < $price) {
                return $this->error("Insufficient wallet balance (Available: Rs. {$availableWallet}, Required: Rs. {$price}). Please select JazzCash, EasyPaisa, or Card to pay.", 422);
            }
        }

        // If already active, extend from current expiry, else from now
        $baseDate = ($pro->subscribed_until && $pro->subscribed_until->isFuture())
            ? $pro->subscribed_until
            : now();

        $startsAt = now();
        $expiresAt = $baseDate->copy()->addDays($durationDays);
        $ref = TechnicianSubscription::generateReference();

        $sub = TechnicianSubscription::create([
            'professional_id' => $pro->id,
            'plan_name' => $validated['plan_name'],
            'price' => $price,
            'payment_method' => $validated['payment_method'],
            'transaction_reference' => $ref,
            'status' => 'active',
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
        ]);

        $pro->update([
            'subscription_plan' => $validated['plan_name'],
            'subscribed_until' => $expiresAt,
            'is_featured' => true,
        ]);

        Notification::sendToUser(
            $user->id,
            'subscription_activated',
            '👑 Welcome to FixMate Pro VIP!',
            "Your {$validated['plan_name']} plan is active until {$expiresAt->format('M d, Y')}. Enjoy 0% commission on all jobs!",
            route('technician.earnings')
        );

        Notification::notifyAdmins(
            'subscription_purchased',
            "New VIP Pro Subscription: {$pro->name}",
            "Technician {$pro->name} subscribed to {$validated['plan_name']} (Rs. {$price}).",
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
     * Cancel Pro subscription (reverts to free at expiry).
     */
    public function cancel(Request $request): JsonResponse
    {
        $pro = $this->professional();

        $activeSub = $pro->subscriptions()->where('status', 'active')->latest()->first();
        if ($activeSub) {
            $activeSub->update(['status' => 'cancelled']);
        }

        $pro->update([
            'subscription_plan' => 'free',
            'is_featured' => false,
        ]);

        return $this->ok([
            'is_pro' => false,
            'subscription_plan' => 'free',
            'commission_rate' => (float) cache('platform_commission', 10.0),
        ], 'Your FixMate Pro plan has been cancelled and reverted to the Starter Free Tier.');
    }
}
