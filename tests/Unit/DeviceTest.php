<?php

namespace Tests\Unit;

use App\Device;
use App\DeviceMetric;
use App\DeviceUid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    public function testCylinderDeviceVolume()
    {
        $device = $this->makeDevice([
            'dimensions' => [
                'shape' => 'cylinder',
                'diameter' => 350,
                'height' => 1000,
            ]
        ]);
        factory(DeviceMetric::class)->create([
            'device_id' => $device->id,
            'value' => 1000,
        ]);

        $this->assertEquals(9621, $device->currentVolume);
    }

    public function testCylinderDevicePercent()
    {
        $device = $this->makeDevice([
            'dimensions' => [
                'shape' => 'cylinder',
                'diameter' => 350,
                'height' => 10000,
            ]
        ]);

        factory(DeviceMetric::class)->create([
            'device_id' => $device->id,
            'value' => 1000,
            'created_at' => Carbon::now()->subDay(),
        ]);

        $this->assertEquals(10, $device->currentPercent);

        factory(DeviceMetric::class)->create([
            'device_id' => $device->id,
            'value' => 8000,
            'created_at' => Carbon::now(),
        ]);

        $this->assertEquals(80, $device->currentPercent);
    }

    public function testRectangleDeviceVolume()
    {
        $device = $this->makeDevice([
            'dimensions' => [
                'shape' => 'rectangle',
                'length' => 200,
                'width' => 200,
            ]
        ]);
        factory(DeviceMetric::class)->create([
            'device_id' => $device->id,
            'value' => 2400,
        ]);

        $this->assertEquals(9600000, $device->currentVolume);
    }

    public function testRectangleDevicePercent()
    {
        $device = $this->makeDevice([
            'dimensions' => [
                'shape' => 'rectangle',
                'length' => 200,
                'width' => 200,
                'height' => 1000,
            ]
        ]);
        factory(DeviceMetric::class)->create([
            'device_id' => $device->id,
            'value' => 500,
        ]);

        $this->assertEquals(50, $device->currentPercent);
    }

    public function testDeviceDaysLeft()
    {
        $device = $this->makeDevice([
            'dimensions' => [
                'shape' => 'cylinder',
                'diameter' => 350,
                'height' => 20000,
            ]
        ]);

        for ($i = 0; $i < 11; $i++) {
            factory(DeviceMetric::class)->create([
                'device_id' => $device->id,
                'value' => 2000 - (100 * $i),
                'created_at' => Carbon::now()->subDays(11)->addDays($i),
            ]);
        }

        $this->assertEquals(10, $device->daysRemaining);
    }

    /**
     * Seed a device
     *
     * @param array $attributes
     * @return \App\Device
     */
    private function makeDevice(array $attributes): Device
    {
        $uid = factory(DeviceUid::class)->create();
        return factory(Device::class)->create($attributes + ['uid' => $uid->uid]);
    }
}
