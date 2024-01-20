<?php

namespace App\Http\Controllers\AutoRickshaw;

use App\Http\Controllers\Controller;
use App\Models\AutoRickshaw\AutoRickshawType;
use Illuminate\Http\Request;

class AutoRickshawTypeController extends Controller
{
    public function index()
    {
        $types = AutoRickshawType::all();

        return view('auto_rickshaw.type.all',compact('types'));
    }
    public function add()
    {
        return view('auto_rickshaw.type.add');
    }
    public function addPost(Request $request)
    {

        $request->validate([
            'type'=>'required',
            'name'=>'required',
            'fees'=>'required|numeric',
            'vat'=>'required|numeric',
            'tin_plate'=>'nullable|numeric',
            'name_change_fees'=>'nullable|numeric',
        ]);
        $type = new AutoRickshawType();
        $type->type = $request->type;
        $type->name = $request->name;
        $type->fees = $request->fees;
        $type->vat = $request->vat;
        $vatTotal = ($request->fees / 100) * $request->vat;
        $total = $vatTotal + $request->tin_plate + $request->fees + $request->others;
        $type->tin_plate = $request->tin_plate ?? 0;
        $type->total = $total;
        $type->name_change_fees = $request->tin_plate ?? 0;
        $type->others = $request->others ?? 0;
        $type->save();

        return redirect()->route('auto_rickshaw.type')
            ->with('message','Type add successfully.');
    }
    public function edit(AutoRickshawType $type)
    {
        return view('auto_rickshaw.type.edit',compact('type'));
    }

    public function editPost(AutoRickshawType $type,Request $request)
    {
        $request->validate([
            'type'=>'required',
            'name'=>'required',
            'fees'=>'required|numeric',
            'vat'=>'required|numeric',
            'tin_plate'=>'nullable|numeric',
            'name_change_fees'=>'nullable|numeric',
        ]);
        $type->type = $request->type;
        $type->name = $request->name;
        $type->fees = $request->fees;
        $type->vat = $request->vat;
        $vatTotal = ($request->fees / 100) * $request->vat;
        $total = $vatTotal + $request->tin_plate + $request->fees + $request->others;
        $type->tin_plate = $request->tin_plate ?? 0;
        $type->total = $total;
        $type->name_change_fees = $request->name_change_fees ?? 0;
        $type->others = $request->others ?? 0;
        $type->save();

        return redirect()->route('auto_rickshaw.type')
            ->with('message','Type edit successfully.');
    }

    public function getTypeDetails(Request $request)
    {
        $type = AutoRickshawType::where('id',$request->typeId)->first()->toArray();
        return response()->json($type);
    }
}
