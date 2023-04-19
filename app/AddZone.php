<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddZone extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addzone';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'gid';
}
