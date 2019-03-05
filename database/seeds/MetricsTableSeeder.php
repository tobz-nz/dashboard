<?php

use App\DeviceMetric;
use Illuminate\Database\Seeder;

class MetricsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DeviceMetric::class, 50)->create(['device_id' => 1]);
    }
}
