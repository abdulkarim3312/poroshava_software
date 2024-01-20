<?php

namespace App\Http\Controllers\TradeLicense;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Holding\HoldingArea;
use App\Models\Holding\HoldingInfo;
use App\Models\Holding\WardInfo;
use App\Models\TradeLicense\SignBoard;
use App\Models\TradeLicense\TradeInspactorReport;
use App\Models\TradeLicense\TradeUser;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class TradeLicenseController extends Controller
{
    public function add(){
        $wardInfos = WardInfo::get();
        $areas = HoldingArea::get();
        $districts = District::get();
        $upazilas = Upazila::get();
        $signBoards = SignBoard::get();
        return view('trade_license.info.add_trade_license',compact('wardInfos','areas','districts','upazilas','signBoards'));
    }
    public function addPost(Request $request){
        $request['signboard_size'] = bnNumberToEn($request->signboard_size);
        $request['org_telephone_no'] = bnNumberToEn($request->org_telephone_no);
        $request['org_contact_no'] = bnNumberToEn($request->org_contact_no);
        $request['mobile_no'] = bnNumberToEn($request->mobile_no);
        $request['nid_no'] = bnNumberToEn($request->nid_no);
        $request['shop_no'] = bnNumberToEn($request->shop_no);

        $request->validate([
            'organization_name' => 'required|string|max:255',
            'business_type_name' => 'required|string|max:255',
            'name_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'org_start_date' => 'required|string|max:255',
            'organization_address' => 'required|string|max:255',
            'ward_id' => 'required',
            'road_id' => 'required',
            'district_id' => 'required',
            'upazila_id' => 'required',
            'income_tax' => 'required',
            'bin_vat' => 'required',
            'signboard_type' => 'required',
            'signboard_size' => 'required|numeric',
            'owner_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'date_of_birth' => 'required|string|max:255',
            'marital_status' => 'required|string|max:255',
            'nid_no' => 'required|numeric',
            'present_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'mobile_no' => 'required|numeric',
            'check' => 'required',
            'nid_scan_copy' => 'nullable|image|max:100',
            'personal_tin_scan_copy' => 'nullable|image|max:100',
            'org_tin_scan_copy' => 'nullable|image|max:100',
            'bin_vat_scan_copy' => 'nullable|image|max:100',
            'balance_sheet' => 'nullable|image|max:60',
            'tax_tenant_copy' => 'nullable|image|max:60',
            'tax_paid_voucher_scan_copy' => 'nullable|image|max:60',
            'image' => 'nullable|image|max:60',
            'org_drowing_paper' => 'nullable|image|max:60',
            'location_drowing_paper' => 'nullable|image|max:60',
        ]);
//        dd($request->signboard_type);
        $signBoardType = SignBoard::where('id',$request->signboard_type)->first();

        $tradeUser = new TradeUser();
        $tradeUser->organization_name = $request->organization_name;
        $tradeUser->business_type_name = $request->business_type_name;
        $tradeUser->name_type = $request->name_type;
        $tradeUser->name = $request->name;
        $tradeUser->licence_no = "";
        $tradeUser->licence_id = "";
        $tradeUser->licence_issue_date = "";
        $tradeUser->approved_paid_capital = $request->approved_paid_capital;
        $tradeUser->org_start_date = date('Y-m-d', strtotime($request->org_start_date));
        $tradeUser->organization_address = $request->organization_address;
        $tradeUser->holding_no = $request->holding_no;
        $tradeUser->shop_no = $request->shop_no;
        $tradeUser->ward_id = $request->ward_id;
        $tradeUser->road_id = $request->road_id;
        $tradeUser->district_id = $request->district_id;
        $tradeUser->upazila_id = $request->upazila_id;
        $tradeUser->income_tax = $request->income_tax;
        $tradeUser->tin_no = $request->tin_no;
        $tradeUser->bin_vat = $request->bin_vat;
        $tradeUser->bin_vat_no = $request->bin_vat_no;
        $tradeUser->product_types = $request->product_types;
        $tradeUser->total_employers = $request->total_employers;
        $tradeUser->machine_details = $request->machine_details;
        $tradeUser->biddut_generator = $request->biddut_generator;
        $tradeUser->motor_details = $request->motor_details;
        $tradeUser->signboard_id = $request->signboard_type;
        $tradeUser->signboard_size = $request->signboard_size;
        $tradeUser->signboard_fee = $signBoardType->sign_board_rate * $request->signboard_size;
        $tradeUser->org_telephone_no = $request->org_telephone_no;
        $tradeUser->org_contact_no = $request->org_contact_no;
        $tradeUser->org_email = $request->org_email;
        $tradeUser->org_web_site = $request->org_web_site;
//        $tradeUser->owner_name = $request->owner_name;
        $tradeUser->father_husband_name = $request->father_husband_name;
        $tradeUser->mother_name = $request->mother_name;
        $tradeUser->husband_name = $request->husband_name;
        $tradeUser->nationality = $request->nationality;
        $tradeUser->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        $tradeUser->marital_status = $request->marital_status;
        $tradeUser->nid_no = $request->nid_no;
        $tradeUser->personal_tin_no = $request->personal_tin_no;
        $tradeUser->present_address = $request->present_address;
        $tradeUser->permanent_address = $request->permanent_address;
        $tradeUser->mobile_no = $request->mobile_no;
        $tradeUser->email = $request->eamil;

        if ($request->nid_scan_copy) {
            $file = $request->file('nid_scan_copy');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->nid_scan_copy = $request->$path;
        }
        if ($request->personal_tin_scan_copy) {
            $file = $request->file('personal_tin_scan_copy');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->personal_tin_scan_copy = $request->$path;
        }
        if ($request->org_tin_scan_copy) {
            $file = $request->file('org_tin_scan_copy');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->org_tin_scan_copy = $request->$path;
        }
        if ($request->bin_vat_scan_copy) {
            $file = $request->file('bin_vat_scan_copy');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->bin_vat_scan_copy = $request->$path;
        }
        if ($request->balance_sheet) {
            $file = $request->file('balance_sheet');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->balance_sheet = $request->$path;
        }
        if ($request->tax_tenant_copy) {
            $file = $request->file('tax_tenant_copy');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->tax_tenant_copy = $request->$path;
        }
        if ($request->tax_paid_voucher_scan_copy) {
            $file = $request->file('tax_paid_voucher_scan_copy');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->tax_paid_voucher_scan_copy = $request->$path;
        }
        if ($request->image) {
            $file = $request->file('image');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->image = $request->$path;
        }
        if ($request->org_drowing_paper) {
            $file = $request->file('org_drowing_paper');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->org_drowing_paper = $request->$path;
        }
        if ($request->location_drowing_paper) {
            $file = $request->file('location_drowing_paper');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/trade_license_document';
            $file->move($destinationPath, $filename);
            $path = 'uploads/trade_license_document/' . $filename;
            $tradeUser->location_drowing_paper = $request->$path;
        }
        $tradeUser->save();

        return redirect()->route('trade_license_pending_list')->with('message','Application completed.');
    }
    public function addPendingUpdate(Request $request)
    {
        $holdingInfo = HoldingInfo::where('holding_tax_payer_id',$request->holdingTaxPayerId)->first();

        $rules = [
            'org_name' => 'required',
            'owner_name' => 'required',
            'business_type' => 'required',
            'business_start_date' => 'required',
            'business_capital' => 'required',
            'org_address' => 'required',
            'sign_board_type' => 'required',
            'sign_board_size' => 'required',
            'approved_application' => 'required',
        ];
        if ($request->org_name=='2'){
            $rules['correct_org_name'] = 'required';
        }
        if ($request->owner_name=='2'){
            $rules['correct_owner_name'] = 'required';
        }
        if ($request->business_type=='2'){
            $rules['correct_business_type'] = 'required';
        }
        if ($request->business_start_date=='2'){
            $rules['correct_business_start_date'] = 'required';
        }
        if ($request->business_capital=='2'){
            $rules['correct_business_capital'] = 'required';
        }
        if ($request->sign_board_type=='2'){
            $rules['correct_sign_board_type'] = 'required';
        }
        if ($request->sign_board_size=='2'){
            $rules['correct_sign_board_size'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $tradeInspactorReport = new TradeInspactorReport();
        $tradeInspactorReport->trade_user_id = $request->trade_user_id;
        $tradeInspactorReport->org_name = $request->org_name;
        $tradeInspactorReport->correct_org_name = $request->correct_org_name;
        $tradeInspactorReport->owner_name = $request->owner_name;
        $tradeInspactorReport->correct_owner_name = $request->correct_owner_name;
        $tradeInspactorReport->business_type = $request->business_type;
        $tradeInspactorReport->correct_business_type = $request->correct_business_type;
        $tradeInspactorReport->business_start_date = $request->business_start_date;
        $tradeInspactorReport->correct_business_start_date = $request->correct_business_start_date;
        $tradeInspactorReport->business_capital = $request->business_capital;
        $tradeInspactorReport->correct_business_capital = $request->correct_business_capital;
        $tradeInspactorReport->org_address = $request->org_address;
        $tradeInspactorReport->correct_org_address = $request->correct_org_address;
        $tradeInspactorReport->correct_holding_no = $request->correct_holding_no;
        $tradeInspactorReport->correct_shop_no = $request->correct_shop_no;
        $tradeInspactorReport->correct_ward_id = $request->correct_ward_id;
        $tradeInspactorReport->correct_road_id = $request->correct_road_id;
        $tradeInspactorReport->correct_district_id = $request->correct_district_id;
        $tradeInspactorReport->correct_upazila_id = $request->correct_upazila_id;
        $tradeInspactorReport->sign_board_type = $request->sign_board_type;
        $tradeInspactorReport->correct_sign_board_type = $request->correct_sign_board_type;
        $tradeInspactorReport->sign_board_size = $request->sign_board_size;
        $tradeInspactorReport->correct_sign_board_size = $request->correct_sign_board_size;
        $tradeInspactorReport->approved_application = $request->approved_application;
        $tradeInspactorReport->save();

        $tradeUser = TradeUser::where('id',$request->trade_user_id)->first();
        if($request->approved_application=='1'){
            $tradeUser->inspector = 1;
            $tradeUser->inspactor_name = 'Mohammod Mosharof Hossain';
            $tradeUser->secretary = 1;
            $tradeUser->secretary_name = 'Nasrin Jahan';
            $tradeUser->mayor = 1;
            $tradeUser->mayor_name = 'Almas Uddin';
        }
        if ($request->correct_org_name){
            $tradeUser->organization_name = $request->correct_org_name;
        }
        if ($request->correct_owner_name){
            $tradeUser->name = $request->correct_owner_name;
        }
        if ($request->correct_business_type){
            $tradeUser->business_type_name = $request->correct_business_type;
        }
        if ($request->correct_business_start_date){
            $tradeUser->org_start_date = $request->correct_business_start_date;
        }
        if ($request->correct_business_capital){
            $tradeUser->org_start_date = $request->correct_business_capital;
        }
        if ($request->correct_org_address){
            $tradeUser->organization_address = $request->correct_org_address;
        }
        if ($request->correct_holding_no){
            $tradeUser->holding_no = $request->correct_holding_no;
        }
        if ($request->correct_shop_no){
            $tradeUser->shop_no = $request->correct_shop_no;
        }
        if ($request->correct_ward_id){
            $tradeUser->ward_id = $request->correct_ward_id;
        }
        if ($request->correct_road_id){
            $tradeUser->road_id = $request->correct_road_id;
        }
        if ($request->correct_district_id){
            $tradeUser->district_id = $request->correct_district_id;
        }
        if ($request->correct_upazila_id){
            $tradeUser->upazila_id = $request->correct_upazila_id;
        }
        if ($request->correct_sign_board_type){
            $tradeUser->signboard_id = $request->correct_sign_board_type;
        }
        if ($request->correct_sign_board_size){
            $tradeUser->signboard_size = $request->correct_sign_board_size;
        }
        $redirectUrl = route('trade_license_approve_list');
        $tradeUser->save();
        return response()->json(['success' => true,'redirectUrl'=>$redirectUrl, 'message' => 'ট্রেড লাইসেন্স এর তথ্য সফলভাবে যাচাই করা হয়েছে।']);
    }
    public function addLicense(Request $request, TradeUser $tradeUser){
        $request['licence_no'] = bnNumberToEn($request->licence_no);
        $request['nid_no'] = bnNumberToEn($request->nid_no);
        $request['mobile_no'] = bnNumberToEn($request->mobile_no);
        $request['shop_no'] = bnNumberToEn($request->shop_no);
        $request['mobile_no'] = bnNumberToEn($request->mobile_no);
        $request['signboard_size'] = bnNumberToEn($request->signboard_size);
        $request['signboard_fee'] = bnNumberToEn($request->signboard_fee);
        $request['licence_fee'] = bnNumberToEn($request->licence_fee);
        $request['extra'] = bnNumberToEn($request->extra);
        $request['licenc_arrears'] = bnNumberToEn($request->licenc_arrears);
        $request['financial_year'] = bnNumberToEn($request->financial_year);
        $request['arrears_year'] = bnNumberToEn($request->arrears_year);
        $request['licence_id'] = '0'.$request->ward_id.'-00'.$request->ward_id.'-'.$request->licence_no;
        $request->validate([
            'licence_id' =>  [
                'required',
                Rule::unique('trade_users')
                    ->ignore($tradeUser->id)
                    ->where('licence_id',$request->licence_id)
            ],
            'licence_no' => 'required',
            'business_type' => 'required',
            'issue_date' => 'required',
            'signboard_size' => 'required|numeric',
            'financial_year' => 'required|string|max:255',
        ]);
//        dd($request->all());
        $tradeUser->licence_no = $request->licence_no;
        $tradeUser->licence_id = $request->licence_id;
        $tradeUser->licence_issue_date = date('Y-m-d',strtotime($request->issue_date));
        $tradeUser->renewal_date = date('Y-m-d',strtotime($request->issue_date));
        $tradeUser->nid_no = $request->nid_no;
        $tradeUser->holding_no = $request->holding_no;
        $tradeUser->shop_no = $request->shop_no;
        $tradeUser->business_type_id = $request->business_type;
        $tradeUser->signboard_size = $request->signboard_size;
        $tradeUser->signboard_id = $request->signboard_type;
        $tradeUser->signboard_fee = $request->signboard_fee;
        $tradeUser->licence_fee = $request->licence_fee;
        $tradeUser->financial_year = $request->financial_year;
        $tradeUser->extra_rate = $request->extra;
        $tradeUser->arrears = $request->licenc_arrears;
        $tradeUser->arrears_year = $request->arrears_year;
        $tradeUser->inactive_status = 1;
        $tradeUser->save();

        return redirect()->route('trade_license_list')->with('message','ট্রেড লাইসেন্স সফলভাবে যোগ করা হয়েছে');
    }
}
