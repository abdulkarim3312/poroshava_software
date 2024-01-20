<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\Branch;
use App\Models\CashbookIncoexpense;
use App\Models\Incoexpense;
use App\Models\Upangsho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

//        $bankAccounts = BankDetails::where('sister_concern_id',4)
//            ->orderBy('acc_no')
//            ->pluck('acc_no');
//        $bankAccounts2 = BankDetails::where('sister_concern_id',1)
//                ->whereIn('acc_no',$bankAccounts)
//                ->orderBy('acc_no')
//                ->pluck('acc_no');
//        dd($bankAccounts,$bankAccounts2);


        //bank updated
//        $oldAccounts = DB::table('cashbook_bank_details')
//            ->whereIn('branch_id',[1,6,7,8,30])
//            ->pluck('bank_details_id');
//
//        $newAccounts = DB::table('bank_details')
//          ->whereIn('old_id',$oldAccounts)
//          ->pluck('old_id');
//        $newBanks = DB::table('banks')
//            ->whereNotNull('old_id')
//            ->pluck('old_id');
//        $newBranches = DB::table('branches')
//            ->whereNotNull('old_id')
//            ->pluck('old_id');
//
//        $cashbookIncomes = DB::table('cashbook_incoexpenses')
//                        ->whereIn('bank_id',$newBanks)
//                        ->whereIn('branch_id',$newBranches)
//                        ->whereIn('acc_no',$newAccounts)
//                        ->get();
//
//        foreach ($cashbookIncomes as $cashbookIncome){
//            $bankAccount = DB::table('bank_details')
//                ->where('old_id',$cashbookIncome->acc_no)
//                ->first();
//
//            DB::table('cashbook_incoexpenses')
//                ->where('incoexpenses_id',$cashbookIncome->incoexpenses_id)
//                ->update([
//                    'bank_id'=>$bankAccount->bank_id,
//                    'branch_id'=>$bankAccount->branch_id,
//                    'acc_no'=>$bankAccount->bank_details_id,
//                ]);
//        }
//        dd('alhamdulillah');
//Khat updated
        //Update In this section
//        $khats = DB::table('khats')
//            ->where('sister_concern_id',4)
//            ->pluck('old_khat_id');
//
//            $cashbookIncomes = DB::table('cashbook_incoexpenses')
//                ->whereIn('khat_id',$khats)
//                ->get();
//
//
//        foreach ($cashbookIncomes as $cashbookIncome){
//            $khat = DB::table('khats')
//                ->where('old_khat_id',$cashbookIncome->khat_id)
//                ->first();
//
//            DB::table('cashbook_incoexpenses')
//                ->where('incoexpenses_id',$cashbookIncome->incoexpenses_id)
//                ->update([
//                    'khattype_id'=>$khat->tax_type_id,
//                    'khtattypetype_id'=>$khat->tax_type_type_id,
//                    'khat_id'=>$khat->khat_id,
//                ]);
//        }
//        dd('alhamdulillah');


//        $oldAccounts = DB::table('cashbook_bank_details')->get();
//        foreach ($oldAccounts as $oldAccount){
//            $bankOld = Bank::where('old_id',$oldAccount->bank_id)->first();
//            $branchOld = Branch::where('old_id',$oldAccount->branch_id)->first();
//
//            if ($bankOld && $branchOld){
//                $bankAccount = new BankDetails();
//                $bankAccount->sister_concern_id = 4;
//                $bankAccount->old_id = $oldAccount->bank_details_id;
//                $bankAccount->upangsho_id = $oldAccount->upangsho_id;
//                $bankAccount->bank_id = $bankOld->bank_id;
//                $bankAccount->branch_id = $branchOld->branch_id;
//                $bankAccount->acc_code = $oldAccount->acc_code;
//                $bankAccount->acc_details = $oldAccount->acc_details;
//                $bankAccount->acc_no = $oldAccount->acc_no;
//                $bankAccount->open_balance = $oldAccount->open_balance;
//                $bankAccount->update_balance = $oldAccount->update_balance;
//                $bankAccount->status = $oldAccount->status;
//                $bankAccount->save();
//            }
//        }
//        dd('old done');

//        $cashbookIncomes = DB::table('cashbook_incoexpenses')
//            ->select('acc_no')
//            ->groupBy('acc_no')
//            ->pluck('acc_no');
//        $cashbookBanks = BankDetails::where('sister_concern_id',4)
//                    ->whereIn('old_id',$cashbookIncomes)
//                    ->select('acc_no')
//                    ->groupBy('acc_no')
//                    ->pluck('acc_no');
//        $accountBanks = BankDetails::where('sister_concern_id',1)
//            ->whereIn('acc_no',$cashbookBanks)
//            ->select('acc_no')
//            ->groupBy('acc_no')
//            ->pluck('acc_no');
//
//
//        dd('Cashbook Bank '.$cashbookBanks,'Accounts Bank '.$accountBanks);
//        $cashbookIncomes = DB::table('cashbook_incoexpenses')
//            ->whereIn('acc_no',[86,85,62,53,1])
//            ->skip(20116)
//            ->take(10058)
//            ->get();
//
//
//        foreach ($cashbookIncomes as $cashbookIncome){
//            if ($cashbookIncome->acc_no == 86){
//                $newBankId = 95;
//            }elseif ($cashbookIncome->acc_no == 85){
//                    $newBankId = 46;
//
//            }elseif ($cashbookIncome->acc_no == 62){
//                $newBankId = 62;
//
//            }elseif ($cashbookIncome->acc_no == 53){
//                $newBankId = 53;
//
//            }elseif ($cashbookIncome->acc_no == 1){
//                $newBankId = 1;
//
//            }else{
//                $newBankId = null;
//            }
//
//            $bankAccount = BankDetails::where('sister_concern_id',1)
//                ->where('bank_details_id',$newBankId)->first();
//
//            if ($bankAccount){
//                DB::table('cashbook_incoexpenses')
//                    ->where('incoexpenses_id',$cashbookIncome->incoexpenses_id)
//                    ->update([
//                        'bank_id'=>$bankAccount->bank_id,
//                        'branch_id'=>$bankAccount->branch_id,
//                        'acc_no'=>$bankAccount->bank_details_id,
//                    ]);
//            }
//
//        }
//        dd('dddd_bank');

