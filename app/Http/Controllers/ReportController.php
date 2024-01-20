<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\Budget;
use App\Models\Contractor;
use App\Models\Cotractoraccount;
use App\Models\Incoexpense;
use App\Models\Khat;
use App\Models\Projectpayment;
use App\Models\TaxType;
use App\Models\Upangsho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rakibhstu\Banglanumber\NumberToBangla;
use SakibRahaman\DecimalToWords\DecimalToWords;

class ReportController extends Controller
{

    public function projectPaymentRegister(Request $request)
    {
        $contractors = Contractor::all();
        $projectPayments = [];
        $selectContractor = null;
        if ($request->contractor != '' && $request->project != '') {
            $selectContractor = Contractor::where('eid', $request->contractor)->first();
            $projectPayments = Projectpayment::join('cotractoraccounts', 'projectpayments.proklpo_id', '=', 'cotractoraccounts.conacc_id')
                ->join('bank_details', 'projectpayments.bankact', '=', 'bank_details.bank_details_id')
                ->where('projectpayments.proklpo_id', $request->project)
                ->where('cotractoraccounts.contractor_id', $request->contractor)
                ->get();
        }
        return view('accounts.project.report.register', compact('selectContractor',
            'contractors', 'projectPayments'));
    }

    public function projectPaymentCertificate(Request $request)
    {
        $contractors = Contractor::all();
        $projects = [];
        $selectContractor = null;
        if ($request->contractor != '' && $request->financial_year != '') {
            $selectContractor = Contractor::where('eid', $request->contractor)->first();
            //dd($request->financial_year);
            $projects = Cotractoraccount::where('contractor_id', $request->contractor)
                //->where('contractyear',$request->financial_year)
                ->get();

        }
        return view('accounts.project.report.certificate', compact('selectContractor',
            'contractors', 'projects'));
    }


    public function chequeRegisterAllowAll(Request $request)
    {
        if (count($request->incoexpenses_id) > 0) {
            foreach ($request->incoexpenses_id as $x) {
                $expence = Incoexpense::where('incoexpenses_id', $x)->first();
                if ($expence->amount == '')
                    $amount = $expence->amount = 0;

                $amount = str_replace(" ", "", $expence->amount);

                BankDetails::where('bank_details_id', $expence->acc_no)->decrement('update_balance', $expence->amount);

                Incoexpense::where('incoexpenses_id', $x)
                    ->update(['status' => 1]);

            }
            return redirect()->back()->with('message', 'সকল অনুমোদন সফল হয়েছে');
        }
        return redirect()->back()->with('error', 'ডাটা ফিল্টারিং ভুল হয়েছে');
    }

    public function chequeRegisterAllow(Request $request)
    {

        if ($request->incomeExpenseId) {
            $expence = Incoexpense::where('incoexpenses_id', $request->incomeExpenseId)->first();
            $vat = Incoexpense::where('vat_tax_status', $request->incomeExpenseId)
                ->where('receiver_name', '১/১১৩৩/০০৫/০৩১১')->first();
            if ($vat) $vat = $vat->amount;
            $tax = Incoexpense::where('vat_tax_status', $request->incomeExpenseId)
                ->where('receiver_name', '১/১১৪১/০০১০/০১১১')
                ->first();
            if ($tax) $tax = $tax->amount;
            $expences = $expence->amount + $vat + $tax;

            BankDetails::where('bank_details_id', $expence->acc_no)
                ->decrement('update_balance', $expences);

            Incoexpense::where('incoexpenses_id', $request->incomeExpenseId)
                ->update(['status' => 1]);
            Incoexpense::where('vat_tax_status', $request->incomeExpenseId)
                ->update(['status' => 1]);

            return response()->json(['success' => true, 'message' => 'অনুমোদন সফল হয়েছে']);
        }
        return response()->json(['success' => false, 'message' => 'ডাটা ফিল্টারিং ভুল হয়েছে']);


    }

    public function chequeRegisterDelete(Request $request)
    {

        if ($request->incomeExpenseId) {
            Incoexpense::find($request->incomeExpenseId)->delete();
            Incoexpense::where('vat_tax_status', $request->incomeExpenseId)->delete();

            return response()->json(['success' => true, 'message' => 'মুছে ফেলা হয়েছে']);
        }
        return response()->json(['success' => false, 'message' => 'ডাটা ফিল্টারিং ভুল হয়েছে']);

    }

