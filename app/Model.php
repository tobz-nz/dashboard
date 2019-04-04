<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
