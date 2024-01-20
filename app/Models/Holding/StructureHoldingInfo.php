<?php

namespace App\Models\Holding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructureHoldingInfo extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function holdingInfo(){
        return $this->hasOne(HoldingInfo::class,'id','holding_info_id');
    }
    public function holdingTaxPayerInfo(){
        return $this->hasOne(HoldingTaxPayer::class,'id','holding_tax_payer_id');
    }
    public function holdingUseType(){
        return $this->hasOne(HoldingUseType::class,'id','use_type_id');
    }
    public function holdingStructureType(){
        return $this->hasOne(StructureType::class,'id','structure_type_id');
    }
}
