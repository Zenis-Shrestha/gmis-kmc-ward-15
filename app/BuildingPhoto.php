<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingPhoto extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bldg_photos';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    
}
