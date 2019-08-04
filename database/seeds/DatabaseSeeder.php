<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        // $this->call(DeviceUidsTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
        $this->call(MetricsTableSeeder::class);
    }
}
