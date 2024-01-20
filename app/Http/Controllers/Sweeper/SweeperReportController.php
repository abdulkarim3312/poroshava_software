<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;

use App\Models\Sweeper\Area;
use App\Models\Sweeper\SweeperBonus;
use App\Models\Sweeper\BonusProcess;
use App\Models\Sweeper\Cleaner;
use App\Models\Sweeper\SweeperSalary;
use App\Models\Sweeper\SalaryProcess;
use App\Models\Sweeper\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SweeperReportController extends Controller
{
    public function bonus(Request $request)
    {
        $bonusDates = BonusProcess::select('year','month','bonus')->distinct()->get();
        $areas = Area::orderBy('community')->get();
        $types = Type::orderBy('name')->get();
        $bonuses = [];

        $query = SweeperBonus::select(DB::raw('sum(total) total,cleaner_id,year,bonus,month,area_id,team_id,type_id'));

        if ($request->bonus) {
            $query->where('bonus',substr($request->bonus, -1))
                    ->where('year',date('Y',strtotime($request->bonus)))
                    ->where('month',date('m',strtotime($request->bonus)));

        }


        if ($request->area) {
            $query->where('area_id',$request->area);
        }
        if ($request->team) {
            $query->where('team_id',$request->team);
        }
        if ($request->type) {
            $query->where('type_id',$request->type);
        }
        if ($request->submit != '') {

            $bonuses = $query->groupBy('cleaner_id','bonus','month','year','area_id','team_id','type_id')
                        ->orderBy('cleaner_id')->get();
        }



        return view('sweeper.report.bonus',compact('bonusDates','areas','types','bonuses'));
    }
    public function monthlyBill(Request $request)
    {
        $salaryDates = SalaryProcess::select('year')->distinct()->get();
        $areas = Area::orderBy('community')->get();
        $types = Type::orderBy('name')->get();
        $salaries = [];

        $query = Salary::select(DB::raw('sum(total) total,sum(deduction_day) deduction_day,daily_salary,others_salary,cleaner_id,month,area_id,team_id,type_id'));

        if ($request->year) {
            $query->where('year',$request->year);
        }
        if ($request->month) {
            $query->where('month',$request->month);
        }

        if ($request->area) {
            $query->where('area_id',$request->area);
        }
        if ($request->team) {
            $query->where('team_id',$request->team);
        }
        if ($request->type) {
            $query->where('type_id',$request->type);
        }
        if ($request->submit != '') {
            $salaries = $query->groupBy('cleaner_id','deduction_day','daily_salary','others_salary','month','area_id','team_id','type_id')
                        ->orderBy('cleaner_id')->get();
        }




        return view('sweeper.report.monthly_bill',compact('salaryDates','areas','types','salaries'));
    }
    public function biMonthlyBill(Request $request)
    {
        $salaryDates = SalaryProcess::select('year')->distinct()->get();
        $areas = Area::orderBy('community')->get();
        $types = Type::orderBy('name')->get();
        $salaries = [];
        $query = SweeperSalary::query();

        if ($request->year) {
            $query->where('year',$request->year);
        }
        if ($request->month) {
            $query->where('month',$request->month);
        }
        if ($request->bi_month) {
            $query->where('bi_monthly',$request->bi_month);
        }
        if ($request->area) {
            $query->where('area_id',$request->area);
        }
        if ($request->team) {
            $query->where('team_id',$request->team);
        }
        if ($request->type) {
            $query->where('type_id',$request->type);
        }
        if ($request->submit != '') {
            $salaries = $query->orderBy('cleaner_id')->get();
        }


        return view('sweeper.report.bi_monthly_bill',compact('salaryDates','areas','types','salaries'));
    }

    public function salaryTopSheets(Request $request)
    {

        $salaryDates = SalaryProcess::select('year')->distinct()->get();
        $areas = Area::orderBy('community')->get();
        $types = Type::orderBy('name')->get();
        $totalCleaner = '';
        $durationStartDate = '';
        $durationEndDate = '';

        $salaries = [];
        $query = SweeperSalary::query();

        $query->where('bi_monthly',$request->bi_month);
        $query->select(DB::raw('sum(total) as total,sum(daily_salary) as daily_salary,sum(others_salary) as others_salary, bi_monthly'));
        $query->groupBy('bi_monthly');
        if ($request->year) {
            $query->where('year',$request->year);
        }
        if ($request->month) {
            $query->where('month',$request->month);

            $totalCleaner = SweeperSalary::where('year',$request->year)
                    ->where('month',$request->month)
                    ->where('bi_monthly',$request->bi_month)
                    ->count();

        }

        if ($request->submit != '') {
            $salaries = $query->get();

            $count_day = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);


            if (strlen($request->month) == 1){
                $monthValue = '0'.$request->month;
            }else{
                $monthValue = $request->month;
            }

            if ($request->bi_month == 1) {

                $durationStartDate = '01-'.$monthValue.'-'.$request->year;
                $durationEndDate = '15-'.$monthValue.'-'.$request->year;
            }elseif($request->bi_month == 2){
                $lastDay = $count_day - 15;
                //$startDate = Carbon::now(); //returns current day
                $myDate = '01-'.$monthValue.'-'.$request->year;
                $durationStartDate = '16-'.$monthValue.'-'.$request->year;
                $durationEndDate = Carbon::createFromFormat('d-m-Y', $myDate)
                    ->lastOfMonth()
                    ->format('d-m-Y');
            }else if ($request->bi_month == 3){

                $durationStartDate = '01-'.$monthValue.'-'.$request->year;
                $myDate = '01-'.$monthValue.'-'.$request->year;


                $durationEndDate = Carbon::createFromFormat('d-m-Y',$myDate)
                    ->lastOfMonth()
                    ->format('d-m-Y');

            }

        }

        return view('sweeper.report.salary_top_sheets',compact('salaryDates','areas','types','salaries','durationStartDate','durationEndDate',
        'totalCleaner'));
    }
    public function bonusTopSheets(Request $request)
    {

        $bonusDates = BonusProcess::select('year','month','bonus')->distinct()->get();
        $bonus = null;
        $totalCleaner = null;
        if ($request->bonus != '') {
            $bonus = BonusProcess::where('bonus',substr($request->bonus, -1))
                ->where('year',date('Y',strtotime($request->bonus)))
                ->where('month',date('m',strtotime($request->bonus)))
                ->first();

            $totalCleaner = SweeperBonus::where('bonus_processes_id',$bonus->id)->count();

        }


        return view('sweeper.report.bonus_top_sheets',compact('bonusDates','bonus',
        'totalCleaner'));
    }
    public function cleanerInformation(Request $request)
    {
       $areas = Area::orderBy('community')->get();
       $types = Type::orderBy('name')->get();
       $cleaners =[];
       $query = Cleaner::query();

       if ($request->area) {
           $query->where('area_id',$request->area);
       }
        if ($request->team) {
            $query->where('team_id',$request->team);
        }
        if ($request->type) {
            $query->where('type_id',$request->type);
        }
        if ($request->submit != '') {
            $cleaners = $query->orderBy('cleaner_id')->get();
        }

        return view('sweeper.report.cleaner_information',compact('areas','types','cleaners'));
    }

}
