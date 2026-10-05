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
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'identifier' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'name.min' => 'Your full name must be at least 2 characters long.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
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