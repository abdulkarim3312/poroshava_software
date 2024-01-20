<?php

namespace App\Http\Controllers\Holding;

use App\Http\Controllers\Controller;
use App\Models\Holding\HoldingAssessment;
use App\Models\Holding\HoldingCategory;
use App\Models\Holding\HoldingFacility;
use App\Models\Holding\HoldingInfo;
use App\Models\Holding\HoldingTenantInfo;
use App\Models\Holding\HoldingUseType;
use App\Models\Holding\StructureHoldingInfo;
use App\Models\Holding\StructureType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HoldingCommonController extends Controller
{
    public function holdingInfoUpdate(Request $request)
    {

        $request['holding_no'] = bnNumberToEn($request->holding_no);
        $request['old_holding_no'] = bnNumberToEn($request->old_holding_no);
        $request['client_no'] = '0'.$request->ward_id.'-00'.$request->ward_id.'-'.$request->holding_no;

        $holdingInfo = HoldingInfo::where('holding_tax_payer_id',$request->holdingTaxPayerId)->first();

        $rules = [
            'client_no' =>  [
                'required',
                Rule::unique('holding_infos')
                    ->ignore($holdingInfo->id)
                    ->where('client_no',$request->client_no)
            ],
            'holding_no' => 'nullable|max:255',
            'old_holding_no' => 'nullable|max:255',
            'moholla_name' => 'required|max:255',
            'loan_deduct' => 'nullable|max:25',
            'category_id' => 'required',
            'ward_id' => 'required',
            'road_id' => 'required',
            'holding_facility_id' => 'required',
            'structure_type_id' => 'required',
            'use_type_id' => 'required',
            'usingHolding_id' => 'required',

        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }


//Update
        $holdingInfo->holding_no=$request->holding_no;
        $holdingInfo->client_no ='0'.$request->ward_id.'-00'.$request->ward_id.'-'.$request->holding_no;
        $holdingInfo->old_holding_no=$request->old_holding_no ?? null;
        $holdingInfo->moholla_name=$request->moholla_name;
        $holdingInfo->holding_category_id=$request->category_id;
        $holdingInfo->ward_id=$request->ward_id;
        $holdingInfo->holding_area_id=$request->road_id;
        $holdingInfo->loan_deduct=$request->loan_deduct ?? 0;
        $holdingInfo->holding_facility_id=$request->holding_facility_id;
        $holdingInfo->use_type_id=$request->use_type_id;
        $holdingInfo->structure_type_id=$request->structure_type_id;
        $holdingInfo->usingHolding_id=$request->usingHolding_id;
        $holdingInfo->save();


        return response()->json(['success' => true, 'message' => 'হোল্ডিং এর তথ্য সফলভাবে আপডেট হয়েছে।']);

    }

    public function taxPayerStructureAdd(Request $request){
        $rules = [
            'holding_info_id' => 'required|max:255',
            'construction_rate' => 'required|numeric|min:0',
            'use_type_id' => 'required|max:255',
            'structure_type_id' => 'required|max:255',
            'total_floor' => 'required|numeric|min:0',
            'unuse_floor' => 'required|numeric|min:0',
            'owner_floor' => 'required|numeric|min:0',
            'rent_floor' => 'required|numeric|min:0',
            'structure_length' => 'required|numeric|min:0',
            'structure_width' => 'required|numeric|min:0',
            'aprox_monthly_rent' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $holdingStructure = new StructureHoldingInfo();
        $holdingStructure->holding_tax_payer_id = $request->holding_tax_payer_id;
        $holdingStructure->holding_info_id = $request->holding_info_id;
        $holdingStructure->structure_type_id = $request->structure_type_id ;
        $holdingStructure->use_type_id = $request->use_type_id;
        $holdingStructure->total_floor = $request->total_floor;
        $holdingStructure->owner_use_floor_no = $request->owner_floor;
        $holdingStructure->tenant_use_floor_no = $request->rent_floor;
        $holdingStructure->unuse_floor_no = $request->unuse_floor;
        $holdingStructure->structure_length = $request->structure_length;
        $holdingStructure->structure_width = $request->structure_width;
        $holdingStructure->construction_rate = $request->construction_rate;
        $holdingStructure->aprox_monthly_rent = $request->aprox_monthly_rent;
        if($request->owner_floor > 0){
            $totalVolume =number_format($request->structure_length*$request->structure_width,2);
            $holdingStructure->structure_volume =$totalVolume*$request->total_floor;
            $holdingStructure->construction_amount = $totalVolume *$request->construction_rate*$request->total_floor;
        }else{
            $holdingStructure->structure_volume =0;
            $holdingStructure->construction_amount = 0;
        }

        $holdingStructure->save();

//
//        $holdingAssessment = HoldingAssessment::where('holding_tax_payer_id',$request->holding_tax_payer_id)->first();
//
//        $approxRent = $holdingStructure->aprox_monthly_rent*12;
//
//        $yearlyAssessment = ($holdingStructure->construction_amount*7.5)/100;
//
//        $maintainDeduct = $yearlyAssessment/6;
//        $ownerDeduct = ($yearlyAssessment-$maintainDeduct)/4;
//        $actualAssessment = $yearlyAssessment-$maintainDeduct-$ownerDeduct;
//        $holdingTax = ($actualAssessment*7)/100;
//        $lightTax = ($actualAssessment*2)/100;
//
//        $holdingAssessment->consider_holding_tax=0;
//        $holdingAssessment->increment('total_approximate_rent',$approxRent);
//        $holdingAssessment->increment('Yearly_assesment',$yearlyAssessment);
//        $holdingAssessment->increment('Maintenance_deduct',$maintainDeduct);
//        $holdingAssessment->increment('owner_deduct',$ownerDeduct);
//        $holdingAssessment->increment('actual_assesment',$actualAssessment);
//        $holdingAssessment->increment('holding_tax',$holdingTax);
//        $holdingAssessment->increment('light_tax',$lightTax);
//        $holdingAssessment->save();
//        $holdingAssessment->total_tax=$holdingAssessment->holding_tax+$holdingAssessment->light_tax;
//        $holdingAssessment->save();

        return response(['success' => true, 'message' => 'সফলভাবে সংরক্ষণ হয়েছে।',]);
    }
    public function taxPayerStructureEdit(Request $request){
        $rules = [
            'holding_info_id' => 'required|max:255',
            'construction_rate' => 'required|numeric|min:0',
            'use_type_id' => 'required|max:255',
            'structure_type_id' => 'required|max:255',
            'total_floor' => 'required|numeric|min:0',
            'unuse_floor' => 'required|numeric|min:0',
            'owner_floor' => 'required|numeric|min:0',
            'rent_floor' => 'required|numeric|min:0',
            'structure_length' => 'required|numeric|min:0',
            'structure_width' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

//        $holdingAssessment = HoldingAssessment::where('holding_tax_payer_id',$request->holding_tax_payer_id)->first();

        $holdingStructure = StructureHoldingInfo::find($request->structure_holding_info_id);

        //Reverse Data to Holding Assessment
//        $approxRent = $holdingStructure->aprox_monthly_rent*12;
//        $yearlyAssessment = ($holdingStructure->construction_amount*7.5)/100;
//        $maintainDeduct = $yearlyAssessment/6;
//        $ownerDeduct = ($yearlyAssessment-$maintainDeduct)/4;
//        $actualAssessment = $yearlyAssessment-$maintainDeduct-$ownerDeduct;
//        $holdingTax = ($actualAssessment*7)/100;
//        $lightTax = ($actualAssessment*2)/100;
//
//        $holdingAssessment->consider_holding_tax=0;
//        $holdingAssessment->decrement('total_approximate_rent',$approxRent);
//        $holdingAssessment->decrement('Yearly_assesment',$yearlyAssessment);
//        $holdingAssessment->decrement('Maintenance_deduct',$maintainDeduct);
//        $holdingAssessment->decrement('owner_deduct',$ownerDeduct);
//        $holdingAssessment->decrement('actual_assesment',$actualAssessment);
//        $holdingAssessment->decrement('holding_tax',$holdingTax);
//        $holdingAssessment->decrement('light_tax',$lightTax);
//        $holdingAssessment->save();

        $holdingStructure->holding_tax_payer_id = $request->holding_tax_payer_id;
        $holdingStructure->holding_info_id = $request->holding_info_id;
        $holdingStructure->structure_type_id = $request->structure_type_id ;
        $holdingStructure->use_type_id = $request->use_type_id;
        $holdingStructure->total_floor = $request->total_floor;
        $holdingStructure->owner_use_floor_no = $request->owner_floor;
        $holdingStructure->tenant_use_floor_no = $request->rent_floor;
        $holdingStructure->unuse_floor_no = $request->unuse_floor;
        $holdingStructure->structure_length = $request->structure_length;
        $holdingStructure->structure_width = $request->structure_width;
        $holdingStructure->construction_rate = $request->construction_rate;
        $holdingStructure->aprox_monthly_rent = $request->aprox_monthly_rent;
        if($request->owner_floor > 0){
            $totalVolume =number_format($request->structure_length*$request->structure_width,2);
            $holdingStructure->structure_volume =$totalVolume*$request->total_floor;
            $holdingStructure->construction_amount = $totalVolume *$request->construction_rate*$request->total_floor;
        }else{
            $holdingStructure->structure_volume =0;
            $holdingStructure->construction_amount = 0;
        }

        $holdingStructure->save();


        return response(['success' => true, 'message' => 'সফলভাবে আপডেট হয়েছে।',]);
    }
    public function taxPayerTenantAdd(Request $request){
        $rules = [
            'holding_info_id' => 'required|max:255',
            'structure_type_id' => 'required|numeric|min:0',
            'tenant_floor' => 'nullable|max:255',
            'tenant_name' => 'required|max:25',
            'nid' => 'required|max:255',
            'monthly_rent' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $holdingTenantInfo = new HoldingTenantInfo();
        $holdingTenantInfo->holding_tax_payer_id = $request->holding_tax_payer_id;
        $holdingTenantInfo->holding_info_id = $request->holding_info_id;
        $holdingTenantInfo->structure_type_id = $request->structure_type_id;
        $holdingTenantInfo->tenant_floor = $request->tenant_floor;
        $holdingTenantInfo->tenant_name = $request->tenant_name;
        $holdingTenantInfo->nid_no = $request->nid;
        $holdingTenantInfo->monthly_rent = $request->monthly_rent;
        $holdingTenantInfo->save();

        return response(['success' => true, 'message' => 'সফলভাবে সংরক্ষণ হয়েছে।',]);
    }
    public function taxPayerTenantEdit(Request $request){

        $rules = [
            'holding_info_id' => 'required|max:255',
            'structure_type_id' => 'required|numeric|min:0',
            'tenant_floor' => 'nullable|max:255',
            'tenant_name' => 'required|max:25',
            'nid' => 'required|max:255',
            'monthly_rent' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }


        $holdingTenantInfo = HoldingTenantInfo::find($request->holding_tenant_info_id);

        $holdingTenantInfo->holding_tax_payer_id = $request->holding_tax_payer_id;
        $holdingTenantInfo->holding_info_id = $request->holding_info_id;
        $holdingTenantInfo->structure_type_id = $request->structure_type_id;
        $holdingTenantInfo->tenant_floor = $request->tenant_floor ?? '';
        $holdingTenantInfo->tenant_name = $request->tenant_name;
        $holdingTenantInfo->nid_no = $request->nid;
        $holdingTenantInfo->monthly_rent = $request->monthly_rent;
        $holdingTenantInfo->save();

        return response(['success' => true, 'message' => 'সফলভাবে আপডেট হয়েছে।',]);
    }
    public function getStructureTemplateDetails(Request $request)
    {

        $structureHolding = StructureHoldingInfo::where('id',$request->structureId)->first();
        $holdingInfos = HoldingInfo::where('holding_tax_payer_id',$structureHolding->holding_tax_payer_id)->get();
        $holdingUseTypes = HoldingUseType::get();
        $structureTypes =StructureType::get();
        $structureTemplateHtml = view('layouts.partial.__structure_template',compact('structureHolding','holdingInfos','holdingUseTypes','structureTypes'))->render();

        return response()->json([
            'html'=>$structureTemplateHtml,
        ]);
    }
    public function getTenantTemplateDetails(Request $request)
    {

        $holdingTenant = HoldingTenantInfo::where('id',$request->tenantId)->first();
        $holdingInfos = HoldingInfo::where('holding_tax_payer_id',$holdingTenant->holding_tax_payer_id)->get();
        $structureTypes =StructureType::get();
        $tenantTemplateHtml = view('layouts.partial.__tenant_template',compact('holdingTenant','holdingInfos','structureTypes'))->render();

        return response()->json([
            'html'=>$tenantTemplateHtml,
        ]);
    }

    public function assessmentSubmitAndCalculation(Request $request){

        $holdingAssessment = HoldingAssessment::where('id',$request->assessmentId)->first();
        $holdingInfo = HoldingInfo::where('id',$holdingAssessment->holding_info_id)->first();
        $holdingStructureAproxMonthlySum = StructureHoldingInfo::where('holding_info_id',$holdingInfo->id)->sum('aprox_monthly_rent');
        $holdingStructureConstructionAmountSum = StructureHoldingInfo::where('holding_info_id',$holdingInfo->id)->sum('construction_amount');

        if($holdingStructureAproxMonthlySum<$holdingStructureConstructionAmountSum){
            $totalAmount = $holdingStructureConstructionAmountSum;
        }else{
            $totalAmount = $holdingStructureAproxMonthlySum;
        }


        $approxRent = $totalAmount*12;

        $yearlyAssessment = ($totalAmount*7.5)/100;


        $maintainDeduct = $yearlyAssessment/6;
        $ownerDeduct = ($yearlyAssessment-$maintainDeduct)/4;

        if($yearlyAssessment<4500){
            $actualAssessment = 4500;
        }else{
            $actualAssessment = $yearlyAssessment-$maintainDeduct-$ownerDeduct;
        }

        $holdingTax = ($actualAssessment*7)/100;  //হোল্ডিং কর  (৭%)

        if($holdingInfo->holding_facility_id==1 || $holdingInfo->holding_facility_id==5){
            $lightTax = ($actualAssessment*2)/100;   //বিদ্যুৎ রেইট (২%)
        }else{
            $lightTax = 0;
        }

        if($holdingInfo->holding_facility_id==3 ||$holdingInfo->holding_facility_id==5) {
            $consrvancyTax = ($actualAssessment * 2) / 100; //পরিষ্কার রেইট (২%)
        }else{
            $consrvancyTax = 0;
        }


        $holdingAssessment->consider_holding_tax=0;
        $holdingAssessment->total_approximate_rent = $approxRent;
        $holdingAssessment->Yearly_assesment = $yearlyAssessment;
        $holdingAssessment->Maintenance_deduct = $maintainDeduct;
        $holdingAssessment->owner_deduct = $ownerDeduct;
        $holdingAssessment->actual_assesment = $actualAssessment;
        $holdingAssessment->holding_tax = $holdingTax;
        $holdingAssessment->light_tax = $lightTax;
        $holdingAssessment->consrvancy_tax = $consrvancyTax;
        $holdingAssessment->re_interim_assessment = 1;
        $holdingAssessment->save();
        $holdingAssessment->total_tax=$holdingTax+$lightTax+$consrvancyTax+$holdingAssessment->consider_holding_tax;
        $holdingAssessment->save();

        return response(['success' => true, 'message' => 'এসেসমেন্ট সফলভাবে সম্পূর্ণ হয়েছে।',]);
    }
}
