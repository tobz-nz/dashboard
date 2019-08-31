<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\PostgresConnection;

class Model extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    /**
     * @inheritdoc
     */
    public function getDateFormat()
    {
        if ($this->getConnection() instanceof PostgresConnection) {
            return $this->dateFormat ?: parent::getDateFormat();
        }

        parent::getDateFormat();
    }
}
