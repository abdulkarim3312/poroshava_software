<?php

namespace App\Http\Controllers\AutoRickshaw;

use App\Http\Controllers\Controller;
use App\Models\AutoRickshaw\AutoRickshawType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AutoRickshaw\AutoRickshawDriverLicense;
use App\Models\AutoRickshaw\AutoRickshawOwnerLicense;
use Yajra\DataTables\Facades\DataTables;

class AutoRickshawHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){


        return view('dashboard');
    }


    public function vehicleLicense(){

        $types = AutoRickshawType::where('type',2)->get();

        return view('auto_rickshaw.vehicle',compact('types'));
    }

    public function vehicleLicensePost(Request $request){

        $request->validate([
            'type'=>'required',
            'fiscal_year'=>'required',
            'driver_name'=>'required',
            'father_name'=>'required',
            'mother_name'=>'required',
            'age'=>'required',
            'nid'=>'required',
            'current_address'=>'required',
            'address'=>'required',
            'upazila'=>'required',
            'post'=>'required',
            'license_no'=>'required',
            'taka_receive_no'=>'required',
            'delivery_date'=>'required',
        ]);

        $bn= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        $lastslno = AutoRickshawDriverLicense::where('year',$request->fiscal_year)->orderBy('id', 'desc')->first();
        if(empty($lastslno)){
            $lastslno=1;
        }else{
            $lastslno = (int)$lastslno->slno + 1;
        }

        $slno = str_pad($lastslno,5,"0",STR_PAD_LEFT);

        $typeInfo = AutoRickshawType::where('id',$request->type)->first();


        $vehicle = new AutoRickshawDriverLicense;
        $vehicle->type_id = $request->type;
        $vehicle->slno = $slno;
        $vehicle->year = $request->fiscal_year;
        $vehicle->name = $request->driver_name;
        $vehicle->fname = $request->father_name;
        $vehicle->mname = $request->mother_name;
        $vehicle->age = str_replace($bn, $en, $request->age);
        $vehicle->nid = $request->nid;
        $vehicle->current_address = $request->current_address;
        $vehicle->address = $request->address;
        $vehicle->upjela = $request->upazila;
        $vehicle->post = $request->post;
        $vehicle->delivery_date = Carbon::parse($request->delivery_date);
        $vehicle->licenseno = str_replace($bn, $en, $request->license_no);
        $vehicle->taka_receive_no = str_replace($bn, $en, $request->taka_receive_no);
        $vehicle->licensefee =  $typeInfo->fees;
        $vehicle->others =  $typeInfo->others;
        $vatTotal = ($typeInfo->fees / 100) * $typeInfo->vat;
        $vehicle->vat =  $vatTotal;
        $vehicle->total = $vatTotal + $typeInfo->fees;
        $vehicle->issuedate = date('Y-m-d');
        $vehicle->save();

        $driverLicense = AutoRickshawDriverLicense::where('id', $vehicle->id)->first();

        return view('auto_rickshaw.vehicle_licence_print', compact('driverLicense'));
    }

    public function vehicleLicenseEdit(AutoRickshawDriverLicense $driverLicense){

        $types = AutoRickshawType::where('type',2)->get();

        return view('auto_rickshaw.vehicle_licence_edit', compact('driverLicense','types'));
    }

    public function vehicleLicenseEditPost(AutoRickshawDriverLicense $driverLicense, Request $request){

        //dd($request->all());

        $request->validate([
            'type'=>'required',
            'fiscal_year'=>'required',
            'driver_name'=>'required',
            'father_name'=>'required',
            'mother_name'=>'required',
            'age'=>'required',
            'nid'=>'required',
            'current_address'=>'required',
            'address'=>'required',
            'upazila'=>'required',
            'post'=>'required',
            'license_no'=>'required',
            'taka_receive_no'=>'required',
        ]);

        $bn= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        $lastslno = AutoRickshawDriverLicense::where('year',$request->fiscal_year)->orderBy('id', 'desc')->first();
        if(empty($lastslno)){ $lastslno=1;}else{ $lastslno = (int)$lastslno->slno + 1; }

        $typeInfo = AutoRickshawType::where('id',$request->type)->first();

        $driverLicense->type_id = $request->type;
        $driverLicense->year = $request->fiscal_year;
        $driverLicense->name = $request->driver_name;
        $driverLicense->fname = $request->father_name;
        $driverLicense->mname = $request->mother_name;
        $driverLicense->age = str_replace($bn, $en, $request->age);
        $driverLicense->nid = $request->nid;
        $driverLicense->current_address = $request->current_address;
        $driverLicense->address = $request->address;
        $driverLicense->upjela = $request->upazila;
        $driverLicense->post = $request->post;
        $driverLicense->delivery_date = Carbon::parse($request->delivery_date);
        $driverLicense->licenseno = str_replace($bn, $en, $request->license_no);
        $driverLicense->taka_receive_no = str_replace($bn, $en, $request->taka_receive_no);
        $driverLicense->licensefee =  $typeInfo->fees;
        $driverLicense->others =  $typeInfo->others;
        $vatTotal = ($typeInfo->fees / 100) * $typeInfo->vat;
        $driverLicense->vat =  $vatTotal;
        $driverLicense->total = $vatTotal + $typeInfo->fees;
        $driverLicense->issuedate = date('Y-m-d');
        $driverLicense->save();

        $driverLicense = AutoRickshawDriverLicense::where('id', $driverLicense->id)->first();

        return view('auto_rickshaw.vehicle_licence_print', compact('driverLicense'));

    }

    public function allVehicleLicense(){

        return view('auto_rickshaw.allvehicle');
    }

    public function vehicleLicensePrint(AutoRickshawDriverLicense $driverLicense){

        return view('auto_rickshaw.vehicle_licence_print', compact('driverLicense'));

    }

    public function ownerLicensePrint(AutoRickshawOwnerLicense $ownerLicense){

        return view('auto_rickshaw.owner_licence_print', compact('ownerLicense'));

    }


    public function ownerLicense(){

        $types = AutoRickshawType::where('type',1)->get();
        return view('auto_rickshaw.owner',compact('types'));
    }


    public function ownerLicensePost(Request $request){

        $request->validate([
            'type'=>'required',
            'fiscal_year'=>'required',
            'owner_name'=>'required|max:255',
            'father_name'=>'required|max:255',
            'mother_name'=>'required|max:255',
            'model_no'=>'nullable|max:255',
            'nid'=>'required|max:255',
            'address'=>'required|max:255',
            'current_address'=>'required|max:255',
            'plate_no'=>'required|max:255',
            'upazila'=>'required|max:255',
            'post'=>'required|max:255',
            'license_no'=>'required|max:255',
            'taka_receive_no'=>'required|max:255',
            'delivery_date'=>'required',
        ]);

        $bn= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        $lastslno = AutoRickshawOwnerLicense::orderBy('id', 'desc')->first();
        if(empty($lastslno)){ $lastslno=1;}else{ $lastslno = (int)$lastslno->slno + 1; }

        $slno = str_pad($lastslno,5,"0",STR_PAD_LEFT);

        $typeInfo = AutoRickshawType::where('id',$request->type)->first();


        $vehicle = new AutoRickshawOwnerLicense;
        $vehicle->type_id = $request->type;
        $vehicle->slno = $slno;
        $vehicle->year = $request->fiscal_year;
        $vehicle->name = $request->owner_name;
        $vehicle->fname = $request->father_name;
        $vehicle->mname = $request->mother_name;
        $vehicle->modelno = str_replace($bn, $en, $request->model_no);
        $vehicle->nid = $request->nid;
        $vehicle->address = $request->address;
        $vehicle->current_address = $request->current_address;
        $vehicle->plate_no = $request->plate_no;
        $vehicle->upjela = $request->upazila;
        $vehicle->post = $request->post;
        $vehicle->delivery_date = Carbon::parse($request->delivery_date);
        $vehicle->licenseno = str_replace($bn, $en, $request->license_no);
        $vehicle->taka_receive_no = str_replace($bn, $en, $request->taka_receive_no);
        $vehicle->licensefee =  $typeInfo->fees;
        $vehicle->tinplate =  $typeInfo->tin_plate;
        $vatTotal = ($typeInfo->fees / 100) * $typeInfo->vat;
        $vehicle->vat =  $vatTotal;
        $vehicle->total =  $typeInfo->fees + $typeInfo->tin_plate + $vatTotal;
        $vehicle->name_change_fees =  $typeInfo->name_change_fees;
        $vehicle->others =  $typeInfo->others;
        $vehicle->issuedate = date('Y-m-d');
        $vehicle->save();

        $ownerLicense = AutoRickshawOwnerLicense::where('id', $vehicle->id)->first();

        return view('auto_rickshaw.owner_licence_print', compact('ownerLicense'));
    }

    public function ownerLicenseEdit(AutoRickshawOwnerLicense $ownerLicense){
        $types = AutoRickshawType::where('type',1)->get();
        return view('auto_rickshaw.owner_licence_edit', compact('ownerLicense','types'));
    }

    public function ownerLicenseEditPost(AutoRickshawOwnerLicense $ownerLicense,Request $request){

        $request->validate([
            'type'=>'required',
            'fiscal_year'=>'required',
            'owner_name'=>'required|max:255',
            'father_name'=>'required|max:255',
            'mother_name'=>'required|max:255',
            'model_no'=>'nullable|max:255',
            'nid'=>'required|max:255',
            'address'=>'required|max:255',
            'current_address'=>'required|max:255',
            'plate_no'=>'required|max:255',
            'upazila'=>'required|max:255',
            'post'=>'required|max:255',
            'license_no'=>'required|max:255',
            'taka_receive_no'=>'required|max:255',
            'delivery_date'=>'required',
        ]);

        $bn= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        $lastslno = AutoRickshawOwnerLicense::orderBy('id', 'desc')->first();
        if(empty($lastslno)){ $lastslno=1;}else{ $lastslno = (int)$lastslno->slno + 1; }


        $typeInfo = AutoRickshawType::where('id',$request->type)->first();

        $ownerLicense->type_id = $request->type;
        $ownerLicense->year = $request->fiscal_year;
        $ownerLicense->name = $request->owner_name;
        $ownerLicense->fname = $request->father_name;
        $ownerLicense->mname = $request->mother_name;
        $ownerLicense->modelno = str_replace($bn, $en, $request->model_no);
        $ownerLicense->nid = $request->nid;
        $ownerLicense->address = $request->address;
        $ownerLicense->current_address = $request->current_address;
        $ownerLicense->plate_no = $request->plate_no;
        $ownerLicense->upjela = $request->upazila;
        $ownerLicense->post = $request->post;
        $ownerLicense->delivery_date = Carbon::parse($request->delivery_date);
        $ownerLicense->licenseno = str_replace($bn, $en, $request->license_no);
        $ownerLicense->taka_receive_no = str_replace($bn, $en, $request->taka_receive_no);
        $ownerLicense->licensefee =  $typeInfo->fees;
        $ownerLicense->tinplate =  $typeInfo->tin_plate;
        $vatTotal = ($typeInfo->fees / 100) * $typeInfo->vat;
        $ownerLicense->vat =  $vatTotal;
        $ownerLicense->total =  $typeInfo->fees + $typeInfo->tin_plate + $vatTotal;
        $ownerLicense->name_change_fees =  $typeInfo->name_change_fees;
        $ownerLicense->others =  $typeInfo->others;
        $ownerLicense->issuedate = date('Y-m-d');
        $ownerLicense->save();

        $ownerLicense = AutoRickshawOwnerLicense::where('id', $ownerLicense->id)->first();

        return view('auto_rickshaw.owner_licence_print', compact('ownerLicense'));
    }

    public function allOwnerLicense(){

        return view('auto_rickshaw.allowner');
    }

    public function ownerLicenseDatatable()
    {
        $query = AutoRickshawOwnerLicense::with('type');
        return DataTables::eloquent($query)

            ->addColumn('action', function(AutoRickshawOwnerLicense $ownerLicense) {

             return '<a class="btn btn-success bg-gradient-success btn-sm" href="'.route('auto_rickshaw.owner_print',['ownerLicense'=>$ownerLicense->id]).'">Print</a>
                     <a style="margin-top: 8px" class="btn btn-success bg-gradient-successc btn-sm" href="'.route('auto_rickshaw.owner_license_edit',['ownerLicense'=>$ownerLicense->id]).'">Edit</a>';


            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function vehicleLicenseDatatable()
    {
        $query = AutoRickshawDriverLicense::with('type');
        return DataTables::eloquent($query)

            ->addColumn('action', function(AutoRickshawDriverLicense $driverLicense) {

             return '<a class="btn btn-success bg-gradient-success btn-sm" href="'.route('auto_rickshaw.vehicle_print',['driverLicense'=>$driverLicense->id]).'">Print</a>
                     <a class="btn btn-success bg-gradient-success btn-sm" href="'.route('auto_rickshaw.vehicle_edit',['driverLicense'=>$driverLicense->id]).'">Edit</a>';

            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function vehicleLicenseCollectionReport(Request $request)
    {
        $licences = [];
        $query = AutoRickshawDriverLicense::query();
        if ($request->type){
            $query->where('type_id',$request->type);
        }
        if ($request->fiscal_year){
            $query->where('year',$request->fiscal_year);
        }
        if ($request->start_date){
            $query->whereBetween('issuedate',[Carbon::parse($request->start_date)->format('Y-m-d'),Carbon::parse($request->end_date)->format('Y-m-d')]);
        }
        if ($request->submit != ''){
            $licences = $query->get();
        }

        $types = AutoRickshawType::where('type',2)->get();

        return view('auto_rickshaw.allvehicle_report_c',compact('licences','types'));
    }
    public function vehicleLicenseReport(Request $request)
    {
        $licences = [];

        $query = AutoRickshawDriverLicense::query();
        if ($request->type){
            $query->where('type_id',$request->type);
        }
        if ($request->fiscal_year){
            $query->where('year',$request->fiscal_year);
        }
        if ($request->start_date){
            $query->whereBetween('issuedate',[Carbon::parse($request->start_date)->format('Y-m-d'),Carbon::parse($request->end_date)->format('Y-m-d')]);
        }
        if ($request->submit != ''){
            $licences = $query->get();
        }
        $types = AutoRickshawType::where('type',2)->get();

        return view('auto_rickshaw.allvehicle_report',compact('licences','types'));
    }
    public function ownerLicenseReport(Request $request)
    {

        $licences = [];

        $query = AutoRickshawOwnerLicense::query();
        if ($request->type){
            $query->where('type_id',$request->type);
        }
        if ($request->fiscal_year){
            $query->where('year',$request->fiscal_year);
        }
        if ($request->start_date){
            $query->whereBetween('issuedate',[Carbon::parse($request->start_date)->format('Y-m-d'),Carbon::parse($request->end_date)->format('Y-m-d')]);
        }
        if ($request->submit != ''){
            $licences = $query->get();
        }



        $types = AutoRickshawType::where('type',1)->get();

        return view('auto_rickshaw.allowner_report',compact('licences','types'));
    }
    public function ownerLicenseCollectionReport(Request $request)
    {
        $licences = [];
        $query = AutoRickshawOwnerLicense::query();
        if ($request->type){
            $query->where('type_id',$request->type);
        }
        if ($request->fiscal_year){
            $query->where('year',$request->fiscal_year);
        }
        if ($request->start_date){
            $query->whereBetween('issuedate',[Carbon::parse($request->start_date)->format('Y-m-d'),Carbon::parse($request->end_date)->format('Y-m-d')]);
        }
        if ($request->submit != ''){
            $licences = $query->get();
        }


        $types = AutoRickshawType::where('type',1)->get();

        return view('auto_rickshaw.allowner_report_c',compact('licences','types'));
    }

}
