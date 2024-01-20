<?php

namespace App\Http\Controllers\Holding;

use App\Http\Controllers\Controller;
use App\Models\Holding\StructureType;
use Illuminate\Http\Request;

class StructureTypeController extends Controller
{
    public function index() {
        $structureTypes = StructureType::get();
        return view('holding_tax.setting.structure_type.all', compact('structureTypes'));
    }

    public function add() {
        return view('holding_tax.setting.structure_type.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $structureType = new StructureType();
        $structureType->name = $request->name;
        $structureType->save();

        return redirect()->route('holding.structure_type')->with('message', 'হোল্ডিং স্থাপনার ধরন যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(StructureType $structureType) {
        return view('holding_tax.setting.structure_type.edit', compact('structureType'));
    }

    public function editPost(StructureType $structureType, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $structureType->name = $request->name;
        $structureType->save();

        return redirect()->route('holding.structure_type')->with('message', 'হোল্ডিং স্থাপনার ধরন পরিবর্তন সম্পন্ন হয়েছে।');
    }

    public function delete(Request $request) {
        StructureType::where('id', $request->structureTypeId)->delete();
        return response()->json(['success'=>true,'message'=>"সফলভাবে মুছে ফেলা হয়েছে।"]);
    }
}
