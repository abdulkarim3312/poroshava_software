<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    //
	static protected $year;
	static protected $upangso;
	static protected $khatid;
	static protected $dueids = array();
	static protected $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
	static protected $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

	protected $guarded = [];

    public function upangsho()
    {
        return $this->belongsTo(Upangsho::class,'upangsho_id','upangsho_id');
    }
    public function taxType()
    {
        return $this->belongsTo(TaxType::class,'khattype_id','tax_id');
    }
    public function taxSubType()
    {
        return $this->belongsTo(TaxTypeType::class,'khtattypetype_id','tax_id');
    }
    public function sector()
    {
        return $this->belongsTo(Khat::class,'khat_id','khat_id');
    }

	public static function getinbudget($upangsho_id, $year, $khatid){

		self::$year = $year;
		self::$upangso = $upangsho_id;
		self::$khatid = $khatid;
		$data=''; $sl=1;

		$khattypes = TaxType::where('sister_concern_id',1)->where('upangsho_id', $upangsho_id)->where('khat_id', $khatid)->get();
//		dd($khattypes);
		foreach($khattypes as $khats){
			if($khats->subormain != 1){
//                dd($khats);
				$data .= '<tr>

					<td align="center">'. str_replace(self::$en, self::$bn, $sl++) .'।</td>
					<td style="text-align:left">'. $khats->tax_name .'</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>'.
				self::getinkhats($khats->khat_id,$khats->tax_id, $upangsho_id);

			}else{
//                 dd($khats);
				$khattypes = Khat::where('sister_concern_id',1)->where('tax_type_id', $khats->tax_id)->first()->khat_id ?? 0;
//                dd($khattypes);
				$data .= '<tr>
					<td align="center">'. str_replace(self::$en, self::$bn, $sl++) .'।</td>
					<td style="text-align:left">'. $khats->tax_name .'</td>';
					$data .=  self::getkhatsbadget($khattypes)
				.'</tr>';

				 if(in_array($khattypes, self::$dueids)){ // for static bokeya calculation 'বকেয়া'

        		    $data .= '<tr>

        				<td></td>
        				<td style="text-align:left">বকেয়া</td>'
        				.self::getkhatsbadgetdue($khattypes);

        			$data .= '</tr>';

        		}
			}
		}
		return $data;
	}


	public static function getinkhats($khatid,$khattaxid,$upangsho_id){

		$data='';
		$khattypes = Khat::where('sister_concern_id',1)->where('upangsho_id',$upangsho_id)->where('khattype', $khatid)->where('tax_type_id', $khattaxid)->get();
		$flag = 0;
//        dd($khatid);
		foreach($khattypes as $khats){
			$tax = TaxTypeType::where('sister_concern_id',1)->where('tax_id', $khats->tax_type_type_id)->first();
			if($khats->tax_type_type_id!=0){
				 if($flag != $khats->tax_type_type_id){
					$data .= '<tr>
						<td></td>
						<td style="text-align:left">'.$tax->serialise.' '.$tax->tax_name2 .'</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>';
					$flag = $khats->tax_type_type_id;
				 }
			}

			$data .= '<tr>

				<td></td>
				<td style="text-align:left">'. $khats->serilas.' '.$khats->khat_name.'</td>'
				.self::getkhatsbadget($khats->khat_id);

			 $data .= '</tr>';

    		 if(in_array($khats->khat_id, self::$dueids)){

    		    $data .= '<tr>

    				<td></td>
    				<td style="text-align:left">বকেয়া</td>'
    				.self::getkhatsbadgetdue($khats->khat_id);

    			$data .= '</tr>';

    		}
		}
		return $data;
	}


	public static function getkhatsbadget($khatid){
		$data='';
		$yr = self::$year;
		$year = explode('-', self::$year);
		$prev_year = ($year[0]-1).'-'.($year[1]-1);
		$next_year = ($year[0]+1).'-'.($year[1]+1);

		$budgets = Budget::where('khat_id', $khatid)->where('year', $yr)->first();
		$prev_budgets = (self::$khatid==1)? self::getaay($khatid, $prev_year) : self::getbaay($khatid, $prev_year);
		$next_budgets = Budget::where('khat_id', $khatid)->where('year', $next_year)->first();


		$data .= '<td align="right">'; if($prev_budgets) $data .=  str_replace(self::$en, self::$bn, $prev_budgets.'.00'); $data .='</td>
		<td align="right">'; if($budgets) $data .=str_replace(self::$en, self::$bn, $budgets->budget_amo.'.00'); $data .='</td>
		<td align="right">'; if($next_budgets) $data .=str_replace(self::$en, self::$bn, $next_budgets->budget_amo.'.00'); $data .='</td>';

		return $data;
	}

	public static function getkhatsbadgetdue($khatid){

		$data='';
		$yr = self::$year;
		$year = explode('-', self::$year);
		$next_year = ($year[0]+1).'-'.($year[1]+1);

		$budgets = Budget::where('khat_id', $khatid)->where('year', $yr)->first();
		$exporinc = (self::$khatid==1)? self::getaay($khatid, $yr) : self::getbaay($khatid, $yr);

		$next_budgets = Budget::where('khat_id', $khatid)->where('year', $next_year)->first();

		$nextexporinc = (self::$khatid==1)? self::getaay($khatid, $next_year) : self::getbaay($khatid, $next_year);

		$data .= '<td align="right"></td>
		<td align="right">'; if($budgets) $data .=str_replace(self::$en, self::$bn, ($budgets->budget_amo - $exporinc).'.00'); $data .='</td>
		<td align="right">'; if($next_budgets) $data .=str_replace(self::$en, self::$bn, ($next_budgets->budget_amo -$nextexporinc).'.00'); $data .='</td>';

		return $data;
	}


	public static function getbudget(){
	    $data='';
	    $badget = Budget::select('*', 'budgets.khat_id')->join('upangshos','upangshos.upangsho_id','=','budgets.upangsho_id')
			->join('khattypes','khattypes.khat_id','=','budgets.inout_id')
			->join('khats','khats.khat_id','=','budgets.khat_id')
		    ->join('tax_types','tax_types.tax_id','=','budgets.khattype_id')->get();


	    foreach($badget as $bdgt){

            $data .= '<tr class="gradeX">

                <td>'.$bdgt->upangsho_name.'</td>
                <td>'.$bdgt->khat.'</td>
                <td>'.$bdgt->tax_name.'</td>
                <td><span id="khatname'.$bdgt->bidget_id.'">'.$bdgt->serilas.$bdgt->khat_name.'</span>
                    <input type="hidden" id="khatid'.$bdgt->bidget_id.'" name="khatid" value="'.$bdgt->khat_id.'">
                </td>
                <td><span id="year'.$bdgt->bidget_id.'"><strong>'. str_replace(self::$en, self::$bn, $bdgt->year).'</strong></span></td>
                <td align="right"><strong>'. str_replace(self::$en, self::$bn, $bdgt->budget_amo.'.00') .'</strong></td>

				<td align="right"><strong>'. str_replace(self::$en, self::$bn, self::getaay($bdgt->khat_id, $bdgt->year).'.00') .'</strong></td>
				<td align="right"><strong>'. str_replace(self::$en, self::$bn, self::getbaay($bdgt->khat_id, $bdgt->year).'.00') .'</strong></td>';
				if($bdgt->inout_id==2){

				    $data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, ($bdgt->budget_amo - self::getbaay($bdgt->khat_id, $bdgt->year)).'.00') .'</strong></td>';
				}else{

				    $data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, ($bdgt->budget_amo - self::getaay($bdgt->khat_id, $bdgt->year)).'.00') .'</strong></td>';
				}
				$data .= '<td>
                    <button class="btn btn-primary btn-xs" onclick="getbudget('.$bdgt->bidget_id.')"><i class="fa fa-pencil"></i></button>
                </td>
            </tr>';
		}
		return $data;

	}

	public static function getaay($khat_id, $year){
	    return Incoexpense::where('inout_id', 1)->where('khat_id', $khat_id)->where('year', $year)->sum('amount');
	}

	public static function getbaay($khat_id, $year){
	    return Incoexpense::where('inout_id', 2)->where('khat_id', $khat_id)->where('year', $year)->where('status', 1)->sum('amount');
	}

	public static function getpendingbudget(){
	    $data='';
	    $badget = BudgetLog::join('khats', 'khats.khat_id', '=', 'budget_logs.khat_id')->where('budget_logs.status', 2)->get();
	    foreach($badget as $bdgt){

            $data .= '<tr class="gradeX">
                <td id="khatname'.$bdgt->bdgtlog_id.'">'.$bdgt->khat_name.'</td>
                <td id="budgetyr'.$bdgt->bdgtlog_id.'">'.$bdgt->year.'</td>
                <td align="right"><strong>'. str_replace(self::$en, self::$bn, $bdgt->amount.'.00') .'</strong></td>
                <td>
                    <button class="btn btn-primary btn-xs" onclick="getupdatebudget('.$bdgt->bdgtlog_id.', '.$bdgt->budget_id.','. $bdgt->amount .')"><i class="fa fa-pencil"></i></button>
                </td>
            </tr>';
		}
		return $data;
	}
}
