<?php

namespace App\Http\Controllers\Collection;

use App\Enumeration\Role;
use App\Enumeration\SubRole;
use App\Http\Controllers\Controller;
use App\Models\Collection\CollectionArea;
use App\Models\Collection\CollectionClosing;
use App\Models\Collection\Collection;
use App\Models\Collection\CollectionSubType;
use App\Models\Collection\CollectionType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Rakibhstu\Banglanumber\NumberToBangla;
use Yajra\DataTables\Facades\DataTables;

class CollectionController extends Controller
{
    public function receiptPrint(Collection $collection)
    {
        $bangla = new NumberToBangla();
        $collection->bangla_fees = $bangla->bnWord($collection->grand_total);

        return view('collection.collection.receipt',compact('collection'));
    }
    public function datatable() {

        $query = Collection::with('subType','area');
        if (Auth::user()->role == Role::$COLLECTION && Auth::user()->sub_role == SubRole::$COLLECTOR)
                $query->where('collect_by',auth()->user()->id);

        return DataTables::eloquent($query)
            ->addColumn('action', function(Collection $collection) {
                $btn = '';
                $btn .='<a target="_blank" href="'.route('collection.receipt_print',['collection'=>$collection->id]).'" class="btn btn-default btn-sm"><i class="fa fa-print"></i> রশিদ </a>';
                if (Auth::user()->role == Role::$COLLECTION && Auth::user()->sub_role != SubRole::$CASHIER)
                    $btn .='<a href="'.route('collection.edit',['collection'=>$collection->id]).'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';

                return $btn;
            })
            ->editColumn('date', function(Collection $collection) {
                return Carbon::parse($collection->date)->format('d-m-Y');
            })
            ->addColumn('sub_type', function(Collection $collection) {
                return $collection->subType->name ?? '';
            })
            ->addColumn('area', function(Collection $collection) {
                return $collection->area->area_name ?? '';
            })
            ->orderColumn('date', function ($query, $order) {
                $query->orderBy('date', $order)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action'])
            ->filter(function ($query) {
                if (request()->has('start_date') && request('start_date') != '' && request()->has('end_date') && request('end_date') != '') {
                   $start = date('Y-m-d',strtotime(request('start_date')));
                   $end = date('Y-m-d',strtotime(request('end_date')));
                    $query->where('date', '>=', $start);
                    $query->where('date', '<=', $end);
                }

                if (request()->has('type') && request('type') != '') {
                    $query->where('type_id', request('type'));
                }
                if (request()->has('sub_type') && request('sub_type') != '') {
                    $query->where('sub_type_id', request('sub_type'));
                }
                if (request()->has('collector') && request('collector') != '') {
                    $query->where('collect_by', request('collector'));
                }
            })
            ->toJson();
    }
    public function closingDatatable() {
        $query = CollectionClosing::with('closingBy','approveBy');

        if (auth()->user()->role == Role::$COLLECTION && auth()->user()->sub_role == SubRole::$COLLECTOR)
                $query->where('closing_by',Auth::id());

        return DataTables::eloquent($query)
            ->addColumn('action', function(CollectionClosing $closing) {
                    $btn = '';
                    if ($closing->status == 0 && Auth::user()->role == Role::$COLLECTION && Auth::user()->sub_role == SubRole::$CASHIER){
                        $btn .='<a role="button" data-approve="1" data-id="'.$closing->id.'" class="btn btn-warning btn-sm btn-approve text-white"><i class="fa fa-check"></i> অনুমোদনের জন্য অপেক্ষমান </a>';
                    }
                if ($closing->status == 0) {
                    $btn .= ' <a role="button" data-id="' . $closing->id . '" class="btn btn-danger btn-sm btn-trash"> <i class="fa fa-trash"></i> </a>';
                }
                $btn .= ' <a href="'.route('collection.report.collection').'?start='.date('d-m-Y',strtotime($closing->date)).'&end='.date('d-m-Y',strtotime($closing->date)).'&type=&sub_type=&collector='.$closing->closing_by.'&search=dd" class="btn btn-primary btn-sm"> Details </a>';

                return $btn;



            })
            ->editColumn('date', function(CollectionClosing $closing) {
                return Carbon::parse($closing->date)->format('d-m-Y');
            })
            ->editColumn('status', function(CollectionClosing $closing) {
                if ($closing->status == 1)
                     return '<span class="badge badge-success text-white">অনুমোদিত</span>';
                else
                    return '<span class="badge badge-warning text-white">অপেক্ষমান</span>';
            })
            ->addColumn('closing_by', function(CollectionClosing $closing) {
                return $closing->closingBy->name ?? '';
            })
            ->addColumn('approve_by', function(CollectionClosing $closing) {
                return $closing->approveBy->name ?? '';
            })
            ->addColumn('total_amount', function(CollectionClosing $closing) {
                return en_to_bn($closing->collections($closing->date,$closing->closing_by));
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }

    public function index()
    {
        $types = CollectionType::orderBy('name')->get();
        $users = User::where('role',Role::$COLLECTION)
            ->where('sub_role',SubRole::$COLLECTOR)
            ->orderBy('name')->get();

        return view('collection.collection.all',compact('types','users'));
    }

    public function add()
    {
        $types = CollectionType::where('status',1)->orderBy('name')->get();
        $areas = CollectionArea::where('status',1)->orderBy('area_name')->get();
        return view('collection.collection.add',compact('types','areas'));
    }

    public function addPost(Request $request)
    {


        $request->discount = floatval(en_number($request->discount));
        $request->vat = floatval(en_number($request->vat));
        $request->fees = floatval(en_number($request->fees));

        $request->validate([
            'name'=>'required|max:255',
            'mobile_no'=>'nullable',
            'area'=>'required',
            'holding_no'=>'required',
            'type'=>'required',
            'sub_type'=>'required',
            'fees'=>'required|min:1',
            'vat'=>'required|min:0',
            'discount_type'=>'required',
            'discount'=>'nullable',
            'date'=>'required|date',
        ]);

        $closing = CollectionClosing::where('date',date('Y-m-d',strtotime($request->date)))
            ->where('closing_by',Auth::id())->first();

        if ($closing)
            return redirect()->route('collection.add')
                ->withInput()
                ->with('error','ইতিমধ্যে এই তারিখের দৈনিক সমাপনী সম্পন্ন হয়েছে');

        $lastReceipt = Collection::orderBy('receipt_no','desc')->first();

        if ($lastReceipt)
            $receipt_no = $lastReceipt->receipt_no + 1;
        else
            $receipt_no = 10001;



        $collection = new Collection();
        $collection->receipt_no = $receipt_no;
        $collection->name = $request->name;
        $collection->mobile_no = $request->mobile_no;
        $collection->holding_no = $request->holding_no;
        $collection->area_id = $request->area;
        $collection->type_id = $request->type;
        $collection->sub_type_id = $request->sub_type;
        $collection->fees = $request->fees;
        $collection->vat_percent = $request->vat;
        $vat = ($request->fees * $request->vat) / 100;
        $collection->vat = $vat;
        $subTotal = $vat + $request->fees;
        $collection->sub_total = $subTotal;

        if ($request->discount_type == 1){
            $collection->discount_percent = $request->discount ?? 0;
            $discount = ($request->fees * $request->discount) / 100;
            $collection->discount = $discount;
        }else{
            $discountPercentage = ($request->discount * 100) / $request->fees;

            $collection->discount_percent = $discountPercentage;
            $discount = $request->discount ?? 0;
            $collection->discount = $discount;
        }



        $collection->grand_total = $subTotal - ($discount);
        $collection->date = date('Y-m-d',strtotime($request->date));
        $collection->collect_by = Auth::id();
        $collection->save();
        return redirect()
            ->route('collection.receipt_print',['collection'=>$collection->id])
            ->with('message','আদায় গ্রহণ করা হয়েছে');
    }

    public function userPinCheck(Request $request)
    {
        $rules = [
            'pin'=>'required|digits:4'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($request->pin != ''){
            $admin = User::where('role',Role::$ADMIN)
                    ->where('pin',$request->pin)
                    ->first();

            if ($admin->pin != $request->pin){
                return response()->json(['success' => false, 'message' => 'আপনার পিন ভুল']);
            }
        }

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);

        }

        if ($request->collection_id != ''){

            $collection = Collection::where('id',$request->collection_id)->first();

            if ($collection){
                Session::put('collectionId',$collection->id);
                return response()->json(['success' => true, 'url' => route('collection.edit')]);

            }else{
                return response()->json(['success' => false, 'message' => 'খুঁজে পাওয়া যায়নি']);
            }

        }else{
            return response()->json(['success' => false, 'message' => 'খুঁজে পাওয়া যায়নি']);
        }




    }
    public function closingApprove(Request $request)
    {

        if ($request->closingId != ''){

            $closing = CollectionClosing::where('id',$request->closingId)->first();

            if ($closing){
                $closing->status = 1;
                $closing->approve_by = Auth::id();
                $closing->save();
                return response()->json(['success' => true, 'message' => 'দৈনিক সমাপনী গ্রহণ করা হয়েছে']);
            }else{
                return response()->json(['success' => false, 'message' => 'খুঁজে পাওয়া যায়নি']);
            }

        }else{
            return response()->json(['success' => false, 'message' => 'খুঁজে পাওয়া যায়নি']);
        }

    }
    public function closingDelete(Request $request)
    {
        $rules = [
            'pin'=>'required|digits:4'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($request->pin != ''){
            $admin = User::where('role',Role::$ADMIN)
                ->where('pin',$request->pin)
                ->first();
            if ($admin->pin != $request->pin){
                return response()->json(['success' => false, 'message' => 'আপনার পিন ভুল']);
            }
        }

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);

        }


        if ($request->closing_id != ''){

            $closing = CollectionClosing::where('id',$request->closing_id)->first();

            if ($closing){
                if ($request->approve){
                    if ($request->approve == 1){
                        $closing->status = 1;
                        $closing->approve_by = Auth::id();
                        $closing->save();
                        return response()->json(['success' => true, 'message' => 'দৈনিক সমাপনী গ্রহণ করা হয়েছে']);
                    }else{
                        return response()->json(['success' => false, 'message' => 'খুঁজে পাওয়া যায়নি']);
                    }
                }else{
                    $closing->delete();
                    return response()->json(['success' => true, 'message' => 'সমাপনী মুছে ফেলা হয়েছে']);
                }

            }else{
                return response()->json(['success' => false, 'message' => 'খুঁজে পাওয়া যায়নি']);
            }

        }else{
            return response()->json(['success' => false, 'message' => 'খুঁজে পাওয়া যায়নি']);
        }




    }

    public function edit(Collection $collection)
    {

        if (!$collection)
            abort('404');

        $types = CollectionType::where('status',1)->orderBy('name')->get();
        $areas = CollectionArea::where('status',1)->orderBy('area_name')->get();
        return view('collection.collection.edit',compact('collection',
            'types','areas'));
    }

    public function editPost(Collection $collection,Request $request)
    {
        $request->discount = floatval(en_number($request->discount));
        $request->vat = floatval(en_number($request->vat));
        $request->fees = floatval(en_number($request->fees));

        $request->validate([
            'name'=>'required|max:255',
            'mobile_no'=>'nullable',
            'holding_no'=>'required',
            'area'=>'required',
            'type'=>'required',
            'sub_type'=>'required',
            'discount_type'=>'required',
            'fees'=>'required|min:1',
            'vat'=>'required|min:0',
            'discount'=>'nullable',
            'date'=>'required|date',
        ]);

        $closing = CollectionClosing::where('date',date('Y-m-d',strtotime($request->date)))
            ->where('closing_by',Auth::id())->first();

        if ($closing)
            return redirect()->route('collection.add')
                ->withInput()
                ->with('error','ইতিমধ্যে এই তারিখের দৈনিক সমাপনী সম্পন্ন হয়েছে');


        $collection->old_grand_total = $collection->grand_total;
        $collection->update_by = Auth::id();
        $collection->save();

        $collection->name = $request->name;
        $collection->mobile_no = $request->mobile_no;
        $collection->holding_no = $request->holding_no;
        $collection->area_id = $request->area;
        $collection->type_id = $request->type;
        $collection->sub_type_id = $request->sub_type;
        $collection->fees = $request->fees;
        $collection->vat_percent = $request->vat;
        $vat = ($request->fees * $request->vat) / 100;
        $collection->vat = $vat;
        $subTotal = $vat + $request->fees;
        $collection->sub_total = $subTotal;

        if ($request->discount_type == 1){
            $collection->discount_percent = $request->discount ?? 0;
            $discount = ($request->fees * $request->discount) / 100;
            $collection->discount = $discount;
        }else{
            $discountPercentage = ($request->discount * 100) / $request->fees;

            $collection->discount_percent = $discountPercentage;
            $discount = $request->discount ?? 0;
            $collection->discount = $discount;
        }

        $collection->grand_total = $subTotal - ($discount);
        $collection->date = date('Y-m-d',strtotime($request->date));
        $collection->save();
        return redirect()
            ->route('collection.all')
            ->with('message','আদায় পরিবর্তন করা হয়েছে');
    }

    public function getSubType(Request $request)
    {
       $subTypes =  CollectionSubType::where('type_id',$request->typeId)
            ->where('status',1)
            ->orderBy('name')
            ->get()->toArray();
       return response($subTypes);
    }
    public function getFees(Request $request)
    {
       $subType =  CollectionSubType::select('fees')->where('id',$request->subTypeId)
            ->first();

       return response($subType->fees);
    }

    public function closing()
    {
        return view('collection.collection.closing');
    }

    public function closingPost(Request $request)
    {
        $request->validate([
            'date'=>'required|date',
        ]);


        $collection = Collection::where('collect_by',Auth::id())
                ->where('date',date('Y-m-d',strtotime($request->date)))
                ->first();

        if (!$collection)
            return redirect()->back()
                 ->withInput()
                ->with('error','এই তারিখে কোনো আদায় হয়নি');

        $closing = CollectionClosing::where('date',date('Y-m-d',strtotime($request->date)))
            ->where('closing_by',Auth::id())->first();

        if ($closing)
            return redirect()->back()
                    ->withInput()
                    ->with('error','ইতিমধ্যে এই তারিখের দৈনিক সমাপনী সম্পন্ন হয়েছে');


        $closing = new CollectionClosing();
        $closing->date = date('Y-m-d',strtotime($request->date));
        $closing->closing_by = Auth::id();
        $closing->save();

        return  redirect()->back()
                ->with('message','দৈনিক সমাপনী সম্পন্ন হয়েছে');
    }
}
