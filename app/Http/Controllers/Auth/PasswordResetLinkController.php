<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
        ]);

        $identifier = trim($request->input('identifier'));
        $user = OtpService::findByIdentifier($identifier);

        if ($user && $user->is_active) {
            $login = OtpService::isEmail($identifier) ? strtolower($identifier) : OtpService::normalizePhone($identifier);
            OtpService::issue($user, $login, OtpService::PURPOSE_RESET);
        }

        return redirect()->route('verify-otp');
    }
}