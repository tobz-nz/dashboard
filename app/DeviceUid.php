<?php

namespace App;

use App\Model;

class DeviceUid extends Model
{
    protected $primaryKey = 'uid';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'registered_at',
    ];

    protected $casts = [
        'uid' => 'string',
    ];
}
