<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $identifier = session('otp.identifier');
        $purpose = session('otp.purpose');

        if (! $identifier) {
            return redirect()->route('register');
        }

        $targetText = $purpose === OtpService::PURPOSE_RESET
            ? 'set your new password'
            : ((int) session('otp.role') === User::ROLE_TECHNICIAN ? 'complete technician verification' : 'go to your customer dashboard');

        return view('Frontend.auth.verify-otp', [
            'identifier' => $identifier,
            'maskedIdentifier' => OtpService::maskIdentifier($identifier),
            'purpose' => $purpose,
            'targetText' => $targetText,
            'devCode' => app()->environment('local') ? session('otp.dev_code') : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'otp' => ['required', 'array', 'size:6'],
            'otp.*' => ['required', 'numeric'],
        ]);

        $identifier = trim($request->input('identifier'));
        $purpose = session('otp.purpose');

        if (! $purpose || $identifier !== session('otp.identifier')) {
            throw ValidationException::withMessages(['otp' => 'The verification session has expired. Please restart.']);
        }

        $user = OtpService::findByIdentifier($identifier);

        if (! $user) {
            throw ValidationException::withMessages(['otp' => 'We could not find the account for verification.']);
        }

        $code = implode('', $request->input('otp', []));

        if (! OtpService::verify($user, $code)) {
            throw ValidationException::withMessages(['otp' => 'The code is invalid or has expired. Please request a new code.']);
        }

        session()->forget(['otp.identifier', 'otp.purpose', 'otp.role', 'otp.dev_code']);

        if ($purpose === OtpService::PURPOSE_RESET) {
            session()->put('otp.reset_approved', $identifier);

            return redirect()->route('reset-password');
        }

        Auth::login($user, false);

        if ($user->isTechnician()) {
            return redirect()->route('technician.verification');
        }

        return redirect()->route('customer.dashboard');
    }

    public function resend(): RedirectResponse
    {
        $identifier = session('otp.identifier');
        $purpose = session('otp.purpose');

        if (! $identifier || ! $purpose) {
            return redirect()->route('register');
        }

        $user = OtpService::findByIdentifier($identifier);

        if (! $user) {
            return redirect()->route('register');
        }

        OtpService::issue($user, $identifier, $purpose);

        return redirect()->route('verify-otp')
            ->with('status', 'A new verification code has been sent.');
    }
}