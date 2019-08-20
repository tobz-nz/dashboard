<?php

namespace App\Listeners;

use App\Events\DeviceSeen;
use App\Events\MetricRecorded;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastSeenAt
{
    use InteractsWithQueue;

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
     * @param  MetricRecorded  $event
     * @return void
     */
    public function handle(DeviceSeen $event)
    {
        $event->device->update([
            'last_seen_at' => new Carbon,
        ]);
    }
}
