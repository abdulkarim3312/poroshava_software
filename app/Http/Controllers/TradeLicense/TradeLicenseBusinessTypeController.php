<?php

namespace App\Http\Controllers\TradeLicense;

use App\Http\Controllers\Controller;
use App\Models\TradeLicense\BusinessType;
use Illuminate\Http\Request;

class TradeLicenseBusinessTypeController extends Controller
{
    public function index() {
        $businessTypes = BusinessType::get();
        return view('trade_license.setting.business_type.all', compact('businessTypes'));
    }

    public function add() {
        return view('trade_license.setting.business_type.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'business_type' => 'required|string|max:255',
            'type_rate' => 'required|numeric|min:0',
        ]);

        $businessType = new BusinessType();
        $businessType->business_type = $request->business_type;
        $businessType->type_rate = $request->type_rate;
        $businessType->save();

        return redirect()->route('trade_license_business_type')->with('message', 'ব্যবসার ধরন যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(BusinessType $businessType) {
        return view('trade_license.setting.business_type.edit', compact('businessType'));
    }

    public function editPost(BusinessType $businessType, Request $request) {
        $request->validate([
            'business_type' => 'required|string|max:255',
            'type_rate' => 'required|numeric|min:0',
        ]);

        $businessType->business_type = $request->business_type;
        $businessType->type_rate = $request->type_rate;
        $businessType->save();

        return redirect()->route('trade_license_business_type')->with('message', 'ব্যবসার ধরন পরিবর্তন সম্পন্ন হয়েছে।');
    }

    public function delete(Request $request) {
        BusinessType::where('id', $request->businessTypeID)->delete();
        return response()->json(['success'=>true,'message'=>"মুছে ফেলা হয়েছে।"]);
    }
}
