<?php

namespace Modules\Auth\Listeners;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Auth\Events\UserCreated;

class SendVerificationEmail
{
    /**
     * Handle the event.
     *
     * @param  \Modules\Auth\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
