<?php

use App\Models\CashbookIncoexpense;
use App\Models\Incoexpense;
use App\Models\Khat;
use App\Models\Salaryproces;
use App\Models\TradeLicense\TradeUser;

function enStringToBn($string)
{
    $englishChars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
        'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
        'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    );

    $bengaliChars = array(
        'অ', 'ব', 'ক', 'দ', 'ই', 'ফ', 'গ', 'হ', 'ই', 'জ', 'ক', 'ল', 'ম', 'ন',
        'ও', 'প', 'ক', 'র', 'স', 'ট', 'উ', 'ভ', 'ও', 'এক্স', 'ও', 'য'
    );

// Replace English characters with Bengali characters
    $bnString = '';
    $length = mb_strlen($string);

    for ($i = 0; $i < $length; $i++) {
        $char = mb_substr($string, $i, 1);

        if (in_array($char, $englishChars)) {
            $charIndex = array_search($char, $englishChars);
            $bnString .= $bengaliChars[$charIndex];
        } else {
            $bnString .= $char;
        }
    }

    return $bnString; // Output: হেল্লো, ওর্ল্ড!
}

function enMonthToBnMonth($month)
{
    $englishMonthNames = array(
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    );

    $bengaliMonthNames = array(
        'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
        'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
    );

// Convert English digits to Bengali digits
    return strtr($month, array_combine($englishMonthNames, $bengaliMonthNames));

}

function bnMonthToEnMonth($month)
{
    $englishMonthNames = array(
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    );

    $bengaliMonthNames = array(
        'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
        'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
    );

// Convert English digits to Bengali digits
    return strtr($month, array_combine($bengaliMonthNames, $englishMonthNames));

}

function enNumberToBn($number)
{
    $enDigits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $bnDigits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');

// Convert English digits to Bengali digits
    return strtr($number, array_combine($enDigits, $bnDigits));

}

function bnNumberToEn($number)
{
    $bnDigits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $enDigits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

// Convert English digits to Bengali digits
    return strtr($number, array_combine($bnDigits, $enDigits));

}

function getBudgetIncome($khat_id, $year)
{
    return Incoexpense::where('inout_id', 1)
        ->where('khat_id', $khat_id)
        ->where('year', $year)
        ->sum('amount');

}

function getBudgetExpense($khat_id, $year)
{
    return Incoexpense::where('inout_id', 2)
        ->where('khat_id', $khat_id)
        ->where('year', $year)
        ->where('status', 1)
        ->sum('amount');

}

function employeeLoan($employee, $loan)
{

    if ($loan->loanType->id == 1) {
        $amount = Salaryproces::where('emid', $employee->eid)
            ->where('f_load_id', $loan->id)
            ->sum('pfloanadvance');
    } else {
        return Salaryproces::where('emid', $employee->eid)
            ->where('o_load_id', $loan->id)
            ->sum('otherloan');
    }
}

function employeeTotalSalary($employee)
{
    $totalSalary = ((float)$employee->salary + (float)$employee->houserent + (float)$employee->treatment + (float)$employee->tifin + (float)$employee->education + (float)$employee->tour + (float)$employee->mobile + (float)$employee->tranport + (float)$employee->mohargho + (float)$employee->others);
    return $totalSalary - (float)$employee->pf_found - (float)$employee->pfloanadvance - (float)$employee->otherloan;

}

function getheads($id)
{

    $data = '';
    $khats = Khat::where('tax_type_id', $id)->get();
    foreach ($khats as $kt) {
        $data .= '<th>' . $kt->khat_name . '</th>';
    }
    return $data;
}

function getrows($id, $date)
{

    $data = '';
    $khats = Khat::where('tax_type_id', $id)->get();
    foreach ($khats as $kt) {
        $data .= '<td align="right">' . enNumberToBn(getamount($kt->khat_id, $date)) . '</td>';
    }
    return $data;
}

function getTotal($id, $month)
{
    $vattaxamnt = 0;
    $amnt = CashbookIncoexpense::where('khat_id', $id)
        ->where('date', 'like', $month . '%')
        ->where('status', 1)->sum('amount');
    if ($amnt != 0) {
        $incoexpensesids = CashbookIncoexpense::where('khat_id', $id)->where('date', 'like', $month . '%')->where('status', 1)->get();
        foreach ($incoexpensesids as $exinid) {

            $vattax = CashbookIncoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $exinid->date);
            if ($vattax->count() > 0) {
                $vattaxamnt += $vattax->sum('amount');
            } else {
                $vattaxamnt = 0;
            }
        }
        $amnt = number_format($amnt + $vattaxamnt, 2);

    }
    return $amnt;
}

