<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\PostgresConnection;

class Model extends BaseModel
{
    /**
     * @inheritdoc
     */
    public function getDateFormat()
    {
        if ($this->getConnection() instanceof PostgresConnection) {
            return 'Y-m-d H:i:sO';
        }

        return parent::getDateFormat();
    }
}
