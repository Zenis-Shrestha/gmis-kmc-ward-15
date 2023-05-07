<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessTaxPayment extends Model
{
    
    protected $table = 'business_tax_payments';
    protected $fillable = [
        'registration', 'fiscal_year', 'tax_paid_end_at'
        
    ];
    public static function selectAll(){
        return BusinessTaxPayment::select('registration', 'fiscal_year', 'tax_paid_end_at');
    }
}