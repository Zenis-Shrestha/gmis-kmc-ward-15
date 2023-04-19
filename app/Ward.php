<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wardpl';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'gid';
}
