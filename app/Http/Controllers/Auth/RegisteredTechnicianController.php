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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'cnic' => ['required', 'string', 'max:20'],
            'experience' => ['required', 'string', 'max:255'],
            'trade' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'An account already exists with this email.',
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