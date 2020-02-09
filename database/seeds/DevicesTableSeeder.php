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
        ])->each(function ($uid) {
            factory(Device::class)->create([
                'uid' => $uid->uid,
                'api_token' => 'api-token',
            ]);
        });

        factory(DeviceUid::class, 2)->create([
        ])->each(function ($uid) {
            factory(Device::class)->create([
                'uid' => $uid->uid,
            ]);
        });

    }
}
