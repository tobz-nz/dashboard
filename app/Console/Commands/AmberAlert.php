<?php

namespace App\Console\Commands;

use App\Device;
use App\Notifications\DeviceFoundNotification;
use App\Notifications\DeviceMissingNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AmberAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tankful:amber {--W|within=60 : Number of minutes that a device can be missing for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify of any missing devices that have not been seen in a while';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $minutes = (int) $this->option('within') ?: 60;

        Device::whereRaw(sprintf('last_seen_at < NOW() - INTERVAL \'%d minutes\'', $minutes))
        // Device::whereRaw('last_seen_at < NOW() - INTERVAL \'? minutes\'', [$minutes])
            ->where('meta->is_missing', '!=', true)
            ->chunk(100, function ($missingDevices) {
                $missingDevices->each(function ($device) {
                    $this->error("{$device->name} Missing");
                    $device->owner->notify(new DeviceMissingNotification($device));
                    $device->setAttribute('meta->is_missing', true)->save();
                });
            });

        Device::whereRaw(sprintf('last_seen_at > NOW() - INTERVAL \'%d minutes\'', $minutes))
        // Device::whereRaw('last_seen_at > NOW() - INTERVAL \'? minutes\'', [$minutes])
            ->where(['meta->is_missing' => true])
            ->chunk(100, function ($missingDevices) {
                $missingDevices->each(function ($device) {
                    $this->info("{$device->name} Found");
                    $device->owner->notify(new DeviceFoundNotification($device));
                    $device->setAttribute('meta->is_missing', false)->save();
                });
            });
    }
}
