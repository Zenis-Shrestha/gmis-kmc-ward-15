<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'road';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'gid';

    /**
     * Get the street associated with road.
     */
    public function street()
    {
        return $this->belongsTo('App\Street', 'strtcd', 'strtcd');
    }

    /**
     * Get the verification yes no associated with road.
     */
    public function verfYesNo()
    {
        return $this->belongsTo('App\VerfYesNo', 'vflag', 'value');
    }

    /**
     * Get the address zone associated with road.
     */
    public function addZone()
    {
        return $this->belongsTo('App\AddZone', 'addrzn', 'value');
    }

    /**
     * Get the road hierarchy associated with road.
     */
    public function roadHierarchy()
    {
        return $this->belongsTo('App\RoadHierarchy', 'rdhier', 'value');
    }

    /**
     * Get the road surface associated with road.
     */
    public function roadSurface()
    {
        return $this->belongsTo('App\RoadSurface', 'rdsurf', 'value');
    }
}
