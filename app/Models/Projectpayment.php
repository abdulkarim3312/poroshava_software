<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectpayment extends Model
{
    protected $primaryKey = 'pid';

    protected $fillable=['payment_date','commints','payment','userid','proklpo_id','check_nos','voucher_no','bill_type','prev_bill_amount1'];
}
