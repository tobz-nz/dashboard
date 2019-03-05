<?php

namespace App;

use App\Device;
use Illuminate\Database\Eloquent\Model;

class DeviceMetric extends Model
{
    protected $table = 'device_metrics';

    protected $casts = [
        'value' => 'float',
    ];

    /**
     * Device relationship
     *
     * @return \Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
