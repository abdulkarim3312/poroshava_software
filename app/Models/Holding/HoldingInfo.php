<?php

namespace App\Models\Holding;

use App\Models\Holding\HoldingFacility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldingInfo extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function wardInfo()
    {
        return $this->belongsTo(WardInfo::class,'ward_id','id');
    }
    public function holdingArea()
    {
        return $this->belongsTo(HoldingArea::class,'holding_area_id','id');
    }
    public function holdingCategory(){
        return $this->belongsTo(HoldingCategory::class,'holding_category_id','id');
    }
    public function holdingUseType(){
        return $this->belongsTo(HoldingUseType::class,'use_type_id','id');
    }
    public function holdingFacility(){
        return $this->belongsTo(HoldingFacility::class,'holding_facility_id','id');
    }
    public function structureInfos() {
        return $this->hasMany(StructureHoldingInfo::class,'holding_info_id');
    }
    public function holdingTenantInfos() {
        return $this->hasMany(HoldingTenantInfo::class,'holding_info_id');
    }
}
