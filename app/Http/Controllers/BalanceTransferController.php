<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\Incoexpense;
use App\Models\Upangsho;
use Illuminate\Http\Request;

class BalanceTransferController extends Controller
{
    public function create()
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $banks = Bank::all();
        return view('accounts.balance_transfer.create', compact('sections', 'banks'));
    }

    public function store(Request $request)
    {
        $request['amount'] = bnNumberToEn($request->amount);
        $request['cheque_no'] = bnNumberToEn($request->cheque_no);
        $request['voucher_no'] = bnNumberToEn($request->voucher_no);

        $request->validate([
            'upangsho' => 'required',
            'financial_year' => 'required',
            'bank' => 'required',
            'branch' => 'required',
            'bank_account' => 'required',
            'target_bank' => 'required',
            'target_branch' => 'required',
            'target_bank_account' => 'required|different:bank_account',
            'amount' => 'required|numeric|min:1',
            'voucher_no' => 'required|max:255',
            'cheque_no' => 'required|max:255',
        ]);
        $bankamount = BankDetails::where('bank_details_id', $request->bank_account)
            ->first()->update_balance;

        if ($bankamount < $request->amount) {
            return redirect()->back()->withInput()->with('error', 'আর্থিক স্থানন্তর সফল হইনি, ব্যালান্স চেক করুন');
        }

        BankDetails::where('bank_details_id', $request->target_bank_account)
            ->increment('update_balance', $request->amount);

        Incoexpense::create([
            'upangsho_id' => $request->upangsho,
            'inout_id' => 2,
            'khattype_id' => 75,
            'khtattypetype_id' => 0,
            'khat_id' => 186,
            'khat_des' => 'স্থানানন্ত্র প্রদান',
            'year' => $request->financial_year,
            'bank_id' => $request['bank'],
            'branch_id' => $request['branch'],
            'acc_no' => $request['bank_account'],
            'vourcher_no' => '',
            'vat_tax_status' => 0,
            'status' => 0,
            'chalan_no' => '',
            'check_no' => $request->cheque_no,
            'amount' => $request->amount,
            'date' => date('Y-m-d'),
            'receiver_name' => '',
            'receive_datwe' => date('Y-m-d'),
            'note' => 'স্থানানন্ত্র প্রদান'

        ]);

        Incoexpense::create([
            'upangsho_id' => $request->upangsho,
            'inout_id' => 1,
            'khattype_id' => 56,
            'khtattypetype_id' => 0,
            'khat_id' => 240,
            'khat_des' => 'স্থানানন্ত্র গ্রহন',
            'year' => $request->financial_year,
            'bank_id' => $request->target_bank,
            'branch_id' => $request->target_branch,
            'acc_no' => $request->target_bank_account,
            'vourcher_no' => $request->voucher_no,
            'vat_tax_status' => 0,
            'status' => 1,
            'chalan_no' => '',
            'check_no' => '',
            'amount' => $request['amount'],
            'date' => date('Y-m-d'),
            'receiver_name' => '',
            'receive_datwe' => date('Y-m-d'),
            'note' => 'স্থানানন্ত্র গ্রহন'
        ]);

        return redirect()->back()->with('message', 'আর্থিক স্থানন্তর সফল হয়েছে');
    }
}
