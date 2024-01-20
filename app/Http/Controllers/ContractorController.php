<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Department;
use App\Models\Employee;
use App\Models\SalaryScale;
use App\Models\Upangsho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class ContractorController extends Controller
{
    public function index()
    {
        return view('accounts.contractor.index');
    }

    public function create()
    {
        $idNo = Contractor::orderBy('emp_id', 'desc')->first()->emp_id;
        return view('accounts.contractor.create', compact( 'idNo'));
    }

    public function store(Request $request)
    {
        $request['id_no'] = bnNumberToEn($request->id_no);
        $request['mobile_no'] = bnNumberToEn($request->mobile_no);
        $request['nid_no'] = bnNumberToEn($request->nid_no);
        $request['tin_no'] = bnNumberToEn($request->tin_no);

        $request->validate([
            'id_no' => 'required',
            'name' => 'required|max:100',
            'proprietor_name' => 'required|max:100',
            'address' => 'required|max:255',
            'nid_no' => 'required',
            'tin_no' => 'nullable',
            'mobile_no' => 'required|digits:11',
            'email' => 'nullable|email|max:100',
            'photo' => 'nullable|mimes:jpeg,png,jpg,PNG,JPEG,JPG'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Upload Image
            $file = $request->file('photo');
            $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'uploads/contractor';
            $file->move($destinationPath, $filename);
            $photoPath = 'uploads/contractor/' . $filename;
        }


        $contractor = new Contractor();
        $contractor->emp_id = $request->id_no;
        $contractor->name = $request->name;
        $contractor->fname = $request->proprietor_name;
        $contractor->mob = $request->mobile_no;
        $contractor->email = $request->email;
        $contractor->nid = $request->nid_no;
        $contractor->tin = $request->tin_no;
        $contractor->salaryaccno = $request->address;
        $contractor->photo = $photoPath;
        $contractor->save();

        return redirect()->route('contractor')->with('message', 'ঠিকাদার সংযুক্তি সফল হয়েছে');

    }

    public function datatable()
    {

        $query = Contractor::query();
        return DataTables::eloquent($query)
            ->addColumn('action', function (Contractor $contractor) {
                $btn = '<a  href="' .route('contractor.edit',['contractor'=>$contractor->eid]). '" class="btn btn-success bg-gradient-success btn-sm edit"><i class="fa fa-edit"></i></a>';
                return $btn;
            })

            ->editColumn('emp_id', function (Contractor $contractor) {
                return enNumberToBn($contractor->emp_id);
            })
            ->editColumn('salaryaccno', function (Contractor $contractor) {
                return enNumberToBn($contractor->salaryaccno);
            })
            ->editColumn('mob', function (Contractor $contractor) {
                return enNumberToBn($contractor->mob);
            })

            ->addColumn('photo', function (Contractor $contractor) {
                if (file_exists($contractor->photo))
                    return '<img width="80px" src="' . asset($contractor->photo) . '" alt="Image">';
            })
            ->rawColumns(['action', 'photo'])
            ->toJson();
    }

    public function edit(Contractor $contractor)
    {
        return view('accounts.contractor.edit',compact('contractor'));
    }
    public function update(Contractor $contractor,Request $request)
    {

        $request['id_no'] = bnNumberToEn($request->id_no);
        $request['mobile_no'] = bnNumberToEn($request->mobile_no);
        $request['nid_no'] = bnNumberToEn($request->nid_no);
        $request['tin_no'] = bnNumberToEn($request->tin_no);

        $request->validate([
            'id_no' => 'required',
            'name' => 'required|max:100',
            'proprietor_name' => 'required|max:100',
            'address' => 'required|max:255',
            'nid_no' => 'required',
            'tin_no' => 'nullable',
            'mobile_no' => 'required|digits:11',
            'email' => 'nullable|email|max:100',
            'photo' => 'nullable|mimes:jpeg,png,jpg,PNG,JPEG,JPG'
        ]);

        if ($request->hasFile('photo')) {
            // Upload Image
            $file = $request->file('photo');
            $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'uploads/contractor';
            $file->move($destinationPath, $filename);
            $contractor->photo = 'uploads/contractor/' . $filename;
        }

        $contractor->emp_id = $request->id_no;
        $contractor->name = $request->name;
        $contractor->fname = $request->proprietor_name;
        $contractor->mob = $request->mobile_no;
        $contractor->email = $request->email;
        $contractor->nid = $request->nid_no;
        $contractor->tin = $request->tin_no;
        $contractor->salaryaccno = $request->address;
        $contractor->save();



        return redirect()->route('contractor')->with('message', 'ঠিকাদার হালনাগাদ সফল হয়েছে');

    }
}
