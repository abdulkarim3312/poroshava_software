<?php

namespace App\Models\AutoRickshaw;

use Illuminate\Database\Eloquent\Model;

class AutoRickshawOwnerLicense extends Model
{
     protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(AutoRickshawType::class,'type_id','id');
     }
}
