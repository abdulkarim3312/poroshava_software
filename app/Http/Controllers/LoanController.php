<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    public function index()
    {
        return view('hr_payroll.loan.index');
    }
    public function datatable()
    {

        $query = Loan::with('employee','employee.SalaryScale','loanType');
        return DataTables::eloquent($query)

            ->addColumn('employee_id_no', function (Loan $loan) {
                return enNumberToBn($loan->employee->emp_id ?? null);
            })
            ->addColumn('employee_name', function (Loan $loan) {
                return $loan->employee->name;
            })
            ->addColumn('employee_designation_name', function (Loan $loan) {
                return $loan->employee->designation;
            })
            ->addColumn('employee_salary_scale', function (Loan $loan) {
                return enNumberToBn($loan->employee->SalaryScale->name ?? null);
            })
            ->addColumn('loan_type_name', function (Loan $loan) {
                return $loan->loanType->name ?? '';
            })
            ->editColumn('date', function (Loan $loan) {
                return enNumberToBn(Carbon::parse($loan->date)->format('d-m-Y'));
            })
            ->addColumn('amount', function (Loan $loan) {
                return enNumberToBn(number_format($loan->amount,2));
            })
            ->addColumn('loan_paid', function (Loan $loan) {
                return enNumberToBn(number_format(employeeLoan($loan->employee,$loan),2));
            })
            ->addColumn('due_paid', function (Loan $loan) {
                return enNumberToBn(number_format($loan->amount - employeeLoan($loan->employee,$loan),2));
            })
            ->rawColumns(['action','photo'])
            ->toJson();
    }
    public function loanProcess()
    {
        $departments = Department::all();
        $loanTypes = LoanType::all();
        return view('hr_payroll.loan.loan_process', compact('departments', 'loanTypes'));
    }

    public function loanProcessPost(Request $request)
    {
        $request['amount'] = bnNumberToEn($request->amount);
        $request['monthly_installment_amount'] = bnNumberToEn($request->monthly_installment_amount);
        $request['date'] = bnNumberToEn($request->date);

        $request->validate([
            'department' => 'required',
            'employee' => 'required',
            'loan_type' => 'required',
            'amount' => 'required|numeric|min:1',
            'monthly_installment_amount' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);
        $loan = new Loan();
        $loan->employee_id = $request->employee;
        $loan->loan_type_id = $request->loan_type;
        $loan->amount = $request->amount;
        $loan->monthly_installment_amount = $request->monthly_installment_amount;
        $loan->date = Carbon::parse($request->date);
        $loan->save();

        return back()->with('message', 'লোন পক্রিয়া সফল হয়েছে');
    }
}
