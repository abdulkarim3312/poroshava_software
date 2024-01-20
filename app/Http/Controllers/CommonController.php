<?php

namespace App\Http\Controllers;

use App\Models\BankDetails;
use App\Models\Branch;
use App\Models\Budget;
use App\Models\Cotractoraccount;
use App\Models\Employee;
use App\Models\Incoexpense;
use App\Models\Khat;
use App\Models\Salaryproces;
use App\Models\Shakha;
use App\Models\TaxType;
use App\Models\TaxTypeType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommonController extends Controller
{

    public function getContractorWiseProjects(Request $request)
    {
        $projects = Cotractoraccount::where('contractor_id', $request->contractorId)->get();

        return response($projects);
    }
    public function getBranches(Request $request)
    {
        $branches = Branch::where('bank_id', $request->bankId)->get();

        return response($branches);
    }

    public function getBankAccounts(Request $request)
    {
        $query = BankDetails::where('branch_id', $request->branchId);
        if ($request->upangshoId) {


            $query->where('upangsho_id', $request->upangshoId);
            if($request->upangshoId ==2 && $request->type == 1 && $request->branchId == 8){
                $query->orWhere('bank_details_id', 13);
            }
        }



        $accounts = $query->get();

        return response($accounts);
    }

    public function getSectorTypes(Request $request)
    {
        $sectors = TaxType::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->where('khat_id', $request->incomeExpenditureId)
            ->get();
        return response($sectors);
    }

    public function getUpangshoWiseSectorTypes(Request $request)
    {
        $sectors = TaxType::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->where('upangsho_id', $request->upangshoId)
            ->where('khat_id', $request->incomeExpenditureId)->get();

        return response($sectors);
    }

    public function getSubSectorTypes(Request $request)
    {
        $subSectors = TaxTypeType::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->where('khtattype_id', $request->sectorId)
            ->orWhere('tax_id', 0)
            ->get();
        return response($subSectors);
    }

    public function getUpangshoIncomeExpenditureSubSectorTypes(Request $request)
    {
        $subSectors = TaxTypeType::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->where('upangsho_id', $request->upangshoId)
            ->where('khat_id', $request->incomeExpenditureId)
            ->where('khtattype_id', $request->sectorId)
            ->orWhere('tax_id', 0)
            ->get();
        return response($subSectors);
    }

    public function getSector(Request $request)
    {
        $sectorQuery = Khat::where('sister_concern_id',auth()->user()->sister_concern_id)
            ->where('tax_type_type_id', $request->subSectorTypeId);
            if($request->sectorTypeId != ''){
                $sectorQuery->where('tax_type_id', $request->sectorTypeId);
            }
            if($request->upangshoId != ''){
                $sectorQuery->where('upangsho_id', $request->upangshoId);
            }
            $sectors = $sectorQuery->get();
        return response($sectors);
    }
    public function getCashBookSector(Request $request)
    {
        $query = Khat::whereNotNull('account_khat_id')->where('sister_concern_id',auth()->user()->sister_concern_id)
            ->where('tax_type_type_id', $request->subSectorTypeId)
            ->orWhere('khat_id',464);
        if ($request->upangshoId != ''){
            $query->where('upangsho_id', $request->upangshoId);
        }
        $sectors = $query->get();

        return response($sectors);
    }
    public function getCashbookSectorDetails(Request $request)
    {
        $khat = Khat::where('khat_id',464)->first();

        $sectors = Khat::whereIn('khat_id',json_decode($khat->khat_id_json))
            ->get();
        return response($sectors);
    }

    public function checkBudget(Request $request)
    {

        $budget = Budget::where('khat_id', $request->sectorId)
            ->where('year', $request->financialYear)
            ->where('inout_id', $request->incomeExpenditureId)
            ->first();

        if ($budget) {
            $expense = Incoexpense::where('khat_id', $request->sectorId)
                ->where('year', $request->financialYear)
                ->where('inout_id', $request->incomeExpenditureId)
                ->where('status', 1)
                ->sum('amount');
            return response([
                'budget_type' => $request->incomeExpenditureId,
                'success' => false,
                'amount' => $budget->budget_amo - $expense,
                'message' => 'এই অর্থ বছর বাজেট সংযুক্তি সম্পন্ন হয়েছে, বাজেট ব্যবস্থাপন থেকে বৃদ্ধি করতে পারবেন।',
            ]);
        } else {
            return response([
                'success' => true,
            ]);
        }
    }

    public function getDepartmentWiseEmployees(Request $request)
    {
        $employees = Employee::where('branchid', $request->departmentId)->get();

        return response($employees);
    }
    public function getSalaryProcessMonths(Request $request)
    {
        $resultMonths = Salaryproces::where('yearmonth', 'LIKE', '%'.$request->year)
            ->select('yearmonth')
            ->groupBy('yearmonth')
            ->pluck('yearmonth')->toArray();
        $monthOldNames = [];
        foreach ($resultMonths as $resultMonth) {
            $carbonDate = Carbon::createFromFormat('m/Y', $resultMonth);
            $monthName = $carbonDate->monthName;
            $monthOldNames[] = $monthName;
        }

        $newMonths = [];
        for ($i=1;$i<=12;$i++){
            $newMonths[] = Carbon::create()->month($i)->monthName;
        }
        $months = array_diff($newMonths,$monthOldNames);
        $bnMonths = [];
        foreach ($months as $month){
            $bnMonths[] = enMonthToBnMonth($month);
        }


        return response($bnMonths);
    }
    public function getSalaryDepositMonths(Request $request)
    {
        $resultMonths = Salaryproces::where('yearmonth', 'LIKE', '%'.$request->year)
            ->where('status',2)
            ->where('salary_status',2)
            ->select('yearmonth')
            ->groupBy('yearmonth')
            ->pluck('yearmonth')->toArray();


        $monthOldNames = [];
        foreach ($resultMonths as $resultMonth) {
            $carbonDate = Carbon::createFromFormat('m/Y', $resultMonth);
            $monthName = $carbonDate->monthName;
            $monthOldNames[] = $monthName;
        }

        $bnMonths = [];
        foreach ($monthOldNames as $month){
            $bnMonths[] = enMonthToBnMonth($month);
        }


        return response($bnMonths);
    }
    public function getPfDepositMonths(Request $request)
    {
        $resultMonths = Salaryproces::where('yearmonth', 'LIKE', '%'.$request->year)
            ->where('status', 2)
            ->where('profund_status', '2')
            ->select('yearmonth')
            ->groupBy('yearmonth')
            ->pluck('yearmonth')->toArray();


        $monthOldNames = [];
        foreach ($resultMonths as $resultMonth) {
            $carbonDate = Carbon::createFromFormat('m/Y', $resultMonth);
            $monthName = $carbonDate->monthName;
            $monthOldNames[] = $monthName;
        }

        $bnMonths = [];
        foreach ($monthOldNames as $month){
            $bnMonths[] = enMonthToBnMonth($month);
        }


        return response($bnMonths);
    }
    public function getGratuityDepositMonths(Request $request)
    {
        $resultMonths = Salaryproces::where('yearmonth', 'LIKE', '%'.$request->year)
            ->where('status', 2)
            ->where('graduaty_status',2)
            ->select('yearmonth')
            ->groupBy('yearmonth')
            ->pluck('yearmonth')->toArray();


        $monthOldNames = [];
        foreach ($resultMonths as $resultMonth) {
            $carbonDate = Carbon::createFromFormat('m/Y', $resultMonth);
            $monthName = $carbonDate->monthName;
            $monthOldNames[] = $monthName;
        }

        $bnMonths = [];
        foreach ($monthOldNames as $month){
            $bnMonths[] = enMonthToBnMonth($month);
        }


        return response($bnMonths);
    }
    public function getMonths(Request $request)
    {

        $newMonths = [];
        for ($i=1;$i<=12;$i++){
            $newMonths[] = Carbon::create()->month($i)->monthName;
        }

        $bnMonths = [];
        foreach ($newMonths as $month){
            $bnMonths[] = enMonthToBnMonth($month);
        }


        return response($bnMonths);
    }
    public function getSections(Request $request)
    {
        $sections = Shakha::where('biv_id',$request->departmentId)->get();
        return response($sections);
    }
}
