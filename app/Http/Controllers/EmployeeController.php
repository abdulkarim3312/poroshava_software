<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\SalaryScale;
use App\Models\Upangsho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Ramsey\Uuid\Uuid;

class EmployeeController extends Controller
{
    public function index()
    {

//        $employees = Employee::all();
//        foreach ($employees as $employee){
//            Employee::where('eid',$employee->eid)->update([
//                'photo'=>'uploads/employee/'.$employee->photo
//            ]);
//        }
//        dd('done');



        return view('hr_payroll.employee.index');
    }

    public function create()
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $idNo = Employee::orderBy('emp_id', 'desc')->first()->emp_id;
        $departments = Department::where('status', 1)->get();
        $salaryScales = SalaryScale::where('status', 1)->get();
        return view('hr_payroll.employee.create', compact('salaryScales', 'departments', 'sections', 'idNo'));
    }

    public function store(Request $request)
    {
        $request['id_no'] = bnNumberToEn($request->id_no);
        $request['salary'] = bnNumberToEn($request->salary);
        $request['mobile_no'] = bnNumberToEn($request->mobile_no);
        $request['salary_account_no'] = bnNumberToEn($request->salary_account_no);
        $request['provident_fund_account_no'] = bnNumberToEn($request->provident_fund_account_no);
        $request['gratuity_account_no'] = bnNumberToEn($request->gratuity_account_no);
        $request['nid_no'] = bnNumberToEn($request->nid_no);
        $request['tin_no'] = bnNumberToEn($request->tin_no);

        $request->validate([
            'upangsho' => 'required',
            'id_no' => 'required',
            'religion' => 'required',
            'name' => 'required|max:100',
            'father_name' => 'required|max:100',
            'mother_name' => 'required|max:100',
            'department' => 'required',
            'section' => 'required',
            'salary_scale' => 'required',
            'designation' => 'required',
            'salary' => 'required|numeric|min:1',
            'joining_date' => 'required|date',
            'joining_present_post_date' => 'required|date',
            'retired_date' => 'nullable|date',
            'entertainment_allowance_date' => 'nullable|date',
            'nid_no' => 'required',
            'tin_no' => 'nullable',
            'birth_day' => 'required|date',
            'mobile_no' => 'required|digits:11',
            'email' => 'nullable|email|max:100',
            'salary_account_no' => 'required|min:0',
            'provident_fund_account_no' => 'required|min:0',
            'gratuity_account_no' => 'required|min:0',
            'photo' => 'nullable|mimes:jpeg,png,jpg,PNG,JPEG,JPG'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Upload Image
            $file = $request->file('photo');
            $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'uploads/employee';
            $file->move($destinationPath, $filename);
            $photoPath = 'uploads/employee/' . $filename;
        }

        if ($request->gratuity_account_no == 0) {
            $gratuityFund = 0;
        } else {
            $gratuityFund = round(($request->salary * 25) / 100);
        }

        if ($request->provident_fund_account_no == 0) {
            $pfFund = 0;
        } else {
            $pfFund = round(($request->salary * 10) / 100);
        }

        $employee = new Employee();
        $employee->emp_id = $request->id_no;
        $employee->upananso = $request->upangsho;
        $employee->branchid = $request->department;
        $employee->shaka_id = $request->section;
        $employee->scaleid = $request->salary_scale;
        $employee->name = $request->name;
        $employee->designation = $request->designation;
        $employee->fname = $request->father_name;
        $employee->mname = $request->mother_name;
        $employee->relig = $request->religion;
        $employee->mob = $request->mobile_no;
        $employee->email = $request->email;
        $employee->nid = $request->nid_no;
        $employee->tin = $request->tin_no;
        $employee->salary = $request->salary;
        $employee->salaryaccno = $request->salary_account_no;
        $employee->pfaccno = $request->provident_fund_account_no;
        $employee->grataccno = $request->gratuity_account_no;
        $employee->graduaty = $gratuityFund;
        $employee->pf_found = $pfFund;
        $employee->photo = $photoPath;
        $employee->satatus = 1;
        $employee->birthdate = Carbon::parse($request->birth_day);
        $employee->joindate = Carbon::parse($request->joining_date);
        $employee->presdate = Carbon::parse($request->joining_present_post_date);
        $employee->retireddate = $request->retired_date ? Carbon::parse($request->retired_date) : null;
        $employee->srintidate = $request->entertainment_allowance_date ? Carbon::parse($request->entertainment_allowance_date) : null;
        $employee->save();

        return redirect()->route('employee')->with('message', 'কর্মচারী সংযুক্তি সফল হয়েছে');

    }

    public function datatable()
    {

        $query = Employee::with('department');
        return DataTables::eloquent($query)
            ->addColumn('action', function (Employee $employee) {
                $btn = '<a  href="' .route('employee.edit',['employee'=>$employee->eid]). '" class="btn btn-success bg-gradient-success btn-sm edit"><i class="fa fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('department_name', function (Employee $employee) {
                return $employee->department->name ?? '';
            })
            ->editColumn('emp_id', function (Employee $employee) {
                return enNumberToBn($employee->emp_id);
            })
            ->editColumn('salaryaccno', function (Employee $employee) {
                return enNumberToBn($employee->salaryaccno);
            })
            ->editColumn('mob', function (Employee $employee) {
                return enNumberToBn($employee->mob);
            })
            ->editColumn('joindate', function (Employee $employee) {
                return enNumberToBn(Carbon::parse($employee->joindate)->format('d-m-Y'));
            })
            ->addColumn('photo', function (Employee $employee) {
                if (file_exists($employee->photo))
                    return '<img width="80px" src="' . asset($employee->photo) . '" alt="Image">';
            })
            ->rawColumns(['action', 'photo'])
            ->toJson();
    }

    public function edit(Employee $employee)
    {
        $sections = Upangsho::where('upangsho_id', '!=', 0)->get();
        $departments = Department::where('status', 1)->get();
        $salaryScales = SalaryScale::where('status', 1)->get();
        return view('hr_payroll.employee.edit',compact('employee','departments',
        'salaryScales','sections'));
    }
    public function update(Employee $employee,Request $request)
    {

        $request['id_no'] = bnNumberToEn($request->id_no);
        $request['salary'] = bnNumberToEn($request->salary);
        $request['mobile_no'] = bnNumberToEn($request->mobile_no);
        $request['salary_account_no'] = bnNumberToEn($request->salary_account_no);
        $request['provident_fund_account_no'] = bnNumberToEn($request->provident_fund_account_no);
        $request['gratuity_account_no'] = bnNumberToEn($request->gratuity_account_no);
        $request['nid_no'] = bnNumberToEn($request->nid_no);
        $request['tin_no'] = bnNumberToEn($request->tin_no);

        $request->validate([
            'upangsho' => 'required',
            'id_no' => 'required',
            'religion' => 'required',
            'name' => 'required|max:100',
            'father_name' => 'required|max:100',
            'mother_name' => 'required|max:100',
            'department' => 'required',
            'section' => 'required',
            'salary_scale' => 'required',
            'designation' => 'required',
            'salary' => 'required|numeric|min:1',
            'joining_date' => 'required|date',
            'joining_present_post_date' => 'required|date',
            'retired_date' => 'nullable|date',
            'entertainment_allowance_date' => 'nullable|date',
            'nid_no' => 'required',
            'tin_no' => 'nullable',
            'birth_day' => 'required|date',
            'mobile_no' => 'required|digits:11',
            'email' => 'nullable|email|max:100',
            'salary_account_no' => 'required|min:0',
            'provident_fund_account_no' => 'required|min:0',
            'gratuity_account_no' => 'required|min:0',
            'photo' => 'nullable|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
            'status' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            // Upload Image
            $file = $request->file('photo');
            $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'uploads/employee';
            $file->move($destinationPath, $filename);
            $employee->photo = 'uploads/employee/' . $filename;
        }

        if ($request->gratuity_account_no == 0) {
            $gratuityFund = 0;
        } else {
            $gratuityFund = round(($request->salary * 25) / 100);
        }

        if ($request->provident_fund_account_no == 0) {
            $pfFund = 0;
        } else {
            $pfFund = round(($request->salary * 10) / 100);
        }

        $employee->emp_id = $request->id_no;
        $employee->branchid = $request->department;
        $employee->shaka_id = $request->section;
        $employee->scaleid = $request->salary_scale;
        $employee->name = $request->name;
        $employee->designation = $request->designation;
        $employee->fname = $request->father_name;
        $employee->mname = $request->mother_name;
        $employee->relig = $request->religion;
        $employee->upananso = $request->upangsho;
        $employee->mob = $request->mobile_no;
        $employee->email = $request->email;
        $employee->nid = $request->nid_no;
        $employee->tin = $request->tin_no;
        $employee->salary = $request->salary;
        $employee->salaryaccno = $request->salary_account_no;
        $employee->pfaccno = $request->provident_fund_account_no;
        $employee->grataccno = $request->gratuity_account_no;
        $employee->graduaty = $gratuityFund;
        $employee->pf_found = $pfFund;
        $employee->satatus = $request->status;
        $employee->birthdate = Carbon::parse($request->birth_day);
        $employee->joindate = Carbon::parse($request->joining_date);
        $employee->presdate = Carbon::parse($request->joining_present_post_date);
        $employee->retireddate = $request->retired_date ? Carbon::parse($request->retired_date) : null;
        $employee->srintidate = $request->entertainment_allowance_date ? Carbon::parse($request->entertainment_allowance_date) : null;
        $employee->save();

        return redirect()->route('employee')->with('message', 'কর্মচারী হালনাগাদ সফল হয়েছে');

    }
}
