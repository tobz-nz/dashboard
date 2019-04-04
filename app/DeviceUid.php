<?php

namespace App;

use App\Model;

class DeviceUid extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $casts = [
        'uid' => 'string',
    ];
}
