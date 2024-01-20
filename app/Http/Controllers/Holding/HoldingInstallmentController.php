<?php

namespace App\Http\Controllers\Holding;

use App\Http\Controllers\Controller;
use App\Models\Holding\HoldingBill;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HoldingInstallmentController extends Controller
{
    public function index() {
        return view('holding_tax.installment_process.index');
    }

    public function process(Request $request) {

        HoldingBill::where('status', 1)
            ->update([
                'last_pay_date' => Carbon::parse($request->last_date),
                'issue_date' => Carbon::parse($request->issue_date),
                'installment_type' => $request->type
            ]);

        return redirect()->route('holding.installment_process')->with('message','প্রক্রিয়া সফল হয়ছে।');
    }
}
