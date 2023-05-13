<?php

namespace App\Listeners;

use App\Events\WelcomeNotification;
use App\Mail\usermail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WelcomeNotification  $event
     * @return void
     */
    public function handle(WelcomeNotification $event)
    {
        Mail::to($event->notificationData['email'])->send(new usermail($event->notificationData));
    }
}
