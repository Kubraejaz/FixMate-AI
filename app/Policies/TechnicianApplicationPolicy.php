<?php

namespace App\Policies;

use App\Models\TechnicianApplication;
use App\Models\User;

class TechnicianApplicationPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function view(User $user, TechnicianApplication $application): bool
    {
        return $application->user_id !== null && (int) $application->user_id === (int) $user->id;
    }

    public function review(User $user): bool
    {
        return $user->isAdmin();
    }
}
