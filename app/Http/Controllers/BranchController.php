<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Upangsho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

//     $oldBanks = DB::table('cashbook_branches')->get();
//        foreach ($oldBanks as $oldBank){
//            $bankOld = Bank::where('old_id',$oldBank->bank_id)->first();
//            if ($bankOld){
//                $branch = new Branch();
//                $branch->sister_concern_id = 4;
//                $branch->bank_id = $bankOld->bank_id;
//                $branch->old_id = $oldBank->branch_id;
//                $branch->branch_name = $oldBank->branch_name;
//                $branch->status = $oldBank->status;
//                $branch->save();
//            }
//        }
//        dd('old done');

        $branches = Branch::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->get();

        return view('accounts.branch.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banks = Bank::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->get();
      return view('accounts.branch.create',compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank'=>'required',
            'name'=>'required|max:255',
            'status'=>'required',
        ]);
        $branch = new Branch();
        $branch->sister_concern_id = auth()->user()->sister_concern_id;
        $branch->bank_id = $request->bank;
        $branch->branch_name = $request->name;
        $branch->status = $request->status;
        $branch->save();
        return redirect()->route('branch')->with('message', 'Branch created successfully.');

    }

    public function edit(Branch $branch)
    {
        $banks = Bank::where('sister_concern_id',auth()->user()->sister_concern_id)
                            ->get();
        return view('accounts.branch.edit',compact('branch','banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Branch $branch,Request $request)
    {

        $request->validate([
            'bank'=>'required',
            'name'=>'required|max:255',
            'status'=>'required',
        ]);

        $branch->bank_id = $request->bank;
        $branch->branch_name = $request->name;
        $branch->status = $request->status;
        $branch->save();

        return redirect()->route('branch')->with('message', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
