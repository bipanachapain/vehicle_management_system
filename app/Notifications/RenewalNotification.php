<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;


class RenewalNotification extends Notification
{
    use Queueable;
    public $text;

    /**
     * Create a new notification instance.
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','webpush'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Renewable Document Expiry Alert')
             ->line($this->text) 
            // ->action('Notification Action', url('/'))
            ->action('Notification Action', route('user.renewables'))
            ->line('Thank you for using our application!');
    }

//     public function toWebPush($notifiable, $notification)
//    {
//     return (new WebPushMessage)
//         ->title('Document Expiry Alert')
//         ->icon('/icon.png')
//         ->body($this->text)
//         ->action('View Details', url('/my-renewables'));
//    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->text,
        ];
    }
    
}
