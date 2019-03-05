<?php

use App\Device;
use App\DeviceUid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DeviceUid::class)->create([
            'uid' => '30aea44e6b24',
            'registered_at' => new Carbon,
        ]);

        factory(DeviceUid::class, 5)->create();

        factory(Device::class)->create([
            'uid' => '30aea44e6b24',
        ]);
    }
}
