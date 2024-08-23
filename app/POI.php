<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\TypeOf;
class POI extends Model
{     use SoftDeletes;
    protected $table = 'point_of_interest';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $with =['typeUse'];

    public function typeUse(){
        return $this->belongsTo(TypeOf::class,'type','id');
    }
}
