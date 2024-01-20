<?php

namespace App\Http\Controllers;

use App\Enumeration\Role;
use App\Enumeration\SubRole;
use App\Models\SisterConcern;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{


    public function datatable() {
        $query = User::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('action', function(User $user) {
                    return '<a href="'.route('user.edit',['user'=>$user->id]).'" class="btn btn-success bg-gradient-success btn-sm btn-edit"><i class="fa fa-edit"></i></a>';
            })
            ->editColumn('role', function(User $user) {
                if ($user->is_super_admin == Role::$IS_SUPER_ADMIN){
                        return 'আডমিন';
                }else{
                   if($user->role == Role::$ACCOUNTS)
                        return 'একাউন্টস';
                    elseif($user->role == Role::$HR_PAYROLL)
                        return 'এইচআর এন্ড পেরোল';
                    elseif ($user->role == Role::$SWEEPER_BILL)
                        return 'সুইপার বিল';
                    elseif ($user->role == Role::$CASH_BOOK)
                        return 'ক্যাশবুক';
                    elseif ($user->role == Role::$HOLDING_TAX)
                        return 'হোল্ডিং ট্যাক্স';
                   elseif ($user->role == Role::$TRADE_LICENSE)
                       return 'ট্রেড লাইসেন্স';
                   elseif($user->role == Role::$COLLECTION)
                      return 'আদায়';
                   elseif($user->role == Role::$AUTO_RICKSHAW)
                      return 'অটো রিক্সা লাইসেন্স';
                }


            })
            ->editColumn('sub_role', function(User $user) {
                if($user->role == Role::$COLLECTION){
                   if($user->sub_role == SubRole::$ADMIN){
                       return 'সকল';
                   }elseif($user->sub_role == SubRole::$COLLECTOR){
                       return 'আদায়কারী';
                   }elseif($user->sub_role == SubRole::$CASHIER){
                       return 'ক্যাশিয়ার';
                   }else{
                       return 'সকল';
                   }
                }else{
                    return 'আডমিন';
                }


            })
            ->editColumn('status', function(User $user) {
                if ($user->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';

            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function index() {
        if (auth()->user()->is_super_admin != Role::$IS_SUPER_ADMIN)
            abort('401');


        return view('user.all');
    }

    public function add() {
        if (auth()->user()->is_super_admin != Role::$IS_SUPER_ADMIN)
            abort('401');
        $sisterConcerns = SisterConcern::where('status',1)->get();

        return view('user.add',compact('sisterConcerns'));
    }

    public function addPost(Request $request) {
        if (auth()->user()->is_super_admin != Role::$IS_SUPER_ADMIN)
            abort('401');

        $request['username'] = strtolower($request->username);

        $rules = [
            'name' => 'required|string|max:255',
            'role' => ['required'],
            'sub_role' => ['required'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed',Password::defaults()],
            'status' => 'required',
        ];
        $request->validate($rules);

        $user = new User();
        $user->role = $request->role;
        $user->sub_role = $request->sub_role;
        $user->sister_concern_id = $request->role - 1;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->plain_password = $request->password;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;
        $user->save();

        return redirect()->route('user')->with('message', 'User add successfully.');
    }

    public function edit(User $user) {
        if (auth()->user()->is_super_admin != Role::$IS_SUPER_ADMIN)
            abort('401');
        $sisterConcerns = SisterConcern::where('status',1)->get();

        return view('user.edit', compact('user','sisterConcerns'));
    }

    public function editPost(User $user, Request $request) {
        if (auth()->user()->is_super_admin != Role::$IS_SUPER_ADMIN)
            abort('401');


        $request['username'] = strtolower($request->username);

        $rules = [
            'name' =>  ['required','max:255'],
            'role' =>  ['required'],
            'sub_role' =>  ['required'],
            'username' =>  [
                'required','max:255',
                Rule::unique('users')
                    ->ignore($user)
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'email' =>  [
                'nullable','max:255',
                Rule::unique('users')
                    ->ignore($user)
            ],
            'status' => 'required',
        ];

        $request->validate($rules);

        $user->name = $request->name;
        $user->role = $request->role;
        $user->sub_role = $request->sub_role;
        $user->sister_concern_id = $request->role - 1;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password){
            $user->plain_password = $request->password;
            $user->password = bcrypt($request->password);
        }

        $user->status = $request->status;
        $user->save();

        return redirect()->route('user')->with('message', 'User edit successfully.');
    }
}
