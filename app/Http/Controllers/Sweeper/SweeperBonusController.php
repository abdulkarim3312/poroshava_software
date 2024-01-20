<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;

use App\Models\Sweeper\SweeperBonus;
use App\Models\Sweeper\BonusProcess;
use App\Models\Sweeper\Cleaner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SweeperBonusController extends Controller
{


    public function cleanerBonusProcess (Request $request)
    {
        if($request->bonus != '' && $request->date != ''){

          $bonusCheck = BonusProcess::where('year',date('Y',strtotime($request->date)))
                            ->where('month',date('m',strtotime($request->date)))
                            ->where('bonus',$request->bonus)
                            ->first();


            if ($bonusCheck) {
                return redirect()->route('cleaner_bonus_process')
                    ->with('error','এই বোনাস প্রস্তুত আছে');
            }

            if ($request->bonus == 1 || $request->bonus == 2) {

                $cleaners = Cleaner::where('status',1)
                    ->where('religion',1)
                    ->get();

            }elseif ($request->bonus == 4){
                $cleaners = Cleaner::where('status',1)
                    ->where('religion',2)
                    ->get();
            }elseif ($request->bonus == 3){
                $cleaners = Cleaner::where('status',1)
                    ->get();
            }



            if (count($cleaners) > 0) {
                $total = 0;
                foreach ($cleaners as $cleaner){
                    $total += $cleaner->bonus;
                }
                $bonusProcess = new BonusProcess();
                $bonusProcess->bonus = $request->bonus;
                $bonusProcess->date = $request->date;
                $bonusProcess->month =date('m',strtotime($request->date));
                $bonusProcess->year = date('Y',strtotime($request->date));
                $bonusProcess->total = $total;
                $bonusProcess->save();

                foreach ($cleaners as $cleaner){

                    $bonus = new Bonus();
                    $bonus->bonus_processes_id = $bonusProcess->id;
                    $bonus->cleaner_id = $cleaner->cleaner_id;
                    $bonus->area_id = $cleaner->area_id;
                    $bonus->team_id = $cleaner->team_id;
                    $bonus->type_id = $cleaner->type_id;
                    $bonus->bonus = $request->bonus;
                    $bonus->date = $request->date;
                    $bonus->year = date('Y',strtotime($request->date));
                    $bonus->month = date('m',strtotime($request->date));
                    $bonus->total = $cleaner->bonus;
                    $bonus->save();

                }
            }else{
                return redirect()->route('cleaner_bonus_process')
                    ->with('error','এখানে কোনো পরিচ্ছন্ন কর্মী পাওয়া যায়নি। ');
            }

            return redirect()->route('cleaner_bonus_process')
                ->with('message','বোনাস প্রস্তুত সম্পন্ন হয়েছে।');

        }
        return view('sweeper.bonus.bonus_process');
    }


}
