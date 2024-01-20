<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Bank;
use App\Models\BankDetails;
use App\Models\Branch;
use App\Models\BudgetLog;
use App\Models\Khat;
use App\Models\TaxType;
use App\Models\TaxTypeType;
use App\Models\Upangsho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('accounts.budget.index');
    }
    public function pendingList()
    {
        return view('accounts.budget.pending');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Upangsho::where('upangsho_id','!=',0)->get();
        $types = TaxType::where('sister_concern_id',auth()->user()->sister_concern_id)->get();
      return view('accounts.budget.create',compact('sections','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['amount'] = bnNumberToEn($request->amount);

        $request->validate([
            'upangsho'=>'required',
            'financial_year'=>'required',
            'sector_type'=>'required',
            'sub_sector_type'=>'required',
            'sector'=>'required',
            'income_expenditure'=>'required',
            'amount'=>'required|numeric|min:1',
        ]);
        Budget::create([
            'user_id'           => Auth::id(),
            'upangsho_id'       => $request['upangsho'],
            'inout_id'          => $request['income_expenditure'],
            'khattype_id'       => $request['sector_type'],
            'khtattypetype_id'  => $request['sub_sector_type'],
            'khat_id'           => $request['sector'],
            'year'              => bnNumberToEn($request['financial_year']),
            'budget_amo'        => $request['amount'],
        ]);


        return redirect()->route('budget')->with('message', 'Budget created successfully.');

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request['amount'] = bnNumberToEn($request->amount);
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $budget = Budget::where('bidget_id',$request->budget_id)->first();

        $budgetLog = new BudgetLog;
        $budgetLog->user_id = Auth::id();
        $budgetLog->budget_id = $budget->bidget_id;
        $budgetLog->khat_id = $budget->khat_id;
        $budgetLog->status = 2;
        $budgetLog->year = $budget->year;
        $budgetLog->amount = $request->amount;
        $budgetLog->apprby = Auth::id();
        $budgetLog->save();

        return response()->json(['success' => 'বাজেটের পরিমাণ সফলভাবে জমা দেওয়া হয়েছে']);

    }
    public function approved(Request $request)
    {
        $request['amount'] = bnNumberToEn($request->amount);
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $budgetLog = BudgetLog::where('bdgtlog_id',$request->budget_log_id)
            ->first();

        Budget::where('bidget_id', $budgetLog->budget_id)
            ->increment('budget_amo',$request->amount);

        $budgetLog->update([
            'amount' => $request->amount,
            'status' => 1,
            'apprby' => Auth::id(),
        ]);

        return response()->json(['success' => 'বাজেটের পরিমাণ অনুমোদন দেওয়া হয়েছে']);

    }
    public function datatable() {

        $query = Budget::with('upangsho','taxType','taxSubType','sector');

        return DataTables::eloquent($query)
            ->addColumn('action', function(Budget $budget) {
                return '<a role="button" data-id="'.$budget->bidget_id.'" data-fiscal_year="'.enNumberToBn($budget->year).'" data-sector_type_name="'.$budget->taxType->tax_name.'" data-sector_name="'.$budget->sector->serilas.' '.$budget->sector->khat_name.'" class="btn btn-success bg-gradient-success btn-sm budget-edit"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('upangsho_name', function(Budget $budget) {
                return $budget->upangsho->upangsho_name ?? '';
            })
            ->addColumn('sector_type_name', function(Budget $budget) {
                return $budget->taxType->tax_name ?? '';
            })
            ->addColumn('sub_sector_type_name', function(Budget $budget) {
                return $budget->taxSubType->tax_name2 ?? '';
            })
            ->addColumn('sector_name', function(Budget $budget) {
                return $budget->sector->khat_name ?? '';
            })
            ->addColumn('sector_serilas_name', function(Budget $budget) {
                return $budget->sector->serilas ?? '';
            })
            ->editColumn('year', function(Budget $budget) {
                return enNumberToBn($budget->year);
            })
            ->editColumn('budget_amo', function(Budget $budget) {
                return enNumberToBn($budget->budget_amo);
            })
            ->addColumn('budget_income', function(Budget $budget) {
                return enNumberToBn(number_format(getBudgetIncome($budget->khat_id, $budget->year),2));
            })
            ->addColumn('budget_expense', function(Budget $budget) {
                return enNumberToBn(number_format(getBudgetExpense($budget->khat_id, $budget->year),2));
            })
            ->addColumn('remaining_budget', function(Budget $budget) {
                if ($budget->inout_id == 2){
                    return enNumberToBn(number_format($budget->budget_amo - getBudgetExpense($budget->khat_id, $budget->year),2));
                }else{
                    return enNumberToBn(number_format($budget->budget_amo - getBudgetIncome($budget->khat_id, $budget->year),2));
                }
            })


            ->addColumn('status', function(Budget $budget) {
                if ($budget->status == 1)
                    return '<span class="badge badge-success">সক্রিয়</span>';
                else
                    return '<span class="badge badge-danger">নিষ্ক্রিয়</span>';
            })
            ->addColumn('income_expenditure', function(Budget $budget) {
                if ($budget->inout_id == 1)
                    return 'আয়';
                else
                    return 'ব্যয়';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function pendingDatatable() {

        $query = BudgetLog::where('budget_logs.status',2)->with('sector');

        return DataTables::eloquent($query)
            ->addColumn('action', function(BudgetLog $budgetLog) {
                return '<a role="button" data-id="'.$budgetLog->bdgtlog_id .'" data-fiscal_year="'.enNumberToBn($budgetLog->year).'"  data-sector_name="'.($budgetLog->sector->serilas ?? ' ').' '.$budgetLog->sector->khat_name.'" data-amount="'.$budgetLog->amount.'"  class="btn btn-warning bg-gradient-warning text-white btn-sm budget-approve">Approve</a>';
            })
            ->addColumn('sector_name', function(BudgetLog $budgetLog) {
                return $budgetLog->sector->khat_name ?? '';
            })
            ->addColumn('sector_serilas_name', function(BudgetLog $budgetLog) {
                return $budgetLog->sector->serilas ?? '';
            })
            ->editColumn('year', function(BudgetLog $budgetLog) {
                return enNumberToBn($budgetLog->year);
            })
            ->editColumn('amount', function(BudgetLog $budgetLog) {
                return enNumberToBn(number_format((floatval($budgetLog->amount)),2));
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
