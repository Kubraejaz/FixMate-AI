<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OtpService
{
    public const PURPOSE_REGISTER = 'register';

    public const PURPOSE_RESET = 'reset';

    public const CODE_EXPIRY_MINUTES = 10;

    public const MAX_ATTEMPTS = 5;

    /**
     * Issue a 6-digit OTP for the given user, persist it (hashed) and
     * deliver it via SMS (or mail when no phone is known).
     */
    public static function issue(User $user, string $identifier, string $purpose): void
    {
        $code = (string) random_int(100000, 999999);

        $user->forceFill([
            'otp_code' => Hash::make($code),
            'otp_purpose' => $purpose,
            'otp_expires_at' => now()->addMinutes(self::CODE_EXPIRY_MINUTES),
            'otp_attempts' => 0,
        ])->save();

        $user->notify(new OtpNotification($code));

        if (app()->environment('local', 'testing')) {
            Log::info("[OTP][{$identifier}] purpose={$purpose} code={$code}");
        }

        if (app()->environment('local')) {
            session()->put('otp.dev_code', $code);
        }

        session()->put('otp.identifier', $identifier);
        session()->put('otp.purpose', $purpose);
    }

    /**
     * Verify a submitted code against the user's stored token.
     * Consumes the token once it is accepted or the attempts are exhausted.
     */
    public static function verify(User $user, string $code): bool
    {
        if (! $user->otp_code || ! $user->otp_expires_at) {
            return false;
        }

        if ($user->otp_expires_at->isPast()) {
            $user->forceFill(['otp_code' => null, 'otp_purpose' => null, 'otp_expires_at' => null])->save();

            return false;
        }

        if ((int) $user->otp_attempts >= self::MAX_ATTEMPTS) {
            return false;
        }

        if (! Hash::check($code, $user->otp_code)) {
            $user->increment('otp_attempts');

            return false;
        }

        $user->forceFill([
            'otp_code' => null,
            'otp_purpose' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
            'contact_verified_at' => now(),
        ])->save();

        return true;
    }

    public static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        return str_starts_with(trim($phone), '+') ? '+'.$digits : $digits;
    }

    public static function isEmail(string $identifier): bool
    {
        return filter_var(trim($identifier), FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function findByIdentifier(string $identifier): ?User
    {
        $identifier = trim($identifier);

        if (self::isEmail($identifier)) {
            return User::whereRaw('LOWER(email) = ?', [strtolower($identifier)])->first();
        }

        return User::where('phone', self::normalizePhone($identifier))->first();
    }

    public static function maskIdentifier(string $identifier): string
    {
        if (self::isEmail($identifier)) {
            [$local, $domain] = explode('@', strtolower($identifier));
            $keeper = substr($local, 0, 2);

            return $keeper.str_repeat('*', max(3, strlen($local) - 2)).'@'.$domain;
        }

        $digits = self::normalizePhone($identifier);
        $last4 = substr($digits, -4);

        return '******'.$last4;
    }
}