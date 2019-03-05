<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceUid extends Model
{
    public $timestamps = false;

    protected $casts = [
        'uid' => 'string',
    ];
}
