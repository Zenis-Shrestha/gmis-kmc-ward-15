<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxStsCode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tax_status_code';
    public function building(){
            return $this->hasMany('App\Building');

}

}
