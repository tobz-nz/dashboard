<?php

namespace App;

use App\Alert;
use App\Concerns\HasVolume;
use App\DeviceMetric;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Device extends Model
{
    use SoftDeletes;
    use HasVolume;

    public $fillable = [
        'uid',
        'api_token',
        'owner_id',
        'name',
        'color',
        'address',
        'household_size',
        'dimensions',
        'meta',
    ];

    public $hidden = [
        'id',
        'api_token',
    ];

    public $casts = [
        'address' => 'object',
        'dimensions' => 'object',
        'meta' => 'object',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }

    /**
     * Get name & fallback to the uid if no name ste
     *
     * @param  string $name
     * @return string
     */
    public function getNameAttribute($name)
    {
        return $name ?: $this->uid;
    }

    /**
     * Get name & fallback to the uid if no name ste
     *
     * @param  string $name
     * @return string
     */
    public function getBatteryLevelAttribute($value)
    {
        return $value ?: data_get($this->meta, 'battery.level', 'alert');
    }

    /**
     * Owner relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Metrics relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metrics()
    {
        return $this->hasMany(DeviceMetric::class)
            ->orderByDesc('created_at');
    }

    /**
     * Latest level metric
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentLevel()
    {
        return $this->hasOne(DeviceMetric::class)
            ->whereType('level')
            ->orderByDesc('id');
    }

    /**
     * Alert relationships
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts()
    {
        return $this->hasMany(Alert::class)
            ->orderByDesc('percent');
    }
}
