<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxPaymentStatus extends Model
{

    protected $table = 'tax_payment_status';
    protected $primaryKey = 'bin';

    public static function selectAll(){
        return TaxPaymentStatus::select('bin', 'owner_name', 'last_payment_date', 'due_year', 'match');
    }
}