<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;

class SeasonController extends Controller
{
    


    public function currentSeason() {

        $season = Season::orderBy('to','desc')->first();
        $comps = $season->competitions()->orderBy('when')->get();

        return view('competitions.league', ['season' => $season, 'comps' => $comps]);
    }

    public function previousSeason($sid) {

        $slugParts = explode('-', $sid);

        $season = Season::whereYear('from', $slugParts[0])->first();
        $comps = $season->competitions()->orderBy('when')->get();

        return view('competitions.league', ['season' => $season, 'comps' => $comps]);
    }


}
