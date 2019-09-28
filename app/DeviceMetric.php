<?php

namespace App;

use App\Device;
use App\Model;

class DeviceMetric extends Model
{
    protected $table = 'device_metrics';

    protected $fillable = [
        'device_id',
        'value',
        'type',
        'meta',
    ];

    protected $casts = [
        'value' => 'float',
        'meta' => 'object',
    ];

    protected $touches = [
        'device',
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
