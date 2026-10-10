<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\ProfessionalResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends TechnicianController
{
    public function show(Request $request): JsonResponse
    {
        $pro = $this->professional();

        return $this->ok([
            'user' => new UserResource($request->user()),
            'professional' => new ProfessionalResource($pro->load('profession')),
        ], 'Profile retrieved.');
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'city' => ['required', 'string', 'max:50'],
            'area' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:2000'],
        ], [
            'name.regex' => 'Please provide a valid full name containing only letters, spaces, and periods.',
            'phone.regex' => 'Please enter a valid mobile contact number.',
        ]);

        $pro = $this->professional();

        $user->update($validated);

        $pro->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'experience' => $validated['experience'] ?? $pro->experience,
            'description' => $validated['description'] ?? $pro->description,
        ]);

        return $this->ok([
            'user' => new UserResource($user->fresh()),
            'professional' => new ProfessionalResource($pro->fresh('profession')),
        ], 'Profile and technician description updated successfully.');
    }
}
