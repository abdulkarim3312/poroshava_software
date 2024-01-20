<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;
use App\Models\Sweeper\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index() {
        $types = Type::with('cleaners')->get();

        return view('sweeper.administrator.type.all', compact('types'));
    }

    public function add() {
        return view('sweeper.administrator.type.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $type= new Type();
        $type->name = $request->name;
        $type->save();

        return redirect()->route('type')->with('message', 'ধরণ যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(Type $type) {
        return view('sweeper.administrator.type.edit', compact('type'));
    }

    public function editPost(Type $type, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $type->name = $request->name;
        $type->save();

        return redirect()->route('type')->with('message', 'ধরণ পরিবর্তন সম্পন্ন হয়েছে।');
    }
}
