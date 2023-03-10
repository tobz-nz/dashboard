<?php

namespace App\Concerns;

use App\DeviceMetric;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

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
     * Get current level
     *
     * @param  string $value
     * @return string
     */
    public function getCurrentLevelAttribute($value): int
    {
        return app('cache')
            ->tags([
                "device.{$this->id}",
            ])
            ->rememberForever("currentlevel.{$this->id}", function () {
                return $this->metrics()
                    ->whereType('level')
                    ->orderByDesc('id')
                    ->value('value') ?: 0;
            });
    }

    /**
     * Get name & fallback to the uid if no name ste
     *
     * @param  string $name
     * @return string
     */
    public function getCurrentAvgAttribute($value): int
    {
        return app('cache')
            ->tags([
                "device.{$this->id}",
            ])
            ->rememberForever("currentAvg.{$this->id}", function () {
                return $this->metrics()
                    ->where('created_at', function ($query) {
                        return $query
                            ->select(DB::raw('MAX(created_at)'))
                            ->from('device_metrics');
                    })
                    ->avg('value') ?: 0;
            });
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
            return 0;
        }

        return $this->mmToLitres($level);
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
     * Get the colour to use for the current level
     *
     * @return string
     */
    public function getLevelColorAttribute(): string
    {
        if ($this->currentPercent >= 65) {
            return '--green-2';
        }

        if ($this->currentPercent >= 40) {
            return '--yellow-2';
        }

        return '--red-1';
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
        SELECT
            value,
            (created_at AT TIME ZONE 'UTC')::TIMESTAMPTZ AS created_at
        FROM
            device_metrics
            INNER JOIN (
                SELECT
                    MAX(created_at) AT TIME ZONE 'UTC') AS max_created_at
                FROM
                    device_metrics
                WHERE
                    deleted_at IS NULL
                GROUP BY
                    Date(created_at)) AS t ON created_at = t.max_created_at AT TIME ZONE 'UTC'
        ORDER BY
            max_created_at
        */

        $timezone = optional($this->meta)->timezone ?? 'UTC';

        $sub = DB::table($table)
            ->select(DB::raw("max(created_at AT TIME ZONE '{$timezone}') AS max_created_at"))
            ->where(['device_id' => $this->getKey()])
            ->whereNull('deleted_at')
            ->groupBy(DB::raw("DATE(created_at AT TIME ZONE '{$timezone}')"));

        return $this->metrics()
            ->select(
                'value',
                // Note the type cast is required to add the timezone offset to the formated date
                // Also note, that the offset is always +00 instead of the actual offset. No idea why.
                DB::raw("(created_at AT TIME ZONE '{$timezone}')::TIMESTAMPTZ as created_at")
            )
            ->whereNull('deleted_at')
            ->joinSub($sub, 'm', function ($join) use ($timezone) {
                $join->on('created_at', '=', DB::raw("m.max_created_at AT TIME ZONE '{$timezone}'"));
            })
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
        return (int) $this->burnRate ? ceil($this->currentLevel / $this->burnRate) : null;
    }

    /**
     * Calculate the current burn rate
     *
     * @return int|null
     */
    public function getBurnRateAttribute(): ?int
    {
        $dailies = app('cache')
            ->tags([
                "device.{$this->id}",
            ])->remember("burnRate.{$this->id}", 1/2, function () {
                return $this->dailyMetrics(30)
                    ->orderByDesc('max_created_at')
                    ->get()
                    ->reverse();
            });

        $last = optional($dailies->first())->value ?? 0;
        $burn = collect([]);

        foreach ($dailies as $metric) {
            $val = $last - $metric->value;
            if ($val > 0) {
                // We only want readings where the value has gone down
                $burn->push($val);
            }
            $last = $metric->value;
        }

        // if no readings to cound return null.
        // (time remaining is indeterminate)
        if ($burn->count() === 0) {
            return 0;
        }

        // return the average daily burn rate
        return $burn->sum() / $burn->count();
    }

    /**
     * Calculate mm of depth to cubic Litres
     *
     * @param float $valueInMm
     * @return int
     */
    public function mmToLitres(float $valueInMm): float
    {
        if (optional($this->dimensions)->shape === 'cylinder') {
            // radius in cm
            $diameter = (int) $this->dimensions->diameter ?? 1;
            $radius = $diameter / 2;

            // ?? x (radius)2 x Depth = cm3 / 1000 = litres
            // eg: round((pi() * pow(175, 2) * 222.2) / 1000, 2) = 21378.15 Litres
            return round(((pi() * pow($radius, 2)) * $valueInMm) / 10000);
        }

        if (optional($this->dimensions)->shape === 'rectangle') {
            $length = $this->dimensions->length;
            $width = $this->dimensions->width;

            return round($valueInMm * $width * $length);
        }

        throw new RuntimeException('Invalid Device Shape');
    }
}
