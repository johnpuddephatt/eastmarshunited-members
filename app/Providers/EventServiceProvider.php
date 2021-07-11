<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\Approved;
use App\Events\ExchangeCreated;
use App\Events\ExchangeApproved;
use App\Events\ExchangeCompleted;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\SendAccountVerificationNotification;
use App\Listeners\SendAccountApprovedNotification;
use App\Listeners\SendExchangeCreatedNotification;
use App\Listeners\SendExchangeApprovedNotification;
use App\Listeners\SendExchangeCompletedNotification;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendAccountVerificationNotification::class,
        ],
        Approved::class => [
            SendAccountApprovedNotification::class
        ],
        ExchangeCreated::class => [
            SendExchangeCreatedNotification::class
        ],
        ExchangeApproved::class => [
            SendExchangeApprovedNotification::class
        ],
        ExchangeCompleted::class => [
            SendExchangeCompletedNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
