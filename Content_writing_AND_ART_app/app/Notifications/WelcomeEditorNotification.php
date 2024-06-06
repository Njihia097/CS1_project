<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class WelcomeEditorNotification extends VerifyEmailNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        // $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
        ->subject('Welcome to Our Platform')
        ->greeting('Hello ' . $notifiable->name . ',')
        ->line('You have been registered as an editor on our platform.')
        ->line('To complete your registration, please verify your email and set your password.')
        ->line('Here are the steps:')
        ->line('1. Click the "Verify Email" button below.')
        ->line('2. On the verification page, click "Forgot your password?" to reset your password.')
        ->line('3. Follow the instructions in the password reset email to set a new password.')
        ->action('Verify Email', url('/email/verify'))
        ->line('Thank you for joining us!');
    }

    /**
     * Get the verification URL for the given notifiable.
     */

     protected function verifyUrl($notifiable)
     {
        return URL::temporarySignedRoute(
            'verifycation.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
     }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
