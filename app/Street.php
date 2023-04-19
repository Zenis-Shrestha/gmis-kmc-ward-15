<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'street';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'gid';

    /**
     * Get the address zone associated with street.
     */
    public function addZone()
    {
        return $this->belongsTo('App\AddZone', 'addrzn', 'value');
    }

    /**
     * Get the verification yes no associated with building.
     */
    public function vflagVerfYesNo()
    {
        return $this->belongsTo('App\VerfYesNo', 'vflag', 'value');
    }
}
