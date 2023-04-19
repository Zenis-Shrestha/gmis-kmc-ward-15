<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ByLaw extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bylaws';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'gid';
}
