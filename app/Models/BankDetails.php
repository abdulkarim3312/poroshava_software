<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    //
    protected $guarded = [];
    protected $primaryKey = 'bank_details_id';

    public function upangsho()
    {
        return $this->belongsTo(Upangsho::class,'upangsho_id','upangsho_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id','bank_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','branch_id');
    }
    public static function details($year=''){


        $data=''; $update_balance=0;
        $sl = 1;

    	$bank_datas = BankDetails::join('banks', 'banks.bank_id', '=', 'bank_details.bank_id')
               ->join('branches', 'branches.branch_id', '=', 'bank_details.branch_id')->get();

        foreach($bank_datas as $bank_data){


        	$data .= '<tr class="gradeX">
                <td>'. $sl++.'</td>
                <td>'. $bank_data->bank_name .', '. $bank_data->branch_name .'</td>
                <td>'. $bank_data->acc_no .'</td>
                <td>'. $bank_data->acc_details .'</td>

                <td align="right">'. number_format((float)$bank_data->update_balance, 2) .'</td>
            </tr>';

            // if($year !=''){

            // 	$incomexpense = Incoexpense::where('acc_no', $bank_data->bank_details_id)->where('year', $year)->get();
            // }else{

            // 	$incomexpense = Incoexpense::where('acc_no', $bank_data->bank_details_id)->get();

            // }
            // foreach($incomexpense as $inex){

            //     $update_balance +=  $inex->amount;
            // }

            // $data .= '<td>'. $update_balance .'</td></tr>';
            // $update_balance=0;
       }
       return $data;

    }
}
