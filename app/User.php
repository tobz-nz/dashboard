<?php

namespace App;

use App\Account;
use App\Device;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Billable;
    use HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'apn_tokens',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
        'apn_tokens',
        'remember_token',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'apn_tokens' => 'array',
    ];

    /**
     * Get user APN tokens
     *
     * @return array
     */
    public function routeNotificationForApn(): array
    {
        return $this->apn_tokens;
    }

    /**
     * Avatar image
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        return Gravatar::fallback(asset('images/icons.svg#avatar'))
            ->get($this->email);
    }

    /**
     * Device relstionship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany(Device::class, 'owner_id');
    }

    /**
     * Device relstionship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }
}
