<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\PasswordSetupNotification;

class SendPasswordSetupNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;
        if($user->hasRole('editor')) {
            //send password setup link
            $token = app('auth.password.broker')->createToken($user);
            $user->notify(new PasswordSetupNotification($token));
        }
    }
}
