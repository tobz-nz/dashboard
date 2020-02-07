<?php

namespace App;

use App\Account;
use App\Device;
use Creativeorange\Gravatar\Facades\Gravatar;
use function GuzzleHttp\json_decode;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Cashier\Billable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Billable, Impersonate;
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
        'preferences',
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
        'email_verified_at',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'apn_tokens' => 'array',
        'preferences' => 'object',
    ];

    /**
     * @inheritdoc
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

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
     * Fetch a cache key for specified cached resources
     *
     * @param string $key
     * @return void
     */
    public function getCachKey(string $key = null)
    {
        $cacheKeys = [
            'devices' => sprintf('users.%d.devices', $this->id),
        ];

        return $cacheKeys[$key] ?? sprintf('users.%d', $this->id);
    }

    /**
     * Check if push notifications are enabled
     *
     * @return boolean
     */
    public function pushEnabled()
    {
        return $this->pushSubscriptions()->count() ||
            count($this->apn_tokens ?? []);
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->id === 1;
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
     * Decode preferences with safety catch
     *
     * @param string $value
     * @return mixed
     */
    public function getPreferencesAttribute($value)
    {
        return optional((object) json_decode($value ?: '[]'));
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

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return $this->slack_webhook_url ?? config('services.slack.webhook_url');
    }
}
