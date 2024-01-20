<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boraddo extends Model
{
    protected $primaryKey = 'upangsho_id';
    protected $fillable = [

        'upangsho_name', 'status',
    ];

    static protected $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    static protected $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

    static protected $bnm = array("জানুয়ারি","ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্নবর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর");
    static protected $enm = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");

    static protected $ids = '';
    static protected $budget = '';
    static protected $upangsho = '';
    static protected $khat = '';


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

        //print_r($ids); exit;
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

            $data .= '<th colspan="'. self::colspan($mh->tax_id) .'">'. $mh->tax_name .'</th>';
        }
        $data .= '</tr><tr>';
        foreach($mainheads as $mh){

            $data .= self::getheads($mh->tax_id);
        }
        $data .= '</tr>
            </thead>
            <tbody>';

        foreach($expdates as $ed){

            $data .= '<tr><td>'. str_replace(self::$en, self::$bn, date('d/m/Y', strtotime($ed->date))) .'</td>';
            foreach($mainheads as $mh){

                $data .= self::getrows($mh->tax_id, $ed->date);
            }
            $data .= '</tr>';
        }


        $data .= '<tr><td>মোট</td>';
        foreach($mainheads as $mh){
            $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
            foreach($khats as $kt){

                $data .= '<td align="right">'.self::getTotal($kt->khat_id, $month).'</td>';
            }

        }
        $data .= '</tr>';

        $data .= '<tr><td>গত মাসের জের</td>';
        foreach($mainheads as $mh){
            $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
            foreach($khats as $kt){

                $data .= '<td align="right">'.self::getPrevTotal($kt->khat_id, $month).'</td>';
            }
        }
        $data .= '</tr>';

        $data .= '<tr><td>সর্ব মোট</td>';
        foreach($mainheads as $mh){
            $khats = Khat::where('tax_type_id', $mh->tax_id)->get();
            foreach($khats as $kt){
                $data .= '<td align="right">'.self::getGrandTotal($kt->khat_id, $month).'</td>';
            }
        }
        $data .= '</tr>';
        $data .= '</tbody>
        </table>';

        return $data;
    }

    protected static function colspan($id){

        return Khat::where('tax_type_id', $id)->count();
    }

    protected static function getheads($id){

        $data ='';
        $khats = Khat::where('tax_type_id', $id)->get();
        foreach($khats as $kt){

            $data .= '<th>'. $kt->khat_name .'</th>';
        }
        return $data;
    }

    protected static function getrows($id, $date){

        $data ='';
        $khats = Khat::where('tax_type_id', $id)->get();
        foreach($khats as $kt){

            $data .= '<td align="right">'.self::getamount($kt->khat_id, $date).'</td>';
        }
        return $data;
    }

    protected static function getamount($id, $date){

        $amnt = Incoexpense::where('khat_id', $id)->where('date', $date)->where('status', 1)->sum('amount');
        if($amnt==0){$amnt='';}else{ $amnt = number_format($amnt); } return str_replace(self::$en, self::$bn, $amnt);
    }

    protected static function getTotal($id, $month){

        $amnt = Incoexpense::where('khat_id', $id)->where('date', 'like', $month.'%')->where('status', 1)->sum('amount');
        if($amnt!=0){ $amnt = number_format($amnt); } return str_replace(self::$en, self::$bn, $amnt);
    }


    protected static function getPrevTotal($id, $month){

        $m = explode('-', $month)[1]; $y = explode('-', $month)[0];

        if($m != '07'){

            $to = date('Y-m-t', strtotime($y.'-'.$m.'-01 -1 month'));

            //echo $to; exit;

            if($m <= '06') { $y--; }
            $from = $y.'-07-01'; //die();
            $amnt = Incoexpense::where('khat_id', $id)->where('status', 1)->whereBetween('date', [$from, $to])->sum('amount');
            if($amnt!=0){ $amnt = number_format($amnt); } return str_replace(self::$en, self::$bn, $amnt);

        }else{

            return '';
        }
    }

    protected static function getGrandTotal($id, $month){

        $m = explode('-', $month)[1]; $y = explode('-', $month)[0];

        //$number = cal_days_in_month(CAL_GREGORIAN, $m, $y);
        // $to =  $y.'-'.$m.'-'.$number;

        $to = date('Y-m-t', strtotime($y.'-'.$m.'-01'));
        //echo $to; exit;
        if($m <= '06') { $y--; }
        $from = $y.'-07-01'; //die();
        $amnt = Incoexpense::where('khat_id', $id)->where('status', 1)->whereBetween('date', [$from, $to])->sum('amount');
        if($amnt!=0){ $amnt = number_format($amnt); } return str_replace(self::$en, self::$bn, $amnt);

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


    public static function balancegenarate($upang, $sd, $ed){

        if($upang!=''){


            $aay = Incoexpense::where('upangsho_id', $upang)->where('inout_id', 1)->where('receive_datwe', '<', $sd)->sum('amount');
            $bay = Incoexpense::where('upangsho_id', $upang)->where('inout_id', 2)->where('receive_datwe', '<', $sd)->sum('amount');
        }else{

            $aay = Incoexpense::where('inout_id', 1)->where('receive_datwe', '<', $sd)->sum('amount');
            $bay = Incoexpense::where('inout_id', 2)->where('receive_datwe', '<', $sd)->sum('amount');
        }
        return $aay - $bay;
    }


    public static function getBalancesheet($upang, $sd, $ed){

        $balance = self::balancegenarate($upang, $sd, $ed);

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
                    ->whereBetween('incoexpenses.receive_datwe', [$sd, $ed])
                    ->groupBy('incoexpenses.khat_id')
                    ->get();
        }
        $incomeblankrows=''; $expeneblankrows=''; $in=1; $ex=1;
        $incnt =  $getIncoms->count()+1; $excnt = $getExpenses->count();
        $diff = $incnt - $excnt;
        for($i=0; $i<abs($diff); $i++){
            if($incnt<$excnt){ $incomeblankrows .= '<tr><td>-</td><td></td><td></td></tr>'; }else{ $expeneblankrows .= '<tr><td>-</td><td><td></td></td></tr>';  }
        }
        $data = '<table class="display table-bordered col-md-6" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রম </th>
        	        <th> খাত </th>
        	        <th> আয়  </th>
        	    </tr>
        	</thead>
        	<tbody>
        	<tr>
	            <td></td>
	            <td><strong>প্রাম্ভিক জের</strong></td>
	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, $balance) .'</strong></td>
	       </tr>';
        $inamnt = 0; $examnt = 0;
        foreach($getIncoms as $getIncom){

            $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $in++) .'</td>
	            <td>'. $getIncom->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, self::getkhatincomeespense($getIncom->incoexpenses_id)) .'</td>
	       </tr>';

            $inamnt += self::getkhatincomeespense($getIncom->incoexpenses_id);
        }
        $inandbal = $inamnt + $balance;
        $data .= $incomeblankrows.'</tbody><tfoot>
        	        <tr>
        	            <td></td>
        	            <td align="right"><strong>মোট আয়</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, $inamnt) .'</strong></td>
        	        </tr>
        	        <tr>
        	            <td></td>
        	            <td align="right"><strong>সর্বমোট আয়</strong></td>
        	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, $inandbal) .'</strong></td>
        	        </tr>
    	        </tfoot>
	        </table>
	        <table class="display table-bordered col-md-6" id="my Table">
	        <thead>

        	    <tr>
        	        <th> ক্রম </th>
        	        <th> খাত </th>
        	        <th> ব্যায়  </th>
        	    </tr>
        	</thead>
        	<tbody>';


        foreach($getExpenses as $getExpen){

            $data .= '<tr>
	            <td>'. str_replace(self::$en, self::$bn, $ex++) .'</td>
	            <td>'. $getExpen->khat_name .'</td>
	            <td align="right">'. str_replace(self::$en, self::$bn, self::getkhatincomeespense($getExpen->incoexpenses_id)) .'</td>
	       </tr>';

            $examnt += self::getkhatincomeespense($getExpen->incoexpenses_id);
        }
        $data .= $expeneblankrows.'</tbody>
    	    <tfoot>
    	        <tr>
    	            <td></td>
    	            <td align="right"><strong>ব্যয় মোট</strong></td>
    	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, $examnt) .'</strong></td>
    	        </tr>
    	   </tfoot>
    	</table>';


        if($inandbal < $examnt){ $bal = $examnt - $inandbal; $sign = '-'; }else{ {$bal = $inandbal - $examnt; $sign = '+'; }}

        $data .= '<table class="display table table-bordered col-md-12" id="my Table">



	        <tr>
	            <td align="right"><strong>মোট</strong></td>
	            <td align="right"><strong>'. str_replace(self::$en, self::$bn, $inandbal) .'</strong></td>
	            <td align="right"><strong>( '. $sign .' )</strong></td>
	            <td align="right"><strong>সমাপ্তি জের : '. str_replace(self::$en, self::$bn, $bal) .'</strong></td>
	        </tr>
	    </table>';

        return $data;

    }
    public static function getkhatincomeespense($id){

        return Incoexpense::where('incoexpenses_id', $id)->first()->amount;

    }
}
