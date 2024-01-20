<?php

namespace App\Http\Controllers\TradeLicense;

use App\Http\Controllers\Controller;
use App\Models\Holding\HoldingArea;
use App\Models\Holding\HoldingInfo;
use App\Models\Upazila;
use Illuminate\Http\Request;

class TradeCommonController extends Controller
{
    public function holdingNoJson(Request $request){
        if (!$request->searchTerm) {
            $holding_no = HoldingInfo::orderBy('holding_no')
                ->limit(20)
                ->get();
        } else {
            $holding_no = HoldingInfo::where('holding_no', 'like','%'.$request->searchTerm.'%')
                ->orderBy('holding_no')
                ->limit(20)
                ->get();
        }
        $data = array();

        foreach ($holding_no as $holding) {
            $data[] = [
                'id' => $holding->holding_no,
                'text' =>enNumberToBn($holding->holding_no)
            ];
        }

        echo json_encode($data);
    }
    public function getMoholla(Request $request){
        $moholla = HoldingArea::where('ward_id', $request->wardID)
            ->orderBy('road_name')
            ->get()->toArray();

        return response()->json($moholla);
    }
    public function getUpazila(Request $request){
        $upazila = Upazila::where('district_id', $request->districtID)
            ->orderBy('bn_name')
            ->get()->toArray();

        return response()->json($upazila);
    }
}
