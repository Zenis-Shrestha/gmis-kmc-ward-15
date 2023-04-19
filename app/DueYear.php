<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DueYear extends Model
{
    // use HasFactory;

    protected $table = 'due_years';
    protected $primaryKey = 'id';

    public static function getInAscOrder(){
        return DueYear::orderBy('id', 'asc')->pluck('name', 'name')->all();
    }
}
