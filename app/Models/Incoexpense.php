<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\Khat;
use Illuminate\Database\Eloquent\Model;
use App\Models\BankDetails;
use App\Models\TaxType;
use App\Models\Branch;
use App\Models\TaxTypeType;
use App\Models\Upangsho;

class Incoexpense extends Model
{
	static protected $year;
	static protected $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
	static protected $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    protected $primaryKey = 'incoexpenses_id';
    protected $guarded = [];

    public function upangsho()
    {
        return $this->belongsTo(Upangsho::class,'upangsho_id','upangsho_id');
    }
    public function incomeExpenseType()
    {
        return $this->belongsTo(Khattype::class,'inout_id','khat_id');
    }
    public function taxType()
    {
        return $this->belongsTo(TaxType::class,'khattype_id','tax_id');
    }
    public function taxSubType()
    {
        return $this->belongsTo(TaxTypeType::class,'khtattypetype_id','tax_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id','bank_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','branch_id');
    }
    public function bankAccount()
    {
        return $this->belongsTo(BankDetails::class,'acc_no','bank_details_id');
    }
    public function sector()
    {
        return $this->belongsTo(Khat::class,'khat_id','khat_id');
    }
    public static function allexpenses($bank_id, $branch, $accno, $sd, $ed){


		$data=''; $totalexp = 0;
		$expensese  = Incoexpense::join('upangshos','upangshos.upangsho_id', '=', 'incoexpenses.upangsho_id')
			->join('khats','khats.khat_id', '=', 'incoexpenses.khat_id')
		    ->join('tax_types','tax_types.tax_id', '=', 'incoexpenses.khattype_id')
		    ->join('tax_type_types','tax_type_types.tax_id', '=', 'incoexpenses.khtattypetype_id')
		    ->where('incoexpenses.bank_id', $bank_id)
		    ->where('incoexpenses.branch_id', $branch)
		    ->where('incoexpenses.acc_no', $accno)
		    ->where('incoexpenses.inout_id', 2)
		    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
		    ->where('incoexpenses.status', 1)
		    ->get();

			foreach($expensese as $exp){
		     	if($exp->tax_name2 == 0) { $exptax_name2 ='নাই'; }else{ $exptax_name2 =$exp->tax_name2; }
		     	$data .= '<tr>
		     	    <td>'. $exp->receive_datwe .'</td>

	                <td>'. $exp->khat_name .'</td>
	                <td>'. $exp->receiver_name .'</td>
	                <td>'. str_replace(self::$en, self::$bn, $exp->vourcher_no) .'</td>
	                <td>'. $exp->khat_des .'</td>
	                <td align="right">'. str_replace(self::$en, self::$bn, $exp->amount)	.'</td>
	                <td>'. str_replace(self::$en, self::$bn, $exp->check_no) .'</td>
	                <td align="right">'. str_replace(self::$en, self::$bn, $exp->amount)	.'</td>
	                <td>'. $exp->note .'</td>
	                <td class="bankdetailsaction">'; if($exp->uncashstatus!=1){
	                        $data .= '<a href="javascript:void(0)" onclick="makeuncash('. $exp->incoexpenses_id .')" class="btn btn-success">আন ক্যাশ</a>';
    	                }else{
    	                    $data .= 'আন ক্যাশ';
    	                }
	               $data .= '</td>
	            </tr>';
	            $totalexp += (float)$exp->amount;
	        }

	        // <td>'. $exp->upangsho_name .'</td>
	        // <td>'. $exp->tax_name .'</td>
	        // <td>'. $exptax_name2 .'</td>

	        $data .= '<tr>
                  <td align="right" colspan="7"><strong>মোট</strong></td>
                  <td align="right"><strong>'. str_replace(self::$en, self::$bn, $totalexp) .'</strong></td>
                  <td colspan="2"></td>
            </tr>';

