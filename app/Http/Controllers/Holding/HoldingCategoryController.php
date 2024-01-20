<?php

namespace App\Http\Controllers\Holding;

use App\Http\Controllers\Controller;
use App\Models\Holding\HoldingCategory;
use Illuminate\Http\Request;

class HoldingCategoryController extends Controller
{
    public function index() {
        $holdingCategories = HoldingCategory::get();
        return view('holding_tax.setting.holding_category.all', compact('holdingCategories'));
    }

    public function add() {
        return view('holding_tax.setting.holding_category.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'taxable' => 'required',
            'tax_rate' => 'nullable|string|max:25',
        ]);

        $holdingCategory = new HoldingCategory();
        $holdingCategory->name = $request->name;
        $holdingCategory->taxable = $request->taxable;
        $holdingCategory->tax_rate = $request->tax_rate;
        $holdingCategory->save();

        return redirect()->route('holding.holding_category')->with('message', 'হোল্ডিং মালিকানার ধরন যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(HoldingCategory $holdingCategory) {
        return view('holding_tax.setting.holding_category.edit', compact('holdingCategory'));
    }

    public function editPost(HoldingCategory $holdingCategory, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'taxable' => 'required',
            'tax_rate' => 'nullable|string|max:25',
        ]);

        $holdingCategory->name = $request->name;
        $holdingCategory->taxable = $request->taxable;
        $holdingCategory->tax_rate = $request->tax_rate;
        $holdingCategory->save();

        return redirect()->route('holding.holding_category')->with('message', 'হোল্ডিং মালিকানার ধরন পরিবর্তন সম্পন্ন হয়েছে।');
    }

    public function delete(Request $request) {
        HoldingCategory::where('id', $request->holdingCategoryId)->delete();
        return response()->json(['success'=>true,'message'=>"সফলভাবে মুছে ফেলা হয়েছে।"]);
    }
}
