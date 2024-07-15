<?php

namespace App\Notifications;

use App\Models\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContentStatusUpdateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $content;

    /**
     * Create a new notification instance.
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Your content status has been updated.')
                    ->action('View Content', url('/content/'.$this->content->ContentID))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Content Status Updated',
            'message' => 'Your content titled "' . $this->content->Title . '" has been updated to ' . $this->content->Status . '.',
            'content_id' => $this->content->ContentID,
            'status' => $this->content->Status,
        ];
    }
}
