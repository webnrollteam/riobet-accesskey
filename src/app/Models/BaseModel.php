<?php

namespace Riobet\AccessKey\App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static function table()
    {
        return with(new static)->getTable();
    }
}
