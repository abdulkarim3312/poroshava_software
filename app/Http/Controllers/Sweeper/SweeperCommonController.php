<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;

use App\Models\Sweeper\Area;
use App\Models\Sweeper\Cleaner;
use App\Models\Sweeper\SalaryProcess;
use App\Models\Sweeper\Team;
use Illuminate\Http\Request;

class SweeperCommonController extends Controller
{
    public function getTeam(Request $request)
    {
        $teams = Team::where('area_id', $request->communityID)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($teams);
   }
    public function getCleaner(Request $request)
    {
        $cleaner = Cleaner::where('id', $request->cleanerId)
            ->first();


        return response()->json($cleaner);
   }

    public function getMonth(Request $request) {
        $salaryProcess = SalaryProcess::select('month')
            ->where('year', $request->year)
            ->where('bi_monthly',1)
            ->where('bi_monthly',2)
            ->get();

        $proceedMonths = [];
        $result = [];
         $en = ['January','February','March','April','May','June','July','August','September','October','November','December'];
         $bn = ['জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','অগাস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
        foreach ($salaryProcess as $item)
            $proceedMonths[] = $item->month;

        for($i=1; $i <=12; $i++) {
            if (!in_array($i, $proceedMonths)) {
                $result[] = [
                    'id' => $i,
                    'name' => str_replace($en,$bn,date('F', mktime(0, 0, 0, $i, 10))),
                ];
            }
        }

        return response()->json($result);
    }
    public function getSalaryProcessMonth(Request $request) {
        $salaryProcess = SalaryProcess::select('month')
            ->where('year', $request->year)
            //->where('bi_monthly',1)
            //->where('bi_monthly',2)
            ->get();

        $proceedMonths = [];
        $result = [];
         $en = ['January','February','March','April','May','June','July','August','September','October','November','December'];
         $bn = ['জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে','জুন','জুলাই','অগাস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
        foreach ($salaryProcess as $item)
            $proceedMonths[] = $item->month;

        for($i=1; $i <=12; $i++) {
            if (in_array($i, $proceedMonths)) {
                $result[] = [
                    'id' => $i,
                    'name' => str_replace($en,$bn,date('F', mktime(0, 0, 0, $i, 10))),
                ];
            }
        }

        return response()->json($result);
    }
    public function getBiMonth(Request $request) {

        $salaryProcess = SalaryProcess::select('bi_monthly')
            ->where('month', $request->month)
            //->where('bi_monthly', $request->bi_month)
            ->where('year', $request->year)
            ->get();

        $proceedBiMonths = [];
        $result = [];

        foreach ($salaryProcess as $item)
            $proceedBiMonths[] = $item->bi_monthly;


        if (count($proceedBiMonths) == 1) {
            foreach ($proceedBiMonths as $item){

                if ($item == 3) {
                    $result = [];
                }elseif ($item == 1){
                    $result[] = [
                        'id' => 2,
                        'name' => 'দ্বিতীয় পাক্ষিক',

                    ];
                }elseif ($item == 2){
                    $result[] = [
                        'id' => 1,
                        'name' => 'প্রথম পাক্ষিক',

                    ];
                }
            }
        }elseif (count($proceedBiMonths) > 1){

         $result = [];

        }else{
            for($i=1; $i <=3; $i++) {
                $result[] = [
                    'id' => $i,
                    'name' => $i == 1 ? 'প্রথম পাক্ষিক' : ($i == 2 ? 'দ্বিতীয় পাক্ষিক' : 'মাসিক'),

                ];

            }
        }

//        $result[0] = [
//            'id' => 1,
//            'name' => 'প্রথম পাক্ষিক',
//        ];
//        $result[1] = [
//            'id' => 2,
//            'name' => 'দ্বিতীয় পাক্ষিক',
//        ];
        return response()->json($result);
    }
    public function getSalaryProcessBiMonth(Request $request) {
        $salaryProcess = SalaryProcess::select('bi_monthly')
            ->where('month', $request->month)
            //->where('bi_monthly', $request->bi_month)
            ->where('year', $request->year)
            ->get();

        $proceedBiMonths = [];
        $result = [];

        foreach ($salaryProcess as $item)
            $proceedBiMonths[] = $item->bi_monthly;

        if (count($proceedBiMonths) == 1) {
            foreach ($proceedBiMonths as $item){

                if ($item == 3) {
                    $result[] = [
                        'id' => 3,
                        'name' => 'মাসিক',

                    ];
                }elseif ($item == 1){
                    $result[] = [
                        'id' => 1,
                        'name' => 'প্রথম পাক্ষিক',

                    ];
                }elseif ($item == 2){
                    $result[] = [
                        'id' => 2,
                        'name' => 'দ্বিতীয় পাক্ষিক',

                    ];

                }
            }
        }elseif (count($proceedBiMonths) > 1){

            $result[] = [
                'id' => 1,
                'name' => 'প্রথম পাক্ষিক',

            ];
            $result[] = [
                'id' => 2,
                'name' => 'দ্বিতীয় পাক্ষিক',

            ];

        }else{
            for($i=1; $i <=3; $i++) {
                $result[] = [
                    'id' => $i,
                    'name' => $i == 1 ? 'প্রথম পাক্ষিক' : ($i == 2 ? 'দ্বিতীয় পাক্ষিক' : 'মাসিক'),

                ];

            }
        }
//        $result[0] = [
//            'id' => 1,
//            'name' => 'প্রথম পাক্ষিক',
//        ];
//        $result[1] = [
//            'id' => 2,
//            'name' => 'দ্বিতীয় পাক্ষিক',
//        ];
        return response()->json($result);
    }
}
