<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingBusiness extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bldg_business_tax';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    
}
