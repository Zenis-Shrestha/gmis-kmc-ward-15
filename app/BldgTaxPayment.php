<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class BldgTaxPayment extends Model
{
    
    protected $table = 'bldg_tax_payments';
    protected $fillable = [
        'bin', 'owner_name', 'fiscal_year', 'tax_paid_end_at'
        
    ];
    public static function selectAll(){
        return TaxPayment::select('bin', 'fiscal_year', 'due_year', 'match');
    }
}