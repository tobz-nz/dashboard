<?php

namespace App\Observers;

use App\Device;
use App\DeviceUid;
use Illuminate\Support\Carbon;

class DeviceObserver
{
    /**
     * Handle the device "created" event.
     *
     * @param  \App\Device  $device
     * @return void
     */
    public function created(Device $device)
    {
        DeviceUid::where(['uid' => $device->uid, 'registered_at' => null])
            ->firstOrFail()
            ->update(['registered_at' => new Carbon]);

        $device->update([
            'last_seen_at' => new Carbon,
        ]);
    }

    /**
     * Handle the device "updated" event.
     *
     * @param  \App\Device  $device
     * @return void
     */
    public function updated(Device $device)
    {
        $this->flushCache($device);
    }

    /**
     * Handle the device "deleted" event.
     *
     * @param  \App\Device  $device
     * @return void
     */
    public function deleted(Device $device)
    {
        $this->flushCache($device);
    }

    /**
     * Handle the device "restored" event.
     *
     * @param  \App\Device  $device
     * @return void
     */
    public function restored(Device $device)
    {
        //
    }

    /**
     * Handle the device "force deleted" event.
     *
     * @param  \App\Device  $device
     * @return void
     */
    public function forceDeleted(Device $device)
    {
        $this->flushCache($device);
    }

    /**
     * Clear out any caches related to this device
     *
     * @return void
     */
    private function flushCache(Device $device)
    {
        app('cache')->tags([
            $device->owner->getCachKey('devices'),
            "device.{$device->id}",
        ])->flush();
    }
}
