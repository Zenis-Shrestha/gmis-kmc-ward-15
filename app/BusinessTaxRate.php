<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessTaxRate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business_tax_rates';

    /**
     * Specify the primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    
}