    public function chequeRegisterPrint(Incoexpense $incomeExpense)
    {


        $vat = Incoexpense::where('vat_tax_status', $incomeExpense->incoexpenses_id)->where('receiver_name', '১/১১৩৩/০০৫/০৩১১')->first();
        $tax = Incoexpense::where('vat_tax_status', $incomeExpense->incoexpenses_id)->where('receiver_name', '১/১১৪১/০০১০/০১১১')->first();

        $jamanot = Incoexpense::where('vat_tax_status', $incomeExpense->incoexpenses_id)->where('receiver_name', '১৪০০০৪১১০৭')->first();

        return view('accounts.report.cheque_register_print', compact('vat', 'tax', 'jamanot', 'incomeExpense'));
    }

    public function chequePrint(Incoexpense $incomeExpense)
    {

        $numberToWord = new NumberToBangla();
        if ($incomeExpense->cheque_amount > 0){
            $chequeAmount = $incomeExpense->cheque_amount;
        }else{
            $chequeAmount = $incomeExpense->amount;
        }
        $incomeExpense->amount_in_word = $numberToWord->bnWord($chequeAmount);
        return view('accounts.report.cheque_print_old', compact('chequeAmount','numberToWord', 'incomeExpense'));
    }

    public function challanPrint(Incoexpense $incomeExpense)
    {
        $vat = Incoexpense::where('vat_tax_status', $incomeExpense->incoexpenses_id)->where('receiver_name', '১/১১৩৩/০০৫/০৩১১')->first();
        $tax = Incoexpense::where('vat_tax_status', $incomeExpense->incoexpenses_id)->where('receiver_name', '১/১১৪১/০০১০/০১১১')->first();
        if ($vat) {
            $vat->amount_in_word = DecimalToWords::convert($vat->amount, 'Taka',
                'Poisa');
        }
        if ($tax) {
            $tax->amount_in_word = DecimalToWords::convert($tax->amount, 'Taka',
                'Poisa');
        }
        $inWordBangla = new NumberToBangla();

        return view('accounts.report.challan_print', compact('incomeExpense', 'tax', 'vat', 'inWordBangla'));
    }

    public function chequeRegisterDetails(Request $request)
    {


        $incomeExpense = Incoexpense::where('incoexpenses_id', $request->incomeExpenseId)->first();
        $vat = Incoexpense::where('vat_tax_status', $request->incomeExpenseId)->where('receiver_name', '১/১১৩৩/০০৫/০৩১১')->first();
        $tax = Incoexpense::where('vat_tax_status', $request->incomeExpenseId)->where('receiver_name', '১/১১৪১/০০১০/০১১১')->first();

        return response()->json([
            'incomeExpense' => $incomeExpense,
            'vat' => $vat,
            'tax' => $tax,
        ]);
    }

