<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class income extends Model
{
    //
    protected $fillable = [
        'income_id', 'upangsho_id', 'bank_id','check_chalan', 'paymant_date', 'note','status'
    ];
}
