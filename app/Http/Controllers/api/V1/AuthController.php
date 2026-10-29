<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Profession;
use App\Models\Professional;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    /**
     * Unified registration endpoint for mobile apps and web API.
     */
    public function register(Request $request): JsonResponse
    {
        $role = strtolower((string) ($request->input('role') ?? $request->input('user_type') ?? 'customer'));
        $isTechnician = in_array($role, ['technician', 'provider', '3', 3], true);

        // Normalize inputs
        $name = trim((string) ($request->input('name') ?? $request->input('full_name') ?? ''));
        $identifier = trim((string) ($request->input('identifier') ?? $request->input('email') ?? $request->input('phone') ?? ''));
        $password = (string) $request->input('password');
        $city = (string) ($request->input('city') ?? 'Islamabad');

        $request->merge([
            'name' => $name,
            'identifier' => $identifier,
            'city' => $city,
            'password_confirmation' => $request->input('password_confirmation') ?? $password,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:100'],
        ]);

        $isEmail = OtpService::isEmail($identifier);
        $email = $isEmail ? strtolower($identifier) : ($request->input('email') ? strtolower(trim($request->input('email'))) : null);
        $phone = $isEmail ? ($request->input('phone') ? OtpService::normalizePhone($request->input('phone')) : null) : OtpService::normalizePhone($identifier);

        if ($email && User::where('email', $email)->exists()) {
            throw ValidationException::withMessages(['email' => 'An account already exists with this email.']);
        }

        if ($phone && User::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages(['phone' => 'An account already exists with this phone number.']);
        }

        $userType = $isTechnician ? User::TYPE_TECHNICIAN : User::TYPE_CUSTOMER;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'city' => $city,
            'password' => $password,
            'user_type' => $userType,
            'is_active' => true,
            'is_verified' => true,
        ]);

        if ($isTechnician) {
            Professional::create([
                'user_id' => $user->id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone ?? '',
                'experience' => $request->input('experience') ?? '1 year',
                'cnic_number' => $request->input('cnic') ?? '00000-0000000-0',
                'is_verified' => false,
            ]);
        }

        $token = $user->createToken($request->input('device_name') ?? 'mobile')->plainTextToken;

        return $this->created([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new \App\Http\Resources\UserResource($user),
            'requires_otp' => false,
        ], 'Registration successful.');
    }

    /**
     * Register a new customer account and dispatch a verification OTP.
     */
    public function registerCustomer(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'identifier' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
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

        $code = OtpService::issue($user, $identifier, OtpService::PURPOSE_REGISTER);

        return $this->created([
            'user' => new \App\Http\Resources\UserResource($user),
            'identifier' => $identifier,
            'masked_identifier' => OtpService::maskIdentifier($identifier),
            'requires_otp' => true,
            'otp' => $this->devOtp($code),
        ], 'Registration successful. A verification code has been sent.');
    }

    /**
     * Register a new technician account (with professional profile) and dispatch an OTP.
     */
    public function registerTechnician(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'cnic' => ['required', 'string', 'max:20', 'regex:/^\d{5}-?\d{7}-?\d{1}$/'],
            'experience' => ['required', 'string', 'max:50'],
            'trade' => ['required', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'email.unique' => 'An account already exists with this email.',
            'phone.regex' => 'Please enter a valid mobile number (e.g. 03001234567 or +923001234567).',
            'cnic.regex' => 'Please provide a valid 13-digit Pakistani CNIC number (e.g. 42101-1234567-1).',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $phone = OtpService::normalizePhone($data['phone']);
        $email = strtolower(trim($data['email']));

        if (User::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages(['phone' => 'A technician is already registered with this phone number.']);
        }

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
            'city' => $data['city'] ?? null,
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

        $code = OtpService::issue($user, $phone, OtpService::PURPOSE_REGISTER);

        return $this->created([
            'user' => new \App\Http\Resources\UserResource($user->load('professional')),
            'identifier' => $phone,
            'masked_identifier' => OtpService::maskIdentifier($phone),
            'requires_otp' => true,
            'otp' => $this->devOtp($code),
        ], 'Technician registration successful. A verification code has been sent.');
    }

    /**
     * Authenticate a user and return a Sanctum bearer token.
     */
    public function login(Request $request): JsonResponse
    {
        if (! $request->has('identifier') && $request->has('email')) {
            $request->merge(['identifier' => $request->input('email')]);
        }
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $identifier = trim($data['identifier']);
        $user = OtpService::findByIdentifier($identifier);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'identifier' => 'These credentials do not match our records.',
            ]);
        }

        if (! $user->is_active) {
            return $this->error('Your profile has been blocked. Please contact the FixMate team for assistance.', 403);
        }

        $user->forceFill(['last_login_at' => now()])->save();

        $token = $user->createToken($data['device_name'] ?? 'mobile')->plainTextToken;

        $user->load('professional.profession');

        return $this->ok([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new \App\Http\Resources\UserResource($user),
        ], 'Signed in successfully.');
    }

    /**
     * Verify the registration OTP and issue a bearer token.
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'otp' => ['required'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $identifier = trim($data['identifier']);
        $user = OtpService::findByIdentifier($identifier);

        if (! $user) {
            throw ValidationException::withMessages(['otp' => 'We could not find the account for verification.']);
        }

        if ($user->otp_purpose === OtpService::PURPOSE_RESET) {
            throw ValidationException::withMessages(['otp' => 'This code is for password reset. Please use the reset-password endpoint.']);
        }

        $code = $this->extractOtp($data['otp']);

        if (! OtpService::verify($user, $code)) {
            throw ValidationException::withMessages(['otp' => 'The code is invalid or has expired. Please request a new code.']);
        }

        $token = $user->createToken($data['device_name'] ?? 'mobile')->plainTextToken;

        $user->load('professional.profession');

        return $this->ok([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new \App\Http\Resources\UserResource($user),
        ], 'Account verified successfully.');
    }

    /**
     * Resend a verification OTP for registration/contact verification.
     */
    public function resendOtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
        ]);

        $identifier = trim($data['identifier']);
        $user = OtpService::findByIdentifier($identifier);

        if (! $user) {
            throw ValidationException::withMessages(['identifier' => 'We could not find the account for verification.']);
        }

        $purpose = $user->otp_purpose ?: OtpService::PURPOSE_REGISTER;
        $code = OtpService::issue($user, $identifier, $purpose);

        return $this->ok([
            'identifier' => $identifier,
            'masked_identifier' => OtpService::maskIdentifier($identifier),
            'otp' => $this->devOtp($code),
        ], 'A new verification code has been sent.');
    }

    /**
     * Request a password reset OTP.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
        ]);

        $identifier = trim($data['identifier']);
        $user = OtpService::findByIdentifier($identifier);

        $code = null;

        if ($user && $user->is_active) {
            $login = OtpService::isEmail($identifier) ? strtolower($identifier) : OtpService::normalizePhone($identifier);
            $code = OtpService::issue($user, $login, OtpService::PURPOSE_RESET);
        }

        return $this->ok([
            'identifier' => $identifier,
            'masked_identifier' => OtpService::maskIdentifier($identifier),
            'otp' => $this->devOtp($code),
        ], 'If an account exists for that identifier, a password reset code has been sent.');
    }

    /**
     * Reset a password using a valid reset OTP.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'otp' => ['required'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        $identifier = trim($data['identifier']);
        $user = OtpService::findByIdentifier($identifier);

        if (! $user || $user->otp_purpose !== OtpService::PURPOSE_RESET) {
            throw ValidationException::withMessages(['otp' => 'The password reset session is invalid. Please request a new code.']);
        }

        $code = $this->extractOtp($data['otp']);

        if (! OtpService::verify($user, $code)) {
            throw ValidationException::withMessages(['otp' => 'The code is invalid or has expired. Please request a new code.']);
        }

        $user->forceFill([
            'password' => $data['password'],
            'otp_code' => null,
            'otp_purpose' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ])->save();

        $user->tokens()->delete();

        return $this->ok(null, 'Your password has been reset. Please sign in with your new password.');
    }

    /**
     * Return the authenticated user profile.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load(['professional.profession']);

        return $this->ok(new \App\Http\Resources\UserResource($user), 'Profile retrieved.');
    }

    /**
     * Revoke the current access token.
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return $this->ok(null, 'Signed out successfully.');
    }

    /**
     * Revoke all access tokens for the user.
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->ok(null, 'Signed out from all devices successfully.');
    }

    /**
     * Normalise an OTP payload which may be a string or an array of digits.
     */
    protected function extractOtp(mixed $otp): string
    {
        if (is_array($otp)) {
            return implode('', $otp);
        }

        return (string) $otp;
    }

    /**
     * Expose the OTP in non-production environments to aid automated testing.
     */
    protected function devOtp(?string $code): ?string
    {
        if (! $code) {
            return null;
        }

        return app()->environment('local', 'testing') ? $code : null;
    }
}