    public function chequeRegisterupdate(Request $request)
    {
        $request['cheque_amount'] = bnNumberToEn($request->cheque_amount);
        $request['amount'] = bnNumberToEn($request->amount);
        $request['cheque_no'] = bnNumberToEn($request->cheque_no);
        $request['voucher_no'] = bnNumberToEn($request->voucher_no);
        $request['vat'] = bnNumberToEn($request->vat ?? null);
        $request['vat_voucher_no'] = bnNumberToEn($request->vat_voucher_no ?? null);
        $request['vat_cheque_no'] = bnNumberToEn($request->vat_cheque_no ?? null);
        $request['tax'] = bnNumberToEn($request->tax ?? null);
        $request['tax_voucher_no'] = bnNumberToEn($request->tax_voucher_no ?? null);
        $request['tax_cheque_no'] = bnNumberToEn($request->tax_cheque_no ?? null);

        $validatedData = $request->validate([
            'description' => 'required|max:255',
            'voucher_no' => 'required|max:255',
            'cheque_no' => 'required|max:255',
            'amount' => 'required|numeric|min:1',
            'cheque_amount' => 'nullable|numeric',
            'receiver_name' => 'nullable|max:255',
            'date' => 'required|date',
            'note' => 'nullable|max:255',
            'vat' => 'nullable|numeric',
            'vat_voucher_no' => 'nullable|max:255',
            'vat_cheque_no' => 'nullable|max:255',
            'tax' => 'nullable|numeric',
            'tax_voucher_no' => 'nullable|max:255',
            'tax_cheque_no' => 'nullable|max:255',
        ]);

        $incoexpense = Incoexpense::find($request->income_expense_id);
        $incoexpense->vourcher_no = $request->voucher_no;
        $incoexpense->check_no = $request->cheque_no;
        $incoexpense->khat_des = $request->description;
        $incoexpense->amount = $request->amount;
        $incoexpense->cheque_amount = $request->cheque_amount ?? 0;
        $incoexpense->date = Carbon::parse($request->date);
        $incoexpense->receiver_name = $request->receiver_name;
        $incoexpense->receive_datwe = Carbon::parse($request->date);
        $incoexpense->note = $request->note;
        $incoexpense->save();

        $vat = Incoexpense::where('vat_tax_status', $request->income_expense_id)
            ->where('receiver_name', '১/১১৩৩/০০৫/০৩১১');

        if ($vat->count() > 0) {

            if (!empty($request->vat)) { // row and vat exist

                $vat = $vat->first();
                $vat->vourcher_no = $request->vat_voucher_no;
                $vat->check_no = $request->vat_cheque_no;
                $vat->khat_des = '-ঐ-কাজের মূঃসঃক';
                $vat->amount = $request->vat;
                $vat->date = Carbon::parse($request->date);
                $vat->receiver_name = '১/১১৩৩/০০৫/০৩১১';
                $vat->receive_datwe = Carbon::parse($request->date);
                $vat->note = $request->note;
                $vat->save();

            } else { // row but vat not exist

                Incoexpense::where('vat_tax_status', $request->income_expense_id)->where('receiver_name', '১/১১৩৩/০০৫/০৩১১')->delete();
            }
        } else { // not row but vat given

            $incoexpense = Incoexpense::find($request->income_expense_id);
            $newincoexpense = $incoexpense->replicate();
            $newincoexpense->save();
            $newvatid = $newincoexpense->incoexpenses_id;

            //echo $newvatid; exit;

            $newvat = Incoexpense::find($newvatid);

            $newvat->vourcher_no = $request->vat_voucher_no;
            $newvat->check_no = $request->vat_cheque_no;
            $newvat->khat_des = '-ঐ-কাজের মূঃসঃক';
            $newvat->amount = $request->vat;
            $newvat->date = Carbon::parse($request->date);
            $newvat->vat_tax_status = $request->income_expense_id;
            $newvat->receiver_name = '১/১১৩৩/০০৫/০৩১১';
            $newvat->receive_datwe = Carbon::parse($request->date);
            $newvat->note = $request->note;
            $newvat->save();

        }

        $tax = Incoexpense::where('vat_tax_status', $request->income_expense_id)->where('receiver_name', '১/১১৪১/০০১০/০১১১');

        if ($tax->count() > 0) {

            if (!empty($request->tax)) { // row and tax exist
                $tax = $tax->first();
                $tax->vourcher_no = $request->taxvourcher_no;
                $tax->check_no = $request->tax_check_no;
                $tax->chalan_no = $request->chalan_no;
                $tax->amount = $request->tax;
                $tax->date = Carbon::parse($request->date);
                $tax->receive_datwe = Carbon::parse($request->date);
                $tax->note = $request->note;
                $tax->save();

            } else { // row but vat not exist

                Incoexpense::where('vat_tax_status', $request->income_expense_id)->where('receiver_name', '১/১১৪১/০০১০/০১১১')->delete();
            }
        } else { // not row but vat given

            $incoexpense = Incoexpense::find($request->income_expense_id);
            $newincoexpense = $incoexpense->replicate();
            $newincoexpense->save();
            $newtaxid = $newincoexpense->incoexpenses_id;

            $newtax = Incoexpense::find($newtaxid);

            $newtax->vourcher_no = $request->tax_voucher_no;
            $newtax->check_no = $request->tax_cheque_no;
            $newtax->khat_des = 'ঐ-কাজের আয়কর';
            $newtax->amount = $request->tax;
            $newtax->date = Carbon::parse($request->date);
            $newtax->vat_tax_status = $request->income_expense_id;
            $newtax->receive_datwe = Carbon::parse($request->date);
            $newtax->receiver_name = '১/১১৪১/০০১০/০১১১';
            $newtax->note = $request->note;
            $newtax->save();

        }


        return response()->json(['success' => 'আয়/ব্যয় সংযুক্তি হালনাগাদ হয়েছে']);

    }

