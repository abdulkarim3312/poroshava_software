<?php

namespace App\Http\Controllers;

use App\Models\Upangsho;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Upangsho::all();

        return view('accounts.section.index',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('accounts.section.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'code'=>'required|max:255',
            'status'=>'required',
        ]);
        $upangsho = new Upangsho();
        $upangsho->upangsho_name = $request->name;
        $upangsho->upangsho_code = $request->code;
        $upangsho->status = $request->status;
        $upangsho->save();
        return redirect()->route('section')->with('message', 'Upangsho created successfully.');

    }

    public function edit(Upangsho $upangsho)
    {
        return view('accounts.section.edit',compact('upangsho'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Upangsho $upangsho,Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'code'=>'required|max:255',
            'status'=>'required',
        ]);

        $upangsho->upangsho_name = $request->name;
        $upangsho->upangsho_code = $request->code;
        $upangsho->status = $request->status;
        $upangsho->save();
        return redirect()->route('section')->with('message', 'Upangsho updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
