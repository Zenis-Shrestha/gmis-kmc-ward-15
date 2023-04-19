<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function nullIfBlank($field)
    {
        return trim($field) !== '' ? $field : null;
    }
}
