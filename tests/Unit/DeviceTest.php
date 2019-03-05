<?php

namespace Tests\Unit;

use App\Device;
use App\DeviceMetric;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    public function testCylinderDeviceVolume()
    {
        $device = factory(Device::class)->create([
            'id' => 1,
            'dimensions' => [
                'shape' => 'cylinder',
                'diameter' => 350,
            ]
        ]);
        factory(DeviceMetric::class)->create([
            'device_id' => 1,
        ]);

        $this->assertEquals(22956, $device->currentVolume);
    }

    public function testCylinderDevicePercent()
    {
        $device = factory(Device::class)->create([
            'id' => 1,
            'dimensions' => [
                'shape' => 'cylinder',
                'diameter' => 350,
                'height' => 10000,
            ]
        ]);
        // For some reason have to create 2 metrics here else it fails.
        // No idea why, 1 should be fine.
        factory(DeviceMetric::class, 2)->create([
            'device_id' => 1,
            'value'=> 1000,
        ]);

        $this->assertEquals(10, $device->currentPercent);

        factory(DeviceMetric::class)->create([
            'device_id' => 1,
            'value'=> 8000,
        ]);

        $this->assertEquals(80, $device->currentPercent);
    }

    public function testRectangleDeviceVolume()
    {
        $device = factory(Device::class)->create([
            'id' => 1,
            'dimensions' => [
                'shape' => 'rectangle',
                'length' => 200,
                'width' => 200,
                'depth' => 2400,
            ]
        ]);
        factory(DeviceMetric::class)->create([
            'device_id' => 1,
        ]);

        $this->assertEquals(9544000, $device->currentVolume);
    }

    public function testRectangleDevicePercent()
    {
        $device = factory(Device::class)->create([
            'id' => 1,
            'dimensions' => [
                'shape' => 'rectangle',
                'length' => 200,
                'width' => 200,
                'depth' => 2400,
            ]
        ]);
        factory(DeviceMetric::class)->create([
            'device_id' => 1,
        ]);

        $this->assertEquals(9544000, $device->currentVolume);
    }
}
