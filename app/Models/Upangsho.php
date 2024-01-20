<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upangsho extends Model
{
    protected $primaryKey = 'upangsho_id';
    protected $guarded = [];

    static protected $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
	static protected $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

	static protected $bnm = array("জানুয়ারি","ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্নবর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর");
	static protected $enm = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");

    static protected $ids = '';
    static protected $budget = '';
    static protected $upangsho = '';
    static protected $khat = '';

    static protected $opblce = 100000.55;

    public static function getecoyears($sy){

        $data ='';
        for($i = $sy; $i <= date('y'); $i++){

            $d = '20'. $i .'-'. ($i+1);
            $data .= '<option value="'.$d.'">'. str_replace(self::$en, self::$bn, $d) .'</option>';
        }
        return $data;
    }

    public static function getabstruct($month, $ids){

        self::$ids = $ids;

        $mainheads = TaxType::whereIn('tax_id', self::$ids)->get();

        $expdates = Incoexpense::whereIn('khattype_id', self::$ids)->where('status', 1)->where('date', 'like', $month.'%')->groupBy('date')->orderBy('date')->get();
        $m = explode('-', $month);

        $data = 'মাসঃ '.str_replace(self::$enm, self::$bnm, $m[1]).' '.str_replace(self::$en, self::$bn, $m[0]);

        $data .= '<br>
        <table class="display table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle;">তারিখ</th>';
                    foreach($mainheads as $mh){

                        if($mh->subormain!=1){

                            $data .= '<th style="vertical-align: middle;" colspan="'. self::colspan($mh->tax_id) .'">'. $mh->tax_name .'</th>';
                        }else{

                            $data .= '<th style="vertical-align: middle;" colspan="'. self::colspan($mh->tax_id) .'" rowspan="2">'. $mh->tax_name .'</th>';
                        }
                    }
                    $data .= '</tr><tr>';
                    foreach($mainheads as $mh){

                        if($mh->subormain!=1){

                            $data .= self::getheads($mh->tax_id);
                        }
                    }
                $data .= '<th style="vertical-align: middle;">মোট</th></tr>
            </thead>
            <tbody>';

                $grandtotal = 0;
                foreach($expdates as $ed){

                    $daytotal = 0;
                    $data .= '<tr><td>'. str_replace(self::$en, self::$bn, date('d/m/Y', strtotime($ed->date))) .'</td>';
                    foreach($mainheads as $mh){

                        $data .= self::getrows($mh->tax_id, $ed->date);
                        $daytotal += self::getrowtotal($mh->tax_id, $ed->date);
                        $grandtotal += self::getrowtotal($mh->tax_id, $ed->date);
                    }
                    $data .= '<td align="right">'. str_replace(self::$en, self::$bn, number_format($daytotal, 2)) .'</td></tr>';
                }


                $data .= '<tr><td>মোট</td>';
                foreach($mainheads as $mh){
                    $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
                    foreach($khats as $kt){

                        $data .= '<td align="right">'.self::getTotal($kt->khat_id, $month).'</td>';

                    }

                }
                $data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($grandtotal, 2)) .'</strong></td></tr>';

                $data .= '<tr><td>গত মাসের জের</td>';
                $grandtotalpre = 0;
                foreach($mainheads as $mh){
                    $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
                    foreach($khats as $kt){

                        $data .= '<td align="right">'. str_replace(self::$en, self::$bn, number_format((float)self::getPrevTotal($kt->khat_id, $month),2)).'</td>';
                        $grandtotalpre += (float)self::getPrevTotal($kt->khat_id, $month);
                    }
                }
                $data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($grandtotalpre, 2)) .'</strong></td></tr>';

                $data .= '<tr><td>সর্ব মোট</td>';
                $grandtotalfinal = 0;
                foreach($mainheads as $mh){
                    $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
                    foreach($khats as $kt){

                        $data .= '<td align="right">'. str_replace(self::$en, self::$bn, number_format(self::getGrandTotal($kt->khat_id, $month),2)).'</td>';
                        $grandtotalfinal += self::getGrandTotal($kt->khat_id, $month);
                    }
                }
                $data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($grandtotalfinal, 2)) .'</strong></td></tr>';
            $data .= '</tbody>
        </table><div class="col-md-12" style="padding-top:100px">
    	  <div class="row" style="float: left;width: 100%;">

                            <table width="100%">

                                <tr>

                                    <td width="25%" style="text-align:center">  হিসাব রক্ষক <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center">  হিসাব রক্ষণ কর্মকর্তা  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> মেয়র <br/>  ফরিদপুর পৌরসভা </td>
                                </tr>
                            </table>


                        </div>';

        return $data;
    }

    protected static function colspan($id){

        return Khat::where('tax_type_id', $id)->count();
    }

    protected static function getheads($id){

        $data ='';
        $khats = Khat::where('tax_type_id', $id)->get();
        foreach($khats as $kt){

             $data .= '<th style="vertical-align: middle;">'. $kt->khat_name .'</th>';
        }
        return $data;
    }

    protected static function getrows($id, $date){

        $data ='';
        $khats = Khat::where('tax_type_id', $id)->get();
        foreach($khats as $kt){

             $data .= '<td align="right">'.  str_replace(self::$en, self::$bn, number_format((float)self::getamount($kt->khat_id, $date),2)).'</td>';
        }
        return $data;
    }

    protected static function getrowtotal($id, $date){

        $data = 0;
        $khats = Khat::where('tax_type_id', $id)->get();
        foreach($khats as $kt){

             $data += (float)self::getamount($kt->khat_id, $date);
        }
        return $data;
    }

    protected static function getamount($id, $date){
       $vattaxamnt=0;

        $amnt = Incoexpense::where('khat_id', $id)->where('date', $date)->where('status', 1)->sum('amount');
        if($amnt==0){ $amnt=''; }else{
            $incoexpensesids = Incoexpense::where('khat_id', $id)->where('date', $date)->where('status', 1)->get();
            foreach($incoexpensesids as $exinid){

                $vattax = Incoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $date);
                if($vattax->count() > 0){ $vattaxamnt += $vattax->sum('amount'); }else{ $vattaxamnt = 0; }
            }


            $amnt = $amnt + $vattaxamnt;
        }
        return $amnt;
    }

    protected static function getTotal($id, $month){
        $vattaxamnt=0;
        $amnt = Incoexpense::where('khat_id', $id)->where('date', 'like', $month.'%')->where('status', 1)->sum('amount');
        if($amnt!=0){
            $incoexpensesids = Incoexpense::where('khat_id', $id)->where('date', 'like', $month.'%')->where('status', 1)->get();
            foreach($incoexpensesids as $exinid){

                $vattax = Incoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $exinid->date);
                if($vattax->count() > 0){ $vattaxamnt += $vattax->sum('amount'); }else{ $vattaxamnt = 0; }
            }
            $amnt = number_format($amnt + $vattaxamnt, 2);

        } return str_replace(self::$en, self::$bn, $amnt);
    }

    protected static function getPrevTotal($id, $month){
        $vattaxamnt=0;
        $m = explode('-', $month)[1]; $y = explode('-', $month)[0];

        if($m != '07'){

            $to = date('Y-m-t', strtotime($y.'-'.$m.'-01 -1 month'));

            //echo $to; exit;

            if($m <= '06') { $y--; }
            $from = $y.'-07-01'; //die();
            $amnt = Incoexpense::where('khat_id', $id)->where('status', 1)->whereBetween('date', [$from, $to])->sum('amount');


            $incoexpensesids = Incoexpense::where('khat_id', $id)->whereBetween('date', [$from, $to])->where('status', 1)->get();
            foreach($incoexpensesids as $exinid){

                $vattax = Incoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $exinid->date);
                if($vattax->count() > 0){ $vattaxamnt += $vattax->sum('amount'); }else{ $vattaxamnt = 0; }
            }
            $amnt = $amnt + $vattaxamnt;

            return $amnt;

        }else{

            return '';
        }
    }

    protected static function getGrandTotal($id, $month){
        $vattaxamnt=0;
        $m = explode('-', $month)[1]; $y = explode('-', $month)[0];

        $to = date('Y-m-t', strtotime($y.'-'.$m.'-01'));
        //echo $to; exit;
        if($m <= '06') { $y--; }
        $from = $y.'-07-01'; //die();
        $amnt = Incoexpense::where('khat_id', $id)->where('status', 1)->whereBetween('date', [$from, $to])->sum('amount');
        $incoexpensesids = Incoexpense::where('khat_id', $id)->whereBetween('date', [$from, $to])->where('status', 1)->get();
        foreach($incoexpensesids as $exinid){

            $vattax = Incoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $exinid->date);
            if($vattax->count() > 0){ $vattaxamnt += $vattax->sum('amount'); }else{ $vattaxamnt = 0; }
        }
        $amnt = $amnt + $vattaxamnt;
        return $amnt;

    }

    // badget control register------------------------------------------------------------------------------------------------------------------->

    public static function getBadgetRegister($upangsho, $khat, $yaer){

        self::$upangsho = $upangsho; self::$khat = $khat; $data='';$i=1; $totamount=0;

        $budget = Budget::where('khat_id', $khat)->where('year', $yaer);
        if($budget->count() != null ){

            self::$budget = $budget = $budget->first()->budget_amo;
            $khatexpenses = Incoexpense::where('khat_id', $khat)->where('year', $yaer)->get();
            foreach($khatexpenses as $kex){

                $data .= '<tr>
                    <td align="right">'. str_replace(self::$en, self::$bn, $i++) .'</td>
                    <td>'. str_replace(self::$en, self::$bn, date('d-m-Y', strtotime($kex->date))) .'</td>
                    <td>'. $kex->khat_des .'</td>
                    <td align="right">'. str_replace(self::$en, self::$bn, $budget) .'</td>
                    <td align="right">'. str_replace(self::$en, self::$bn, $kex->amount) .'</td>
                    <td align="right">'; $totamount += (int)$kex->amount; $data .= str_replace(self::$en, self::$bn, $totamount).'</td>
                    <td align="right">'; $budget -= (int)$kex->amount; $data .= str_replace(self::$en, self::$bn, $budget).'</td>
                    <td>'. $kex->note.'</td>
                </tr>';
            }
        }
        return $data;

    }

    public static function getBadget(){

        return self::$budget;
    }

    public static function getKhatNupangsho(){


        $upangsho = self::where('upangsho_id', self::$upangsho)->first()->upangsho_name;
        $khat = Khat::where('khat_id', self::$khat)->first();
        $khatserial = $khat->serilas;
        $khatname = $khat->khat_name;
        return $upangsho.', বাজেট খাত :'.$khatserial.' '.$khatname;
    }

	public static function balancegenarate($upang, $sd){

	    $aay = Incoexpense::where('upangsho_id', $upang)->where('inout_id', 1)->where('receive_datwe', '<', $sd)->sum('amount');
        // dd($aay);
	    $aay += BankDetails::where('upangsho_id', $upang)->sum('open_balance');
        // dd($aay);
	    $bay = Incoexpense::where('upangsho_id', $upang)->where('inout_id', 2)->where('status', 1)->where('receive_datwe', '<', $sd)->sum('amount');
        // dd($bay);
    	$opening = $aay - $bay;
        // dd($opening);
	    return $opening;
	}

	public static function getBalancesheet($upang, $sd, $ed){

	    $balance = self::balancegenarate($upang, $sd);

	    //echo  $upangsho.' '.$khat.' '.$sd.' '.$ed; exit;

	    if($upang!=''){

	        $getIncoms =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                ->where('incoexpenses.upangsho_id', $upang)
                ->where('inout_id', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();

                $getExpenses =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
    	        ->where('incoexpenses.upangsho_id', $upang)
    	        ->where('inout_id', 2)
    	        ->where('incoexpenses.status', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();
	    }else{

	        $getIncoms =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')

                ->where('inout_id', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();

    	    $getExpenses =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
    	        ->where('inout_id', 2)
    	        ->where('incoexpenses.status', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();
	    }
	    $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
	    $incnt =  $getIncoms->count(); $excnt = $getExpenses->count();
	    $diff = $incnt - $excnt;
	    for($i=0; $i<abs($diff); $i++){
	        if($incnt<$excnt){ $incomeblankrows .= '<tr><td>-</td><td></td><td></td></tr>'; }else{ $expeneblankrows .= '<tr><td>-</td><td><td></td></td></tr>';  }
	    }
	    $data = '<table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রঃ নং </th>
        	        <th> খাত </th>
        	        <th> আয়  </th>
        	    </tr>
        	</thead>
        	<tbody>';
	    $inamnt = 0; $examnt = 0;
	    foreach($getIncoms as $getIncom){

	       $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $in++) .'</td>
	            <td>'. $getIncom->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespense($getIncom->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

	       $inamnt += self::getkhatincomeespense($getIncom->khat_id, $sd, $ed);
	    }
	    $inandbal = $inamnt + $balance;
	    $data .= $incomeblankrows.'<tr>
        	            <td></td>
        	            <td align="right"><strong>মোট আয়</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inamnt,2)) .'</strong></td>
        	        </tr>
        	        <tr>
        	            <td></td>
        	            <td align="right"><strong>প্রারম্ভিক স্থিতি</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($balance,2)) .'</strong></td>
        	       </tr>
        	        <tr>
        	            <td></td>
        	            <td align="right"><strong>সর্বমোট</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inandbal,2)) .'</strong></td>
        	        </tr>
    	        </tbody>
	        </table>
	        <table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রঃ নং </th>
        	        <th> খাত </th>
        	        <th> ব্যায়  </th>
        	    </tr>
        	</thead>
        	<tbody>';


	    foreach($getExpenses as $getExpen){

	       $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $ex++) .'</td>
	            <td>'. $getExpen->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespense($getExpen->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

	       $examnt += self::getkhatincomeespense($getExpen->khat_id, $sd, $ed);
	    }
	    if($inandbal < $examnt){ $bal = $examnt - $inandbal; $sign = '-'; }else{ {$bal = $inandbal - $examnt; $sign = '+'; }}
	    //$bal = $inandbal - $examnt;
	    $data .= $expeneblankrows.'
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>মোট ব্যয় </strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt,2)) .'</strong></td>
    	        </tr>
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>সমাপনী স্থিতি</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($bal, 2)) .'</strong></td>
    	        </tr>
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>সর্বমোট</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt+$bal,2)) .'</strong></td>
    	        </tr>
    	   </tbody>
    	</table><div class="col-md-12 col-sm-12" style="padding-top:150px">
    	  <div class="row" style="float: left;width: 100%;padding-top: 108px;">

                            <table width="100%">

                                <tr>

                                    <td width="25%" style="text-align:center">  হিসাব রক্ষক <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center">  হিসাব রক্ষণ কর্মকর্তা  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> মেয়র <br/>  ফরিদপুর পৌরসভা </td>
                                </tr>
                            </table>


                        </div>';

	    return $data;

	}








	public static function getDailyBalancesheet($upang, $sd, $ed){

	    $balance = self::balancegenarate($upang, $sd);

	    //echo  $upangsho.' '.$khat.' '.$sd.' '.$ed; exit;

	    if($upang!=''){

	        $getIncoms =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                ->where('incoexpenses.upangsho_id', $upang)
                ->where('inout_id', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();

                $getExpenses =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
    	        ->where('incoexpenses.upangsho_id', $upang)
    	        ->where('inout_id', 2)
    	        ->where('incoexpenses.status', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();
	    }else{

	        $getIncoms =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')

                ->where('inout_id', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();

    	    $getExpenses =
    	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
    	        ->where('inout_id', 2)
    	        ->where('incoexpenses.status', 1)
                ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                ->groupBy('incoexpenses.khat_id')
                ->get();
	    }
	    $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
	    $incnt =  $getIncoms->count(); $excnt = $getExpenses->count();
	    $diff = $incnt - $excnt;
	    for($i=0; $i<abs($diff); $i++){
	        if($incnt<$excnt){ $incomeblankrows .= '<tr><td>-</td><td></td><td></td></tr>'; }else{ $expeneblankrows .= '<tr><td>-</td><td><td></td></td></tr>';  }
	    }
	    $data = '<table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রঃ নং </th>
        	        <th> খাত </th>
        	        <th> আয়  </th>
        	    </tr>
        	</thead>
        	<tbody>';
	    $inamnt = 0; $examnt = 0;
	    foreach($getIncoms as $getIncom){

	       $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $in++) .'</td>
	            <td>'. $getIncom->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespense($getIncom->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

	       $inamnt += self::getkhatincomeespense($getIncom->khat_id, $sd, $ed);
	    }
	    $inandbal = $inamnt + $balance;
	    $data .= $incomeblankrows.'<tr>
        	            <td></td>
        	            <td align="right"><strong>দৈনিক  মোট আয়</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inamnt,2)) .'</strong></td>
        	        </tr>
        	        <tr>
        	            <td></td>
        	            <td align="right"><strong>প্রারম্ভিক স্থিতি</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($balance,2)) .'</strong></td>
        	       </tr>
        	        <tr>
        	            <td></td>
        	            <td align="right"><strong>সর্বমোট</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inandbal,2)) .'</strong></td>
        	        </tr>
    	        </tbody>

	        </table>
	        <table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রঃ নং </th>
        	        <th> খাত </th>
        	        <th> ব্যায়  </th>
        	    </tr>
        	</thead>
        	<tbody>';


	    foreach($getExpenses as $getExpen){

	       $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $ex++) .'</td>
	            <td>'. $getExpen->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespense($getExpen->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

	       $examnt += self::getkhatincomeespense($getExpen->khat_id, $sd, $ed);
	    }
	    if($inandbal < $examnt){ $bal = $examnt - $inandbal; $sign = '-'; }else{ {$bal = $inandbal - $examnt; $sign = '+'; }}
	    $data .= $expeneblankrows.'
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>দৈনিক  মোট ব্যয় </strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt,2)) .'</strong></td>
    	        </tr>
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>সমাপনী স্থিতি</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($bal, 2)) .'</strong></td>
    	        </tr>
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>সর্বমোট</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt+$bal,2)) .'</strong></td>
    	        </tr>
    	   </tbody>
    	</table>
     <div class="row" style="float: left;width: 100%;padding-top: 108px;">

                            <table width="100%">

                                <tr>

                                    <td width="25%" style="text-align:center">  হিসাব রক্ষক <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center">  হিসাব রক্ষণ কর্মকর্তা  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> মেয়র <br/>  ফরিদপুর পৌরসভা </td>
                                </tr>
                            </table>


                        </div>';

	    return $data;

	}













	public static function getkhatincomeespense($id, $sd, $ed){

	    return Incoexpense::where('khat_id', $id)->where('status', 1)->whereBetween('receive_datwe', [$sd, $ed])->sum('amount');

	}

	public static function getkhatincomeespenseAcc($id, $kid, $sd, $ed){

	    return Incoexpense::where('acc_no', $id)->where('khat_id', $kid)->where('status', 1)->whereBetween('receive_datwe', [$sd, $ed])->sum('amount');
	}

	public static function accBalancegenarate($upang, $sd){

	    $aay = Incoexpense::where('acc_no', $upang)->where('inout_id', 1)->where('receive_datwe', '<', $sd)->sum('amount');
	    $aay += BankDetails::where('bank_details_id', $upang)->sum('open_balance');
	    $bay = Incoexpense::where('acc_no', $upang)->where('inout_id', 2)->where('status', 1)->where('receive_datwe', '<', $sd)->sum('amount');
    	$opening = $aay - $bay;

	    return $opening;
	}

	public static function getAccBalancesheet($upang, $sd, $ed){

	    $balance = self::accBalancegenarate($upang, $sd);


        $getIncoms =
	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
            ->where('incoexpenses.acc_no', $upang)
            ->where('inout_id', 1)
            ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
            ->groupBy('incoexpenses.khat_id')
            ->get();

        $getExpenses =
	        Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
	        ->where('incoexpenses.acc_no', $upang)
	        ->where('inout_id', 2)
	        ->where('incoexpenses.status', 1)
            ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
            ->groupBy('incoexpenses.khat_id')
            ->get();

	    $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
	    $incnt =  $getIncoms->count();
	    $excnt = $getExpenses->count();
	    $diff = $incnt - $excnt;

	    for($i=0; $i<abs($diff); $i++){
	        if($incnt<$excnt){ $incomeblankrows .= '<tr><td>-</td><td></td><td></td></tr>'; }else{ $expeneblankrows .= '<tr> <td style="height:80px;"> </td> <td style="height:80px;"> </td> <td style="height:80px;"> </td></tr>';  }
	    }

	    $data = '<style> .table td{ height:65px; }</style><table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রঃনং </th>
        	        <th> খাত </th>
        	        <th> আয়  </th>
        	    </tr>
        	</thead>
        	<tbody>';

	    $inamnt = 0; $examnt = 0;

	    foreach($getIncoms as $getIncom){

	       $data .= '<tr>
	            <td style="height:80px;">'. str_replace(self::$en, self::$bn, $in++) .'</td>
	            <td style="height:80px;">'. $getIncom->khat_name .'</td>
	            <td style="height:80px;" align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespenseAcc($getIncom->acc_no, $getIncom->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

	       $inamnt += self::getkhatincomeespenseAcc($getIncom->acc_no, $getIncom->khat_id, $sd, $ed);
	    }

	    $inandbal = $inamnt + $balance;

	    $data .= $incomeblankrows.'
        	        <tr>
        	            <td style="height:80px;"></td>
        	            <td style="height:80px;" align="right"><strong>মোট আয়</strong></td>
        	            <td style="height:80px;" align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inamnt,2)) .'</strong></td>
        	        </tr>
        	        <tr>
        	            <td style="height:80px;"></td>
        	            <td style="height:80px;" align="right"><strong>প্রারম্ভিক স্থিতি</strong></td>
        	            <td style="height:80px;" align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($balance,2)) .'</strong></td>
        	       </tr>
        	        <tr>
        	            <td style="height:80px;"></td>
        	            <td style="height:80px;" align="right"><strong>সর্বমোট</strong></td>
        	            <td style="height:80px;" align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inandbal,2)) .'</strong></td>
        	        </tr>
    	        </tbody>
	        </table>
	        <table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রঃনং </th>
        	        <th> খাত </th>
        	        <th> ব্যায়  </th>
        	    </tr>
        	</thead>
        	<tbody>';


	    foreach($getExpenses as $getExpen){

	       $data .= '<tr>
	            <td style="height:80px;">'. str_replace(self::$en, self::$bn, $ex++) .'</td>
	            <td style="height:80px;">'. $getExpen->khat_name .'</td>
	            <td style="height:80px;" align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespenseAcc($getExpen->acc_no, $getExpen->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

	       $examnt += self::getkhatincomeespenseAcc($getExpen->acc_no, $getExpen->khat_id, $sd, $ed);
	    }
	    if($inandbal < $examnt){ $bal = $examnt - $inandbal; $sign = '-'; }else{ {$bal = $inandbal - $examnt; $sign = ''; }}
	    $data .= $expeneblankrows.'
    	        <tr>
    	            <td style="height:80px;"></td>
    	            <td style="height:80px;" align="right"><strong>মোট ব্যয় </strong></td>
    	            <td style="height:80px;" align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt,2)) .'</strong></td>
    	        </tr>
    	        <tr>
    	            <td style="height:80px;"></td>
    	            <td style="height:80px;" align="right"><strong>সমাপনী স্থিতি</strong></td>
    	            <td style="height:80px;" align="right"><strong>'.$sign.' '. str_replace(self::$en, self::$bn, number_format($bal, 2)) .'</strong></td>
    	        </tr>
    	        <tr>
    	            <td style="height:80px;"></td>
    	            <td style="height:80px;" align="right"><strong>সর্বমোট</strong></td>
    	            <td style="height:80px;" align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inandbal,2)) .'</strong></td>
    	        </tr>
    	   </tbody>
        </table>


                        <div class="row" style="float: left;width: 100%;padding-top: 108px;">

                            <table width="100%">

                                <tr>

                                    <td width="25%" style="text-align:center">  হিসাব রক্ষক <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center">  হিসাব রক্ষণ কর্মকর্তা  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> মেয়র <br/>  ফরিদপুর পৌরসভা </td>
                                </tr>
                            </table>


                        </div>


                        ';

	    return $data;

	}



	// daily abstruct ----------------------------------------------------------------------------------------------------------------------------------->>>>


	public static function getDailyAbstruct($from, $to, $ids, $preids = '') {

        self::$ids = $ids;

        $mainheads = TaxType::whereIn('tax_id', self::$ids)->get();

        // $expdates = Incoexpense::whereIn('khattype_id', self::$ids)->where('status', 1)->where('date', 'like', $month.'%')->groupBy('date')->orderBy('date')->get();

        $expdates = Incoexpense::whereIn('khattype_id', self::$ids)->where('status', 1)->whereBetween('date', [$from, $to])->orderBy('date')->get();

        $month = $from;
        //$m = explode('-', $month);

        //$data = ' তারিখঃ '.str_replace(self::$enm, self::$bnm, $m[1]).' '.str_replace(self::$en, self::$bn, $m[0]);

        $data = ' তারিখঃ '.$from.' হতে  '.$to;

        $data .= '<br>
        <table class="display table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle;">তারিখ</th>';
                    foreach($mainheads as $mh) {

                        if($mh->subormain!=1) {
                            $data .= '<th style="vertical-align: middle;" colspan="'. self::colspan($mh->tax_id) .'">'. $mh->tax_name .'</th>';
                        }else{
                            $data .= '<th style="vertical-align: middle;" colspan="'. self::colspan($mh->tax_id) .'" rowspan="2">'. $mh->tax_name .'</th>';
                        }
                    }
                    $data .= '<th></th></tr><tr>';
                    foreach($mainheads as $mh) {
                        if($mh->subormain!=1) {
                            $data .= self::getheads($mh->tax_id);
                        }
                    }
                $data .= '<th style="vertical-align: middle;">মোট</th></tr>
            </thead>
            <tbody>';

                $grandtotal = 0;
                foreach($expdates as $ed) {

                    $daytotal = 0;
                    $data .= '<tr><td>'. str_replace(self::$en, self::$bn, date('d/m/Y', strtotime($ed->date))) .'</td>';
                    foreach($mainheads as $mh){

                        $data .= self::getrows1($ed->incoexpenses_id, $mh->tax_id, $ed->date);
                        $daytotal += self::getrowtotal1($ed->incoexpenses_id, $mh->tax_id, $ed->date);
                        $grandtotal += self::getrowtotal1($ed->incoexpenses_id, $mh->tax_id, $ed->date);
                    }
                    $data .= '<td align="right">'. str_replace(self::$en, self::$bn, number_format($daytotal, 2)) .'</td></tr>';
                }


                $data .= '<tr><td>মোট</td>';
                foreach($mainheads as $mh){
                    $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
                    foreach($khats as $kt){

                        $data .= '<td align="right">'.self::getTotal1($kt->khat_id, $month).'</td>';
                    }

                }
                $data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($grandtotal, 2)) .'</strong></td></tr>';

                if($preids!=''){

                    $expdates0 = Incoexpense::whereIn('khattype_id', $preids)->where('status', 1)->whereBetween('date', [$from, $to])->orderBy('date')->get();
                    $mainheads0 = TaxType::whereIn('tax_id', $preids)->get();

                    $grandtotal0 = 0;
                    foreach($expdates0 as $ed0) {
                        foreach($mainheads0 as $mh0){
                            $grandtotal0 += self::getrowtotal1($ed0->incoexpenses_id, $mh0->tax_id, $ed0->date);
                        }
                    }
                    $cnt=0;
                    $data .= '<tr><td>সর্বমোট</td>';
                    foreach($mainheads as $mh){
                        $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
                        foreach($khats as $kt){

                            $cnt++;
                        }

                    }

                    $tot = $grandtotal0+$grandtotal;
                    $data .= '<td align="right" colspan="'. $cnt .'">'. str_replace(self::$en, self::$bn, number_format($grandtotal0, 2)) .' +
                        '. str_replace(self::$en, self::$bn, number_format($grandtotal, 2)) .' =</td>
                    <td align="right"><strong>


                        '. str_replace(self::$en, self::$bn, number_format($tot, 2)) .'

                    </strong></td></tr>';
                }

                //$data .= '<tr><td>গত মাসের জের</td>';
                $grandtotalpre = 0;
                foreach($mainheads as $mh){
                    $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
                    foreach($khats as $kt){

                        //$data .= '<td align="right">'. str_replace(self::$en, self::$bn, number_format((float)self::getPrevTotal($kt->khat_id, $month),2)).'</td>';
                        $grandtotalpre += (float)self::getPrevTotal($kt->khat_id, $month);
                    }
                }
                //$data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($grandtotalpre, 2)) .'</strong></td></tr>';

                //$data .= '<tr><td>সর্ব মোট</td>';
                $grandtotalfinal = 0;
                foreach($mainheads as $mh){
                    $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
                    foreach($khats as $kt){

                        $grandtotalfinal += self::getGrandTotal($kt->khat_id, $month);
                    }
                }
                //$data .= '<td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($grandtotalfinal, 2)) .'</strong></td></tr>';
            $data .= '</tbody>
        </table>';

        return $data;
    }


	protected static function getrows1($inexid, $id, $date) {

        $data ='';
        $khats = Khat::where('tax_type_id', $id)->get();
        foreach($khats as $kt){

             $data .= '<td align="right">';
             if(self::getamount1($inexid, $kt->khat_id, $date) !='')
             $data .=str_replace(self::$en, self::$bn, number_format((float)self::getamount1($inexid, $kt->khat_id, $date),2)).'</td>';
        }
        return $data;
    }

    protected static function getamount1($inexid, $id, $date) {

        $vattaxamnt=0;

        $amnt = Incoexpense::where('khat_id', $id)->where('date', $date)->where('incoexpenses_id', $inexid)->where('status', 1)->first();
        if(!empty($amnt)){ $amnt=$amnt->amount; }else{

            $incoexpensesids = Incoexpense::where('khat_id', $id)->where('date', $date)->where('status', 1)->get();
            foreach($incoexpensesids as $exinid){

                $vattax = Incoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $date);
                if($vattax->count() > 0){ $vattaxamnt += $vattax->sum('amount'); }else{ $vattaxamnt = 0; }
            }


            $amnt = $amnt + $vattaxamnt;
        }
        return $amnt;
    }

    protected static function getTotal1($id, $month){
        $vattaxamnt=0;
        $amnt = Incoexpense::where('khat_id', $id)->where('date', 'like', $month.'%')->where('status', 1)->sum('amount');
        if($amnt!=0){
            $incoexpensesids = Incoexpense::where('khat_id', $id)->where('date', 'like', $month.'%')->where('status', 1)->get();
            foreach($incoexpensesids as $exinid){

                $vattax = Incoexpense::where('vat_tax_status', $exinid->incoexpenses_id)->where('date', $exinid->date);
                if($vattax->count() > 0){ $vattaxamnt += $vattax->sum('amount'); }else{ $vattaxamnt = 0; }
            }
            $amnt = number_format($amnt + $vattaxamnt, 2);

        } return str_replace(self::$en, self::$bn, $amnt);
    }

    protected static function getrowtotal1($inexid, $id, $date){

        $data = 0;
        $khats = Khat::where('tax_type_id', $id)->get();
        foreach($khats as $kt){

             $data += (float)self::getamount1($inexid, $kt->khat_id, $date);
        }
        return $data;
    }

    public static function get_recptlist($upang, $sd, $ed){

        $balance = self::balancegenarate($upang, $sd);

        //echo  $upangsho.' '.$khat.' '.$sd.' '.$ed; exit;

        if($upang!=''){

            $getIncoms =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                    ->join('bank_details','bank_details.bank_details_id','=','incoexpenses.acc_no')
                    ->join('banks','banks.bank_id','=','incoexpenses.bank_id')
                    ->where('incoexpenses.upangsho_id', $upang)
                    ->where('inout_id', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                   // ->groupBy('incoexpenses.khat_id')
                    ->get();

            $getExpenses =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                    ->join('bank_details','bank_details.bank_details_id','=','incoexpenses.acc_no')
                    ->join('banks','banks.bank_id','=','incoexpenses.bank_id')
                    ->where('incoexpenses.upangsho_id', $upang)
                    ->where('inout_id', 2)
                    ->where('incoexpenses.status', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    //->groupBy('incoexpenses.khat_id')
                    ->get();
        }else{

            $getIncoms =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                    ->join('bank_details','bank_details.bank_details_id','=','incoexpenses.acc_no')
                    ->join('banks','banks.bank_id','=','incoexpenses.bank_id')
                    ->where('inout_id', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    //->groupBy('incoexpenses.khat_id')
                    ->get();

            $getExpenses =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                    ->join('bank_details','bank_details.bank_details_id','=','incoexpenses.acc_no')
                    ->join('banks','banks.bank_id','=','incoexpenses.bank_id')
                    ->where('inout_id', 2)
                    ->where('incoexpenses.status', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    //->groupBy('incoexpenses.khat_id')
                    ->get();
        }
        $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
        $incnt =  $getIncoms->count(); $excnt = $getExpenses->count();
        $diff = $incnt - $excnt;
        for($i=0; $i<abs($diff); $i++){
            if($incnt<$excnt){ $incomeblankrows .= '<tr><td>-<br>-</td><td></td><td></td><td></td><td></td></tr>'; }else{ $expeneblankrows .= '<tr><td>-<br>-</td><td></td><td></td><td></td><td></td><td></td></tr>';  }
        }
        $data = '<div class="row"><div class="col-md-6 " style="margin-bootom:5px"><span><strong>ডেবিট(প্রাপ্তি) </strong></span></div> <div class="col-md-6" style="text-align: right; margin-bootom:5px" ><span><strong> ক্রেডিট (পরিশোধ)</strong></span></div></div>
		<table class="table table-bordered" style="width:45%; margin:0px; float:left; border:1px solid #000" id="my Table">

			<thead>

        	    <tr>

        	        <th> তারিখ  </th>
        	        <th> খাত </th>
        	        <th> টাকার পরিমান </th>
        	        <th> চেক নং  </th>
        	        <th> ব্যাংকের   নাম ও হিসাব নং </th>

        	    </tr>
        	</thead>
        	<tbody>';
        $inamnt = 0; $examnt = 0;
        foreach($getIncoms as $getIncom){

            $data .= '<tr>

	            <td>'. str_replace(self::$en, self::$bn, $getIncom->receive_datwe) .'</td>

	            <td>'. $getIncom->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format($getIncom->amount)) .'</td>
	            <td>'. $getIncom->check_no .'</td>
	             <td>'. $getIncom->bank_name .  $getIncom->acc_no. '</td>
	       </tr>';

            $inamnt += $getIncom->amount;
        }
        $inandbal = $inamnt + $balance;
        $data .= $incomeblankrows.'<tr>

        	            <td></td>




        	            <td align="right"><strong>মোট আয়</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inamnt,2)) .'</strong></td>
        	             <td></td>
        	            <td></td>
        	        </tr>
        	        <tr>

        	            <td></td>


        	            <td align="right"><strong>প্রারম্ভিক স্থিতি</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($balance,2)) .'</strong></td>
        	              <td></td>
        	             <td></td>
        	       </tr>
        	        <tr>

        	            <td></td>



        	            <td align="right"><strong>সর্বমোট</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inandbal,2)) .'</strong></td>
        	             <td></td>
        	         <td></td>
        	        </tr>
    	        </tbody>
	        </table>
	        <table class="table table-bordered" style="width:55%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>

        	    <tr>

        	        <th> তারিখ </th>
        	        <th> খাত </th>
        	        <th>  ভাউচার নং</th>
					<th>  চেক নং </th>
        	        <th>  টাকার পরিমান</th>

        	        <th>  ব্যাংকের   নাম ও হিসাব নং</th>
        	    </tr>
        	</thead>
        	<tbody>';


        foreach($getExpenses as $getExpen){

            $data .= '<tr>




	            <td style="border: 1px solid #000;">'. str_replace(self::$en, self::$bn,  $getExpen->receive_datwe) .'</td>
	            <td style="border: 1px solid #000;">'. $getExpen->khat_name .'</td>
	            <td style="border: 1px solid #000;" >'. $getExpen->vourcher_no .'</td>
	            <td style="border: 1px solid #000;">'. $getExpen->check_no .'</td>
	            <td style="border: 1px solid #000;"  align="right">'. str_replace(self::$en, self::$bn, number_format($getExpen->amount)) .'</td>

	             <td style="border: 1px solid #000;">'. $getExpen->bank_name .  $getExpen->acc_no. '</td>
	       </tr>';

            $examnt += $getExpen->amount;
        }
        if($inandbal < $examnt){ $bal = $examnt - $inandbal; $sign = '-'; }else{ {$bal = $inandbal - $examnt; $sign = '+'; }}
        $data .= $expeneblankrows.'
    	        <tr>

        	            <td></td>
        	            <td></td>
        	            <td></td>

    	            <td align="right"><strong>মোট ব্যয় </strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt,2)) .'</strong></td>
    	             <td></td>

    	        </tr>
    	        <tr>

        	            <td></td>
        	            <td></td>
        	            <td></td>
    	            <td align="right"><strong>সমাপনী স্থিতি</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($bal, 2)) .'</strong></td>
    	              <td></td>


    	        </tr>
    	        <tr>

    	            <td style="border: 1px solid #000;"></td>
    	            <td style="border: 1px solid #000;"></td>
    	          <td style="border: 1px solid #000;"></td>
    	            <td style="border: 1px solid #000;" align="right"><strong>সর্বমোট</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt+$bal,2)) .'</strong></td>
    	              <td style="border: 1px solid #000;"></td>

    	        </tr>
    	   </tbody>
    	</table>

		<div class="row" style="float: left;width: 100%;padding-top: 108px;">

                            <table width="100%">

                                <tr>

                                    <td width="25%" style="text-align:center">  হিসাব রক্ষক <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center">  হিসাব রক্ষন  কর্মকর্তা  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> মেয়র <br/>  ফরিদপুর পৌরসভা </td>
                                </tr>
                            </table>


                        </div>';

        return $data;

    }

    public static function getBalancesheetYearly($upang, $sd, $ed){

        $balance = self::balancegenarate($upang, $sd);
       
        //echo  $upangsho.' '.$khat.' '.$sd.' '.$ed; exit;

        if($upang!=''){
           
            $getIncoms =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                    ->where('incoexpenses.upangsho_id', $upang)
                    ->where('inout_id', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    ->groupBy('incoexpenses.khat_id')
                    ->get();
                    // dd($getIncoms);
            foreach ($getIncoms as $income) {
                $budget = Budget::where('khat_id', $income->khat_id)
                    ->where('year', '2019-20')
                    ->first();

                $income->budget = $budget ? $budget->budget_amo : 0;
            }

            $getExpenses =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                    ->where('incoexpenses.upangsho_id', $upang)
                    ->where('inout_id', 2)
                    ->where('incoexpenses.status', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    ->groupBy('incoexpenses.khat_id')
                    ->get();

            foreach ($getExpenses as $expense) {
                $budget = Budget::where('khat_id', $expense->khat_id)
                    ->where('year', '2019-20')
                    ->first();

                $expense->budget = $budget ? $budget->budget_amo : 0;
            }
        }else{

            $getIncoms =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')

                    ->where('inout_id', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    ->groupBy('incoexpenses.khat_id')
                    ->get();

            $getExpenses =
                Incoexpense::join('khats', 'khats.khat_id', '=', 'incoexpenses.khat_id')
                    ->where('inout_id', 2)
                    ->where('incoexpenses.status', 1)
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    ->groupBy('incoexpenses.khat_id')
                    ->get();
        }
        $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
        $incnt =  $getIncoms->count(); $excnt = $getExpenses->count();
        $diff = $incnt - $excnt;
        for($i=0; $i<abs($diff); $i++){
            if($incnt<$excnt){ $incomeblankrows .= '<tr><td>-</td><td></td><td></td><td></td><td></td></tr>'; }else{ $expeneblankrows .= '<tr><td>-</td><td></td><td></td><td></td><td></td></tr>';  }
        }
        $data = '<table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>
    	        
    	        <tr>
    	            <th colspan="5">প্রাপ্তি</th>
                </tr>
                <tr>
    	            <th colspan="5">১</th>
                </tr>
        	    <tr>
        	        <th> ক্রঃ নং </th>
        	        <th> খাত </th>
        	        <th> বাজেট </th>
        	        <th> প্রকৃত  </th>
        	        <th> পার্থক্য </th>
        	    </tr>
        	</thead>
        	<tbody>';
        $inamnt = 0; $examnt = 0;
        $totalBudgetIncome = 0;
        $totalRemainIncome = 0;
        foreach($getIncoms as $getIncom){

            $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $in++) .'</td>
	            <td>'. $getIncom->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format($getIncom->budget,2)) .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespense($getIncom->khat_id, $sd, $ed),2)) .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format($getIncom->budget-self::getkhatincomeespense($getIncom->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

            $inamnt += self::getkhatincomeespense($getIncom->khat_id, $sd, $ed);
            $totalBudgetIncome += $getIncom->budget;
            $totalRemainIncome += $getIncom->budget-self::getkhatincomeespense($getIncom->khat_id, $sd, $ed);
        }
        $inandbal = $inamnt + $balance;
        $data .= $incomeblankrows.'<tr>
        	            <td></td>
        	            <td align="right"><strong>উপ-মোট</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($totalBudgetIncome,2)) .'</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inamnt,2)) .'</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($totalRemainIncome,2)) .'</strong></td>
        	        </tr>
        	        
        	        <tr>
        	            <td style="height:80px;"></td>
        	            <td style="height:80px;" align="right"><strong>প্রারম্ভিক জের</strong></td>
        	            <td></td>
        	            <td style="height:80px;" align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($balance,2)) .'</strong></td>
        	            <td></td>
        	       </tr>
        	        <tr>
        	            <td style="height:80px;"></td>
        	            <td style="height:80px;" align="right"><strong>সর্বমোট</strong></td>
        	            <td></td>
        	            <td style="height:80px;" align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($inandbal,2)) .'</strong></td>
        	            <td></td>
        	        </tr>
    	        </tbody>
	        </table>
	        <table class="table table-bordered" style="width:50%; margin:0px; float:left; border:1px solid #000" id="my Table">
	        <thead>
	             <tr>
    	            <th colspan="5">পরিশোধ</th>
                </tr>
                <tr>
    	            <th colspan="5">২</th>
                </tr>
        	    <tr>
        	        <th> ক্রঃ নং </th>
        	        <th> খাত </th>
        	        <th> বাজেট </th>
        	        <th> প্রকৃত  </th>
        	        <th> পার্থক্য </th>
        	    </tr>
        	</thead>
        	<tbody>';


        $totalBudgetExpense = 0;
        $totalRemainExpense = 0;
        foreach($getExpenses as $getExpen){

            $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $ex++) .'</td>
	            <td>'. $getExpen->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format($getExpen->budget,2)) .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format(self::getkhatincomeespense($getExpen->khat_id, $sd, $ed),2)) .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, number_format($getExpen->budget-self::getkhatincomeespense($getExpen->khat_id, $sd, $ed),2)) .'</td>
	       </tr>';

            $examnt += self::getkhatincomeespense($getExpen->khat_id, $sd, $ed);
            $totalBudgetExpense += $getExpen->budget;
            $totalRemainExpense += $getExpen->budget-self::getkhatincomeespense($getExpen->khat_id, $sd, $ed);
        }
        if($inandbal < $examnt){ $bal = $examnt - $inandbal; $sign = '-'; }else{ {$bal = $inandbal - $examnt; $sign = '+'; }}
        $data .= $expeneblankrows.'
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>উপ-মোট</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($totalBudgetExpense,2)) .'</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt,2)) .'</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($totalRemainExpense,2)) .'</strong></td>
    	        </tr>
    	        
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>সমাপ্তি জের</strong></td>
    	            <td></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($bal, 2)) .'</strong></td>
    	            <td></td>
    	        </tr>
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>সর্বমোট</strong></td>
    	            <td></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, number_format($examnt+$bal,2)) .'</strong></td>
    	            <td></td>
    	        </tr>
    	   </tbody>
    	</table><div class="col-md-12 col-sm-12" style="padding-top:150px">
    	  <div class="row" style="float: left;width: 100%;padding-top: 108px;">

                            <table width="100%">

                                <tr>
                         
                                    <td width="25%" style="text-align:center">  হিসাব রক্ষক <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center">  হিসাব রক্ষণ কর্মকর্তা  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> প্রধান নির্বাহী কর্মকর্তা / সচিব  <br/> ফরিদপুর পৌরসভা </td>
                                    <td width="25%"  style="text-align:center"> মেয়র <br/>  ফরিদপুর পৌরসভা </td>
                                </tr>
                            </table>


                        </div>';

        return $data;

    }
}
