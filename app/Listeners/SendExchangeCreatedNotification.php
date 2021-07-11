<?php

namespace App\Listeners;

use App\Events\ExchangeCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExchangeCreatedNotification;

class SendExchangeCreatedNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(ExchangeCreated $event)
    {
        $event->exchange->recipient_user->notify(new ExchangeCreatedNotification($event->exchange, $event->message));
    }
}
