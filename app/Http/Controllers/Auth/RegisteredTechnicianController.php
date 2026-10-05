<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisteredTechnicianController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'cnic' => ['required', 'string', 'max:20', 'regex:/^\d{5}-?\d{7}-?\d{1}$/'],
            'experience' => ['required', 'string', 'max:50'],
            'trade' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'name.min' => 'Full name must be at least 2 characters long.',
            'email.unique' => 'An account already exists with this email.',
            'phone.regex' => 'Please enter a valid mobile number (e.g. 03001234567 or +923001234567).',
            'cnic.regex' => 'Please provide a valid 13-digit Pakistani CNIC number (e.g. 42101-1234567-1).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $phone = OtpService::normalizePhone($data['phone']);
        $email = strtolower(trim($data['email']));

        if (User::whereRaw('LOWER(email) = ?', [$email])->exists()) {
            throw ValidationException::withMessages(['email' => 'An account already exists with this email.']);
        }

        if (User::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages(['phone' => 'A technician is already registered with this phone number.']);
        }

        // Map trade string or ID to a profession
        $professionId = null;
        if (is_numeric($data['trade'])) {
            $professionId = (int) $data['trade'];
        } else {
            $tradeText = strtolower($data['trade']);
            $profession = Profession::all()->first(function ($p) use ($tradeText) {
                return str_contains($tradeText, strtolower($p->name)) || str_contains($tradeText, $p->slug);
            });
            $professionId = $profession?->id;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $email,
            'phone' => $phone,
            'password' => $data['password'],
            'user_type' => User::TYPE_TECHNICIAN,
            'profession_id' => $professionId,
            'experience' => $data['experience'],
            'cnic_number' => $data['cnic'],
            'is_verified' => false,
            'is_active' => true,
        ]);

        Professional::create([
            'user_id' => $user->id,
            'profession_id' => $professionId,
            'name' => $data['name'],
            'email' => $email,
            'phone' => $phone,
            'experience' => $data['experience'],
            'cnic_number' => $data['cnic'],
            'is_verified' => false,
        ]);

        session()->put('otp.role', User::TYPE_TECHNICIAN);
        session()->put('otp.user_type', User::TYPE_TECHNICIAN);

        OtpService::issue($user, $phone, OtpService::PURPOSE_REGISTER);

        return redirect()->route('verify-otp');
    }
}