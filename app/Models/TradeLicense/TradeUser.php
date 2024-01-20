<?php

namespace App\Models\TradeLicense;

use App\Models\District;
use App\Models\Holding\HoldingArea;
use App\Models\Holding\WardInfo;
use App\Models\Upazila;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeUser extends Model
{
    use HasFactory;

    public function areaInfo(){
        return $this->belongsTo(HoldingArea::class,'road_id','id');
    }
    public function wardInfo(){
        return $this->belongsTo(WardInfo::class,'ward_id','id');
    }
    public function businessType(){
        return $this->belongsTo(BusinessType::class,'business_type_id','id');
    }
    public function upazila(){
        return $this->belongsTo(Upazila::class,'upazila_id','id');
    }
    public function district(){
        return $this->belongsTo(District::class,'district_id','id');
    }
    public function signBoard(){
        return $this->belongsTo(SignBoard::class,'signboard_id','id');
    }
}
