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

    /*

        RAW QUERY TO GET A GIVEN SEASON UNIS COMPETITION POINTS FOR THE ENTIRE SEASON (inc Points for A & B):

        SELECT U.name AS SeasonUni, UU.name AS Host, CUP.overal_pos, CUP.a_pos, CUP.b_pos, LC.when, GREATEST(1,11-CUP.a_pos) AS A_Points, GREATEST(1,11-CUP.b_pos) AS B_Points FROM competition_uni_places AS CUP
        INNER JOIN season_unis SU ON CUP.season_uni=SU.id
        INNER JOIN universities U ON SU.uni=U.id
        INNER JOIN league_competitions LC ON LC.id = CUP.league_comp
        INNER JOIN universities UU ON LC.host = UU.id
        WHERE SU.id=SEASON-UNI-ID-HERE ORDER BY LC.when;

    */





}
