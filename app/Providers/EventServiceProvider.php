<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /* the event to listener mappings for the application. @var array<class-string, array<int, class-string>> */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /* register any events for your application. @return void */
    public function boot()
    {

    }

    /* determine if events and listeners should be automatically discovered. @return bool */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
