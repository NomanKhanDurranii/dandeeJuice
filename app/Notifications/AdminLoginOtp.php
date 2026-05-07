<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminLoginOtp extends Notification
{
    public function __construct(
        public string $code,
        public int $codeExpiryMinutes,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your DandeeJuice Admin Login Code')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line("Your one-time login code is: **{$this->code}**")
            ->line("This code expires in {$this->codeExpiryMinutes} minutes.")
            ->line('If you did not request this, please ignore this email.');
    }
}