    public function chequeRegister(Request $request)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $expenses = [];
        if ($request->start_date != '' && $request->end_date != '') {
            $expenses = Incoexpense::with('upangsho', 'taxType', 'taxSubType', 'sector', 'bank', 'branch', 'bankAccount')
                ->where('inout_id', 2)
                 ->where('status', 0)
                ->where('upangsho_id', $request->upangsho)
                ->where('year', $request->financial_year)
                ->whereBetween('receive_datwe', [Carbon::parse($request->start_date)->format('Y-m-d'), Carbon::parse($request->end_date)->format('Y-m-d')])
                ->get();
        }

        return view('accounts.report.cheque_register', compact('sections', 'expenses'));
    }


    public function incomeUncash(Request $request)
    {
        $incomes = Incoexpense::join('upangshos','upangshos.upangsho_id','=','incoexpenses.upangsho_id')
            ->join('khattypes','khattypes.khat_id','=','incoexpenses.inout_id')
            ->join('khats','khats.khat_id','=','incoexpenses.khat_id')
            ->join('tax_types','tax_types.tax_id','=','incoexpenses.khattype_id')
            ->join('banks','banks.bank_id','=','incoexpenses.bank_id')
            ->join('branches','branches.branch_id','=','incoexpenses.branch_id')
            ->join('bank_details','bank_details.bank_details_id','=','incoexpenses.acc_no')
            ->where('inout_id', 1)
            ->where('uncashstatus', 1)
            ->get();

        return view('accounts.report.income_uncash', compact('incomes'));
    }
    public function expenseUncash(Request $request)
    {

        $expenses = Incoexpense::join('upangshos','upangshos.upangsho_id','=','incoexpenses.upangsho_id')
            ->join('khattypes','khattypes.khat_id','=','incoexpenses.inout_id')
            ->join('khats','khats.khat_id','=','incoexpenses.khat_id')
            ->join('tax_types','tax_types.tax_id','=','incoexpenses.khattype_id')
            ->join('banks','banks.bank_id','=','incoexpenses.bank_id')
            ->join('branches','branches.branch_id','=','incoexpenses.branch_id')
            ->join('bank_details','bank_details.bank_details_id','=','incoexpenses.acc_no')
            ->where('inout_id', 2)
            ->where('uncashstatus', 1)
            ->get();

        return view('accounts.report.expense_uncash', compact('expenses'));
    }
    public function cashbook(Request $request)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $incomes = [];
        $expenses = [];
        $selectUpangsho = null;
        $balance = 0;
        if ($request->upangsho != '') {
            $selectUpangsho = Upangsho::find($request->upangsho);
            $incomeBalance = Incoexpense::where('upangsho_id', $request->upangsho)->where('inout_id', 1)
                ->where('receive_datwe', '<', Carbon::parse($request->start_date)->format('Y-m-d'))->sum('amount');
            $incomeBalance += BankDetails::where('upangsho_id', $request->upangsho)
                ->sum('open_balance');
            $paymentBalance = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)->where('status', 1)
                ->where('receive_datwe', '<', Carbon::parse($request->start_date)->format('Y-m-d'))->sum('amount');
            $balance = $incomeBalance - $paymentBalance;


            $incomes = Incoexpense::with('upangsho', 'bank', 'branch', 'bankAccount')
                ->where('upangsho_id', $request->upangsho)
                ->where('inout_id', 1)
                ->whereBetween('receive_datwe', [Carbon::parse($request->start_date)->format('Y-m-d'), Carbon::parse($request->end_date)->format('Y-m-d')])
                 ->orderBy('receive_datwe','ASC')
                ->get();

            $expenses = Incoexpense::with('upangsho', 'bank', 'branch', 'bankAccount')
                ->where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->whereBetween('receive_datwe', [Carbon::parse($request->start_date)->format('Y-m-d'), Carbon::parse($request->end_date)->format('Y-m-d')])
                 ->orderBy('receive_datwe','ASC')
                ->get();
        }

        return view('accounts.report.cashbook', compact('sections', 'selectUpangsho',
            'expenses', 'incomes', 'balance'));
    }


    public function cashbookExpenseUnCashConfirm(Request $request)
    {

        $cash = Incoexpense::where('incoexpenses_id', $request->incomeExpenseId)
            ->update(['uncashstatus' => 0]);
        if ($cash) {
            return response()->json(['success' => true, 'message' => 'অনুমোদন সফল হয়েছে']);
        }
        return response()->json(['success' => false, 'message' => 'ডাটা ফিল্টারিং ভুল হয়েছে']);
    }
    public function cashbookExpenseCashConfirm(Request $request)
    {
        $cash = Incoexpense::where('incoexpenses_id', $request->incomeExpenseId)
            ->update(['uncashstatus' => 1]);
        if ($cash) {
            return response()->json(['success' => true, 'message' => 'অনুমোদন সফল হয়েছে']);
        }
        return response()->json(['success' => false, 'message' => 'ডাটা ফিল্টারিং ভুল হয়েছে']);
    }

    public function cashbookExpense(Request $request)
    {
        $banks = Bank::where('sister_concern_id',1)->get();
        $selectBankAccount = null;
        $expenses = [];
        if ($request->bank_account != '') {
            $selectBankAccount = BankDetails::where('bank_details_id', $request->bank_account)->first();
            $expenses = Incoexpense::where('acc_no', $request->bank_account)
                ->where('inout_id', 2)
                ->whereBetween('receive_datwe', [Carbon::parse($request->start_date)->format('Y-m-d'), Carbon::parse($request->end_date)->format('Y-m-d')])
                ->where('status', 1)
                ->with('sector')
                ->get();
        }

        return view('accounts.report.cashbook_expense', compact('banks',
            'expenses', 'selectBankAccount'));
    }

    public function cashbookIncome(Request $request)
    {
        $banks = Bank::where('sister_concern_id',1)->get();
        $selectBankAccount = null;
        $incomes = [];
        if ($request->bank_account != '') {
            $selectBankAccount = BankDetails::where('bank_details_id', $request->bank_account)->first();
            $incomes = Incoexpense::where('acc_no', $request->bank_account)
                ->where('inout_id', 1)
                ->whereBetween('receive_datwe', [Carbon::parse($request->start_date)->format('Y-m-d'), Carbon::parse($request->end_date)->format('Y-m-d')])
                ->where('status', 1)
                ->with('sector')
                ->orderBy('receive_datwe')
                ->get();
        }

        return view('accounts.report.cashbook_income', compact('banks',
            'incomes', 'selectBankAccount'));
    }

    public function bankAccountClosing(Request $request)
    {
        $banks = Bank::where('sister_concern_id',1)->get();
        $selectBankAccount = null;
        $sd = null;
        $ed = null;
        $balance = 0;
        $getIncomes = [];
        $getExpenses = [];
        $incomeBlankRows = '';
        $expenseBlankRows = '';
        if ($request->bank_account != '') {
            $sd = Carbon::parse($request->start_date)->format('Y-m-d');
            $ed = Carbon::parse($request->end_date)->format('Y-m-d');
            $selectBankAccount = BankDetails::where('bank_details_id', $request->bank_account)
                ->first();
            $aay = Incoexpense::where('acc_no', $request->bank_account)
                ->where('inout_id', 1)
                ->where('receive_datwe', '<', $sd)->sum('amount');
            $aay += BankDetails::where('bank_details_id', $request->bank_account)
                ->sum('open_balance');
            $bay = Incoexpense::where('acc_no', $request->bank_account)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->where('receive_datwe', '<', $sd)
                ->sum('amount');
            $balance = $aay - $bay;

            $getIncomes = Incoexpense::where('acc_no', $request->bank_account)
                ->where('inout_id', 1)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('acc_no','khat_id')
                ->groupBy('acc_no','khat_id')
                ->get();


            $getExpenses = Incoexpense::where('acc_no', $request->bank_account)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('acc_no','khat_id')
                ->groupBy('acc_no','khat_id')
                ->get();

            $inCnt = $getIncomes->count();
            $exCnt = $getExpenses->count();
            $diff = ($inCnt - $exCnt) - 3;

            for($i=0; $i < abs($diff); $i++){
                if($inCnt < $exCnt){
                    $incomeBlankRows .= '<tr><td>-</td><td></td><td></td></tr>';
                }else{
                    $expenseBlankRows .= '<tr> <td>--- </td> <td> </td> <td> </td></tr>';
                }
            }
        }

        return view('accounts.report.bank_account_closing', compact('banks',
            'sd','ed', 'selectBankAccount','balance','incomeBlankRows','expenseBlankRows',
        'getExpenses','getIncomes'));
    }

    public function incomeExpenditure(Request $request)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $selectBankAccount = null;
        $sd = null;
        $ed = null;
        $balance = 0;
        $getIncomes = [];
        $selectUpangsho = null;
        $getExpenses = [];
        $incomeBlankRows = '';
        $expenseBlankRows = '';
        if ($request->upangsho != '') {
            $selectUpangsho = Upangsho::find($request->upangsho);
            $sd = Carbon::parse($request->start_date)->format('Y-m-d');
            $ed = Carbon::parse($request->end_date)->format('Y-m-d');
            $selectBankAccount = BankDetails::where('upangsho_id', $request->upangsho)
                ->first();
            $aay = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 1)
                ->where('receive_datwe', '<', $sd)->sum('amount');
            $aay += BankDetails::where('upangsho_id', $request->upangsho)
                ->sum('open_balance');
            $bay = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->where('receive_datwe', '<', $sd)
                ->sum('amount');
            $balance = $aay - $bay;

            $getIncomes = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 1)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('acc_no','khat_id')
                ->groupBy('acc_no','khat_id')
                ->get();


            $getExpenses = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('acc_no','khat_id')
                ->groupBy('acc_no','khat_id')
                ->get();

            $inCnt = $getIncomes->count();
            $exCnt = $getExpenses->count();
            $diff = ($inCnt - $exCnt) - 3;

            for($i=0; $i < abs($diff); $i++){
                if($inCnt < $exCnt){
                    $incomeBlankRows .= '<tr><td>-</td><td></td><td></td></tr>';
                }else{
                    $expenseBlankRows .= '<tr> <td>--- </td> <td> </td> <td> </td></tr>';
                }
            }
        }

        return view('accounts.report.income_expenditure_amount', compact('sections',
            'sd','ed', 'selectBankAccount','balance','incomeBlankRows','expenseBlankRows',
        'getExpenses','getIncomes', 'selectUpangsho'));
    }





     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $upangsho_id ='';
        $taxTypes = '';
        $upangshos = upangsho::all();
        $khats = Khat::where('upangsho_id',3)->where('khattype', 2)->get();
        $years = Budget::select('year')->groupBy('year')->get();
        $menuname = 'রিপোর্টস';

        return view('accounts.report.income_expenditure_amount', compact('upangsho_id', 'menuname','upangshos','khats','taxTypes', 'years'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $upangshoname ='';
        $upangsho_id = $request->upangsho_id; $sd = $request->sd; $ed = $request->ed;
        $badgetRegister = Upangsho::getBalancesheet($upangsho_id, $sd, $ed);
        dd($badgetRegister);
        $upangshos = upangsho::all();
        if($upangsho_id!=''){
        $upangshoname = upangsho::where('upangsho_id', $upangsho_id)->first()->upangsho_name; }
        $khats = Khat::all();
        $years = Budget::select('year')->groupBy('year')->get();
        $menuname = 'রিপোর্টস';
        // $upangshoid = $request->upangsho_id;
        //  $khattypeid = $request->khattype_id;
        $year = $request->year;
        $budget = Upangsho::getBadget();
         $taxTypes = '';

         return view('accounts.report.income_expenditure_amount', compact('banks',
            'sd','ed', 'selectBankAccount','balance','incomeBlankRows','expenseBlankRows',
        'getExpenses','getIncomes'));
    }


    public function create(Request $request)
    {
       $data ='<option value="">খাত নির্ধারণ</option>';
       $taxtptp = Khat::where('upangsho_id', $request->upan)->where('khattype', $request->inout)->where('tax_type_id', $request->khattype)->where('tax_type_type_id', $request->khattype2)->get();

        foreach($taxtptp as $tp){

            $data .= '<option value="'.$tp->khat_id.'">'.$tp->serilas.$tp->khat_name.'</option>';
        }
        echo $data;
    }

    public function yearlyIncomeExpenditure(Request $request)
    {

        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $selectBankAccount = null;
        $financial_year = '';
        $sd = null;
        $ed = null;
        $balance = 0;
        $getIncomes = [];
        $selectUpangsho = null;
        $getExpenses = [];
        $incomeBlankRows = '';
        $expenseBlankRows = '';
        $financial_year = '';
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();

        if ($request->upangsho != '') {



            $dates = explode("/", $request->financial_year);
            $financial_year = $dates[2];
            $upangsho_id = $request->upangsho;
            $sd = $dates[0];
            $ed = $dates[1];
            $selectUpangsho = Upangsho::find($request->upangsho);
            // $sd = Carbon::parse($request->start_date)->format('Y-m-d');
            // $ed = Carbon::parse($request->end_date)->format('Y-m-d');
            $selectBankAccount = BankDetails::where('upangsho_id', $request->upangsho)
                ->first();
            $aay = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 1)
                ->where('receive_datwe', '<', $sd)->sum('amount');
            $aay += BankDetails::where('upangsho_id', $request->upangsho)
                ->sum('open_balance');
            $bay = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->where('receive_datwe', '<', $sd)
                ->sum('amount');
            $balance = $aay - $bay;

            $getIncomes = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 1)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('khat_id')
                ->groupBy('khat_id')
                ->get();
                foreach ($getIncomes as $income) {
                    $budget = Budget::where('khat_id', $income->khat_id)
                        ->where('year', '2023-24')
                        ->first();

                    $income->budget = $budget ? $budget->budget_amo : 0;
                }

            $getExpenses = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->where('khat_id','!=',0)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('khat_id')
                ->groupBy('khat_id')
                ->get();
                // dd($getExpenses);
                foreach ($getExpenses as $expense) {
                    // dd($expense);
                    $budget = Budget::where('khat_id', $expense->khat_id)
                        ->where('year', '2023-24')
                        ->first();
                    $expense->budget = $budget ? $budget->budget_amo : 0;
                }
        }
        else
        {
            $getIncomes = Incoexpense::where('upangsho_id', $request->upangsho)
                        ->where('inout_id', 1)
                        ->whereBetween('receive_datwe', [$sd, $ed])
                        ->select('acc_no','khat_id')
                        ->groupBy('acc_no','khat_id')
                        ->get();

            $getExpenses = Incoexpense::where('upangsho_id', $request->upangsho)
                        ->where('inout_id', 2)
                        ->where('status', 1)
                        ->whereBetween('receive_datwe', [$sd, $ed])
                        ->select('acc_no','khat_id')
                        ->groupBy('acc_no','khat_id')
                        ->get();
        }

        $inCnt = $getIncomes->count();
        $exCnt = $getExpenses->count();
        $diff = ($inCnt - $exCnt);

        for($i=0; $i < abs($diff); $i++){
            if($inCnt < $exCnt){
                $incomeBlankRows .= '<tr><td>-</td><td></td><td></td><td></td><td></td></tr>';
            }else{
                $expenseBlankRows .= '<tr><td>-</td><td></td><td></td><td></td><td></td></tr>';
            }
        }
        return view('accounts.report.yearly_income_expenditure', compact('sections',
            'sd','ed', 'selectBankAccount','balance','incomeBlankRows','expenseBlankRows',
        'getExpenses','getIncomes', 'selectUpangsho', 'financial_year', 'bn', 'en'));
    }

   public function dailyIncomeExpenditure(Request $request)
   {
    $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $selectBankAccount = null;
        $sd = null;
        $ed = null;
        $balance = 0;
        $getIncomes = [];
        $selectUpangsho = null;
        $getExpenses = [];
        $incomeBlankRows = '';
        $expenseBlankRows = '';
        if ($request->upangsho != '') {
            $selectUpangsho = Upangsho::find($request->upangsho);
            $sd = Carbon::parse($request->start_date)->format('Y-m-d');
            $ed = Carbon::parse($request->start_date)->format('Y-m-d');
            $selectBankAccount = BankDetails::where('upangsho_id', $request->upangsho)
                ->first();
            $aay = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 1)
                ->where('receive_datwe', '<', $sd)->sum('amount');
            $aay += BankDetails::where('upangsho_id', $request->upangsho)
                ->sum('open_balance');
            $bay = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->where('receive_datwe', '<', $sd)
                ->sum('amount');
            $balance = $aay - $bay;

            $getIncomes = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 1)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('acc_no','khat_id')
                ->groupBy('acc_no','khat_id')
                ->get();


            $getExpenses = Incoexpense::where('upangsho_id', $request->upangsho)
                ->where('inout_id', 2)
                ->where('status', 1)
                ->whereBetween('receive_datwe', [$sd, $ed])
                ->select('acc_no','khat_id')
                ->groupBy('acc_no','khat_id')
                ->get();

            $inCnt = $getIncomes->count();
            $exCnt = $getExpenses->count();
            $diff = ($inCnt - $exCnt);

            for($i=0; $i < abs($diff); $i++){
                if($inCnt < $exCnt){
                    $incomeBlankRows .= '<tr><td>-</td><td></td><td></td></tr>';
                }else{
                    $expenseBlankRows .= '<tr> <td>--- </td> <td> </td> <td> </td></tr>';
                }
            }
        }
        return view('accounts.report.daily_income_expenditure', compact('sections',
        'sd','ed', 'selectBankAccount','balance','incomeBlankRows','expenseBlankRows',
    'getExpenses','getIncomes', 'selectUpangsho'));
   }

   public function incomeBudget(Request $request){
//        dd($request->all());
        $selectBankAccount = null;
        $financial_year = Budget::select('year')->groupBy('year')->get();
        $selected_financial_year="";
        $khattypes = [];
        $badget = 0;
        $selectUpangsho = null;
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();

        if ($request->upangsho != '') {
            $selected_financial_year = $request->financial_year;
            $upangsho_id = $request->upangsho;
            $khattypes = TaxType::where('sister_concern_id',1)->where('upangsho_id', $upangsho_id)->where('khat_id', 1)->get();
            $badget = Budget::getinbudget($upangsho_id, $selected_financial_year, 1);
            $selectUpangsho = Upangsho::find($request->upangsho);
        }
       return view('accounts.report.income_budget', compact('khattypes','badget','sections','selectUpangsho', 'financial_year','selected_financial_year'));
   }



   public function expenditureBudget(Request $request){
       //dd($request->all());
       $selectBankAccount = null;
       $financial_year = Budget::select('year')->groupBy('year')->get();
       $selected_financial_year="";
       $khattypes = [];
       $badget = 0;
       $selectUpangsho = null;
       $sections = Upangsho::where('upangsho_id', '!=', 0)->get();

       if ($request->upangsho != '') {
           $selected_financial_year = $request->financial_year;
           $upangsho_id = $request->upangsho;
           $khattypes = TaxType::where('sister_concern_id',1)->where('upangsho_id', $upangsho_id)->where('khat_id', 1)->get();
           $badget = Budget::getinbudget($upangsho_id, $selected_financial_year, 2);
           $selectUpangsho = Upangsho::find($request->upangsho);
       }
       return view('accounts.report.expense_budget', compact('khattypes','badget','sections','selectUpangsho', 'financial_year','selected_financial_year'));
   }


   public function bankDetailsReport()
   {
        $bankDetails = BankDetails::with('bank', 'branch')->get();
        $years = Incoexpense::select('year')->groupBy('year')->get();
        return view('accounts.report.bank_details_report', compact('years', 'bankDetails'));
   }
}
