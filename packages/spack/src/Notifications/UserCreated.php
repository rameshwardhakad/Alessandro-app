<?php

namespace Spack\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $password)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('You are added as team member'))
            ->greeting(__('Hi,').' '.$notifiable->name)
            ->line(__('You are added as team member'))
            ->line(__('Please use the following login credentials').':')
            ->line(new HtmlString(__('Email').': <strong>'.$notifiable->email.'</strong>'))
            ->line(new HtmlString(__('Password').': <strong>'.$this->password.'</strong>'))
            ->action(__('Click here to login'), url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            //
        ];
    }
}
