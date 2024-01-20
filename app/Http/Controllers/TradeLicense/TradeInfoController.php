<?php

namespace App\Http\Controllers\TradeLicense;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Holding\HoldingArea;
use App\Models\Holding\HoldingTaxPayer;
use App\Models\Holding\WardInfo;
use App\Models\TradeLicense\BusinessType;
use App\Models\TradeLicense\SignBoard;
use App\Models\TradeLicense\TradeUser;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TradeInfoController extends Controller
{
    public function index()
    {
        return view('trade_license.info.list');
    }

    public function datatable(){
        $query = TradeUser::whereNotNull('licence_no')->where('inactive_status',1)->where('licence_no','!=','')->orderBy('licence_no', 'ASC');

        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('action', function(TradeUser $tradeUser) {
                return '<a href="'.route('trade_license_details',['tradeUser'=>$tradeUser->id]).'" class="btn btn-info bg-gradient-info btn-sm btn-edit"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('licence_no', function (TradeUser $tradeUser){
                return enNumberToBn($tradeUser->licence_no);
            })
            ->addColumn('ward_no', function (TradeUser $tradeUser){
                return enNumberToBn($tradeUser->wardInfo->ward_no ?? '');
            })
            ->addColumn('road_name', function (TradeUser $tradeUser){
                return $tradeUser->areaInfo->road_name  ?? '';
            })
            ->addColumn('mobile_no', function (TradeUser $tradeUser){
                return enNumberToBn($tradeUser->mobile_no);
            })
            ->editColumn('inactive_status', function(TradeUser $taxPayer) {
                if ($taxPayer->inactive_status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';

            })

            ->rawColumns(['action','inactive_status'])
            ->toJson();
    }
    public function approveList()
    {
        return view('trade_license.info.approve_list');
    }

    public function approveListDatatable(){
        $query = TradeUser::where('licence_no','=','')->where('inspector',1)->where('secretary',1)->where('mayor',1);

        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('action', function(TradeUser $tradeUser) {
                return '<a href="'.route('trade_license_approve_details',['tradeUser'=>$tradeUser->id]).'" title="view details" class="btn btn-info bg-gradient-info btn-sm btn-edit"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('ward_no', function (TradeUser $tradeUser){
                return enNumberToBn($tradeUser->wardInfo->ward_no ?? '');
            })
            ->addColumn('road_name', function (TradeUser $tradeUser){
                return $tradeUser->areaInfo->road_name  ?? '';
            })
            ->addColumn('mobile_no', function (TradeUser $tradeUser){
                return enNumberToBn($tradeUser->mobile_no);
            })

            ->rawColumns(['action'])
            ->toJson();
    }
    public function pendingList(){
        return view('trade_license.info.pendig_list');
    }
    public function pendingListDatatable(){
        $query = TradeUser::where('inspector',0)->where('secretary',0)->where('mayor',0)->where('inactive_status',0);

        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('action', function(TradeUser $tradeUser) {
                return '<a href="'.route('trade_license_pending_details',['tradeUser'=>$tradeUser->id]).'" title="view details" class="btn btn-info bg-gradient-info btn-sm btn-edit"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('ward_no', function (TradeUser $tradeUser){
                return enNumberToBn($tradeUser->wardInfo->ward_no ?? '');
            })
            ->addColumn('road_name', function (TradeUser $tradeUser){
                return $tradeUser->areaInfo->road_name  ?? '';
            })
            ->addColumn('mobile_no', function (TradeUser $tradeUser){
                return enNumberToBn($tradeUser->mobile_no);
            })
            ->editColumn('inactive_status', function(TradeUser $taxPayer) {
                if ($taxPayer->inactive_status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';

            })
            ->rawColumns(['action','inactive_status'])
            ->toJson();
    }
    public function add(){
        return view('trade_license.info.add_trade_license');
    }
    public function addPost(){

    }
    public function edit(){

    }
    public function editPost(){

    }
    public function tradeUserDetails(TradeUser $tradeUser){
        return view('trade_license.info.details',compact('tradeUser'));
    }
    public function tradeUserApproveDetails(TradeUser $tradeUser){
        $wardInfos = WardInfo::get();
        $areas = HoldingArea::get();
        $signBoards = SignBoard::get();
        $businessTypes = BusinessType::get();
        return view('trade_license.info.approve_details', compact('tradeUser','wardInfos','areas','signBoards','businessTypes'));
    }
    public function tradeUserPendingDetails(TradeUser $tradeUser){
        $wardInfos = WardInfo::get();
        $areas = HoldingArea::get();
        $districts = District::get();
        $upazilas = Upazila::get();
        $signBoards = SignBoard::get();
        return view('trade_license.info.pending_details',compact('tradeUser','wardInfos','districts','signBoards'));
    }
}
