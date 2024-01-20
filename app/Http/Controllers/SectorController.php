<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\Branch;
use App\Models\CashbookIncoexpense;
use App\Models\Khat;
use App\Models\TaxType;
use App\Models\TaxTypeType;
use App\Models\Upangsho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index2()
    {
        $cashbookSubSectors = DB::table('cashbook_tax_types')->get();
        foreach ($cashbookSubSectors as $cashbookSubSector) {
            $sectorType = new TaxType();
            $sectorType->sister_concern_id = 4;
            $sectorType->upangsho_id = $cashbookSubSector->upangsho_id;
            $sectorType->khat_id = $cashbookSubSector->khat_id;
            $sectorType->subormain = $cashbookSubSector->subormain;
            $sectorType->tax_name = $cashbookSubSector->tax_name;
            $sectorType->status = $cashbookSubSector->status;
            $sectorType->save();

            $cashbookSubSubSectors = DB::table('cashbook_tax_type_types')
                ->where('tax_id', $cashbookSubSector->tax_id)
                ->get();
            foreach ($cashbookSubSubSectors as $cashbookSubSubSector) {
                $sectorSubType = new TaxTypeType();
                $sectorSubType->khtattype_id = $sectorType->tax_id;//refer cashbook_tax_types table
                $sectorSubType->sister_concern_id = 4;
                $sectorSubType->upangsho_id = $cashbookSubSubSector->upangsho_id;
                $sectorSubType->tnt = $cashbookSubSubSector->tnt;
                $sectorSubType->serialise = $cashbookSubSubSector->serialise;
                $sectorSubType->khat_id = $cashbookSubSubSector->khat_id;
                $sectorSubType->tax_name2 = $cashbookSubSubSector->tax_name2;
                $sectorSubType->status = $cashbookSubSubSector->status;
                $sectorSubType->save();

                $cashbookSectors = DB::table('cashbook_khats')
                    ->where('tax_type_type_id', $cashbookSubSubSector->tax_id)
                    ->get();
                foreach ($cashbookSectors as $cashbookSector) {
                    $sector = new Khat();
                    $sector->sister_concern_id = 4;
                    $sector->upangsho_id = $cashbookSector->upangsho_id;
                    $sector->khattype = $cashbookSector->khattype;
                    $sector->txntx = $cashbookSector->txntx;
                    $sector->tax_type_id = $sectorType->tax_id;
                    $sector->tax_type_type_id = $sectorSubType->tax_id;
                    $sector->serilas = $cashbookSector->serilas;
                    $sector->khat_name = $cashbookSector->khat_name;
                    $sector->status = $cashbookSector->status;
                    $sector->save();

                    DB::table('cashbook_incoexpenses')
                        ->where('khat_id', $cashbookSector->khat_id)
                        ->update([
                            'khat_id' => $sector->khat_id,
                        ]);

                }
            }


        }

        $cashbookIncomes = DB::table('cashbook_incoexpenses')->get();

        foreach ($cashbookIncomes as $getCashbookIncome) {
            $cashbookIncome = DB::table('cashbook_incoexpenses')
                ->where('incoexpenses_id', $getCashbookIncome->incoexpenses_id)
                ->first();

            $newSector = Khat::where('khat_id', $getCashbookIncome->khat_id)->first();

            $cashbookIncome->khattype_id = $sectorType->tax_id;
            $cashbookIncome->khtattypetype_id = $sectorSubType->tax_id;
            $cashbookIncome->khat_id = $sector->khat_id;
            $cashbookIncome->save();

        }


        dd('ddd');

        return view('accounts.sector.index');
    }

    public function index()
    {

        //step 3
//        $cashbookSectors = DB::table('cashbook_khats')
//            ->whereIn('upangsho_id',[1,2])
//            ->get();
//
//        foreach ($cashbookSectors as $cashbookSector){
//
//            $cashbookSubSector = DB::table('tax_types')
//                    ->where('old_tax_id',$cashbookSector->tax_type_id)
//                    ->first();
//
//            if ($cashbookSector->tax_type_type_id != 0){
//                $cashbookSubSubSector = DB::table('tax_type_types')
//                    ->where('old_tax_id',$cashbookSector->tax_type_type_id)
//                    ->first();
//                $subSubSectorId = $cashbookSubSubSector->tax_id;
//            }else{
//                $subSubSectorId = 0;
//            }
//
//            dd($cashbookSubSector,$subSubSectorId);
//
//            $sector = new Khat();
//            $sector->sister_concern_id = 4;
//            $sector->old_khat_id = $cashbookSector->khat_id;
//            $sector->upangsho_id = $cashbookSector->upangsho_id;
//            $sector->khattype = $cashbookSector->khattype;
//            $sector->txntx = $cashbookSector->txntx;
//            $sector->tax_type_id = $cashbookSubSector->tax_id;
//            $sector->tax_type_type_id = $subSubSectorId;
//            $sector->serilas = $cashbookSector->serilas;
//            $sector->khat_name = $cashbookSector->khat_name;
//            $sector->status = $cashbookSector->status;
//            $sector->save();
//
//        }
//        dd('fff...gggg');
//


        //Step 2
//        $cashbookSubSubSectors = DB::table('cashbook_tax_type_types')
//            ->whereIn('upangsho_id',[1,2])
//            ->get();
//        foreach ($cashbookSubSubSectors as $cashbookSubSubSector){
//
//            $cashbookSubSector = DB::table('cashbook_tax_types')
//                ->where('tax_id',$cashbookSubSubSector->khtattype_id)
//                ->first();
//
//            $sectorSubType = new TaxTypeType();
//            $sectorSubType->sister_concern_id = 4;
//            $sectorSubType->khtattype_id = $cashbookSubSector->tax_id;//refer cashbook_tax_types table
//            $sectorSubType->old_tax_id = $cashbookSubSubSector->tax_id;
//            $sectorSubType->upangsho_id = $cashbookSubSubSector->upangsho_id;
//            $sectorSubType->tnt = $cashbookSubSubSector->tnt;
//            $sectorSubType->serialise = $cashbookSubSubSector->serialise;
//            $sectorSubType->khat_id = $cashbookSubSubSector->khat_id;
//            $sectorSubType->tax_name2 = $cashbookSubSubSector->tax_name2;
//            $sectorSubType->status = $cashbookSubSubSector->status;
//            $sectorSubType->save();
//
//        }
//        dd('dd...t');
//

        //Step 3
//        $cashbookSubSectors = DB::table('cashbook_tax_types')
//            ->whereIn('upangsho_id',[1,2])->get();
//
//        foreach ($cashbookSubSectors as $cashbookSubSector) {
//            $sectorType = new TaxType();
//            $sectorType->sister_concern_id = 4;
//            $sectorType->old_tax_id = $cashbookSubSector->tax_id;
//            $sectorType->upangsho_id = $cashbookSubSector->upangsho_id;
//            $sectorType->khat_id = $cashbookSubSector->khat_id;
//            $sectorType->subormain = $cashbookSubSector->subormain;
//            $sectorType->tax_name = $cashbookSubSector->tax_name;
//            $sectorType->status = $cashbookSubSector->status;
//            $sectorType->save();
//        }
//
//        dd('ff');
//
//

//        $sectors = DB::table('khats')
//            ->where('sister_concern_id',4)
//            //->where('tax_type_type_id',0)
//            ->get();
//
//        foreach ($sectors as $sector){
//            $subSectors = DB::table('cashbook_tax_types')
//                ->where('tax_id',$sector->tax_type_id)
//                ->get();
//
//            foreach ($subSectors as $subSector){
//                $subNewSector = DB::table('tax_types')
//                    ->where('sister_concern_id',4)
//                    ->where('tax_name',$subSector->tax_name)
//                    ->first();
//                if ($subNewSector){
//                    DB::table('khats')
//                        ->where('tax_type_id',$subSector->tax_id)
//                        ->update([
//                            'tax_type_id'=>$subNewSector->tax_id
//                        ]);
//                }else{
//                    echo 'Failed'.'<br>';
//                }
//
//            }
//        }
//

//        $incomes = DB::table('cashbook_incoexpenses')
//            ->get();
//        foreach ($incomes as $income) {
//            $oldKhat = DB::table('khats')
//                ->where('khat_id', $income->khat_id)
//                ->first();
//
//            if ($oldKhat) {
//                DB::table('cashbook_incoexpenses')
//                    ->where('incoexpenses_id', $income->incoexpenses_id)
//                    ->update([
//                        'khattype_id' => $oldKhat->tax_type_id,
//                        'khtattypetype_id' => $oldKhat->tax_type_type_id,
////                        'khat_id' => $oldKhat->khat_id,
//                    ]);
//            }
//
//        }
//
//        dd('ok');

        return view('accounts.sector.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $khatArray = [
//            423,
//            424,
//            431,
//            432,
//            454,
//            455,
//            457,
//            458,
//            461,
//            474,
//            450,
//            425,
//            426,
//            427,
//            428,
//            430,
//            456,
//            460,
//            433,
//            434,
//            442,
//            435,
//            436,
//            437,
//            438,
//            439,
//            467,
//            440,
//            441,
//            468,
//            443,
//            444,
//            445,
//            446,
//            429,
//            469,
//            447,
//            448,
//            466,
//            470,
//            471,
//            472,
//            477,
//            464,
//            462,
//            463,
//            465,
//            418,
//            419,
//            420,
//            421,
//            422,
//            449,
//            451,
//            452,
//            453,
//            459,
//        ];

//        $khatsId = CashbookIncoexpense::distinct()->pluck('khat_id');
//        $getPluckNames = Khat::whereIn('khat_id', $khatArray)
//                ->get();
//        dd($getPluckNames);

        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $types = TaxType::where('sister_concern_id', auth()->user()->sister_concern_id)->get();
        return view('accounts.sector.create', compact('sections', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'upangsho' => 'required',
            'sector_type' => 'required',
            'sub_sector_type' => 'required',
            'income_expenditure' => 'required',
            'name' => 'required|max:255',
            'serial' => 'nullable|max:255',
            'status' => 'required',
        ]);

        $sector = new Khat();
        $sector->sister_concern_id = auth()->user()->sister_concern_id;
        $sector->upangsho_id = $request->upangsho;
        $sector->khattype = $request->income_expenditure;
        $sector->tax_type_id = $request->sector_type;
        $sector->tax_type_type_id = $request->sub_sector_type;
        $sector->serilas = $request->serial;
        $sector->khat_name = $request->name;
        $sector->status = $request->status;
        $sector->save();


        return redirect()->route('sector')->with('message', 'Sector created successfully.');

    }

    public function edit(Khat $sector)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $types = TaxType::where('sister_concern_id', auth()->user()->sister_concern_id)->get();
        return view('accounts.sector.edit', compact('sections', 'sector', 'sections', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Khat $sector, Request $request)
    {
        $request->validate([
            'upangsho' => 'required',
            'sector_type' => 'required',
            'sub_sector_type' => 'required',
            'income_expenditure' => 'required',
            'name' => 'required|max:255',
            'serial' => 'nullable|max:255',
            'status' => 'required',
        ]);

        $sector->upangsho_id = $request->upangsho;
        $sector->khattype = $request->income_expenditure;
        $sector->tax_type_id = $request->sector_type;
        $sector->tax_type_type_id = $request->sub_sector_type;
        $sector->serilas = $request->serial;
        $sector->khat_name = $request->name;
        $sector->status = $request->status;
        $sector->save();

        return redirect()->route('sector')->with('message', 'Sector updated successfully.');
    }

    public function datatable()
    {


        $query = Khat::select('khats.*')
            ->where('sister_concern_id', auth()->user()->sister_concern_id)
            ->with('upangsho', 'taxType', 'taxSubType');
        return DataTables::eloquent($query)
            ->addColumn('action', function (Khat $sector) {
                return '<a href="' . route('sector.edit', ['sector' => $sector->khat_id]) . '" class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('upangsho_name', function (Khat $sector) {
                return $sector->upangsho->upangsho_name ?? '';
            })
            ->addColumn('sector_type_name', function (Khat $sector) {
                return $sector->taxType->tax_name ?? '';
            })
            ->addColumn('sub_sector_type_name', function (Khat $sector) {
                return $sector->taxSubType->tax_name2 ?? '';
            })
            ->addColumn('status', function (Khat $sector) {
                if ($sector->status == 1)
                    return '<span class="badge badge-success">সক্রিয়</span>';
                else
                    return '<span class="badge badge-danger">নিষ্ক্রিয়</span>';
            })
            ->addColumn('khattype', function (Khat $sector) {
                if ($sector->khattype == 1)
                    return 'আয়';
                else
                    return 'ব্যয়';
            })
            ->rawColumns(['action', 'status'])
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
