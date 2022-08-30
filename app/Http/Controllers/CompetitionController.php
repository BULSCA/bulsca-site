<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewCompetition;
use App\Models\Competition;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompetitionController extends Controller
{
    //


    public function view($cid)
    {

        $arr = explode(".", $cid);
        $id = $arr[count($arr) - 1];



        $lc = Competition::findOrFail($id)->load('hostUni', 'currentSeason');

        return view('dashboard.competitions.view', ['comp' => $lc]);
    }

    public function manage($cid)
    {

        $lc = Competition::find($cid)->load('hostUni', 'currentSeason');

        if ($lc->host != auth()->user()->getHomeUni()->id || !auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id)) {
            return redirect()->route('lc-view', $cid);
        }

        return view('dashboard.competitions.manage', ['comp' => $lc]);
    }

    public function resultsUpload(Request $request, $cid)
    {

        $lc = Competition::find($cid)->load('hostUni');

        $fileName = $lc->hostUni->name . " " .  $lc->when->format('Y') . " Results";

        $fileId = ResourceController::storeResource($request, 'results', 'resources/competition-results', $fileName);

        $lc->results_resource = $fileId->id;

        $lc->save();

        if ($request->input('admin') == "true") {
            return redirect()->back();
        }

        return redirect()->route('lc-manage', ['cid' => $cid]);
    }

    public function resultsRemove(Request $request, $cid)
    {
        $lc = Competition::find($cid);
        $lc->results_resource = null;
        $lc->save();

        if ($request->input('admin') == "true") {
            return redirect()->back();
        }

        return redirect()->route('lc-manage', ['cid' => $cid]);
    }

    public function update(Request $request, Competition $competition)
    {

        $comp = $competition;



        $validated = Validator::make($request->all(), [

            'when' => 'required|date',

        ])->validate();





        $comp->when = $validated['when'];




        $comp->save();

        return redirect()->back();
    }

    public function create(CreateNewCompetition $request)
    {
        $validated = $request->validated();

        $comp = new Competition();
        $comp->host = $validated['host'];
        $comp->season = $validated['season'];
        $comp->when = $validated['when'];

        $comp->save();

        return redirect()->route('admin.competition.view', $comp)->with('message', 'Competition created!');
    }

    public function delete(Request $request)
    {
        $comp = Competition::findOrFail($request->input('id', -1));

        $season = $comp->season;

        $comp->delete();

        return redirect()->route('admin.season.view', $season)->with('message', 'Competition Deleted!');
    }
}
