<?php

namespace App\Listeners;

use App\Events\ExchangeCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExchangeCompletedNotification;

class SendExchangeCompletedNotification
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
    public function handle(ExchangeCompleted $event)
    {
        $event->exchange->source_user->notify(new ExchangeCompletedNotification($event->exchange, $event->message));
    }
}
