<?php

namespace App;

use App\Alert;
use App\Concerns\HasVolume;
use App\DeviceMetric;
use App\Model;
use App\User;
use DateTime;
use Givebutter\LaravelKeyable\Keyable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Device extends Model
{
    use SoftDeletes;
    use Keyable;
    use HasVolume;

    /**
     * @inheritdoc
     */
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
        'last_seen_at',
    ];

    /**
     * @inheritdoc
     */
    public $hidden = [
        'id',
        'api_token',
        'deleted_at',
    ];

    /**
     * @inheritdoc
     */
    public $casts = [
        'address' => 'object',
        'dimensions' => 'object',
        'meta' => 'object',
    ];

    /**
     * @inheritdoc
     */
    public $dates = [
        'last_seen_at',
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

    public function getDate(string $dateAttribute): Carbon
    {
        $timezone = optional($this->meta)->timezone ?: config('app.timezone');
        return $this->$dateAttribute->timezone($timezone);
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
        return $this->hasMany(DeviceMetric::class);
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
