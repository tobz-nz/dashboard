<?php

namespace App\Listeners;

use App\Alert;
use App\Events\MetricRecorded;
use App\Notifications\LevelAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class LevelCheck
{
    use InteractsWithQueue;

    protected $device;

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
    public function handle(MetricRecorded $event)
    {
        $triggeredAlert = null;
        $this->device = $event->device;

        // Load alerts
        $alerts = $this->device->alerts;

        // get last alert raised
        $lastAlert = $this->lastAlert($alerts);

        // loop through alerts and check direction and percent
        $alerts->each(function ($alert) use ($lastAlert, &$triggeredAlert) {
            // Level dropping
            if ($this->LevelDroppedTo($alert)) {
                // device level is lower than the alert & the alert is triggered on drop/change
                $triggeredAlert = $alert;
                return;
            }

            // Level rising
            if ($this->LevelRoseTo($alert)) {
                // device level is higher than the alert & the alert is triggered on rise/change
                $triggeredAlert = $alert;
                return;
            }
        });

        if ($triggeredAlert && $triggeredAlert->isNot($lastAlert)) {
            // send alert notification
            $this->device->owner->notify(new LevelAlert($this->device, $triggeredAlert));

            // Update lastAlert value
            $meta = $this->device->meta;
            $meta->lastAlert = $triggeredAlert->id;
            $this->device->meta = $meta;
            $this->device->save();
        }
    }

    private function LevelDroppedTo(Alert $alert): bool
    {
        return $this->device->currentPercent <= $alert->percent &&
            in_array($alert->trigger, [Alert::DROPPED, Alert::CHANGED]);
    }

    private function LevelRoseTo(Alert $alert): bool
    {
        return $this->device->currentPercent >= $alert->percent &&
            in_array($alert->trigger, [Alert::ROSE, Alert::CHANGED]);
    }

    private function lastAlert(Collection $alerts):? Alert
    {
        if (!$this->device->meta || !$this->device->meta->lastAlert) {
            return null;
        }

        return $alerts->filter(function ($alert) {
            return $alert->id === $this->device->meta->lastAlert;
        })->first();
    }
}