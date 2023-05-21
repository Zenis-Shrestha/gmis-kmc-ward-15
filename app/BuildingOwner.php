<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingOwner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bldg_owners';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    
}