		return $data;
	}

	public static function allincomes($bank_id, $branch, $accno, $sd, $ed){
    	//echo $bank_id. $branch. $accno. $sd. $ed; exit;
		$data=''; $date=''; $totamount=0; $totalinc = 0;

		$expensese  = Incoexpense::select('*', 'incoexpenses.incoexpenses_id')->join('upangshos','upangshos.upangsho_id','=','incoexpenses.upangsho_id')

			->join('khats','khats.khat_id','=','incoexpenses.khat_id')
		    ->join('tax_types','tax_types.tax_id','=','incoexpenses.khattype_id')
		    ->join('tax_type_types','tax_type_types.tax_id','=','incoexpenses.khtattypetype_id')
		    ->where('incoexpenses.bank_id', $bank_id)
		    ->where('incoexpenses.branch_id', $branch)
		    ->where('incoexpenses.acc_no', $accno)
		    ->where('incoexpenses.inout_id', 1)
		    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
		    ->groupBy('incoexpenses.receive_datwe')
		    ->get();

		foreach($expensese as $exp){
	     	if($exp->tax_name2 == 0) { $exptax_name2 ='নাই'; }else{ $exptax_name2 =$exp->tax_name2; }
	     	$data .= '<tr>
	     	    <td>'. str_replace(self::$en, self::$bn, $exp->receive_datwe) .'</td>

                <td>'. $exp->khat_name .'</td>
                <td>'. str_replace(self::$en, self::$bn, $exp->chalan_no) .'</td>
                <td>'. $exp->khat_des .'</td>
                <td align="right">'. str_replace(self::$en, self::$bn, $exp->amount)	.'</td>
                <td></td>
                <td>'. $exp->note .'</td>
                <td class="bankdetailsaction">'; if($exp->uncashstatus!=1){

	                        $data .= '<a href="javascript:void(0)" onclick="makeuncash('. $exp->incoexpenses_id .')" class="btn btn-success">আন ক্যাশ</a>';
    	                }else{

    	                    $data .= 'আন ক্যাশ';
    	                }
	               $data .= '</td>
            </tr>';

            //<td>'. $exp->upangsho_name .'</td>
               // <td>'. $exp->tax_name .'</td>
               // <td>'. $exptax_name2 .'</td>

            $i=0;
            $totamount += $exp->amount;
            $expenseses  = Incoexpense::select('*', 'incoexpenses.incoexpenses_id')->join('upangshos', 'upangshos.upangsho_id', '=', 'incoexpenses.upangsho_id')
				->join('khats','khats.khat_id','=','incoexpenses.khat_id')
			    ->join('tax_types','tax_types.tax_id','=','incoexpenses.khattype_id')
			    ->join('tax_type_types','tax_type_types.tax_id','=','incoexpenses.khtattypetype_id')
			    ->where('incoexpenses.bank_id', $bank_id)
    		    ->where('incoexpenses.branch_id', $branch)
    		    ->where('incoexpenses.acc_no', $accno)
    		    ->where('incoexpenses.inout_id', 1)
    		    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
			    ->where('incoexpenses.receive_datwe', $exp->receive_datwe)->get();

	            foreach($expenseses as $exps){
	                if($i>0)  {
        	            $data .= '<tr>
        	                <td>   </td>

        	                <td>'. $exps->khat_name .'</td>

        	                <td>'. str_replace(self::$en, self::$bn, $exps->chalan_no) .'</td>
        	                <td>'. $exps->khat_des .'</td>
        	                <td align="right">'. str_replace(self::$en, self::$bn, $exps->amount)	.'</td>
        	                <td></td>
        	                <td>'. $exps->note	 .'</td>
        	                <td  class="bankdetailsaction">'; if($exps->uncashstatus!=1){

            	                        $data .= '<a href="javascript:void(0)" onclick="makeuncash('. $exps->incoexpenses_id .')" class="btn btn-success">আন ক্যাশ</a>';
                	                }else{

                	                    $data .= 'আন ক্যাশ';
                	                }
            	               $data .= '</td>
        	            </tr>';
        	            $totamount += $exps->amount;
	                }$i++;
                }

            $data .= '<tr>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">'. str_replace(self::$en, self::$bn, $totamount) .'</td>
                <td></td>
            </tr>';
            $totalinc += $totamount;
            $totamount=0;
        }

        $data .= '<tr>
              <td align="right" colspan="5"><strong>মোট</strong></td>
              <td align="right"><strong>'. str_replace(self::$en, self::$bn, $totalinc) .'</strong></td>
              <td colspan="2"></td>
        </tr>';

		return $data;
	 }


	 public static function checkregister($upangsho_id=null, $year=null, $sd=null, $ed=null){

   		$data='';
         $expensese  = Incoexpense::select('*')
                     ->join('upangshos','upangshos.upangsho_id', '=', 'incoexpenses.upangsho_id')
                     ->join('khats','khats.khat_id','=','incoexpenses.khat_id')
                     ->join('khattypes','khattypes.khat_id','=','incoexpenses.inout_id')
                     ->join('bank_details','bank_details.bank_details_id','=','incoexpenses.acc_no')
                     ->join('banks','banks.bank_id','=','incoexpenses.bank_id')
                     ->where('incoexpenses.inout_id', 2)
                     ->where('incoexpenses.status', 0)
                     ->where('incoexpenses.upangsho_id', $upangsho_id)
                     ->where('incoexpenses.year', $year)
                     ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                     ->get();

	 	    foreach($expensese as $exp){

		     	$data .= '<tr>
		     	    <td>
		     	        <input type="hidden" name="inexids[]" value="'.$exp->incoexpenses_id.'">
		     	        '. str_replace(self::$en, self::$bn, date('d-m-Y', strtotime($exp->receive_datwe))) .'
		     	    </td>
	                <td>'. $exp->upangsho_name .'</td>
	                <td>'. $exp->receiver_name .'</td>
	                <td>'. $exp->khat_name .'</td>
	                <td>'. $exp->khat_des .'</td>
	                <td>'. str_replace(self::$en, self::$bn, $exp->check_no) .'</td>
	                <td>'. str_replace(self::$en, self::$bn, $exp->vourcher_no) .'</td>
	                <td>'. str_replace(self::$en, self::$bn, $exp->acc_no) .'</td>
	                <td>'. $exp->bank_name .'</td>
	                <td>'. str_replace(self::$en, self::$bn, $exp->amount) .'</td>
	                <td></td>
	                <td></td>';
    		     	if($exp->khat_des == '-ঐ-কাজের মূঃসঃক' || $exp->khat_des == 'ঐ-কাজের আয়কর'  ||  $exp->khat_des == '-ঐ-কাজের জামানত')

                        $data .= '<td></td> ';
    		     	else {

    	                $data .='<td class="checkregisterprint"><a class="btn btn-success btn-xs" onclick="return getconfirm()"
                        href="'.url('/').'/check_register/'.$exp->incoexpenses_id.'">Allow</a>

                            <a class="btn btn-default btn-xs" href="'.url('/').'/check_register/update/'.$exp->incoexpenses_id.'">Update</a>
                            <a class="btn btn-danger btn-xs"  onclick="return getconfirm()" href="'.url('/').'/check_register/delete/'.$exp->incoexpenses_id.'"></a><br/>';

                              if($exp->khat == "ব্যয়")
                            $data .='<a class="btn btn-info btn-xs" href="'.url('/').'/check_register/print/'.$exp->incoexpenses_id.'" target="_blank">Print</a> <br/></td>';

                    }
                $data .= '</tr>';
	         }
		return $data;


	 }

	 public static function getvattax($sd, $ed, $id){

	     //echo $sd.' ';
	     //echo $ed;
	     $data = ''; $tot = 0;
	     $vatdata = Incoexpense::join('khats','khats.khat_id','=','incoexpenses.khat_id')
	                            ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
	                            ->where('receiver_name', $id)->get();


	     foreach($vatdata as $vd){

	        $data .= '<tr>
	            <td>'. $vd->khat_name.'</td>
	            <td>'. $vd->khat_des.'</td>
	            <td>'. $vd->receive_datwe.'</td>
	            <td align="right">'. $vd->amount.'</td>
	        </tr>';
	        $tot += (float) $vd->amount;
	     }
	     $data .= '<tr>
	            <td colspan="2"></td>
	            <td align="right"><strong>মোট</strong></td>
	            <td align="right"><strong>'. $tot .'</strong></td>
	        </tr>';
	     return $data;
	 }
}



