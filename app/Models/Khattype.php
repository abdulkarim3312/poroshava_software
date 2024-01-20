<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khattype extends Model
{
    protected $primaryKey = 'khat_id';
    protected $fillable = [
        'khat'
    ];

    public static function gettriabstract($upang, $inout, $year){

        $bn= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $headtext = ['প্রাপ্তির বিস্তারিত বিবরন', 'বাজেট প্রাক্কলন অনুসারে বরাদ্দ', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', '১ম ত্রৈমাসিক এর মোট', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', '২য় ত্রৈমাসিক এর মোট', 'অর্ধ বছরের মোট', 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', '৩য় ত্রৈমাসিক এর মোট', '৩ টি ত্রৈমাসিক এর মোট', 'এপ্রিল', 'মে', 'জুন', '৪র্থ ত্রৈমাসিক এর মোট', 'বছরের মোট'];
        $monthheadnumber = ['',	'',	'',	'',	'',	'৩ + ৪ + ৫','',	'',	'',  '৭ + ৮ + ৯','৬ + ১০',	'',	'',	'',	'১২ + ১৩ + ১৪',	'১১ + ১৫',	'',	'',	'',	'১৭ + ১৮ +১৯',	'১৬ + ২০'];
        $monthheadtext = [ ['07'],	['08'],	['09'],	['07','08','09'], ['10'],	['11'],	['12'],	['10', '11', '12'],	['07', '08', '09', '10', '11', '12'],['01'],['02'],	['03'],	['01', '02', '03'],	['07', '08', '09','10', '11', '12', '01', '02', '03'],	['04'],	['05'],	['06'],	['04', '05', '06'],	['07', '08', '09','10', '11', '12', '01', '02', '03', '04', '05', '06']];
        $banlgaletter = ['ক', 'খ','গ','ঘ','ঙ','চ','ছ','জ','ঝ', 'ঞ','ট','ঠ', 'ড', 'ঢ','ণ','ত','থ','ধ', 'ন','প', 'ফ', 'ব', 'ভ', 'ম','য', 'র', 'ল','শ', 'ষ', 'স','হ', 'ড়','ঢ়','য়'];
        $data = '<table class="display table table-bordered"><thead><tr>';
        foreach($headtext as $ht){

            $data .= '<th>'.$ht.'</th>';
        }
        $data .= '</tr><tr>'; $i=1;
        foreach($monthheadnumber as $nb){

            if($nb!=''){

                $data .= '<th rowspan="" style="vertical-align:middle">'. str_replace($en, $bn, $i++) .'</th>';
            }else{

                $data .= '<th rowspan="2" style="vertical-align:middle">'. str_replace($en, $bn, $i++) .'</th>';
            }
        }
        $data .= '</tr><tr>';
        foreach($monthheadnumber as $nb){

            if($nb!=''){

                $data .= '<th rowspan="" style="vertical-align:middle">'.$nb.'</th>';
            }
        }

        $ktsl = 1;
        $data .= '</tr></thead><tbody>';
        $mainheads = TaxType::where('upangsho_id', $upang)->where('khat_id', $inout)->get();
        $bdgttotal = 0;
        foreach($monthheadtext as $kk => $mht){   $total[$kk] = 0;  }
        foreach($mainheads as $mainhds){

            $data .= '<tr><td>'.str_replace($en, $bn, $ktsl++).'| '.$mainhds->tax_name.'</td><td colspan="20"></td></tr>';
            $khats = Khat::where('tax_type_id', $mainhds->tax_id)->get();
            foreach($khats as $k=>$kt){

                $data .= '<tr><td style="vertical-align: middle;" width="150"><b>'. $banlgaletter[$k].'.</b> '.$kt->khat_name .'</td>';
                $bdgt = Budget::where('khat_id', $kt->khat_id)->where('year', $year)->first(); if(!empty($bdgt)){
                $data .= '<td align="right">'. str_replace($en, $bn, number_format($bdgt->budget_amo,2)) .'</td>'; $bdgttotal += $bdgt->budget_amo; }else{ '<td>budget not define</td>'; }
                foreach($monthheadtext as $kk => $mht){ $incomexpens = 0;

                    foreach($mht as $mh){

                        $incomexpens += Incoexpense::where('year', $year)->where('khat_id', $kt->khat_id)->where('receive_datwe', 'like', '%-'.$mh.'-%')->sum('amount');


                    }
                    $data .= '<td align="right">'. str_replace($en, $bn, number_format($incomexpens,2)) .'</td>';
                    $total[$kk] += (float)$incomexpens;
                }
                $data .= '</tr>';
            }

        }
        //dd($total); exit;
        $data .= '<tr><td>মোট প্রাপ্তি</td><td></td>';
        foreach($monthheadtext as $kk => $mht){

            $data .= '<td align="right">'.str_replace($en, $bn, $total[$kk]).'</td>';
        }
        $blanktd='';
        foreach($monthheadtext as $mht){

            $blanktd .= '<td></td>';
        }


        $data .= '</tr>
        <tr><td>স্বাক্ষরঃ হিসাবরক্ষণ কর্মকর্তা / হিসাবরক্ষক</td><td></td>'. $blanktd .'</tr>
       <tr><td>স্বাক্ষরঃ প্রধান নর্বাহী কর্মকর্তা/সচিব</td><td></td>'. $blanktd .'</tr>
        <tr><td>স্বাক্ষরঃ মেয়র</td><td></td>'. $blanktd .'</tr>
        </tbody></table>';
        return $data;
    }


}
