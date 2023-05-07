<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessTaxPaymentStatus extends Model
{
    protected $table = 'business_tax_payment_status';
    protected $primaryKey = 'business_tax_payment_id';

    public static function selectAll(){
        return BusinessTaxPaymentStatus::select('registration', 'ward', 'due_year', 'match');
    }
}