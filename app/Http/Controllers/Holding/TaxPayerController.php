<?php

namespace App\Http\Controllers\Holding;

use App\Http\Controllers\Controller;
use App\Models\Holding\HoldingArea;
use App\Models\Holding\HoldingAssessment;
use App\Models\Holding\HoldingBill;
use App\Models\Holding\HoldingCategory;
use App\Models\Holding\HoldingFacility;
use App\Models\Holding\HoldingInfo;
use App\Models\Holding\HoldingTaxPayer;
use App\Models\Holding\HoldingTenantInfo;
use App\Models\Holding\HoldingUseType;
use App\Models\Holding\StructureHoldingInfo;
use App\Models\Holding\StructureType;
use App\Models\Holding\WardInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TaxPayerController extends Controller
{
    public function index()
    {
        $holdingAreas = HoldingArea::get();
        return view('holding_tax.tax_payer.all',compact('holdingAreas'));
    }

    public function datatable($area,$name){
        $query = HoldingTaxPayer::where('status',1);
        if($area != '0'){
            $query->whereHas('holdingInfo', function ($query) use ($area) {
                $query->where('holding_area_id', $area);
            });
        }
        if($name != '0'){
            $query->where('name', 'LIKE',"%{$name}%");
        }



        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('action', function(HoldingTaxPayer $taxPayer) {
             $btn = '<a href="'.route('holding.tax_payer_details.add',['holdingTaxPayer'=>$taxPayer->id]). ' " class="btn btn-info bg-gradient-info btn-sm btn-edit"><i class="fa fa-eye"></i></a>';
             return $btn;
            })
            ->addColumn('holding_no', function (HoldingTaxPayer $taxPayer){
                return enNumberToBn($taxPayer->holdingInfo->holding_no ?? '');
            })
            ->addColumn('client_no', function (HoldingTaxPayer $taxPayer){
                return enNumberToBn($taxPayer->holdingInfo->client_no ?? '');
            })
            ->addColumn('ward_no', function (HoldingTaxPayer $taxPayer){
                return enNumberToBn($taxPayer->holdingInfo->wardInfo->ward_no ?? '');
            })
            ->addColumn('holding_name', function (HoldingTaxPayer $taxPayer){
                return $taxPayer->holdingInfo->holdingArea->road_name  ?? '';
            })
            ->addColumn('contact_no', function (HoldingTaxPayer $taxPayer){
                return enNumberToBn($taxPayer->contact_no);
            })

            ->editColumn('status', function(HoldingTaxPayer $taxPayer) {
                if ($taxPayer->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';

            })

            ->rawColumns(['action','status'])
            ->toJson();
    }

    public function add()
    {
        $holdingAreas = HoldingArea::all();
        return view('holding_tax.tax_payer.add',compact('holdingAreas'));

    }

    public function addPost(Request $request)
    {
        $request['national_id'] = bnNumberToEn($request->national_id);
        $request['contact_no'] = bnNumberToEn($request->contact_no);

        $request->validate([
            'name' => 'required|string|max:255',
            'father_husband_name' => 'required|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'contact_no' => 'required|string|max:15',
            'national_id' => 'nullable|string|max:50',
            'email' => 'nullable|max:255',
            'address' => 'required|string|max:255',
        ]);

//        $bn = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
//        $en = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');


        $holdingTaxPayer = new HoldingTaxPayer();
        $holdingTaxPayer->name=$request->name;
        $holdingTaxPayer->father_husband_name=$request->father_husband_name;
        $holdingTaxPayer->mother_name=$request->mother_name;
        $holdingTaxPayer->contact_no=$request->contact_no;
        $holdingTaxPayer->national_id=$request->national_id;
        $holdingTaxPayer->email=$request->email;
        $holdingTaxPayer->address=$request->address;
        $holdingTaxPayer->status=$request->status;
        $holdingTaxPayer->save();

        $holdingInfo = new HoldingInfo();
        $holdingInfo->holding_tax_payer_id = $holdingTaxPayer->id;
        $holdingInfo->save();

        $holdingAssessment = new HoldingAssessment();
        $holdingAssessment->holding_tax_payer_id = $holdingTaxPayer->id;
        $holdingAssessment->holding_info_id = $holdingInfo->id;
        $holdingAssessment->holding_assessment_setting_id = 1;
        $holdingAssessment->total_approximate_rent = 0;
        $holdingAssessment->Yearly_assesment = 0;
        $holdingAssessment->Maintenance_deduct = 0;
        $holdingAssessment->owner_deduct = 0;
        $holdingAssessment->actual_assesment = 0;
        $holdingAssessment->holding_tax = 0;
        $holdingAssessment->light_tax = 0;
        $holdingAssessment->total_tax = 0;
        $holdingAssessment->re_interim_assessment = 2;
        $holdingAssessment->save();

        return redirect()->route('holding_tax_payer_holdinginfo',['holdingTaxPayer'=>$holdingTaxPayer->id])->with('message','করদাতা সফল ভাবে যুক্ত করা হয়েছে');


    }

    public function taxPayerDetailsAdd(HoldingTaxPayer $holdingTaxPayer){
//        return($holdingTaxPayer->id);
        $holdingInfo = HoldingInfo::with('wardInfo','holdingArea','holdingCategory','holdingUseType')->where('holding_tax_payer_id',$holdingTaxPayer->id)->first();
        $holdingStructures = StructureHoldingInfo::with('holdingInfo','holdingTaxPayerInfo','holdingStructureType','holdingUseType')->where('holding_tax_payer_id',$holdingTaxPayer->id)->get();
        $holdingTenants = HoldingTenantInfo::with('holdingInfo','holdingTaxPayerInfo','holdingStructureType')->where('holding_tax_payer_id',$holdingTaxPayer->id)->get();
        $holdingAssessments = HoldingAssessment::with('holdingInfo','holdingAssessmentSetting')->where('holding_tax_payer_id',$holdingTaxPayer->id)->get();
        $holdingAreas = HoldingArea::get();
        $wardInfos = WardInfo::get();
        $holdingCategories = HoldingCategory::get();
        $holdingFacilities = HoldingFacility::get();
        $holdingUseTypes = HoldingUseType::get();
        $structureTypes =StructureType::get();

        return view('holding_tax.tax_payer.details_add',compact('holdingTaxPayer','holdingInfo','holdingStructures','holdingAreas',
            'holdingTenants','holdingAssessments','wardInfos','holdingCategories','holdingFacilities','holdingUseTypes','structureTypes'));
    }

    public function taxPayerAssessmentDetails(HoldingAssessment $holdingAssessment)
    {
        return view('holding_tax.tax_payer.details', compact('holdingAssessment'));
    }

    public function holdinginfoAdd(HoldingTaxPayer $holdingTaxPayer){
        $wardInfos = WardInfo::get();
        $holdingAreas = HoldingArea::get();
        $holdingCategories = HoldingCategory::get();
        $holdingFacilities = HoldingFacility::get();
        $structureTypes =StructureType::get();
        $holdingUseTypes = HoldingUseType::get();
        return view('holding_tax.tax_payer.holdinginfo', compact('holdingTaxPayer','wardInfos','holdingCategories','holdingAreas','holdingFacilities','structureTypes','holdingUseTypes'));
    }
    public function holdinginfoAddPost(HoldingTaxPayer $holdingTaxPayer, Request $request){

        $request['holding_no'] = bnNumberToEn($request->holding_no);
        $request['old_holding_no'] = bnNumberToEn($request->old_holding_no);
        $request['client_no'] = '0'.$request->ward_id.'-00'.$request->ward_id.'-'.$request->holding_no;

        $holdingInfo = HoldingInfo::where('holding_tax_payer_id',$holdingTaxPayer->id)->first();

        $request->validate([
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
        ]);


        $holdingInfo->holding_no=$request->holding_no;
        $holdingInfo->client_no =$request->client_no;
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

        return redirect()->route('holding_tax_payer_construction',['holdingTaxPayer'=>$holdingTaxPayer->id])->with('message','হোল্ডিং এর তথ্য যুক্ত করা হয়েছে');

    }
    public function constructionAdd(HoldingTaxPayer $holdingTaxPayer){
        $holdingInfo = HoldingInfo::with('wardInfo','holdingArea','holdingCategory','holdingUseType')->where('holding_tax_payer_id',$holdingTaxPayer->id)->first();
        $wardInfos = WardInfo::get();
        $holdingAreas = HoldingArea::get();
        $holdingCategories = HoldingCategory::get();
        $holdingFacilities = HoldingFacility::get();
        $structureTypes =StructureType::get();
        $holdingUseTypes = HoldingUseType::get();
        return view('holding_tax.tax_payer.construction', compact('holdingTaxPayer','holdingInfo','wardInfos','holdingCategories','holdingAreas','holdingFacilities','structureTypes','holdingUseTypes'));
    }

    public function constructionAddPost(HoldingTaxPayer $holdingTaxPayer, Request $request)
    {

        $request->validate([
            'holding_info_id' => 'required|max:255',
            'construction_rate' => 'required|numeric|min:0',
            'use_type_id' => 'required|max:255',
            'structure_type_id' => 'required|max:255',
            'total_floor' => 'required|numeric|min:0',
            'unuse_floor' => 'required|numeric|min:0',
            'owner_floor' => 'required|numeric|min:0',
            'rent_floor' => 'nullable|numeric|min:0',
            'structure_length' => 'required|numeric|min:0',
            'structure_width' => 'required|numeric|min:0',
            'aprox_monthly_rent' => 'required|numeric|min:0',
        ]);

        $holdingStructure = new StructureHoldingInfo();
        $holdingStructure->holding_tax_payer_id = $request->holding_tax_payer_id;
        $holdingStructure->holding_info_id = $request->holding_info_id;
        $holdingStructure->structure_type_id = $request->structure_type_id ;
        $holdingStructure->use_type_id = $request->use_type_id;
        $holdingStructure->total_floor = $request->total_floor;
        $holdingStructure->owner_use_floor_no = $request->owner_floor;
        $holdingStructure->tenant_use_floor_no = $request->rent_floor ?? 0;
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

        if($request->rent_floor != ''){
            return redirect()->route('holding_tax_payer_tenant',['holdingTaxPayer'=>$holdingTaxPayer->id])->with('message','হোল্ডিং নির্মাণ তথ্য যুক্ত করা হয়েছে');
        }else{
            return redirect()->route('holding.tax_payer_details.add',['holdingTaxPayer'=>$holdingTaxPayer->id])->with('message','হোল্ডিং নির্মাণ তথ্য যুক্ত করা হয়েছে');
        }

    }
    public function tenantAdd(HoldingTaxPayer $holdingTaxPayer)
    {
        $holdingInfo = HoldingInfo::with('wardInfo', 'holdingArea', 'holdingCategory', 'holdingUseType')->where('holding_tax_payer_id', $holdingTaxPayer->id)->first();
        $wardInfos = WardInfo::get();
        $holdingAreas = HoldingArea::get();
        $holdingCategories = HoldingCategory::get();
        $holdingFacilities = HoldingFacility::get();
        $structureTypes = StructureType::get();
        $holdingUseTypes = HoldingUseType::get();
        return view('holding_tax.tax_payer.tenant', compact('holdingTaxPayer', 'holdingInfo', 'wardInfos', 'holdingCategories', 'holdingAreas', 'holdingFacilities', 'structureTypes', 'holdingUseTypes'));
    }
    public function tenantAddPost(HoldingTaxPayer $holdingTaxPayer, Request $request)
    {
        $request->validate([
            'holding_info_id' => 'required|max:255',
            'structure_type_id' => 'required|numeric|min:0',
            'tenant_floor' => 'nullable|max:255',
            'tenant_name' => 'required|max:25',
            'nid' => 'required|max:255',
            'monthly_rent' => 'required|numeric|min:0',
        ]);
        $holdingTenantInfo = new HoldingTenantInfo();
        $holdingTenantInfo->holding_tax_payer_id = $request->holding_tax_payer_id;
        $holdingTenantInfo->holding_info_id = $request->holding_info_id;
        $holdingTenantInfo->structure_type_id = $request->structure_type_id;
        $holdingTenantInfo->tenant_floor = $request->tenant_floor;
        $holdingTenantInfo->tenant_name = $request->tenant_name;
        $holdingTenantInfo->nid_no = $request->nid;
        $holdingTenantInfo->monthly_rent = $request->monthly_rent;
        $holdingTenantInfo->save();

        return redirect()->route('holding.tax_payer_details.add',['holdingTaxPayer'=>$holdingTaxPayer->id])->with('message','ভাড়াটিয়ার তথ্য যুক্ত করা হয়েছে');
    }
}
