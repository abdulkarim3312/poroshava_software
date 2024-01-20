<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\CashbookIncoexpense;
use App\Models\Incoexpense;
use App\Models\Khat;
use App\Models\TaxType;
use App\Models\TaxTypeType;
use App\Models\Upangsho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashbookReportController extends Controller
{
    public function income()
    {
        $sections = Upangsho::whereIn('upangsho_id',[1,2])
                        ->where('upangsho_id', '!=', 0)->get();
        $types = TaxType::whereIn('upangsho_id',[1,2])
                        ->where('sister_concern_id',4)->get();
        $subTypes = TaxTypeType::where('sister_concern_id',4)
                        ->orWhere('tax_id', 0)
                        ->get();
        $khats = Khat::whereNotNull('account_khat_id')
                        ->get();


        $banks = Bank::where('sister_concern_id',1)->get();
        return view('cashbook.income.create',compact('sections','types',
        'banks','subTypes','khats'));
    }

    public function incomePost(Request $request)
    {
        $request['amount'] = bnNumberToEn($request->amount);
        $request['cheque_no'] = bnNumberToEn($request->cheque_no);
        $request['voucher_no'] = bnNumberToEn($request->voucher_no);

        $rules = [
            'upangsho' => 'required',
            'financial_year' => 'required',
            'bank' => 'required',
            'branch' => 'required',
            'bank_account' => 'required',
            'sector_type' => 'required',
            'sub_sector_type' => 'required',
            'sector' => 'required',
            'tax_type' => 'required',
            'income_expenditure' => 'required',
            'description' => 'nullable|max:255',
            'amount' => 'required|numeric|min:1',
            'voucher_no' => 'nullable|max:255',
            'cheque_no' => 'nullable|max:255',
            'date' => 'required|date',
            'receiver_name' => 'nullable|max:255',
            'note' => 'nullable|max:255',
        ];
        if ($request->sector == 464){
            $rules['sector_details'] = 'required';
        }

        $request->validate($rules);

        if ($request->income_expenditure == 1) {
            $vourcher_no = "";
            $chalan_no = $request->voucher_no;
            $status = 1;
        } else {
            $vourcher_no = $request->voucher_no;
            $chalan_no = "";
            $status = 0;
        }
        if (!empty($request->vat) || !empty($request->tax)) {
            $vat_tax_status = 1;
        } else {
            $vat_tax_status = 0;
        }
        $amount = $request->amount;
        $employ_id = null;

        $incoexpenseid = new CashbookIncoexpense();
        $incoexpenseid->user_id = Auth::id();
        $incoexpenseid->upangsho_id = $request->upangsho;
        $incoexpenseid->inout_id = $request->income_expenditure;
        $incoexpenseid->khattype_id = $request->sector_type;
        $incoexpenseid->khtattypetype_id = $request->sub_sector_type;
        $incoexpenseid->khat_id = $request->sector;
        $incoexpenseid->taxnontax = $request->tax_type;
        $incoexpenseid->khat_des = $request->description;
        $incoexpenseid->year = $request->financial_year;
        $incoexpenseid->bank_id = $request->bank;
        $incoexpenseid->branch_id = $request->branch;
        $incoexpenseid->acc_no = $request->bank_account;
        $incoexpenseid->vourcher_no = $vourcher_no;
        $incoexpenseid->status = $status;
        $incoexpenseid->vat_tax_status = $vat_tax_status;
        $incoexpenseid->chalan_no = $chalan_no;
        $incoexpenseid->check_no = $request->cheque_no;
        $incoexpenseid->amount = $request->amount;
        $incoexpenseid->date = Carbon::parse($request->date);
        $incoexpenseid->receiver_name = $request->receiver_name;
        $incoexpenseid->receive_datwe = Carbon::parse($request->date);
        $incoexpenseid->note = $request->note;
        $incoexpenseid->save();
        $cashbookIncomeId = $incoexpenseid->incoexpenses_id;
        if ($request->income_expenditure == 1) {

            BankDetails::where('bank_details_id', $request->bank_account)
                        ->increment('update_balance', $amount);
        }
            if ($request->sector == 464){
                $accountKhat = Khat::where('khat_id',$request->sector_details)->first();
            }else{
                $cashbookKhat = Khat::where('khat_id',$request->sector)->first();
                $accountKhat = Khat::where('khat_id',$cashbookKhat->account_khat_id)->first();
            }

            $incoexpenseid = new Incoexpense();
            $incoexpenseid->cashbook_incoexpenses_id = $cashbookIncomeId;
            $incoexpenseid->user_id = Auth::id();
            $incoexpenseid->upangsho_id = $request->upangsho;
            $incoexpenseid->inout_id = $request->income_expenditure;
            $incoexpenseid->khattype_id = $accountKhat->tax_type_id;
            $incoexpenseid->khtattypetype_id = $accountKhat->tax_type_type_id;
            $incoexpenseid->khat_id = $accountKhat->khat_id;
            $incoexpenseid->proklpo_id = $employ_id;
            $incoexpenseid->taxnontax = $request->tax_type;
            $incoexpenseid->khat_des = $request->description;
            $incoexpenseid->year = $request->financial_year;
            $incoexpenseid->bank_id = $request->bank;
            $incoexpenseid->branch_id = $request->branch;
            $incoexpenseid->acc_no = $request->bank_account;
            $incoexpenseid->vourcher_no = $vourcher_no;
            $incoexpenseid->status = $status;
            $incoexpenseid->vat_tax_status = $vat_tax_status;
            $incoexpenseid->chalan_no = $chalan_no;
            $incoexpenseid->check_no = $request->cheque_no;
            $incoexpenseid->amount = $request->amount;
            $incoexpenseid->date = Carbon::parse($request->date);
            $incoexpenseid->receiver_name = $request->receiver_name;
            $incoexpenseid->receive_datwe = Carbon::parse($request->date);
            $incoexpenseid->note = $request->note;
            $incoexpenseid->save();



        return redirect()->back()->with('message','আয় সংযুক্তি সফল হয়েছে');
    }

    public function treasurerCashbook(Request $request)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $selectUpangsho = null;
        $taxIncomes = [];
        $nonTaxIncomes = [];
        $nonTaxIncomes2 = [];
        $upangsho_two_in_one = [];
        $upangsho_two_in_two = [];

        $request['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $request['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');

        if ($request->upangsho == 1 && $request->tax_type == 1 && $request->start_date && $request->end_date) {

            $taxIncomes = CashbookIncoexpense::where('upangsho_id',$request->upangsho)
                //->where('khattype_id',1)
                ->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif ($request->upangsho == '' && $request->tax_type == 1 && $request->start_date && $request->end_date) {
            $taxIncomes = CashbookIncoexpense::where('upangsho_id',1)
                //->where('khattype_id',1)
                ->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif ($request->upangsho == 1 && $request->tax_type == '' && $request->start_date && $request->end_date) {
            $taxIncomes = CashbookIncoexpense::where('upangsho_id',1)
                //->where('khattype_id',1)
                ->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif ($request->upangsho == '' && $request->tax_type == '' && $request->start_date && $request->end_date) {
            $taxIncomes = CashbookIncoexpense::where('upangsho_id',1)
                //->where('khattype_id',1)
                ->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }

        if ($request->upangsho == 1 && $request->tax_type == 2 && $request->start_date && $request->end_date) {

            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',['227','190','191','192','193','195','303','312','199','200','210','202','203','204','205','206','321','208','329'])
                ->pluck('khat_id');

            $nonTaxIncomes = CashbookIncoexpense::where('upangsho_id',$request->upangsho)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                ->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();

        }elseif ($request->upangsho == '' && $request->tax_type == 2 && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',['227','190','191','192','193','195','303','312','199','200','210','202','203','204','205','206','321','208','329'])
                ->pluck('khat_id');

            $nonTaxIncomes = CashbookIncoexpense::where('upangsho_id',1)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                ->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif($request->upangsho == 1 && $request->tax_type == '' && $request->start_date && $request->end_date) {

            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',['227','190','191','192','193','195','303','312','199','200','210','202','203','204','205','206','321','208','329'])
                ->pluck('khat_id');
            $nonTaxIncomes = CashbookIncoexpense::where('upangsho_id',1)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                ->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif ($request->upangsho == '' && $request->tax_type == '' && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',['227','190','191','192','193','195','303','312','199','200','210','202','203','204','205','206','321','208','329'])
                ->pluck('khat_id');
            $nonTaxIncomes = CashbookIncoexpense::where('upangsho_id',1)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                ->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }
        if ($request->upangsho == 1 && $request->tax_type == 2 && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[209,'225',322,211,212,213,214,194,323,218,219,320,324,325,326,327,318,315,317,319])
                ->pluck('khat_id');
            $nonTaxIncomes2 = CashbookIncoexpense::where('upangsho_id',$request->upangsho)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                ->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif ($request->upangsho == '' && $request->tax_type == 2 && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[209,'225',322,211,212,213,214,194,323,218,219,320,324,325,326,327,318,315,317,319])
                ->pluck('khat_id');
            $nonTaxIncomes2 = CashbookIncoexpense::where('upangsho_id',1)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                ->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif ($request->upangsho == '' && $request->tax_type == '' && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[209,'225',322,211,212,213,214,194,323,218,219,320,324,325,326,327,318,315,317,319])
                ->pluck('khat_id');
            $nonTaxIncomes2 = CashbookIncoexpense::where('upangsho_id',1)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                ->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }
        if ($request->upangsho == 2 && $request->tax_type == 1 &&  $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[148,149,150,151,152])
                ->pluck('khat_id');
            $upangsho_two_in_one = CashbookIncoexpense::where('upangsho_id',$request->upangsho)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',$request->tax_type)
                //->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif($request->upangsho == 2 && $request->tax_type == '' &&  $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[148,149,150,151,152])
                ->pluck('khat_id');
            $upangsho_two_in_one = CashbookIncoexpense::where('upangsho_id',$request->upangsho)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',$request->tax_type)
                //->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();

        }elseif($request->upangsho == '' && $request->tax_type == 1 &&  $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[148,149,150,151,152])
                ->pluck('khat_id');
            $upangsho_two_in_one = CashbookIncoexpense::where('upangsho_id',2)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                //->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif($request->upangsho == '' && $request->tax_type == '' &&  $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[148,149,150,151,152])
                ->pluck('khat_id');
            $upangsho_two_in_one = CashbookIncoexpense::where('upangsho_id',2)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',1)
                //->where('taxnontax',1)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }

        if ($request->upangsho == 2 && $request->tax_type == 2 && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[222,232,233,234,311])
                ->pluck('khat_id');
            $upangsho_two_in_two = CashbookIncoexpense::where('upangsho_id',$request->upangsho)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',$request->tax_type)
                //->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif($request->upangsho == 2 && $request->tax_type == '' && $request->start_date && $request->end_date) {

            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[222,232,233,234,311])
                ->pluck('khat_id');
            $upangsho_two_in_two = CashbookIncoexpense::where('upangsho_id',$request->upangsho)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',$request->tax_type)
                //->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();

        }elseif ($request->upangsho == '' && $request->tax_type == 2 && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[222,232,233,234,311])
                ->pluck('khat_id');
            $upangsho_two_in_two = CashbookIncoexpense::where('upangsho_id',2)
                ->whereIn('khat_id',$newKhat)
                //->where('khattype_id',$request->tax_type)
                //->where('taxnontax',2)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }elseif($request->upangsho == '' && $request->tax_type == '' && $request->start_date && $request->end_date) {
            $newKhat = DB::table('khats')
                ->whereIn('old_khat_id',[222,232,233,234,311])
                ->pluck('khat_id');
            $upangsho_two_in_two = CashbookIncoexpense::where('upangsho_id',2)
                ->whereIn('khat_id',$newKhat)
                ->where('date','>=',$request->start_date)
                ->where('date','<=',$request->end_date)
                ->orderBy('date')
                ->get();
        }



        return view('cashbook.report.treasurer_cashbook',compact('sections',
        'taxIncomes','nonTaxIncomes','selectUpangsho','taxIncomes','nonTaxIncomes2',
        'upangsho_two_in_one','upangsho_two_in_two'));
    }
    public function abstractRegister(Request $request)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $banglaMonths = [
            1 => "জানুয়ারী",
            2 => "ফেব্রুয়ারী",
            3 => "মার্চ",
            4 => "এপ্রিল",
            5 => "মে",
            6 => "জুন",
            7 => "জুলাই",
            8 => "আগস্ট",
            9 => "সেপ্টেম্বর",
            10 => "অক্টোবর",
            11 => "নভেম্বর",
            12 => "ডিসেম্বর"
        ];
        $selectUpangsho = null;
        $month = null;
        $yearMonth = null;
        $mainheads1 = [];
        $mainheads2 = [];
        $expdates1 = [];
        $expdates2 = [];
        if ($request->upangsho != ''){
            $getMonth = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
            $yearMonth =  $getMonth.'/'.$request->year;
            $month =  $request->year.'-'.$getMonth.'-';


            $selectUpangsho = Upangsho::where('upangsho_id', $request->upangsho)
                ->first();

            $ids1 = TaxType::select('tax_id')
                ->where('sister_concern_id', 4)
                ->where('upangsho_id', $request->upangsho)
                ->where('khat_id', 1)
                ->limit(3)
                ->pluck('tax_id')
                ->toArray();

            $ids2 = TaxType::select('tax_id')
                ->where('sister_concern_id', 4)
                ->where('upangsho_id', $request->upangsho)
                ->where('khat_id', 1)
                ->skip(3)
                ->take(PHP_INT_MAX)
                ->pluck('tax_id')
                ->toArray();


            $mainheads1 = TaxType::where('sister_concern_id', 4)
                            ->whereIn('tax_id',$ids1)
                            ->get();

            $expdates1 = CashbookIncoexpense::whereIn('khattype_id',$ids1)
                ->where('status', 1)
                ->where('date', 'like', $month.'%')
                ->select('date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();


            $mainheads2 = TaxType::where('sister_concern_id', 4)
                ->whereIn('tax_id',$ids2)
                ->get();
            $expdates2 = CashbookIncoexpense::whereIn('khattype_id', $ids2)
                ->where('status', 1)
                ->where('date', 'like', $month.'%')
                ->select('date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        return view('cashbook.report.abstract_register',compact('sections','selectUpangsho',
            'expdates1','expdates2','banglaMonths','yearMonth','mainheads1','mainheads2','month'));
    }
}
