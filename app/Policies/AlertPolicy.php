<?php

namespace App\Policies;

use App\Alert;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlertPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Alerts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the alert.
     *
     * @param  \App\User  $user
     * @param  \App\Alert  $alert
     * @return mixed
     */
    public function view(User $user, Alert $alert)
    {
        return $user->devices()->whereHas('alerts', function ($query) use ($alert) {
            $query->whereId($alert->id);
        })->exists();
    }

    /**
     * Determine whether the user can create alerts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // @todo Check subscription limitations
    }

    /**
     * Determine whether the user can update the alert.
     *
     * @param  \App\User  $user
     * @param  \App\Alert  $alert
     * @return mixed
     */
    public function update(User $user, Alert $alert)
    {
        return $this->view($user, $alert);
    }

    /**
     * Determine whether the user can delete the alert.
     *
     * @param  \App\User  $user
     * @param  \App\Alert  $alert
     * @return mixed
     */
    public function delete(User $user, Alert $alert)
    {
        // @todo Check subscription limitations

        return $this->view($user, $alert);
    }

    /**
     * Determine whether the user can restore the alert.
     *
     * @param  \App\User  $user
     * @param  \App\Alert  $alert
     * @return mixed
     */
    public function restore(User $user, Alert $alert)
    {
        // @todo Check subscription limitations

        return $this->view($user, $alert);
    }

    /**
     * Determine whether the user can permanently delete the alert.
     *
     * @param  \App\User  $user
     * @param  \App\Alert  $alert
     * @return mixed
     */
    public function forceDelete(User $user, Alert $alert)
    {
        //
    }
}
