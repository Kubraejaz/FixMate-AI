<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Technician;
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'cnic' => ['required', 'string', 'max:20'],
            'experience' => ['required', 'string', 'max:255'],
            'trade' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $phone = OtpService::normalizePhone($data['phone']);

        if (User::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages(['phone' => 'A technician is already registered with this phone number.']);
        }

        $user = User::create([
            'name' => $data['name'],
            'phone' => $phone,
            'password' => $data['password'],
            'role' => User::ROLE_TECHNICIAN,
            'is_active' => true,
        ]);

        Technician::create([
            'user_id' => $user->id,
            'trade' => $data['trade'],
            'experience' => $data['experience'],
            'cnic_number' => $data['cnic'],
            'is_verified' => false,
        ]);

        session()->put('otp.role', User::ROLE_TECHNICIAN);

        OtpService::issue($user, $phone, OtpService::PURPOSE_REGISTER);

        return redirect()->route('verify-otp');
    }
}