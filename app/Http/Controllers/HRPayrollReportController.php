<?php

namespace App\Http\Controllers;

use App\Models\Salaryproces;
use App\Models\Upangsho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HRPayrollReportController extends Controller
{
    public function monthlyPayBill(Request $request)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $lastProcessYear = explode('-', Salaryproces::min('fyear'))[0];
        $months = [
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
        $yearMonth = null;
        $salaries = [];
        if ($request->upangsho != '' && $request->year != '' && $request->month != '') {
            $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
            $request['monthYear'] = $month . '/' . $request->year;

            $salaries = Salaryproces::where('yearmonth', $request->monthYear)
                ->whereHas('employeeName', function ($query) use ($request) {
                    $query->where('upananso', $request->upangsho);
                })
                ->with(['employeeName' => function ($query) {
                    $query->orderBy('emp_id');
                }])
                ->get();
            $selectUpangsho = Upangsho::find($request->upangsho);
            $yearMonth = $request['monthYear'];
        }


        return view('hr_payroll.report.monthly_pay_bill', compact('sections', 'lastProcessYear', 'months',
        'salaries','selectUpangsho','yearMonth'));
    }
    public function monthlySalaryTopSheet(Request $request)
    {

        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $lastProcessYear = explode('-', Salaryproces::min('fyear'))[0];
        $months = [
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
        $yearMonth = null;
        $salaries = [];
        if ($request->upangsho != '' && $request->year != '' && $request->month != '') {
            $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
            $request['monthYear'] = $month . '/' . $request->year;

            $selectUpangsho = Upangsho::find($request->upangsho);
            $yearMonth = $request['monthYear'];

            $salaries = Salaryproces::select(
                    'employees.branchid',
                    DB::raw('COUNT(employees.branchid) as division_count'),
                    DB::raw('SUM((salaryproces.salary + salaryproces.houserent + salaryproces.special_benefits + salaryproces.treatment + salaryproces.tifin + salaryproces.wash + salaryproces.education + salaryproces.others) - (salaryproces.pf_found + salaryproces.pfloanadvance + salaryproces.otherloan + salaryproces.tax)) as employsalary'),
                    DB::raw('SUM(salaryproces.pfloanadvance + salaryproces.pf_found + salaryproces.pf_found) as pf_fund'),
                    DB::raw('SUM(salaryproces.graduaty) as graduaty'),
                    DB::raw('SUM(salaryproces.tax) as total_tax'),
                    DB::raw('SUM(salaryproces.onudan) as totalonudan')
                )
                ->leftJoin('employees', 'salaryproces.emid', '=', 'employees.eid')
                ->leftJoin('upangshos', 'upangshos.upangsho_id', '=', 'employees.upananso')
                ->leftJoin('salary_scales', 'salary_scales.id', '=', 'employees.scaleid')
                ->leftJoin('departments', 'departments.id', '=', 'employees.branchid')
                ->where('salaryproces.status', 2)
                ->where('salaryproces.yearmonth', $yearMonth)
                ->where('employees.satatus', 1)
                ->where('employees.upananso', $request->upangsho)
                ->groupBy('employees.branchid')
                ->get();

        }


        return view('hr_payroll.report.monthly_top_sheet', compact('sections', 'lastProcessYear', 'months',
        'salaries','selectUpangsho','yearMonth'));
    }
    public function monthlyBankDeposit(Request $request)
    {

        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $lastProcessYear = explode('-', Salaryproces::min('fyear'))[0];
        $months = [
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
        $yearMonth = null;
        $salaries = [];
        if ($request->upangsho != '' && $request->year != '' && $request->month != '') {
            $month = Carbon::parse(bnMonthToEnMonth($request['month']))->format('m');
            $request['monthYear'] = $month . '/' . $request->year;

            $selectUpangsho = Upangsho::find($request->upangsho);
            $yearMonth = $request['monthYear'];

            $salaries = Salaryproces::select('salaryproces.*', 'employees.emp_id as emp_id', 'employees.upananso as upanansos', 'employees.name as name', 'employees.designation as designation', 'salary_scales.name as tax_name', 'upangshos.upangsho_name as upangsho_name', 'employees.pfaccno as pfaccno', 'employees.grataccno as grataccnos', 'salaryproces.pf_found as pf_found', 'salaryproces.graduaty as graduaty', 'employees.salaryaccno as salaryaccno','salaryproces.onudan as total_onudan')
                ->Leftjoin('employees', 'salaryproces.emid', '=', 'employees.eid')
                ->Leftjoin('upangshos', 'upangshos.upangsho_id', '=', 'employees.branchid')
                ->leftJoin('salary_scales', 'salary_scales.id', '=', 'employees.scaleid')
                ->where('salaryproces.status', 2)
                ->where('salaryproces.yearmonth', $yearMonth)
                ->where('employees.satatus', 1)
                ->orderBy('employees.emp_id', 'asc')
                ->where('employees.upananso', $request->upangsho)
                ->get();


        }


        return view('hr_payroll.report.monthly_bank_deposit', compact('sections', 'lastProcessYear', 'months',
        'salaries','selectUpangsho','yearMonth'));
    }
}
