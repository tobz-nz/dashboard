<?php

namespace App\Providers;

use App\Events\DeviceSeen;
use App\Events\MetricRecorded;
use App\Listeners\LevelCheck;
use App\Listeners\UpdateLastSeenAt;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        ],

        DeviceSeen::class => [
            UpdateLastSeenAt::class,
        ],

        MetricRecorded::class => [
            LevelCheck::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
