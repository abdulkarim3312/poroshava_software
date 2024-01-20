<?php

namespace App\Http\Controllers\Holding;

use App\Http\Controllers\Controller;
use App\Models\Holding\HoldingUseType;
use Illuminate\Http\Request;

class HoldingUseTypeController extends Controller
{
    public function index() {
        $holdingUseTypes = HoldingUseType::get();
        return view('holding_tax.setting.use_type.all', compact('holdingUseTypes'));
    }

    public function add() {
        return view('holding_tax.setting.use_type.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $holdingUseType = new HoldingUseType();
        $holdingUseType->name = $request->name;
        $holdingUseType->save();

        return redirect()->route('holding.use_type')->with('message', 'হোল্ডিং ব্যবহারের ধরন যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(HoldingUseType $holdingUseType) {
        return view('holding_tax.setting.use_type.edit', compact('holdingUseType'));
    }

    public function editPost(HoldingUseType $holdingUseType, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $holdingUseType->name = $request->name;
        $holdingUseType->save();

        return redirect()->route('holding.use_type')->with('message', 'হোল্ডিং ব্যবহারের ধরন পরিবর্তন সম্পন্ন হয়েছে।');
    }
}
