<?php

namespace App\Concerns;

trait HasVolume
{
    /**
     * Get the current percent level
     *
     * @return int
     */
    public function getCurrentPercentAttribute(): int
    {
        return round($this->currentLevel / data_get($this->dimensions, 'height', 0) * 100);
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
}
