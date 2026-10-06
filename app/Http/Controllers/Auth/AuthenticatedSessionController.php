<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $identifier = trim($data['identifier']);
        $user = OtpService::findByIdentifier($identifier);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'identifier' => 'These credentials do not match our records.',
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'identifier' => 'Your profile has been blocked. Please contact the FixMate team for assistance.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $user->forceFill(['last_login_at' => now()])->save();

        $intended = $request->session()->pull('url.intended');

        if ($intended) {
            $path = parse_url($intended, PHP_URL_PATH) ?? '';

            if ($user->isAdmin() && str_starts_with($path, '/admin')) {
                return redirect()->to($intended);
            }

            if ($user->isCustomer() && str_starts_with($path, '/customer')) {
                return redirect()->to($intended);
            }

            if ($user->isTechnician() && str_starts_with($path, '/technician')) {
                return redirect()->to($intended);
            }
        }

        return redirect($user->dashboardRoute());
    }
}