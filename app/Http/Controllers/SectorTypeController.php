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

class SectorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('accounts.sector_type.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Upangsho::where('upangsho_id','!=',0)->get();
      return view('accounts.sector_type.create',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'upangsho'=>'required',
            'income_expenditure'=>'required',
            'name'=>'required|max:255',
            'status'=>'required',
        ]);
        $sectorType = new TaxType();
        $sectorType->sister_concern_id = auth()->user()->sister_concern_id;
        $sectorType->upangsho_id = $request->upangsho;
        $sectorType->khat_id = $request->income_expenditure;
        $sectorType->tax_name = $request->name;
        $sectorType->status = $request->status;
        $sectorType->save();

        return redirect()->route('sector_type')->with('message', 'Sector type created successfully.');

    }

    public function edit(TaxType $sectorType)
    {
        $sections = Upangsho::where('upangsho_id','!=',0)->get();
        return view('accounts.sector_type.edit',compact('sections','sectorType','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaxType $sectorType,Request $request)
    {
        $request->validate([
            'upangsho'=>'required',
            'income_expenditure'=>'required',
            'name'=>'required|max:255',
            'status'=>'required',
        ]);

        $sectorType->upangsho_id = $request->upangsho;
        $sectorType->khat_id = $request->income_expenditure;
        $sectorType->tax_name = $request->name;
        $sectorType->status = $request->status;
        $sectorType->save();

        return redirect()->route('sector_type')->with('message', 'Sector type updated successfully.');
    }
    public function datatable() {
        $query = TaxType::select('tax_types.*')
            ->where('sister_concern_id',auth()->user()->sister_concern_id)
            ->with('upangsho');
        return DataTables::eloquent($query)
            ->addColumn('action', function(TaxType $sectorType) {
                return '<a href="'.route('sector_type.edit',['sectorType'=>$sectorType->tax_id]).'" class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('upangsho_name', function(TaxType $sectorType) {
                return $sectorType->upangsho->upangsho_name ?? '';
            })

            ->addColumn('status', function(TaxType $sectorType) {
                if ($sectorType->status == 1)
                    return '<span class="badge badge-success">সক্রিয়</span>';
                else
                    return '<span class="badge badge-danger">নিষ্ক্রিয়</span>';
            })
            ->addColumn('khat_id', function(TaxType $sectorType) {
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
