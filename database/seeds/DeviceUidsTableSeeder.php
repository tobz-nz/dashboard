<?php

use App\DeviceUid;
use Illuminate\Database\Seeder;

class DeviceUidsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // real one
        factory(DeviceUid::class)->create([
            'uid' => '30aea44e6b24',
        ]);

        // fake ones
        factory(DeviceUid::class, 20)->create();
    }
}
