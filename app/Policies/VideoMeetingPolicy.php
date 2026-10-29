<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VideoMeeting;

class VideoMeetingPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can join this private video meeting.
     */
    public function join(User $user, VideoMeeting $meeting): bool
    {
        if ($user->id === $meeting->caller_id || $user->id === $meeting->receiver_id) {
            return true;
        }

        if ($meeting->booking) {
            if ($meeting->booking->user_id === $user->id) {
                return true;
            }

            if ($meeting->booking->professional?->user_id === $user->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can terminate this session.
     */
    public function end(User $user, VideoMeeting $meeting): bool
    {
        return $this->join($user, $meeting);
    }
}
