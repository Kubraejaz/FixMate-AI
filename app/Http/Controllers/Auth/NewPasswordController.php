<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $identifier = $request->session()->get('otp.reset_approved');

        if (! $identifier) {
            return redirect()->route('forgot-password');
        }

        return view('Frontend.auth.reset-password', [
            'identifier' => $identifier,
            'maskedIdentifier' => OtpService::maskIdentifier($identifier),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $identifier = trim($data['identifier']);
        $approved = $request->session()->get('otp.reset_approved');

        if (! $approved || $approved !== $identifier) {
            throw ValidationException::withMessages([
                'password' => 'The password reset session is invalid. Please start again.',
            ]);
        }

        $user = OtpService::findByIdentifier($identifier);

        if (! $user) {
            throw ValidationException::withMessages([
                'password' => 'The password reset session is invalid. Please start again.',
            ]);
        }

        $user->forceFill([
            'password' => $data['password'],
            'otp_code' => null,
            'otp_purpose' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ])->save();

        $request->session()->forget('otp.reset_approved');

        return redirect()->route('login')->with('status', 'Your password has been reset. Please sign in.');
    }
}