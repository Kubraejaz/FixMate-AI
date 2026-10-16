<?php

namespace App\Services;

use Carbon\CarbonInterface;

/**
 * Single source of truth for subscription plan definitions, pricing and durations.
 *
 * Prices can be overridden at runtime by admins via cache keys
 * (subscription_monthly_price / subscription_annual_price for technicians,
 * subscription_vip_monthly_price / subscription_vip_annual_price for customers).
 */
class SubscriptionPlanService
{
    public const TECHNICIAN_PLANS = [
        'pro_monthly' => ['label' => 'FixMate Pro VIP (Monthly)', 'duration_days' => 30],
        'pro_annual' => ['label' => 'FixMate Pro VIP (Annual Pass)', 'duration_days' => 365],
    ];

    public const CUSTOMER_PLANS = [
        'vip_monthly' => ['label' => 'FixMate Home Care VIP (Monthly)', 'duration_days' => 30],
        'vip_annual' => ['label' => 'FixMate Home Care VIP (Annual Pass)', 'duration_days' => 365],
    ];

    public function technicianMonthlyPrice(): int
    {
        return (int) cache('subscription_monthly_price', 500);
    }

    public function technicianAnnualPrice(): int
    {
        return (int) cache('subscription_annual_price', 4999);
    }

    public function customerMonthlyPrice(): int
    {
        return (int) cache('subscription_vip_monthly_price', 299);
    }

    public function customerAnnualPrice(): int
    {
        return (int) cache('subscription_vip_annual_price', 2999);
    }

    public function isValidTechnicianPlan(string $plan): bool
    {
        return array_key_exists($plan, self::TECHNICIAN_PLANS);
    }

    public function isValidCustomerPlan(string $plan): bool
    {
        return array_key_exists($plan, self::CUSTOMER_PLANS);
    }

    public function technicianPrice(string $plan): int
    {
        return match ($plan) {
            'pro_monthly' => $this->technicianMonthlyPrice(),
            'pro_annual' => $this->technicianAnnualPrice(),
            default => 0,
        };
    }

    public function customerPrice(string $plan): int
    {
        return match ($plan) {
            'vip_monthly' => $this->customerMonthlyPrice(),
            'vip_annual' => $this->customerAnnualPrice(),
            default => 0,
        };
    }

    public function durationDays(string $plan): int
    {
        $definition = self::TECHNICIAN_PLANS[$plan] ?? self::CUSTOMER_PLANS[$plan] ?? null;

        return $definition['duration_days'] ?? 0;
    }

    /**
     * Renewals extend from the current expiry when it is still in the future,
     * otherwise the new period starts immediately.
     */
    public function calculateExpiry(?CarbonInterface $currentExpiry, string $plan): CarbonInterface
    {
        $base = ($currentExpiry && $currentExpiry->isFuture()) ? $currentExpiry->copy() : now();

        return $base->addDays($this->durationDays($plan));
    }

    public function generateReference(string $prefix = 'TXN-SUB'): string
    {
        return strtoupper($prefix.'-'.bin2hex(random_bytes(4)));
    }

    public function passesLuhnCheck(string $cardNumber): bool
    {
        $digits = preg_replace('/\D/', '', $cardNumber);

        if (strlen($digits) < 13 || strlen($digits) > 19) {
            return false;
        }

        $sum = 0;
        $double = false;

        for ($i = strlen($digits) - 1; $i >= 0; $i--) {
            $digit = (int) $digits[$i];

            if ($double) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
            $double = ! $double;
        }

        return $sum % 10 === 0;
    }

    public function isValidCardExpiry(string $expiry): bool
    {
        if (! preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry)) {
            return false;
        }

        [$month, $year] = explode('/', $expiry);

        return now()->setDate(2000 + (int) $year, (int) $month, 1)->endOfMonth()->isFuture();
    }

    public function isValidCardCvc(string $cvc): bool
    {
        return (bool) preg_match('/^\d{3,4}$/', $cvc);
    }
}
