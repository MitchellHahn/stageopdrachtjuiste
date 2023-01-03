<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteNotification extends Notification implements ShouldQueue {

    use Queueable;

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage {
        return (new MailMessage())
            ->line('U bent uitgenodigd voor het exposanten systeem.')
            ->action('Klik hier om uw account te activeren', route('accounts.invite.accept', ['user' => $notifiable]))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array {
        return [

        ];
    }
}
