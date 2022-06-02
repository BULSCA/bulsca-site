<?php

namespace App\Http\Controllers;

use App\Models\LeagueCompetition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    //


    public function view($cid){
        $lc = LeagueCompetition::find($cid)->load('hostUni', 'currentSeason');

        return view('dashboard.competitions.view', ['comp' => $lc]);
    }

    public function manage($cid){
        
        $lc = LeagueCompetition::find($cid)->load('hostUni', 'currentSeason');

        return view('dashboard.competitions.manage', ['comp' => $lc]);
    }

    public function resultsUpload(Request $request, $cid) {

        $lc = LeagueCompetition::find($cid)->load('hostUni');

        $fileName = $lc->hostUni->name . " " .  $lc->when->format('Y') . " Results";

        $fileId = ResourceController::storeResource($request, 'results', 'resources/competition-results', $fileName);

        $lc->results_resource = $fileId;

        $lc->save();

        return redirect()->route('lc-manage', ['cid' => $cid]);

    }

    public function resultsRemove($cid) {
        $lc = LeagueCompetition::find($cid);
        $lc->results_resource = null;
        $lc->save();
        return redirect()->route('lc-manage', ['cid' => $cid]);
    }

}
