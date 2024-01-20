<?php

namespace App\Models\Holding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldingAssessment extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function holdingInfo(){
        return $this->belongsTo(HoldingInfo::class,'holding_info_id','id');
    }
    public function holdingAssessmentSetting(){
        return $this->belongsTo(HoldingAssessmentSetting::class,'holding_assessment_setting_id','id');
    }

    public function taxPayer(){
        return $this->belongsTo(HoldingTaxPayer::class,'holding_tax_payer_id','id');
    }
    public function assessmentSetting(){
        return $this->belongsTo(HoldingAssessmentSetting::class,'holding_assessment_setting_id','id');
    }
}
