<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;
use App\Models\Sweeper\Area;
use App\Models\Sweeper\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index() {
        $teams = Team::with('area','cleaners')->get();

        return view('sweeper.administrator.team.all', compact('teams'));
    }

    public function add() {
        $areas = Area::orderBy('community')->get();

        return view('sweeper.administrator.team.add', compact('areas'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'community' => 'required',
            'team_no' => 'required|string|max:255',
            'team_name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
        ]);

        $team = new Team();
        $team->area_id = $request->community;
        $team->team_no = $request->team_no;
        $team->name = $request->team_name;
        $team->leader = $request->leader_name;
        $team->save();

        return redirect()->route('team')->with('message', 'দল যুক্ত সম্পন্ন হয়েছে।');
    }

    public function edit(Team $team) {
        $areas = Area::orderBy('community')->get();

        return view('sweeper.administrator.team.edit', compact('areas', 'team'));
    }

    public function editPost(Team $team, Request $request) {
        $request->validate([
            'community' => 'required',
            'team_no' => 'required|string|max:255',
            'team_name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
        ]);

        $team->area_id = $request->community;
        $team->team_no = $request->team_no;
        $team->name = $request->team_name;
        $team->leader = $request->leader_name;
        $team->save();

        return redirect()->route('team')->with('message', 'দল পরিবর্তন সম্পন্ন হয়েছে।');
    }
}
