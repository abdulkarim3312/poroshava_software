<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\BonusType;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\Salaryproces;
use App\Models\SalaryScale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{
    public function index()
    {
        return view('hr_payroll.salary.salary_update_list');
    }

    public function salaryEdit(Employee $employee)
    {
        $salaryScales = SalaryScale::where('status', 1)->get();

        $pfLoan = Loan::where('employee_id', $employee->id)
            ->where('status',2)
            ->where('loan_type_id',1)->first();

        $otherLoan = Loan::where('employee_id', $employee->id)
            ->where('status',2)
            ->where('loan_type_id','!=',  1)
            ->first();


        return view('hr_payroll.salary.salary_edit', compact('employee', 'salaryScales',
        'pfLoan','otherLoan'));
    }

    public function salaryStore(Employee $employee, Request $request)
    {
        $request['salary'] = bnNumberToEn($request->salary);
        $request['special_benefits'] = bnNumberToEn($request->special_benefits);
        $request['house_rent'] = bnNumberToEn($request->house_rent);
        $request['medical_fee'] = bnNumberToEn($request->medical_fee);
        $request['tiffin_fee'] = bnNumberToEn($request->tiffin_fee);
        $request['washing_fee'] = bnNumberToEn($request->washing_fee);
        $request['education_fee'] = bnNumberToEn($request->education_fee);
        $request['income_tax'] = bnNumberToEn($request->income_tax);
        $request['others_fee'] = bnNumberToEn($request->others_fee);
        $request['pf_loan'] = bnNumberToEn($request->pf_loan);
        $request['other_loan'] = bnNumberToEn($request->other_loan);

        $rules = [
            'salary_scale' => 'required',
            'salary' => 'required|numeric|min:0',
            'special_benefits' => 'required|numeric|min:0',
            'house_rent' => 'required|numeric|min:0',
            'medical_fee' => 'required|numeric|min:0',
            'tiffin_fee' => 'required|numeric|min:0',
            'washing_fee' => 'required|numeric|min:0',
            'education_fee' => 'required|numeric|min:0',
            'income_tax' => 'required|numeric|min:0',
            'others_fee' => 'required|numeric|min:0',
        ];


        $pf = Loan::where('employee_id', $employee->eid)
            ->where('status', 2)
            ->where('loan_type_id', 1)
            ->first();

        if ($pf) {
            $rules['pf_loan'] = 'required|numeric|min:0';
            $pfUpdate = $pf->repay_loan_pf + $request->pf_loan;
            Loan::where('employee_id', $employee->eid)
                ->where('status', 2)
                ->where('loan_type_id', 1)
                ->update([
                    'repay_loan_pf' => $pfUpdate,
                    'monthly_installment_amount' => $request->pf_loan,
                ]);
        }

        $others = Loan::where('employee_id', $employee->eid)
            ->where('status', 2)
            ->where('loan_type_id', '!=', 1)
            ->first();

        if ($others) {
            $rules['other_loan'] = 'required|numeric|min:0';
            $others = $others->repay_loan_other + $request->other_loan;
            Loan::where('employee_id', $employee->eid)
                ->where('status', 2)
                ->where('loan_type_id', '!=', 1)
                ->update([
                    'repay_loan_other' => $others,
                    'monthly_installment_amount' => $request->other_loan
                ]);
        }

        if ($employee->grataccno == 0) {
            $gratuity = 0;
        } else {
            $gratuity = round(($request->salary * 25) / 100);
        }

        if ($employee->pfaccno == 0) {
            $pfFound = 0;
        } else {
            $pfFound = round(($request->salary * 10) / 100);
        }
        $request->validate($rules);

        $employee->salary = $request->salary;
        $employee->special_benefits = $request->special_benefits;
        $employee->houserent = $request->house_rent;
        $employee->treatment = $request->medical_fee;
        $employee->tifin = $request->tiffin_fee;
        $employee->wash = $request->washing_fee;
        $employee->education = $request->education_fee;
        $employee->tax = $request->income_tax;
        $employee->scaleid = $request->salary_scale;
        $employee->others = $request->others_fee;
        $employee->pf_found = $pfFound;
        $employee->graduaty = $gratuity;
        $employee->save();

        return redirect()->route('employee_salary_update_list')
            ->with('message', 'কর্মচারী বেতন হালনাগাদ সফল হয়েছে ।');
    }

    public function datatable()
    {

        $query = Employee::with('department', 'SalaryScale');
        return DataTables::eloquent($query)
            ->addColumn('action', function (Employee $employee) {
                $btn = '<a href="' . route('employee_salary_edit', ['employee' => $employee->eid]) . '" class="btn btn-success bg-gradient-success btn-sm edit"><i class="fa fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('salary_scale_name', function (Employee $employee) {
                return enNumberToBn($employee->SalaryScale->name ?? null);
            })
            ->addColumn('department_name', function (Employee $employee) {
                return $employee->department->name ?? '';
            })
            ->addColumn('emp_id', function (Employee $employee) {
                return enNumberToBn($employee->emp_id);
            })
            ->editColumn('salary', function (Employee $employee) {
                return enNumberToBn(number_format($employee->salary, 2));
            })
            ->editColumn('updated_at', function (Employee $employee) {
                return enNumberToBn($employee->updated_at->format('d-m-Y'));
            })
            ->addColumn('total_salary', function (Employee $employee) {
                return enNumberToBn(number_format(employeeTotalSalary($employee), 2));
            })
            ->addColumn('photo', function (Employee $employee) {
                return '<img width="80px" src="' . asset($employee->photo) . '" alt="Image">';
            })
            ->rawColumns(['action', 'photo'])
            ->toJson();
    }

    public function salaryProcess(Request $request)
    {
        $lastProcessYear = explode('-', Salaryproces::max('fyear'))[0];

        if ($request->all()) {

            if ($request->year != '' && $request->month != '' && $request->financial_year != '' && $request->process_date != '') {
                $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
                $request['month'] = $month . '/' . $request->year;

                $checkSalaryProcess = Salaryproces::where('yearmonth', $request['month'])->first();
                if ($checkSalaryProcess) {
                    return redirect()->back()
                        ->with('error', 'ইতিমধ্যে এই মাসের বেতন প্রক্রিয়া করা হয়েছে');
                }

                $employee = Employee::where('satatus', 1)->get();
                foreach ($employee as $emp) {
                    $pfLoanInstall = Loan::where('employee_id', $emp->eid)
                        ->where('loan_type_id', 1)
                        ->where('loan_status', 2);
                    if ($pfLoanInstall->count() > 0) {
                        $f_load_id = $pfLoanInstall->first()->id;
                        $pfLoanInstall = $pfLoanInstall->first()->monthly_installment_amount;
                    } else {
                        $f_load_id = null;
                        $pfLoanInstall = 0;
                    }
                    $otherLoanInstall = Loan::where('employee_id', $emp->eid)
                        ->where('loan_type_id', '!=', 1)
                        ->where('loan_status', 2);

                    if ($otherLoanInstall->count() > 0) {
                        $o_load_id = $otherLoanInstall->first()->id;
                        $otherLoanInstall = $otherLoanInstall->sum('monthly_installment_amount');
                    } else {
                        $o_load_id = null;
                        $otherLoanInstall = 0;
                    }

                    $loans = Loan::where('employee_id', $emp->eid)->where('loan_status', 2)->get();

                    foreach ($loans as $loan) {
                        $loanAmount = $loan->amont;
                        if ($loan->lntype == 1) {
                            $loanPaid = Salaryproces::where('emid', $emp->eid)
                                ->where('f_load_id', $loan->id)
                                ->sum('pfloanadvance');

                            $loanDue = (int)$loanAmount - (int)$loanPaid;

                            if ($loanDue < $loan->monthly_installment_amount)
                                $pfLoanInstall = $loanDue;
                        } else {
                            $loanPaid = Salaryproces::where('emid', $emp->eid)
                                ->where('o_load_id', $loan->id)
                                ->sum('otherloan');
                            $loanDue = (int)$loanAmount - (int)$loanPaid;

                            if ($loanDue < $loan->monthly_installment_amount)
                                $otherLoanInstall = $loanDue;
                        }

                        if ($loanDue <= $loan->monthly_installment_amount) {
                            $loan->loan_status = 1;
                            $loan->monthly_installment_amount = 0;
                            $loan->save();
                        }
                    }
                    $financialYear = $request['financial_year'];

                    $sp = new Salaryproces();
                    $sp->emid = $emp->eid;
                    $sp->f_load_id = $f_load_id;
                    $sp->o_load_id = $o_load_id;
                    $sp->fyear = $financialYear;
                    $sp->salary = $emp->salary;
                    $sp->special_benefits = $emp->special_benefits;
                    $sp->houserent = $emp->houserent;
                    $sp->treatment = $emp->treatment;
                    $sp->tifin = $emp->tifin;
                    $sp->wash = $emp->wash;
                    $sp->education = $emp->education;
                    $sp->tax = $emp->tax;
                    $sp->tour = $emp->tour;
                    $sp->mobile = $emp->mobile;
                    $sp->tranport = $emp->tranport;
                    $sp->mohargho = $emp->mohargho;
                    $sp->others = $emp->others;
                    $sp->pfloanadvance = $pfLoanInstall;
                    $sp->otherloan = $otherLoanInstall;
                    $sp->yearmonth = $request->month;
                    $sp->graduaty = $emp->graduaty;
                    $sp->pf_found = $emp->pf_found;
                    $sp->processdate = Carbon::parse($request->process_date);
                    $sp->save();
                }

                return redirect()->back()->with('message', 'বেতন প্রক্রিয়া সফল হয়েছে');
            } else {
                return redirect()->back()->with('error', 'বেতন প্রক্রিয়া করা যাচ্ছে না');
            }
        }
        return view('hr_payroll.salary.salary_process', compact('lastProcessYear'));
    }

    public function salaryDeposit(Request $request)
    {
        $lastProcessYear = explode('-', Salaryproces::where('status', 2)->where('salary_status', 2)->max('fyear'))[0];

        if ($request->all()) {

            if ($request->year != '' && $request->month != '' && $request->financial_year != '' && $request->process_date != '') {
                $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
                $request['month'] = $month . '/' . $request->year;

                $checkSalaryDeposit = Salaryproces::where('status', 2)
                    ->where('salary_status', 1)
                    ->where('yearmonth', $request['month'])
                    ->first();

                if ($checkSalaryDeposit) {
                    return redirect()->back()
                        ->with('error', 'ইতিমধ্যে এই মাসের বেতন জমা করা হয়েছে');
                }


                Salaryproces::where('status', 2)
                    ->where('salary_status', 2)
                    ->where('yearmonth', $request['month'])
                    ->update([
                        'salcashprodate' => Carbon::parse($request->process_date),
                        'fyear' => $request->financial_year,
                        'salary_status' => 1,
                    ]);

                return redirect()->back()->with('message', 'বেতন জমা সফল হয়েছে');
            } else {
                return redirect()->back()->with('error', 'বেতন জমা করা যাচ্ছে না');
            }
        }


        return view('hr_payroll.salary.salary_deposit', compact('lastProcessYear'));
    }

    public function pfDeposit(Request $request)
    {
        $lastProcessYear = explode('-', Salaryproces::where('status', 2)->where('profund_status', '2')->max('fyear'))[0];

        if ($request->all()) {

            if ($request->year != '' && $request->month != '' && $request->process_date != '') {
                $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
                $request['month'] = $month . '/' . $request->year;

                $checkPfDeposit = Salaryproces::where('status', 2)
                    ->where('profund_status', 1)
                    ->where('yearmonth', $request['month'])
                    ->first();

                if ($checkPfDeposit) {
                    return redirect()->back()
                        ->with('error', 'ইতিমধ্যে এই মাসের তহবিল জমা করা হয়েছে');
                }


                Salaryproces::where('status', 2)
                    ->where('profund_status', 2)
                    ->where('yearmonth', $request['month'])
                    ->update([
                        'pfprocesdate' => Carbon::parse($request->process_date),
                        'profund_status' => 1,

                    ]);

                return redirect()->back()->with('message', 'তহবিল জমা সফল হয়েছে');
            } else {
                return redirect()->back()->with('error', 'তহবিল জমা করা যাচ্ছে না');
            }
        }


        return view('hr_payroll.salary.pf_deposit', compact('lastProcessYear'));
    }

    public function gratuityDeposit(Request $request)
    {
        $lastProcessYear = explode('-', Salaryproces::where('status', 2)->where('graduaty_status', 2)->max('fyear'))[0];

        if ($request->all()) {

            if ($request->year != '' && $request->month != '' && $request->process_date != '') {
                $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
                $request['month'] = $month . '/' . $request->year;

                $checkGratuityDeposit = Salaryproces::where('status', 2)
                    ->where('graduaty_status', 1)
                    ->where('yearmonth', $request['month'])
                    ->first();

                if ($checkGratuityDeposit) {
                    return redirect()->back()
                        ->with('error', 'ইতিমধ্যে এই মাসের আনুতোষিক জমা করা হয়েছে');
                }


                Salaryproces::where('status', 2)
                    ->where('graduaty_status', 2)
                    ->where('yearmonth', $request['month'])
                    ->update([
                        'graduaty_process_date' => Carbon::parse($request->process_date),
                        'graduaty_status' => 1,
                    ]);

                return redirect()->back()->with('message', 'আনুতোষিক জমা সফল হয়েছে');
            } else {
                return redirect()->back()->with('error', 'আনুতোষিক জমা করা যাচ্ছে না');
            }
        }


        return view('hr_payroll.salary.gratuity_deposit', compact('lastProcessYear'));
    }

    public function bonusProcess(Request $request)
    {


        $bonusTypes = BonusType::all();

        $lastProcessYear = explode('-', Bonus::max('fiscal_year'))[0];

        if ($request->all()) {

            if ($request->bonus_type != '' && $request->year != '' && $request->financial_year != '' && $request->month != '' && $request->process_date != '') {
                $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
                $request['month'] = $month . '/' . $request->year;

                $bonusType = BonusType::find($request->bonus_type);
                $checkBonus = Bonus::where('relig', $bonusType->bonus_religion_status)
                    ->where('fiscal_year', $request->financial_year)
                    ->where('yearmonth', $request->month)
                    //->where('processdate', Carbon::parse($request->process_date)->format('Y-m-d'))
                    ->first();

                if ($checkBonus) {
                    return redirect()->back()
                        ->with('error', 'ইতিমধ্যে এই বোনাস প্রস্তুত করা হয়েছে');
                }

                if ($bonusType->bonus_religion_status == 1 || $bonusType->bonus_religion_status == 2) {
                    $employees = Employee::where('satatus', 1)->where('relig', $bonusType->bonus_religion_status)->get();
                } elseif ($bonusType->bonus_religion_status == 3) {
                    $employees = Employee::where('satatus', 1)->get();
                }
                foreach ($employees as $emp) {

                    if ($bonusType->bonus_religion_status == 2) {
                        $salary = $emp->salary * 2;

                    } elseif ($bonusType->bonus_religion_status == 1) {
                        $salary = $emp->salary;

                    } elseif ($bonusType->bonus_religion_status == 3) {
                        $salary = $emp->salary * .20;
                    }

                    $pfLoanInstall = Loan::where('employee_id', $emp->eid)
                        ->where('loan_type_id', 1);
                    if ($pfLoanInstall->count() > 0) {
                        $pfLoanInstall = $pfLoanInstall->first()->monthly_installment_amount;
                    } else {
                        $pfLoanInstall = 0;
                    }
                    $otherLoanInstall = Loan::where('employee_id', $emp->eid)
                        ->where('loan_type_id', '!=', 1);

                    if ($otherLoanInstall->count() > 0) {
                        $otherLoanInstall = $otherLoanInstall->sum('monthly_installment_amount');
                    } else {
                        $otherLoanInstall = 0;
                    }
                    if ($emp->grataccno == 0) {
                        $gratuity = 0;
                    } else {
                        $gratuity = (($emp->salary * 25) / 100);
                    }

                    $sp = new Bonus;
                    $sp->emid = $emp->eid;
                    $sp->bonus = $salary;
                    $sp->houserent = $emp->houserent;
                    $sp->treatment = $emp->treatment;
                    $sp->tifin = $emp->tifin;
                    $sp->wash = $emp->wash;
                    $sp->education = $emp->education;
                    $sp->tour = $emp->tour;
                    $sp->mobile = $emp->mobile;
                    $sp->tranport = $emp->tranport;
                    $sp->mohargho = $emp->mohargho;
                    $sp->others = $emp->others;
                    $sp->pfloanadvance = $pfLoanInstall;
                    $sp->otherloan = $otherLoanInstall;
                    $sp->yearmonth = $request->month;
                    $sp->graduaty = $gratuity;
                    $sp->pf_found = $emp->pf_found;
                    $sp->relig = $bonusType->bonus_religion_status;
                    $sp->pfprocesdate = Carbon::parse($request->process_date);
                    $sp->processdate = Carbon::parse($request->process_date);
                    $sp->fyear = $request->financial_year;
                    $sp->fiscal_year = $request->financial_year;
                    $sp->save();
                }


                return redirect()->back()->with('message', 'বোনাস প্রস্তুত সফল হয়েছে');
            } else {
                return redirect()->back()->with('error', 'বোনাস প্রস্তুত করা যাচ্ছে না');
            }
        }


        return view('hr_payroll.salary.bonus_process', compact('lastProcessYear', 'bonusTypes'));
    }


}
