<?php

namespace App\Listeners;

use App\Events\ContractorWelcome;
use App\Mail\contractormail;
use App\Mail\usermail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendContractorWelcome
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
     * @param  \App\Events\ContractorWelcome  $event
     * @return void
     */
    public function handle(ContractorWelcome $event)
    {

        Mail::to($event->notificationData['email'])->send(new contractormail($event->notificationData));

    }
}
