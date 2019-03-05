<?php

namespace App\Policies;

use App\Device;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
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
        if (array_search($user->email, ['tobz.nz@gmail.com'])) {
            return true;
        }
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
        return $user->can('manageDevices');
    }

    /**
     * Determine whether the user can view the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function view(User $user, Device $device)
    {
        return $device->owner_id === $user->id;
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // @todo add limiter
        return true;
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function update(User $user, Device $device)
    {
        return $device->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function delete(User $user, Device $device)
    {
        return $device->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function restore(User $user, Device $device)
    {
        return $device->owner_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function forceDelete(User $user, Device $device)
    {
        return $device->owner_id === $user->id;
    }
}
