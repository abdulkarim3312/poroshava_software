<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;

use App\Models\Sweeper\Area;
use App\Models\Sweeper\Cleaner;
use App\Models\Sweeper\CleanerBonusLog;
use App\Models\Sweeper\CleanerSalaryLog;
use App\Models\Sweeper\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class CleanerController extends Controller
{
    public function index() {

        return view('sweeper.cleaner.all');
    }
    public function cleanerDatatable() {


        if (request()->has('area') && request('area') != '') {
            $query = Cleaner::with('type','area','team')
                   ->where('area_id', request('area'));

         }elseif(request()->has('team') && request('team') != '') {
            $query = Cleaner::with('type','area','team')
                ->where('team_id', request('team'));
        }elseif(request()->has('type') && request('type') != '') {
            $query = Cleaner::with('type','area','team')
                ->where('type_id', request('type'));
        }else {
            $query = Cleaner::with('type','area','team');
         }


        return DataTables::eloquent($query)
            ->addColumn('type', function(Cleaner $cleaner) {
                return $cleaner->type->name;
            })
            ->addColumn('team', function(Cleaner $cleaner) {
                return $cleaner->team->name;
            })
            ->addColumn('area', function(Cleaner $cleaner) {
                return $cleaner->area->community;
            })
            ->addColumn('action', function(Cleaner $cleaner) {
                return '<a class="btn btn-success bg-gradient-success btn-sm" href="'.route('cleaner.edit', ['cleaner' => $cleaner->id]).'">হালনাগাদ</a>';
            })
            ->addColumn('salary_update', function(Cleaner $cleaner) {
                return '<a class="btn btn-success bg-gradient-success btn-sm btn-update" role="button" data-id="'.$cleaner->id.'" data-name="'.$cleaner->name.'">বেতন হালনাগাদ</a> <a class="btn btn-success bg-gradient-success btn-sm btn-bonus" role="button" data-id="'.$cleaner->id.'" data-name="'.$cleaner->name.'">বোনাস হালনাগাদ</a>';
            })
            ->addColumn('status', function(Cleaner $cleaner) {
                if($cleaner->status == 1)
                    return '<span class="label label-success">সক্রিয়</span>';
                else
                    return '<span class="label label-danger">নিষ্ক্রিয়</span>';
            })
            ->editColumn('photo', function(Cleaner $cleaner) {
                return '<img src="'.asset($cleaner->photo).'" height="50px">';
            })
            ->editColumn('daily_salary', function(Cleaner $cleaner) {
                return number_format($cleaner->daily_salary,2);
            })
            ->editColumn('bonus', function(Cleaner $cleaner) {
                return number_format($cleaner->bonus,2);
            })
            ->editColumn('others_salary', function(Cleaner $cleaner) {
                return number_format($cleaner->others_salary,2);
            })
            ->editColumn('deduct_salary', function(Cleaner $cleaner) {
                return number_format($cleaner->deduct_salary,2);
            })

            ->rawColumns(['action','status','salary_update','photo'])
            ->toJson();
    }

    public function add() {

       $areas = Area::orderBy('community')->get();
       $types= Type::orderBy('name')->get();
       $count = Cleaner::count();
       $cleanerId = str_pad($count+1, 4, '0', STR_PAD_LEFT);

        return view('sweeper.cleaner.add',compact('areas','types','cleanerId'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'community' => 'required',
            'team_name' => 'required',
            'religion' => 'required',
            'type' => 'required',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'national_nid' => 'required|string|max:255',
            'mobile_no' => 'required|max:11',
            'address' => 'required',
            'daily_salary' => 'required|numeric',
            'bonus' => 'required|numeric',
            'others_salary' => 'nullable|numeric',
            'deduction_day' => 'nullable|numeric',
            'photo' => 'required|image',
            'status' => 'required|min:0|max:1',
        ]);
        $file = $request->file('photo');
        $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
        $destinationPath = 'uploads/cleaner_photo';
        $file->move($destinationPath, $filename);

        // Thumbs
        $img = Image::make($destinationPath.'/'.$filename);
        $img->resize(450,450);
        $img->save(public_path('uploads/cleaner_photo/'.$filename), 70);
        $thumbs = 'uploads/cleaner_photo/'.$filename;

        $cleaner= new Cleaner();
        $cleaner->cleaner_id = $request->cleaner_id;
        $cleaner->area_id = $request->community;
        $cleaner->religion = $request->religion;
        $cleaner->team_id = $request->team_name;
        $cleaner->type_id = $request->type;
        $cleaner->name = $request->name;
        $cleaner->father_name = $request->father_name;
        $cleaner->national_nid = $request->national_nid;
        $cleaner->mobile_no = $request->mobile_no;
        $cleaner->address = $request->address;
        $cleaner->daily_salary = $request->daily_salary;
        $cleaner->bonus = $request->bonus;
        $cleaner->others_salary = $request->others_salary;
        $cleaner->deduction_day = $request->deduction_day;
        $cleaner->photo = $thumbs;
        $cleaner->status = $request->status;
        $cleaner->save();

        $log = new CleanerSalaryLog();
        $log->cleaner_id = $cleaner->id;
        $log->daily_salary = $request->daily_salary;
        $log->others_salary = $request->others_salary;
        $log->deduction_day = $request->deduction_day;
        $log->save();

        $bonus = new CleanerBonusLog();
        $bonus->cleaner_id = $cleaner->id;
        $bonus->bonus = $request->bonus;
        $bonus->save();

        return redirect()->route('cleaner')->with('message', 'পরিচ্ছন্ন কর্মীর যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(Cleaner $cleaner) {
        $areas = Area::orderBy('community')->get();
        $types= Type::orderBy('name')->get();
        return view('sweeper.cleaner.edit', compact('cleaner','areas','types'));
    }

    public function editPost(Cleaner $cleaner, Request $request) {

        $request->validate([
            'community' => 'required',
            'team_name' => 'required',
            'religion' => 'required',
            'type' => 'required',
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'national_nid' => 'required|string|max:255',
            'mobile_no' => 'required|max:11',
            'address' => 'required',
            'photo' => 'nullable|image',
            'status' => 'required|min:0|max:1',
        ]);

        if ($request->photo) {

//            if ($cleaner->photo)
//                unlink(public_path($cleaner->photo));

            $file = $request->file('photo');
            $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/cleaner_photo';
            $file->move($destinationPath, $filename);

            // Thumbs
            $img = Image::make($destinationPath.'/'.$filename);
            $img->resize(450,450);
            $img->save(public_path('uploads/cleaner_photo/'.$filename), 70);
            $thumbs = 'uploads/cleaner_photo/'.$filename;
            $cleaner->photo = $thumbs;
        }

        $cleaner->area_id = $request->community;
        $cleaner->team_id = $request->team_name;
        $cleaner->type_id = $request->type;
        $cleaner->name = $request->name;
        $cleaner->religion = $request->religion;
        $cleaner->father_name = $request->father_name;
        $cleaner->national_nid = $request->national_nid;
        $cleaner->mobile_no = $request->mobile_no;
        $cleaner->address = $request->address;
        $cleaner->status = $request->status;
        $cleaner->save();

        return redirect()->route('cleaner')->with('message', 'পরিচ্ছন্ন কর্মীর পরিবর্তন সম্পন্ন হয়েছে।');
    }
}
