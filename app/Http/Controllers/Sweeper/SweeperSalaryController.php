<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;
use App\Models\Sweeper\Cleaner;
use App\Models\Sweeper\CleanerBonusLog;
use App\Models\Sweeper\CleanerSalaryLog;
use App\Models\Sweeper\SweeperSalary;
use App\Models\Sweeper\SalaryProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SweeperSalaryController extends Controller
{
    public function cleanerSalaryUpdate()
    {
        return view('sweeper.salary.all');
    }
    public function cleanerSalaryUpdatePost(Request $request)
    {

        $rules = [
            'daily_salary' => 'required|numeric',
            'others_salary' => 'required|numeric',
            'deduction_day' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $cleaner = Cleaner::find($request->cleaner_id);
        $cleaner->daily_salary= $request->daily_salary;
        $cleaner->others_salary= $request->others_salary;
        $cleaner->deduction_day= $request->deduction_day;
        $cleaner->save();

        $log = new CleanerSalaryLog();
        $log->cleaner_id= $cleaner->id;
        $log->daily_salary= $request->daily_salary;
        $log->others_salary= $request->others_salary;
        $log->deduction_day= $request->deduction_day;
        $log->save();

        return response()->json(['success' => true, 'message' => 'পরিচ্ছন্ন কর্মী বেতন হালনাগাদ হয়েছে।', 'redirect_url' => route('cleaner_salary_update')]);

    }
    public function cleanerBonusUpdatePost(Request $request)
    {

        $rules = [
            'bonus' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $cleaner = Cleaner::find($request->cleaner_id);
        $cleaner->bonus= $request->bonus;
        $cleaner->save();

        $log = new CleanerBonusLog();
        $log->cleaner_id= $cleaner->id;
        $log->bonus= $request->bonus;
        $log->save();

        return response()->json(['success' => true, 'message' => 'পরিচ্ছন্ন কর্মী বোনাস হালনাগাদ হয়েছে।', 'redirect_url' => route('cleaner_salary_update')]);

    }

    public function cleanerSalaryProcess (Request $request)
    {
        if($request->year != '' && $request->month != '' && $request->bi_month != '' && $request->date != ''){

           $cleaners = Cleaner::where('status',1)->get();
           $total = 0;
           foreach ($cleaners as $cleaner){
               $daily_salary = $cleaner->daily_salary;
               $others_salary = $cleaner->others_salary;
               $deduction_day = $cleaner->deduction_day;
               $deductSalary = $cleaner->deduct_salary;

               if($request->bi_month == 1) {
                   $working_day = 15 - $deduction_day;
               }elseif ($request->bi_month == 2){
                   $count_day = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
                   $working_day = $count_day - 15 - $deduction_day;
               }else{
                   $count_day = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
                   $working_day = $count_day - $deduction_day;
               }

               $total +=  $daily_salary * $working_day + $others_salary - $deductSalary;
           }
           $salaryProcess = new SalaryProcess();
           $salaryProcess->date = $request->date;
           $salaryProcess->month = $request->month;
           $salaryProcess->bi_monthly = $request->bi_month;
           $salaryProcess->year = $request->year;
           $salaryProcess->total = $total;
           $salaryProcess->save();

           foreach ($cleaners as $cleaner){

               $daily_salary = $cleaner->daily_salary;
               $others_salary = $cleaner->others_salary;
               $deduction_day = $cleaner->deduction_day;
               $deductSalary = $cleaner->deduct_salary;

               if($request->bi_month == 1) {
                   $working_day = 15 - $deduction_day;
               }elseif ($request->bi_month == 2){
                   $count_day = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
                   $working_day = $count_day - 15 - $deduction_day;
               }else{
                   $count_day = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
                   $working_day = $count_day - $deduction_day;
               }
               $total =  $daily_salary * $working_day + $others_salary - $deductSalary;

               $salary = new SweeperSalary();
               $salary->salary_processes_id = $salaryProcess->id;
               $salary->cleaner_id = $cleaner->cleaner_id;
               $salary->area_id = $cleaner->area_id;
               $salary->team_id = $cleaner->team_id;
               $salary->type_id = $cleaner->type_id;
               $salary->date = $request->date;
               $salary->year = $request->year;
               $salary->month = $request->month;
               $salary->bi_monthly = $request->bi_month;
               $salary->deduction_day = $deduction_day;
               $salary->daily_salary = $daily_salary;
               $salary->others_salary = $others_salary;
               $salary->deduct_salary = $deductSalary;
               $salary->total = $total;
               $salary->save();

               Cleaner::where('id',$cleaner->id)->update([
                   'notes'=>null,
               ]);

            }
           return redirect()->route('cleaner_salary_process')
                        ->with('message','বেতন প্রস্তুত সম্পন্ন হয়েছে।');

        }
        return view('sweeper.salary.salary_process');
    }

    public function processSalaryUpdate(Request $request)
    {

        $rules = [
            'daily_salary' => 'required|numeric',
            'salary_id' => 'required|numeric',
            'cleaner_id' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $salary = SweeperSalary::find($request->salary_id);


        $updateProcess = SalaryProcess::where('id',$salary->salary_processes_id)->first();

        $updateProcess->decrement('total',$salary->total);

        $cleaner = Cleaner::find($request->cleaner_id);
        $cleaner->daily_salary = $request->daily_salary;
        // $cleaner->others_salary = $request->others_salary;
        // $cleaner->deduction_day = $request->deduction_day;
        $cleaner->save();

        $log = new CleanerSalaryLog();
        $log->cleaner_id = $cleaner->id;
        $log->daily_salary = $request->daily_salary;
        $log->others_salary = $cleaner->others_salary;
        $log->deduction_day = $cleaner->deduction_day;
        $log->deduct_salary = $cleaner->deduct_salary;
        $log->save();

        // Update Salary Process
        $salary = SweeperSalary::find($request->salary_id);

        $daily_salary = $cleaner->daily_salary;
        $others_salary = $cleaner->others_salary;
        $deduction_day = $cleaner->deduction_day;
        $deduct_salary = $cleaner->deduct_salary;

        if ($salary->bi_monthly == 1) {
            $working_day = 15 - $deduction_day;
        } else {
            $count_day = cal_days_in_month(CAL_GREGORIAN, $salary->month, $salary->year);
            $working_day = $count_day - 15 - $deduction_day;
        }
        $total =  $daily_salary * $working_day + $others_salary - $deduct_salary;

        $salary->deduction_day = $deduction_day;
        $salary->daily_salary = $daily_salary;
        $salary->others_salary = $others_salary;
        $salary->deduct_salary = $deduct_salary;
        $salary->total = $total;
        $salary->save();

        $updateProcess->increment('total',$total);

        return response()->json(['success' => true, 'message' => 'পরিচ্ছন্ন কর্মী বেতন হালনাগাদ হয়েছে।', 'redirect_url' => route('bi_monthly_bill')]);
    }
}
