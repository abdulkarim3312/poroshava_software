<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
     protected $guarded = [];
     protected $primaryKey = 'branch_id';

    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id','bank_id');
     }
}
