<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisteredCustomerController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'identifier' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $identifier = trim($data['identifier']);
        $isEmail = OtpService::isEmail($identifier);

        $email = $isEmail ? strtolower($identifier) : null;
        $phone = $isEmail ? null : OtpService::normalizePhone($identifier);

        if ($email && User::where('email', $email)->exists()) {
            throw ValidationException::withMessages(['identifier' => 'An account already exists with this email.']);
        }

        if ($phone && User::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages(['identifier' => 'An account already exists with this phone number.']);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $email,
            'phone' => $phone,
            'city' => $data['city'],
            'password' => $data['password'],
            'user_type' => User::TYPE_CUSTOMER,
            'is_active' => true,
        ]);

        OtpService::issue($user, $identifier, OtpService::PURPOSE_REGISTER);

        return redirect()->route('verify-otp');
    }
}