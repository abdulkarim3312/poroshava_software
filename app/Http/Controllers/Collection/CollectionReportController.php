<?php

namespace App\Http\Controllers\Collection;

use App\Http\Controllers\Controller;

use App\Enumeration\Role;
use App\Enumeration\SubRole;
use App\Models\Collection\Collection;
use App\Models\Collection\CollectionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionReportController extends Controller
{
    public function summary(Request $request)
    {
        $types = CollectionType::orderBy('name')->get();
        $users = User::where('role',Role::$COLLECTION)
            ->where('sub_role',SubRole::$COLLECTOR)
            ->orderBy('name')->get();
        $collections = [];
        if ($request->start && $request->start != '' && $request->end && $request->end != ''){
            $query = Collection::with('area');
            $query->select(DB::raw('sum(grand_total) as grand_total,sum(fees) as fees,
        sum(vat) as vat,sum(sub_total) as sub_total,sum(discount) as discount,type_id,sub_type_id,date'));
            $query->groupBy('date','type_id','sub_type_id');
            if ($request->start && $request->start != '' && $request->end && $request->end != ''){
                $query->whereBetween('date',[date('Y-m-d',strtotime($request->start)),date('Y-m-d',strtotime($request->end))]);
            }
            if ($request->type && $request->type != ''){
                $query->where('type_id',$request->type);
            }
            if ($request->sub_type && $request->sub_type != ''){
                $query->where('sub_type_id',$request->sub_type);
            }
            if ($request->collector && $request->collector != ''){
                $query->where('collect_by',$request->collector);
            }
            if ($request->search && $request->search != ''){
                $collections = $query->orderBy('date','desc')
                    ->get();
            }
        }


        return view('collection.report.summary',compact('types',
            'users','collections'));
    }
    public function collection(Request $request)
    {
        $types = CollectionType::orderBy('name')->get();
        $users = User::where('role',Role::$COLLECTION)
            ->where('sub_role',SubRole::$COLLECTOR)
            ->orderBy('name')->get();
        $collections = [];
        $query = Collection::with('area');
        if ($request->start && $request->start != '' && $request->end && $request->end != ''){
            $query->whereBetween('date',[date('Y-m-d',strtotime($request->start)),date('Y-m-d',strtotime($request->end))]);
        }
        if ($request->type && $request->type != ''){
            $query->where('type_id',$request->type);
        }
        if ($request->sub_type && $request->sub_type != ''){
            $query->where('sub_type_id',$request->sub_type);
        }
        if ($request->collector && $request->collector != ''){
            $query->where('collect_by',$request->collector);
        }
        if ($request->search && $request->search != ''){
            $collections = $query->orderBy('date','desc')
                        ->get();
        }

        return view('collection.report.collection',compact('types',
            'users','collections'));
    }
    public function userLog(Request $request)
    {
        $types = CollectionType::orderBy('name')->get();
        $users = User::where('role',Role::$COLLECTION)
                ->where('sub_role',SubRole::$COLLECTOR)
                ->orderBy('name')->get();
        $collections = [];
        if ($request->start && $request->start != '' && $request->end && $request->end != ''){
            $query = Collection::with('updateBy');
            if ($request->start && $request->start != '' && $request->end && $request->end != ''){
                $query->whereBetween('date',[date('Y-m-d',strtotime($request->start)),date('Y-m-d',strtotime($request->end))]);
            }
            if ($request->type && $request->type != ''){
                $query->where('type_id',$request->type);
            }
            if ($request->sub_type && $request->sub_type != ''){
                $query->where('sub_type_id',$request->sub_type);
            }
            if ($request->collector && $request->collector != ''){
                $query->where('collect_by',$request->collector);
            }
            if ($request->search && $request->search != ''){
                $collections = $query->orderBy('date','desc')
                    ->whereNotNull('old_grand_total')
                    ->get();
            }
        }


        return view('collection.report.user_log',compact('types',
            'users','collections'));
    }
}
