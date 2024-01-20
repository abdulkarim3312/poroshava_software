<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\Contractor;
use App\Models\Cotractoraccount;
use App\Models\Incoexpense;
use App\Models\Projectpayment;
use App\Models\TaxType;
use App\Models\Upangsho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function paymentList()
    {
        return view('accounts.project.index');
    }

    public function paymentListDatatable()
    {

        $query = Cotractoraccount::with('contractor');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Cotractoraccount $contractorAccount) {
                $btn = '';
                if (($contractorAccount->bill_amnt - $contractorAccount->bill_paid) > 0) {
                    $btn .= '<a  href="' . route('project.contractor_payment', ['contractorAccount' => $contractorAccount->conacc_id]) . '" class="btn btn-warning bg-gradient-warning btn-sm edit">পেমেন্ট</a>';
                }
                return $btn;
            })
            ->editColumn('contact_date', function (Cotractoraccount $contractorAccount) {
                return $contractorAccount->contact_date ? enNumberToBn(Carbon::parse($contractorAccount->contact_date)->format('d-m_y')) : '';
            })
            ->editColumn('contractyear', function (Cotractoraccount $contractorAccount) {
                return enNumberToBn($contractorAccount->contractyear);
            })
            ->editColumn('bill_amnt', function (Cotractoraccount $contractorAccount) {
                return enNumberToBn(number_format(floatval($contractorAccount->bill_amnt), 2));
            })
            ->editColumn('bill_paid', function (Cotractoraccount $contractorAccount) {
                return enNumberToBn(number_format(floatval($contractorAccount->bill_paid), 2));
            })
            ->addColumn('remaining', function (Cotractoraccount $contractorAccount) {
                return enNumberToBn(number_format(floatval($contractorAccount->bill_amnt - $contractorAccount->bill_paid), 2));
            })
            ->addColumn('contractor_id_no', function (Cotractoraccount $contractorAccount) {
                return enNumberToBn($contractorAccount->contractor->emp_id ?? null);
            })
            ->addColumn('contractor_name', function (Cotractoraccount $contractorAccount) {
                return $contractorAccount->contractor->name ?? '';
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function create()
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $contractors = Contractor::all();
        return view('accounts.project.create', compact('sections',
            'contractors'));
    }

    public function store(Request $request)
    {

        $request['project_amount'] = bnNumberToEn($request->project_amount);
        $request['contract_amount'] = bnNumberToEn($request->contract_amount);
        $request['net_bill'] = bnNumberToEn($request->net_bill);
        $request['guarantee_amount'] = bnNumberToEn($request->guarantee_amount);
        $request['financial_year'] = bnNumberToEn($request->financial_year);
        $request['contract_date'] = bnNumberToEn($request->contract_date);
        $request['vat'] = bnNumberToEn($request->vat);
        $request['tax'] = bnNumberToEn($request->tax);
        $request['total_bill'] = bnNumberToEn($request->total_bill);

        $request->validate([
            'upangsho' => 'required',
            'financial_year' => 'required',
            'contractor' => 'required',
            'project_name' => 'required|max:255',
            'estimate_section' => 'required',
            'project_amount' => 'required|numeric|min:1',
            'contract_amount' => 'required|numeric|min:1',
            'net_bill' => 'required|numeric|min:1',
            'guarantee_amount' => 'required|numeric|min:1',
            'vat' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total_bill' => 'required|numeric|min:1',
            'note' => 'nullable|max:255',
            'contract_date' => 'required|date',
        ]);


        $emp = new Cotractoraccount;
        $emp->userid = Auth::id();
        $emp->contractor_id = $request->contractor;
        $emp->project_id = $request->project_name;
        $emp->estmatekhat_id = $request->estimate_section;
        $emp->project_price = $request->project_amount;
        $emp->bill_type = 0;
        $emp->prev_bill_amount = 0;
        $emp->contact_price = $request->contract_amount;
        $emp->bill_amnt = $request->net_bill;
        $emp->security_money = $request->guarantee_amount;
        $emp->contractyear = $request->financial_year;
        $emp->contact_date = Carbon::parse($request->contract_date);
        $emp->vat = $request->vat;
        $emp->incometax = $request->tax;
        $emp->total_bill = $request->total_bill;
        $emp->acc_no = $request->note ?? 'নাই';
        $emp->date = Carbon::parse($request->contract_date);
        $emp->save();


        return redirect()->back()->with('message', 'ঠিকাদারের হিসাব সংযুক্তি  সফল হয়েছে');
    }

    public function payment(Cotractoraccount $contractorAccount)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $types = TaxType::where('sister_concern_id', 1)->get();
        $banks = Bank::where('sister_concern_id', 1)->get();
        return view('accounts.project.payment', compact('contractorAccount', 'sections',
            'types', 'banks'));
    }

    public function paymentPost(Cotractoraccount $contractorAccount, Request $request)
    {

        $request['amount'] = bnNumberToEn($request->amount);
        $request['cheque_no'] = bnNumberToEn($request->cheque_no);
        $request['voucher_no'] = bnNumberToEn($request->voucher_no);
        $request['jamanot'] = bnNumberToEn($request->jamanot ?? null);
        $request['jamanot_voucher_no'] = bnNumberToEn($request->jamanot_voucher_no ?? null);
        $request['jamanot_cheque_no'] = bnNumberToEn($request->jamanot_cheque_no ?? null);
        $request['vat'] = bnNumberToEn($request->vat ?? null);
        $request['vat_voucher_no'] = bnNumberToEn($request->vat_voucher_no ?? null);
        $request['vat_cheque_no'] = bnNumberToEn($request->vat_cheque_no ?? null);
        $request['tax'] = bnNumberToEn($request->tax ?? null);
        $request['tax_voucher_no'] = bnNumberToEn($request->tax_voucher_no ?? null);
        $request['tax_cheque_no'] = bnNumberToEn($request->tax_cheque_no ?? null);
        $message = [
            'description.required_if' => 'দয়া করে খাতের বিবরণ পূরণ করেন',
        ];
        $request->validate([
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
            'description' => 'required_if:income_expenditure,2',
            'amount' => 'required|numeric|min:1',
            'voucher_no' => 'required|max:255',
            'cheque_no' => 'required|max:255',
            'jamanot' => 'nullable|numeric',
            'jamanot_voucher_no' => 'nullable|max:255',
            'jamanot_cheque_no' => 'nullable|max:255',
            'vat' => 'nullable|numeric',
            'vat_voucher_no' => 'nullable|max:255',
            'vat_cheque_no' => 'nullable|max:255',
            'tax' => 'nullable|numeric',
            'tax_voucher_no' => 'nullable|max:255',
            'tax_cheque_no' => 'nullable|max:255',
            'date' => 'required|date',
            'receiver_name' => 'nullable|max:255',
            'note' => 'nullable|max:255',
        ], $message);

        $projectUpdate = Cotractoraccount::where('conacc_id', $contractorAccount->conacc_id)
            ->first();
        $oldBill = $projectUpdate->bill_paid + $request->amount;
        $billAmount = $projectUpdate->bill_amnt;
        $bill_type = $request->bill_type ?? '';
        $prev_bill_amount1 = 0;

        if ($billAmount < $oldBill) {
            return redirect()->back()->withInput()
                ->with('error', ' নীট বিলের  অতিক্রম করেছে ');
        }
        if ($request->income_expenditure == 1) {
            $vourcher_no = "";
            $chalan_no = $request->voucher_no;
            $status = 1;
        } else {
            $vourcher_no = $request->voucher_no;
            $chalan_no = "";
            $status = 0;
        }

        $projectUpdate->update([
            'bill_paid' => $oldBill
        ]);
        $employ_id = $contractorAccount->contractor_id;

        $projectpayment = new Projectpayment;
        $projectpayment->payment_date = Carbon::parse($request->date);
        $projectpayment->payment = $request->amount;
        $projectpayment->commints = $request->note;
        $projectpayment->proklpo_id = $employ_id;
        $projectpayment->bill_type       = $bill_type;
        $projectpayment->userid = Auth::id();
        $projectpayment->bankact = $request->bank_account;
        $projectpayment->check_nos = $request->cheque_no;
        $projectpayment->prev_bill_amount1 = $prev_bill_amount1;
        $projectpayment->voucher_no = $vourcher_no;
        $projectpayment->save();


        if (!empty($request->vat) || !empty($request->tax)) {
            $vat_tax_status = 1;
        } else {
            $vat_tax_status = 0;
        }
        $amount = $request->amount;
        $employ_id = null;

        $incoexpenseid = new Incoexpense();
        $incoexpenseid->user_id = Auth::id();
        $incoexpenseid->upangsho_id = $request->upangsho;
        $incoexpenseid->inout_id = $request->income_expenditure;
        $incoexpenseid->khattype_id = $request->sector_type;
        $incoexpenseid->khtattypetype_id = $request->sub_sector_type;
        $incoexpenseid->khat_id = $request->sector;
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


        if (!empty($request->jamanot)) {
            $jamanot = new Incoexpense;
            $jamanot->user_id = Auth::id();
            $jamanot->upangsho_id = $request->upangsho;
            $jamanot->inout_id = $request->income_expenditure;
            $jamanot->khattype_id = $request->sector_type;
            $jamanot->khtattypetype_id = $request->sub_sector_type;
            $jamanot->khat_id = $request->sector;
            $jamanot->proklpo_id = $employ_id;
            $jamanot->taxnontax = $request->tax_type;
            $jamanot->khat_des = '-ঐ-কাজের জামানত';
            $jamanot->year = $request->financial_year;
            $jamanot->bank_id = $request->bank;
            $jamanot->branch_id = $request->branch;
            $jamanot->acc_no = $request->bank_account;
            $jamanot->vourcher_no = $request->jamanot_voucher_no;
            $jamanot->chalan_no = $chalan_no;
            $jamanot->check_no = $request->jamanot_cheque_no;
            $jamanot->amount = $request->jamanot;
            $jamanot->date = Carbon::parse($request->date);
            $jamanot->receiver_name = '১৪০০০৪১১০৭';
            $jamanot->status = $status;
            $jamanot->vat_tax_status = $incoexpenseid->incoexpenses_id;
            $jamanot->receive_datwe = Carbon::parse($request->date);
            $jamanot->note = $request->note;
            $jamanot->save();

            $jamanot = $request->jamanot;
            $amount += $jamanot;
        }


        if (!empty($request->vat)) {
            $vat = new Incoexpense;
            $vat->user_id = Auth::id();
            $vat->upangsho_id = $request->upangsho;
            $vat->inout_id = $request->income_expenditure;
            $vat->khattype_id = $request->sector_type;
            $vat->khtattypetype_id = $request->sub_sector_type;
            $vat->khat_id = $request->sector;
            $vat->proklpo_id = $employ_id;
            $vat->taxnontax = $request->tax_type;
            $vat->khat_des = '-ঐ-কাজের মূঃসঃক';
            $vat->year = $request->financial_year;
            $vat->bank_id = $request->bank;
            $vat->branch_id = $request->branch;
            $vat->acc_no = $request->bank_account;
            $vat->vourcher_no = $request->vat_voucher_no;
            $vat->chalan_no = $chalan_no;
            $vat->check_no = $request->vat_cheque_no;
            $vat->amount = $request->vat;
            $vat->date = Carbon::parse($request->date);
            $vat->receiver_name = '১/১১৩৩/০০৫/০৩১১';
            $vat->status = $status;
            $vat->vat_tax_status = $incoexpenseid->incoexpenses_id;
            $vat->receive_datwe = Carbon::parse($request->date);
            $vat->note = $request->note;
            $vat->save();

            $vatamnt = $request->vat;
            $amount += $vatamnt;
        }

        if (!empty($request->tax)) {
            $tax = new Incoexpense;
            $tax->user_id = Auth::id();
            $tax->upangsho_id = $request->upangsho;
            $tax->inout_id = $request->income_expenditure;
            $tax->khattype_id = $request->sector_type;
            $tax->khtattypetype_id = $request->sub_sector_type;
            $tax->khat_id = $request->sector;
            $tax->proklpo_id = $employ_id;
            $tax->taxnontax = $request->tax_type;
            $tax->khat_des = 'ঐ-কাজের আয়কর';
            $tax->year = $request->financial_year;
            $tax->bank_id = $request->bank;
            $tax->branch_id = $request->branch;
            $tax->acc_no = $request->bank_account;
            $tax->vourcher_no = $request->tax_voucher_no;
            $tax->status = $status;
            $tax->vat_tax_status = $incoexpenseid->incoexpenses_id;
            $tax->chalan_no = $chalan_no;
            $tax->check_no = $request->tax_cheque_no;
            $tax->amount = $request->tax;
            $tax->date = Carbon::parse($request->date);
            $tax->receiver_name = '১/১১৪১/০০১০/০১১১';
            $tax->receive_datwe = Carbon::parse($request->date);
            $tax->note = $request->note;
            $tax->save();

            $taxamnt = $request->tax;
            $amount += $taxamnt;
        }

        return redirect()->route('project_payment_list')->with('message', 'ঠিকাদারের ব্যয় সংযুক্তি সফল হয়েছে');
    }
}
