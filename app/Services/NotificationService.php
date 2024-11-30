<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    public function sendScheduleChangeNotification(
        Collection $users,
        string $title,
        string $message
    ): void {
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'type' => 'schedule_change'
            ]);
        }
    }

    public function markAsRead(int $notificationId): void
    {
        Notification::where('id', $notificationId)
            ->update(['is_read' => true]);
    }

    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }
} 
