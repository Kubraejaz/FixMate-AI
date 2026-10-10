<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends ApiController
{
    public function show(Request $request): JsonResponse
    {
        return $this->ok(new UserResource($request->user()), 'Profile retrieved.');
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,'.$user->id],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/', 'unique:users,phone,'.$user->id],
            'city' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:255'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'phone.regex' => 'Please enter a valid contact phone number.',
        ]);

        $user->update($validated);

        return $this->ok(new UserResource($user), 'Your profile has been updated successfully!');
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return $this->ok(null, 'Password updated successfully!');
    }

    public function updateNotificationSettings(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->update([
            'notification_settings' => [
                'booking_updates' => $request->boolean('booking_updates'),
                'promotions' => $request->boolean('promotions'),
                'sms_alerts' => $request->boolean('sms_alerts'),
                'whatsapp_alerts' => $request->boolean('whatsapp_alerts'),
                'email_receipts' => $request->boolean('email_receipts'),
                'security_alerts' => true,
            ],
        ]);

        return $this->ok(new UserResource($user), 'Notification preferences saved successfully!');
    }
}
