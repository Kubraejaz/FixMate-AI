<?php

namespace App\Notifications\Channels;

use App\Services\SmsService;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toSms') || ! $notifiable->phone) {
            return;
        }

        $message = $notification->toSms($notifiable);

        app(SmsService::class)->send($notifiable->phone, $message);
    }
}