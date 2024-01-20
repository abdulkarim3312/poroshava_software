<?php

namespace App\Models\Holding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldingTaxPayer extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function holdingArea()
    {
        return $this->belongsTo(HoldingArea::class,'id','area_id');
    }
    public function holdingInfo()
    {
        return $this->belongsTo(HoldingInfo::class,'id','holding_tax_payer_id');
    }


}
