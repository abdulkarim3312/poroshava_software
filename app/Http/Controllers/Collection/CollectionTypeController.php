<?php

namespace App\Http\Controllers\Collection;

use App\Http\Controllers\Controller;
use App\Models\Collection\CollectionType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CollectionTypeController extends Controller
{

    public function datatable() {
        $query = CollectionType::query();

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(CollectionType $type) {
                return '<a href="'.route('collection_type.edit',['type'=>$type->id]).'" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>';
            })
            ->editColumn('status', function(CollectionType $type) {
                if ($type->status == 1)
                    return '<span class="badge bg-success">সক্রিয়</span>';
                else
                    return '<span class="badge bg-danger">নিষ্ক্রিয়</span>';

            })
            ->rawColumns(['action','status'])
            ->toJson();
    }


    public function index() {
        return view('collection.type.all');

    }

    public function add() {
        return view('collection.type.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:collection_types',
            'status' => 'required'
        ]);

        $type = new CollectionType();
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();
        return redirect()->route('collection_type.all')->with('message', 'খাত যুক্ত করুন সফল হয়েছে');
    }

    public function edit(CollectionType $type)
    {
        return view('collection.type.edit', compact('type'));
    }

    public function editPost(CollectionType $type, Request $request) {

        $request->validate([
            'name' => 'required|string|max:255|unique:collection_types,id,'.$type->id,
            'status' => 'required'
        ]);

        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();
        return redirect()->route('collection_type.all')->with('message', 'খাত পরিবর্তন সফল হয়েছে');
    }
}
