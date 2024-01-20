<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenceKhat extends Model
{
    //
    protected $fillable = [
        'upangsho_id', 'tax_type_id', 'serilas', 'exp_khat_name','status'
    ];
}
