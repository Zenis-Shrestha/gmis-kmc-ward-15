<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class TaxPayment extends Model
{
    
    protected $table = 'tax_payments';
    protected $fillable = [
        'bin', 'owner_name', 'gender', 'contact_no', 'last_payment_date'
        
    ];
    public static function selectAll(){
        return TaxPayment::select('bin', 'owner_name', 'last_payment_date', 'due_year', 'match');
    }
}