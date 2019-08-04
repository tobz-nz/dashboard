<?php

namespace App\Concerns;

use App\DeviceMetric;
use Illuminate\Support\Carbon;

trait HasVolume
{
    /**
     * Get the current percent level
     *
     * @return int
     */
    public function getCurrentPercentAttribute(): int
    {
        return (int) round($this->currentLevel / data_get($this->dimensions, 'height', 1) * 100);
    }

    /**
     * Get name & fallback to the uid if no name ste
     *
     * @param  string $name
     * @return string
     */
    public function getCurrentLevelAttribute($value): int
    {
        return $this->metrics()
            ->whereType('level')
            ->orderByDesc('id')
            ->value('value') ?: 0;
    }

    /**
     * Get name & fallback to the uid if no name ste
     *
     * @param  string $name
     * @return string
     */
    public function getCurrentAvgAttribute($value): int
    {
        return $this->metrics()
            ->where('created_at', function ($query) {
                return $query
                    ->select(\DB::raw('MAX(created_at)'))
                    ->from('device_metrics');
            })
            ->avg('value') ?: 0;
    }

    /**
     * Colculate the volume in Litres
     *
     * @param  int $valueInCm
     * @return int
     */
    public function getCurrentVolumeAttribute(int $value = null): int
    {
        $level = $value ?: $this->currentLevel;

        if (empty($level)) {
            return 0.0;
        }

        // value in cm (stored in mm)
        $valueInCm = $level / 10;

        if (optional($this->dimensions)->shape === 'cylinder') {
            // radius in cm
            $diameter = (int) $this->dimensions->diameter ?? 1;
            $radius = $diameter / 2;

            // Π x (radius)2 x Depth = cm3 / 1000 = litres
            // eg: round((pi() * pow(175, 2) * 222.2) / 1000, 2) = 21378.15 Litres
            return round(((pi() * pow($radius, 2)) * $valueInCm) / 1000);
        }

        if (optional($this->dimensions)->shape === 'rectangle') {
            $length = $this->dimensions->length;
            $width = $this->dimensions->width;

            return round($valueInCm * $width * $length);
        }

        throw \RuntimeException('Invalid Device Shape');
    }

    /**
     * Calculae the maximum possible volume in Litres
     *
     * @param  int $value
     * @return int
     */
    public function getMaxVolumeAttribute($value = null): int
    {
        return $this->getCurrentVolumeAttribute($this->dimensions->height);
    }

    /**
     * Get metrics limited to the last entry per day
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dailyMetrics($limit = null)
    {
        $table = DeviceMetric::make()->getTable();

        /*
        SELECT value, created_at
        FROM device_metrics
        INNER JOIN
        (
          SELECT
          MAX(created_at) AS max_created_at
          FROM device_metrics
          GROUP BY Date(`created_at`)
        ) AS t
        ON created_at = t.max_created_at
        */

        $sub = \DB::table($table)
            ->select(\DB::raw('max(created_at) AS max_created_at'))
            ->where(['device_id' => $this->getKey()])
            ->groupBy(\DB::raw('DATE(created_at)'));

        return $this->metrics()
            ->whereNull('deleted_at')
            ->joinSub($sub, 'm', function ($join) {
                $join->on('created_at', '=', 'm.max_created_at');
            })
            ->orderByDesc('max_created_at')
            ->limit($limit);
    }

    /**
     * Calculate the days remaining
     *
     * @return integer|null
     */
    public function getDaysRemainingAttribute(): ?int
    {
        // return days remaining
        return (int) $this->burnRate ? round($this->currentLevel / $this->burnRate) : null;
    }

    /**
     * Calculate the current burn rate
     *
     * @return int|null
     */
    public function getBurnRateAttribute(): ?int
    {
        // reverse so its chronological (we order most recent first by default)
        $dailies = $this->dailyMetrics()->take(30)->get();

        $last = optional($dailies->first())->value ?? 0;
        $burn = collect([]);

        foreach ($dailies as $metric) {
            if ($last - $metric->value > 0) {
                // We only want readings where the value has gone down
                $burn->push($last - $metric->value);
            }
            $last = $metric->value;
        }

        // if no readings to cound return null.
        // (time remaining is indeterminate)
        if ($burn->count() === 0) {
            return null;
        }

        // return the average daily burn rate
        return $burn->sum() / $burn->count();
    }
}
