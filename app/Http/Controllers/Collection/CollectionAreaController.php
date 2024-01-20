<?php

namespace App\Http\Controllers\Collection;

use App\Http\Controllers\Controller;

use App\Models\Collection\CollectionArea;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CollectionAreaController extends Controller
{

    public function datatable() {
        $query = CollectionArea::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(CollectionArea $area) {
                return '<a href="'.route('collection_area.edit',['area'=>$area->id]).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
            })
            ->editColumn('status', function(CollectionArea $area) {
                if ($area->status == 1)
                    return '<span class="badge bg-success">সক্রিয়</span>';
                else
                    return '<span class="badge bg-danger">নিষ্ক্রিয়</span>';

            })
            ->rawColumns(['action','status'])
            ->toJson();
    }

    public function index() {
        return view('collection.area.all');

    }

    public function add() {
        return view('collection.area.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'area_name' => 'required|string|max:255',
            'area_code' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $area = new CollectionArea();
        $area->area_name = $request->area_name;
        $area->area_code = $request->area_code;
        $area->status = $request->status;
        $area->save();
        return redirect()->route('collection_area.all')->with('message', 'মহল্লা যুক্ত করুন সফল হয়েছে');
    }

    public function edit(CollectionArea $area)
    {
        return view('collection.area.edit', compact('area'));
    }

    public function editPost(CollectionArea $area, Request $request) {

        $request->validate([
            'area_name' => 'required|string|max:255',
            'area_code' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $area->area_name = $request->area_name;
        $area->area_code = $request->area_code;
        $area->status = $request->status;
        $area->save();
        return redirect()->route('collection_area.all')->with('message', 'মহল্লা পরিবর্তন সফল হয়েছে');
    }
}
