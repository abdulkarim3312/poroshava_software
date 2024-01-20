<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Upangsho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


//        $oldBanks = DB::table('cashbook_banks')->get();
//        foreach ($oldBanks as $oldBank){
//            $bank = new Bank();
//            $bank->sister_concern_id = 4;
//            $bank->old_id = $oldBank->bank_id;
//            $bank->bank_name = $oldBank->bank_name;
//            $bank->status = $oldBank->status;
//            $bank->save();
//        }
//        dd('old done');


        $banks = Bank::where('sister_concern_id',auth()->user()->sister_concern_id)
                            ->get();

        return view('accounts.bank.index',compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('accounts.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'status'=>'required',
        ]);
        $bank = new Bank();
        $bank->sister_concern_id = auth()->user()->sister_concern_id;
        $bank->bank_name = $request->name;
        $bank->status = $request->status;
        $bank->save();
        return redirect()->route('bank')->with('message', 'Bank created successfully.');

    }

    public function edit(Bank $bank)
    {
        return view('accounts.bank.edit',compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Bank $bank,Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'status'=>'required',
        ]);

        $bank->bank_name = $request->name;
        $bank->status = $request->status;
        $bank->save();
        return redirect()->route('bank')->with('message', 'Bank updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
