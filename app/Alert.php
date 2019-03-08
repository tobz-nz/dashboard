<?php

namespace App;

use App\Device;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    public const DROPPED = 1;
    public const ROSE = 2;
    public const CHANGED = 3;

    public const TRIGGERS = [
        Alert::DROPPED => 'Dropped',
        Alert::ROSE => 'Rose',
        Alert::CHANGED => 'Changed',
    ];

    protected $fillable = [
        'trigger',
        'percent'
    ];

    protected $casts = [
        'trigger' => 'integer',
        'percent' => 'integer',
    ];

    protected $appends = [
        'triggered_on',
    ];

    public $timestamps = false;

    public function getTriggeredOnAttribute()
    {
        return static::TRIGGERS[$this->trigger];
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
