<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    //


    public function view($cid){
        $lc = Competition::find($cid)->load('hostUni', 'currentSeason');

        return view('dashboard.competitions.view', ['comp' => $lc]);
    }

    public function manage($cid){
        
        $lc = Competition::find($cid)->load('hostUni', 'currentSeason');

        if ($lc->host != auth()->user()->getHomeUni()->id || !auth()->user()->isUniAdmin()) {
            return redirect()->route('lc-view', $cid);
        }

        return view('dashboard.competitions.manage', ['comp' => $lc]);
    }

    public function resultsUpload(Request $request, $cid) {

        $lc = Competition::find($cid)->load('hostUni');

        $fileName = $lc->hostUni->name . " " .  $lc->when->format('Y') . " Results";

        $fileId = ResourceController::storeResource($request, 'results', 'resources/competition-results', $fileName);

        $lc->results_resource = $fileId;

        $lc->save();

        return redirect()->route('lc-manage', ['cid' => $cid]);

    }

    public function resultsRemove($cid) {
        $lc = Competition::find($cid);
        $lc->results_resource = null;
        $lc->save();
        return redirect()->route('lc-manage', ['cid' => $cid]);
    }

}
