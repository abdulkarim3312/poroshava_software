<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;
use App\Models\Sweeper\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index() {
        $areas = Area::with('cleaners')->get();
        return view('sweeper.administrator.area.all', compact('areas'));
    }

    public function add() {
        return view('sweeper.administrator.area.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'community' => 'required|string|max:255',
            'president' => 'required|string|max:255',
        ]);

        $area = new Area();
        $area->community = $request->community;
        $area->president = $request->president;
        $area->save();

        return redirect()->route('area')->with('message', 'এলাকা যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(Area $area) {
        return view('sweeper.administrator.area.edit', compact('area'));
    }

    public function editPost(Area $area, Request $request) {
        $request->validate([
            'community' => 'required|string|max:255',
            'president' => 'required|string|max:255',
        ]);

        $area->community = $request->community;
        $area->president = $request->president;
        $area->save();

        return redirect()->route('area')->with('message', 'এলাকা পরিবর্তন সম্পন্ন হয়েছে।');
    }
}
