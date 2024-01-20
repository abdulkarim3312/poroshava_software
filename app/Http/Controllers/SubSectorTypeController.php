<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\Branch;
use App\Models\TaxType;
use App\Models\TaxTypeType;
use App\Models\Upangsho;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubSectorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('accounts.sub_sector_type.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Upangsho::all();
        $sectors = TaxType::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->get();
      return view('accounts.sub_sector_type.create',compact('sections','sectors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'upangsho'=>'required',
            'sector_type'=>'required',
            'income_expenditure'=>'required',
            'name'=>'required|max:255',
            'serial'=>'nullable|max:255',
            'status'=>'required',
        ]);

        $sectorType = new TaxTypeType();
        $sectorType->sister_concern_id = auth()->user()->sister_concern_id;
        $sectorType->upangsho_id = $request->upangsho;
        $sectorType->khtattype_id = $request->sector_type;
        $sectorType->serialise = $request->serial;
        $sectorType->khat_id = $request->income_expenditure;
        $sectorType->tax_name2 = $request->name;
        $sectorType->status = $request->status;
        $sectorType->save();


        return redirect()->route('sub_sector_type')->with('message', 'Sub sector type created successfully.');

    }

    public function edit(TaxTypeType $sectorType)
    {
        $sections = Upangsho::all();
        $sectors = TaxType::where('sister_concern_id',auth()->user()->sister_concern_id)
        ->get();
        return view('accounts.sub_sector_type.edit',compact('sections','sectorType','sections','sectors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaxTypeType $sectorType,Request $request)
    {
        $request->validate([
            'upangsho'=>'required',
            'sector_type'=>'required',
            'income_expenditure'=>'required',
            'name'=>'required|max:255',
            'serial'=>'nullable|max:255',
            'status'=>'required',
        ]);


        $sectorType->upangsho_id = $request->upangsho;
        $sectorType->khtattype_id = $request->sector_type;
        $sectorType->serialise = $request->serial;
        $sectorType->khat_id = $request->income_expenditure;
        $sectorType->tax_name2 = $request->name;
        $sectorType->status = $request->status;
        $sectorType->save();

        return redirect()->route('sub_sector_type')->with('message', 'Sub sector type updated successfully.');
    }
    public function datatable() {
        $query = TaxTypeType::select('tax_type_types.*')
            ->where('sister_concern_id',auth()->user()->sister_concern_id)
            ->with('upangsho','taxType');
        return DataTables::eloquent($query)
            ->addColumn('action', function(TaxTypeType $sectorType) {
                return '<a href="'.route('sub_sector_type.edit',['sectorType'=>$sectorType->tax_id]).'" class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('upangsho_name', function(TaxTypeType $sectorType) {
                return $sectorType->upangsho->upangsho_name ?? '';
            })
            ->addColumn('sector_type_name', function(TaxTypeType $sectorType) {
                return $sectorType->taxType->tax_name ?? '';
            })
            ->addColumn('status', function(TaxTypeType $sectorType) {
                if ($sectorType->status == 1)
                    return '<span class="badge badge-success">সক্রিয়</span>';
                else
                    return '<span class="badge badge-danger">নিষ্ক্রিয়</span>';
            })
            ->addColumn('khat_id', function(TaxTypeType $sectorType) {
                if ($sectorType->khat_id == 1)
                    return 'আয়';
                else
                    return 'ব্যয়';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
