<?php

namespace App\Http\Controllers;

use App\Enumeration\Role;
use App\Models\Collection\Collection;
use App\Models\SisterConcern;
use App\Models\Sweeper\Area;
use App\Models\Sweeper\Cleaner;
use App\Models\Sweeper\Team;
use App\Models\Sweeper\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        if (auth()->user()->is_super_admin == Role::$IS_SUPER_ADMIN) {
            if ($request->role_permission != '') {
                $user = auth()->user();
                 $sisterConcern = SisterConcern::where('role',$request->role_permission)->first();
                $user->sister_concern_id = $sisterConcern->id;
                $user->role = $request->role_permission;
                $user->save();
            } else {
                $sisterConcerns = SisterConcern::orderBy('sort')->where('status',1)->get();
                return view('admin_dashboard',compact('sisterConcerns'));
            }
        }
        $data = [];
        if (auth()->user()->role == Role::$SWEEPER_BILL) {

            $totalArea = Area::count();
            $totalTeam = Team::count();
            $totalType = Type::count();
            $totalCleaner = Cleaner::count();

            $data = [
                'totalArea' => enNumberToBn(number_format($totalArea)),
                'totalTeam' => enNumberToBn(number_format($totalTeam)),
                'totalType' => enNumberToBn(number_format($totalType)),
                'totalCleaner' => enNumberToBn(number_format($totalCleaner))
            ];

        }elseif (auth()->user()->role == Role::$COLLECTION){
            $query = Collection::query();
            if (Auth::user()->role != Role::$ADMIN){
                $query->where('collect_by',Auth::id());
            }
            $collections = $query->where('date',date('Y-m-d'))->get();
            $data['collections'] = $collections;
        }

        return view('dashboard', $data);

    }
}
