<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification
{
    use Queueable;

    public function __construct(public string $code) {}

    public function via(object $notifiable): array
    {
        return $notifiable->phone ? ['sms'] : ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your FixMate AI Verification Code')
            ->line('Your verification code is:')
            ->line('**'.$this->code.'**')
            ->line('This code expires in 10 minutes.');
    }

    public function toSms(object $notifiable): string
    {
        return 'Your FixMate AI verification code is '.$this->code.'. It expires in 10 minutes.';
    }
}