<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class expense extends Model
{
    //
    protected $fillable = [
        'expense_id', 'bank_id', 'upangsho_id', 'check_chalan', 'client_name', 'paymant_date','note','status'
    ];
}
