<?php

namespace App\Http\Controllers\Collection;

use App\Http\Controllers\Controller;
use App\Models\Collection\CollectionSubType;
use App\Models\Collection\CollectionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CollectionSubTypeController extends Controller
{

    public function datatable() {
        $query = CollectionSubType::with('type');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(CollectionSubType $subType) {
                return '<a href="'.route('collection_sub_type.edit',['subType'=>$subType->id]).'" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>';
            })
            ->editColumn('status', function(CollectionSubType $subType) {
                if ($subType->status == 1)
                    return '<span class="badge bg-success">সক্রিয়</span>';
                else
                    return '<span class="badge bg-danger">নিষ্ক্রিয়</span>';

            })
            ->rawColumns(['action','status'])
            ->toJson();
    }

    public function index() {
        return view('collection.sub_type.all');

    }

    public function add() {
        $types = CollectionType::orderBy('name')->get();
        return view('collection.sub_type.add',compact('types'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' =>  ['required','max:255',
                Rule::unique('collection_sub_types')
                    ->where('type_id',$request->type)
            ],
            'type' => 'required',
            'fees' => 'nullable|numeric',
            'status' => 'required',
        ]);

        $subType = new CollectionSubType();
        $subType->type_id = $request->type;
        $subType->name = $request->name;
        $subType->fees = $request->fees;
        $subType->status = $request->status;
        $subType->save();

        return redirect()->route('collection_sub_type.all')->with('message', 'উপ খাত যুক্ত করুন সফল হয়েছে');
    }

    public function edit(CollectionSubType $subType)
    {
        $types = CollectionType::orderBy('name')->get();
        return view('collection.sub_type.edit', compact('subType','types'));
    }

    public function editPost(CollectionSubType $subType, Request $request) {

        $request->validate([
            'name' =>  ['required','max:255',
                Rule::unique('collection_sub_types')
                    ->where('type_id',$request->type)
                     ->ignore($subType)
            ],
            'fees' => 'nullable|numeric',
            'type' => 'required',
            'status' => 'required',
        ]);

        $subType->type_id = $request->type;
        $subType->name = $request->name;
        $subType->fees = $request->fees;
        $subType->status = $request->status;
        $subType->save();
        return redirect()->route('collection_sub_type.all')->with('message', 'উপ খাত পরিবর্তন সফল হয়েছে');
    }
}
