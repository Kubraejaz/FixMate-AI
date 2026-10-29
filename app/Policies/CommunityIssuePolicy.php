<?php

namespace App\Policies;

use App\Models\CommunityIssue;
use App\Models\User;

class CommunityIssuePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function update(User $user, CommunityIssue $issue): bool
    {
        return $issue->user_id !== null && (int) $issue->user_id === (int) $user->id;
    }

    public function delete(User $user, CommunityIssue $issue): bool
    {
        return $issue->user_id !== null && (int) $issue->user_id === (int) $user->id;
    }

    public function moderate(User $user, CommunityIssue $issue): bool
    {
        return $user->isAdmin();
    }

    public function upvote(User $user, CommunityIssue $issue): bool
    {
        return true;
    }
}
