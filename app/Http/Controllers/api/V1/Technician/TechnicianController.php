<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Controllers\Api\V1\ApiController;
use App\Models\Profession;
use App\Models\Professional;

abstract class TechnicianController extends ApiController
{
    /**
     * Get or ensure the authenticated technician's Professional profile.
     */
    protected function professional(): Professional
    {
        $user = request()->user();

        return Professional::firstOrCreate(
            ['user_id' => $user->id],
            [
                'profession_id' => $user->profession_id ?: (Profession::first()?->id ?? 1),
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '+923000000000',
                'experience' => $user->experience ?? '5 Years',
                'is_verified' => (bool) $user->is_verified,
            ]
        );
    }
}
