<?php

namespace App\Listeners;

use App\Events\ExchangeApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExchangeApprovedNotification;

class SendExchangeApprovedNotification
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
    public function handle(ExchangeApproved $event)
    {
        $event->exchange->source_user->notify(new ExchangeApprovedNotification($event->exchange, $event->message));
    }
}