function getamount($id, $date)
{
    $vattaxamnt = 0;

    $amnt = CashbookIncoexpense::where('khat_id', $id)->where('date', $date)->where('status', 1)->sum('amount');
    if ($amnt == 0) {
        $amnt = '';
    } else {
        $incoexpensesids = CashbookIncoexpense::where('khat_id', $id)->where('date', $date)->where('status', 1)->get();
        foreach ($incoexpensesids as $exinid) {

            $vattax = CashbookIncoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $date);
            if ($vattax->count() > 0) {
                $vattaxamnt += $vattax->sum('amount');
            } else {
                $vattaxamnt = 0;
            }
        }


        $amnt = number_format($amnt + $vattaxamnt, 2);
    }
    return $amnt;
}

function getPrevTotal($id, $month)
{

    $vattaxamnt = 0;
    $m = explode('-', $month)[1];
    $y = explode('-', $month)[0];

    if ($m != '07') {

        $to = date('Y-m-t', strtotime($y . '-' . $m . '-01 -1 month'));

        //echo $to; exit;

        if ($m <= '06') {
            $y--;
        }
        $from = $y . '-07-01'; //die();
        $amnt = CashbookIncoexpense::where('khat_id', $id)->where('status', 1)->whereBetween('date', [$from, $to])->sum('amount');


        $incoexpensesids = CashbookIncoexpense::where('khat_id', $id)->whereBetween('date', [$from, $to])->where('status', 1)->get();
        foreach ($incoexpensesids as $exinid) {

            $vattax = CashbookIncoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $exinid->date);
            if ($vattax->count() > 0) {
                $vattaxamnt += $vattax->sum('amount');
            } else {
                $vattaxamnt = 0;
            }
        }
        $amnt = number_format($amnt + $vattaxamnt, 2);

        return $amnt;

    } else {

        return 0;
    }
}

function getGrandTotal($id, $month)
{
    $vattaxamnt = 0;
    $m = explode('-', $month)[1];
    $y = explode('-', $month)[0];

    $to = date('Y-m-t', strtotime($y . '-' . $m . '-01'));
    //echo $to; exit;
    if ($m <= '06') {
        $y--;
    }
    $from = $y . '-07-01'; //die();
    $amnt = CashbookIncoexpense::where('khat_id', $id)
        ->where('status', 1)->whereBetween('date', [$from, $to])->sum('amount');
    $incoexpensesids = CashbookIncoexpense::where('khat_id', $id)
        ->whereBetween('date', [$from, $to])->where('status', 1)->get();
    foreach ($incoexpensesids as $exinid) {

        $vattax = CashbookIncoexpense::where('vat_tax_status', $exinid->incoexpenses_id)
            ->where('date', $exinid->date);
        if ($vattax->count() > 0) {
            $vattaxamnt += $vattax->sum('amount');
        } else {
            $vattaxamnt = 0;
        }
    }
    $amnt = number_format($amnt + $vattaxamnt, 2);
    return $amnt;

}
function colspan($id){
    return Khat::where('tax_type_id', $id)->count();
}

function tradeLicenseApplicationList(){
    return TradeUser::where('licence_no','=','')->where('inspector',0)->where('secretary',0)->where('mayor',0)->where('inactive_status',0)->get();
}
function totalTradeLincenseApplication(){
    return TradeUser::where('licence_no','=','')->where('inspector',0)->where('secretary',0)->where('mayor',0)->where('inactive_status',0)->count();
}
function totalTradeLincenseProcessingApplication(){
//    return TradeUser::where('licence_no','=','')->where('inspector',1)->where('secretary',0)->where('mayor',0)->where('inactive_status',0)->count();
    return TradeUser::where('inspector',1)->where('secretary',0)->where('mayor',0)->count();
}
function totalTradeLicenseCount(){
    return TradeUser::where('licence_no','!=','')->where('inspector',1)->where('secretary',1)->where('mayor',1)->where('inactive_status',1)->count();
}
function totalTradeLicenseRenewCount(){
    return TradeUser::where('licence_no','!=','')->where('inspector',1)->where('secretary',1)->where('mayor',1)->where('financial_year','2023-2024')->where('paid_status',1)->count();
}



if (! function_exists('en_to_bn')) {
    function en_to_bn($value)
    {
        $en = [1,2,3,4,5,6,7,8,9,0];
        $bn = ['১','২','৩','৪','৫','৬','৭','৮','৯','০'];

        $num = floatval($value).'';
        if (strpos($num, '.') !== false)
            return str_replace($en,$bn,number_format($value, 2, '.', ','));
        else
            return str_replace($en,$bn,number_format($value));
    }
}
if (! function_exists('bn_number')) {
    function bn_number($number)
    {
        $en = [1,2,3,4,5,6,7,8,9,0];
        $bn = ['১','২','৩','৪','৫','৬','৭','৮','৯','০'];

        return str_replace($en,$bn,$number);
    }
}
if (! function_exists('en_number')) {
    function en_number($number)
    {
        $en = [1,2,3,4,5,6,7,8,9,0];
        $bn = ['১','২','৩','৪','৫','৬','৭','৮','৯','০'];

        return str_replace($bn,$en,$number);
    }
}
