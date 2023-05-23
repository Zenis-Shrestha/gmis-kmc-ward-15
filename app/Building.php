<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bldg';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'bin';

    /**
     * Get the ward associated with building.
     */
    public function ward()
    {
        return $this->belongsTo('App\Ward', 'ward', 'ward');
    }

    /**
     * Get the street associated with building.
     */
    public function street()
    {
        return $this->belongsTo('App\Street', 'strcd', 'strcd');
    }

    /**
     * Get the address zone associated with building.
     */
    public function addZone()
    {
        return $this->belongsTo('App\AddZone', 'addrzn', 'value');
    }

    /**
     * Get the building use associated with building.
     */
    public function buildingUse()
    {
        return $this->belongsTo('App\BuildingUse', 'bldguse');
    }

    /**
     * Get the building construction associated with building.
     */
    public function buildingConstr()
    {
        return $this->belongsTo('App\BuildingConstr', 'consttyp', 'value');
    }

    /**
     * Get the drinking water source associated with building.
     */
    public function drnkWtrSrc()
    {
        return $this->belongsTo('App\DrnkWtrSrc', 'drnkwtr', 'value');
    }

    /**
     * Get the drainage type associated with building.
     */
    public function drainage()
    {
        return $this->belongsTo('App\Drainage', 'wwdischg', 'value');
    }

    /**
     * Get the tax status associated with building.
     */
    public function taxStsCode()
    {
        return $this->belongsTo('App\TaxStsCode', 'btxsts', 'value');
    }

    /**
     * Get the yes no associated with building.
     */
    public function haddrpltYesNo()
    {
        return $this->belongsTo('App\YesNo', 'haddrplt', 'value');
    }

    /**
     * Get the yes no associated with building.
     */
    public function elecynYesNo()
    {
        return $this->belongsTo('App\YesNo', 'elecyn', 'value');
    }

    /**
     * Get the yes no associated with building.
     */
    public function bprmtynYesNo()
    {
        return $this->belongsTo('App\YesNo', 'haddrplt', 'value');
    }

    /**
     * Get the yes no associated with building.
     */
    public function toilynYesNo()
    {
        return $this->belongsTo('App\YesNo', 'toilyn', 'value');
    }

    /**
     * Get the yes no associated with building.
     */
    public function swsegynYesNo()
    {
        return $this->belongsTo('App\YesNo', 'swsegyn', 'value');
    }

    /**
     * Get the verification yes no associated with building.
     */
    public function addvflagVerfYesNo()
    {
        return $this->belongsTo('App\VerfYesNo', 'addvflag', 'value');
    }

    /**
     * Get the verification yes no associated with building.
     */
    public function buildvflagVerfYesNo()
    {
        return $this->belongsTo('App\VerfYesNo', 'buildvflag', 'value');
    }
    public function businesses()
    {
        return $this->hasMany(BuildingBusiness::class, 'bin');
    }
    public function rents()
    {
        return $this->hasMany(BuildingRent::class, 'bin');
    }
}
