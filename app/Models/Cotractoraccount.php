<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotractoraccount extends Model
{
    protected $primaryKey = 'conacc_id';

    protected $guarded = [];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id','eid');
    }

}
