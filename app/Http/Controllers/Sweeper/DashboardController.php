<?php

namespace App\Http\Controllers\Sweeper;

use App\Http\Controllers\Controller;

use App\Models\Sweeper\Area;
use App\Models\Sweeper\Cleaner;
use App\Models\Sweeper\Team;
use App\Models\Sweeper\Type;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        $totalArea = Area::count();
        $totalTeam = Team::count();
        $totalType = Type::count();
        $totalCleaner = Cleaner::count();

        $data = [
            'totalArea' => str_replace($en, $bn, $totalArea),
            'totalTeam' => str_replace($en, $bn, $totalTeam),
            'totalType' => str_replace($en, $bn, $totalType),
            'totalCleaner' => str_replace($en, $bn, $totalCleaner)];

        return view('dashboard', $data);
    }
}