//        $cashbookIncomes = CashbookIncoexpense::where('receive_datwe','>=',date('2023-07-01'))->get();
//
//        foreach ($cashbookIncomes as $cashbookIncome){
//            BankDetails::where('bank_details_id', $cashbookIncome->acc_no)
//                ->increment('update_balance', $cashbookIncome->amount);
//            $incoexpenseid = new Incoexpense();
//            $incoexpenseid->cashbook_incoexpenses_id = $cashbookIncome->incoexpenses_id;
//            $incoexpenseid->user_id = $cashbookIncome->user_id;
//            $incoexpenseid->upangsho_id = $cashbookIncome->upangsho_id;
//            $incoexpenseid->inout_id = $cashbookIncome->inout_id;
//            $incoexpenseid->khattype_id = $cashbookIncome->khattype_id;
//            $incoexpenseid->khtattypetype_id = $cashbookIncome->khtattypetype_id;
//            $incoexpenseid->khat_id = $cashbookIncome->khat_id;
//            $incoexpenseid->proklpo_id = null;
//            $incoexpenseid->taxnontax = $cashbookIncome->taxnontax;
//            $incoexpenseid->khat_des = $cashbookIncome->khat_des;
//            $incoexpenseid->year = $cashbookIncome->year;
//            $incoexpenseid->bank_id = $cashbookIncome->bank_id;
//            $incoexpenseid->branch_id = $cashbookIncome->branch_id;
//            $incoexpenseid->acc_no = $cashbookIncome->acc_no;
//            $incoexpenseid->vourcher_no = $cashbookIncome->vourcher_no;
//            $incoexpenseid->status = $cashbookIncome->status;
//            $incoexpenseid->vat_tax_status = $cashbookIncome->vat_tax_status;
//            $incoexpenseid->chalan_no = $cashbookIncome->chalan_no;
//            $incoexpenseid->check_no = $cashbookIncome->check_no;
//            $incoexpenseid->amount = $cashbookIncome->amount;
//            $incoexpenseid->date = $cashbookIncome->date;
//            $incoexpenseid->receiver_name = $cashbookIncome->receiver_name;
//            $incoexpenseid->receive_datwe = $cashbookIncome->receive_datwe;
//            $incoexpenseid->note = $cashbookIncome->note;
//            $incoexpenseid->save();
       // }
//    dd('ddd');

        $accounts = BankDetails::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->get();
        return view('accounts.bank_account.index',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $banks = Bank::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->get();
        $sections = Upangsho::all();
      return view('accounts.bank_account.create',compact('banks','sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['opening_balance'] = bnNumberToEn($request->opening_balance);
        $request->validate([
            'upangsho'=>'required',
            'bank'=>'required',
            'branch'=>'required',
            'code'=>'required|max:255',
            'details'=>'required|max:255',
            'account_no'=>'required|max:255',
            'opening_balance'=>'required|numeric|min:0',
            'status'=>'required',
        ]);
        $bankAccount = new BankDetails();
        $bankAccount->sister_concern_id = auth()->user()->sister_concern_id;
        $bankAccount->upangsho_id = $request->upangsho;
        $bankAccount->bank_id = $request->bank;
        $bankAccount->branch_id = $request->branch;
        $bankAccount->acc_code = $request->code;
        $bankAccount->acc_details = $request->details;
        $bankAccount->acc_no = $request->account_no;
        $bankAccount->open_balance = $request->opening_balance;
        $bankAccount->status = $request->status;
        $bankAccount->save();
        return redirect()->route('bank_account')->with('message', 'Bank account created successfully.');

    }

    public function edit(BankDetails $bankAccount)
    {
        $banks = Bank::where('sister_concern_id',auth()->user()->sister_concern_id)
                            ->get();
        $sections = Upangsho::all();
        return view('accounts.bank_account.edit',compact('banks','bankAccount','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankDetails $bankAccount,Request $request)
    {
        $request['opening_balance'] = bnNumberToEn($request->opening_balance);
        $request->validate([
            'upangsho'=>'required',
            'bank'=>'required',
            'branch'=>'required',
            'code'=>'required|max:255',
            'details'=>'required|max:255',
            'account_no'=>'required|max:255',
            'opening_balance'=>'required|numeric|min:0',
            'status'=>'required',
        ]);

        $bankAccount->upangsho_id = $request->upangsho;
        $bankAccount->bank_id = $request->bank;
        $bankAccount->branch_id = $request->branch;
        $bankAccount->acc_code = $request->code;
        $bankAccount->acc_details = $request->details;
        $bankAccount->acc_no = $request->account_no;
        $bankAccount->open_balance = $request->opening_balance;
        $bankAccount->status = $request->status;
        $bankAccount->save();

        return redirect()->route('bank_account')->with('message', 'Bank account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
