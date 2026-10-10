<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends TechnicianController
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = $user->notifications()->latest();

        if ($request->input('filter') === 'unread') {
            $query->unread();
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $notifications = $query->paginate($perPage);

        return $this->ok(NotificationResource::collection($notifications->items()), 'Notifications retrieved.', [
            'current_page' => $notifications->currentPage(),
            'per_page' => $notifications->perPage(),
            'total' => $notifications->total(),
            'last_page' => $notifications->lastPage(),
            'unread_count' => $user->notifications()->unread()->count(),
        ]);
    }

    public function markRead(Request $request, Notification $notification): JsonResponse
    {
        if ($notification->user_id === $request->user()->id) {
            $notification->update(['is_read' => true]);
        }

        return $this->ok([
            'unread_count' => $request->user()->notifications()->unread()->count(),
        ], 'Notification marked as read.');
    }

    public function markAllRead(Request $request): JsonResponse
    {
        $request->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return $this->ok(['unread_count' => 0], 'All notifications marked as read.');
    }
}
