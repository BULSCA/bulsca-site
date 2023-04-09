<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewCompetition;
use App\Http\Requests\ManageCompetitionRequest;
use App\Models\Competition;
use App\Models\CompetitionInfo;
use App\Models\ResultType;
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

        $info = $lc->getInfo;
        if ($info == null) {
            $info = new CompetitionInfo();
            $info->competition = $lc->id;
            $info->save();
        }

        return view('dashboard.competitions.view', ['comp' => $lc, 'info' => $info]);
    }

    public function manage($cid)
    {

        $arr = explode(".", $cid);
        $id = $arr[count($arr) - 1];

        $lc = Competition::find($id)->load('hostUni', 'currentSeason');

        if (!$lc->hostUni->currentUserIsClubAdmin()) {
            return redirect()->route('lc-view', $cid);
        }


        $info = $lc->getInfo;
        if ($info == null) {
            $info = new CompetitionInfo();
            $info->competition = $lc->id;
            $info->save();
            $lc = Competition::find($cid)->load('hostUni', 'currentSeason');
        }

        return view('dashboard.competitions.manage', ['comp' => $lc]);
    }

    public function resultsUpload(Request $request, $cid)
    {

        if (!$request->hasFile('results') && $request->input('result-link', "") == "") return redirect()->back();

        $lc = Competition::find($cid)->load('hostUni');


        if ($request->input('result-link', "") != "") {
            $lc->setResults(ResultType::LINK, $request->input('result-link', ""));
            $lc->save();
            if ($request->input('admin') == "true") {
                return redirect()->back();
            }

            return redirect()->route('lc-manage', ['cid' => $cid]);
        }


        $fileName = $lc->hostUni->name . " " .  $lc->when->format('Y') . " Results";

        $fileId = ResourceController::storeResource($request, 'results', 'resources/competition-results', $fileName);

        //$lc->results_resource = $fileId->id;

        $lc->setResults(ResultType::RESOURCE, $fileId->id);

        $lc->save();

        if ($request->input('admin') == "true") {
            return redirect()->back();
        }

        return redirect()->route('lc-manage', ['cid' => $cid]);
    }

    public function resultsRemove(Request $request, $cid)
    {
        $lc = Competition::find($cid);

        if ($lc->results_resource) $lc->results_resource = null;

        $lc->results_type = ResultType::NONE;
        $lc->save();

        if ($request->input('admin') == "true") {
            return redirect()->back();
        }

        return redirect()->route('lc-manage', ['cid' => $cid]);
    }

    public function packUpload(Request $request, $cid)
    {

        $lc = Competition::find($cid)->load('hostUni');

        $fileName = $lc->hostUni->name . " " .  $lc->when->format('Y') . " Info Pack";

        $fileId = ResourceController::storeResource($request, 'results', 'resources/competition-packs', $fileName);

        $lc->pack_resource = $fileId->id;

        $lc->save();

        if ($request->input('admin') == "true") {
            return redirect()->back();
        }

        return redirect()->route('lc-manage', ['cid' => $cid]);
    }

    public function packRemove(Request $request, $cid)
    {
        $lc = Competition::find($cid);
        $lc->pack_resource = null;
        $lc->save();

        if ($request->input('admin') == "true") {
            return redirect()->back();
        }

        return redirect()->route('lc-manage', ['cid' => $cid]);
    }




    public function update(ManageCompetitionRequest $request, Competition $cid)
    {
        $comp = $cid;

        $info = $comp->getInfo;

        if ($info === null) {
            $info = new CompetitionInfo();
            $info->competition = $cid->id;
        }

        $timetable = [];

        $request->merge(["general_fak_travel" => $request->exists('general_fak_travel'), "general_fak_full" => $request->exists('general_fak_full')]);

        foreach ($request->all() as $key => $value) {
            if (str_contains($key, "timetable")) {
                $request->request->remove($key);
                $timetable[$key] = $value;
            }

            if (str_contains($key, "cost")) {
                $request->merge([$key => str_replace("£", "", str_replace(",", "", $value))]);
            }
        }

        $data = $request->all();

        $data['teams_limit'] =  $request->input('teams_limit', 0);
        if ($data['teams_limit'] === null) {
            $data['teams_limit'] = 0;
        }

        $info->fill($data);

        $info->timetable = $timetable;


        $info->save();

        return redirect()->back();
    }





    public function adminUpdate(Request $request, Competition $competition)
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
