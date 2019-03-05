<?php

namespace App\Policies;

use App\Nova\DeviceMetric;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MetricPolicy
{
    use HandlesAuthorization;

    /**
     * Allow super admins to do all actions
     *
     * @param  \App\User $user
     * @param  string $ability
     * @return bool|void
     */
    public function before($user, $ability)
    {
        if ($user->hasRole('Super')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the metric.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceMetric  $metric
     * @return mixed
     */
    public function view(User $user, DeviceMetric $metric)
    {
        return false;
    }

    /**
     * Determine whether the user can create metrics.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the metric.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceMetric  $metric
     * @return mixed
     */
    public function update(User $user, DeviceMetric $metric)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the metric.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceMetric  $metric
     * @return mixed
     */
    public function delete(User $user, DeviceMetric $metric)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the metric.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceMetric  $metric
     * @return mixed
     */
    public function restore(User $user, DeviceMetric $metric)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the metric.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceMetric  $metric
     * @return mixed
     */
    public function forceDelete(User $user, DeviceMetric $metric)
    {
        return false;
    }
}
