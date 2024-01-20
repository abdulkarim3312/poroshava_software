<?php

namespace App\Http\Controllers\TradeLicense;

use App\Http\Controllers\Controller;
use App\Models\TradeLicense\SignBoard;
use Illuminate\Http\Request;

class TradeLicenseSignBoardController extends Controller
{
    public function index() {
        $signboards = SignBoard::get();
        return view('trade_license.setting.signboard.all', compact('signboards'));
    }

    public function add() {
        return view('trade_license.setting.signboard.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'sign_board_type' => 'required|string|max:255',
            'sign_board_rate' => 'required|numeric|min:0',
        ]);

        $signboard = new SignBoard();
        $signboard->sign_board_type = $request->sign_board_type;
        $signboard->sign_board_rate = $request->sign_board_rate;
        $signboard->save();

        return redirect()->route('trade_license_signboard')->with('message', 'সাইন বোর্ডের ধরন যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(SignBoard $signboard) {
        return view('trade_license.setting.signboard.edit', compact('signboard'));
    }

    public function editPost(SignBoard $signboard, Request $request) {
        $request->validate([
            'sign_board_type' => 'required|string|max:255',
            'sign_board_rate' => 'required|numeric|min:0',
        ]);

        $signboard->sign_board_type = $request->sign_board_type;
        $signboard->sign_board_rate = $request->sign_board_rate;
        $signboard->save();

        return redirect()->route('trade_license_signboard')->with('message', 'সাইন বোর্ডের ধরন পরিবর্তন সম্পন্ন হয়েছে।');
    }

    public function delete(Request $request) {
        SignBoard::where('id', $request->signboardID)->delete();
        return response()->json(['success'=>true,'message'=>"মুছে ফেলা হয়েছে।"]);
    }
}
