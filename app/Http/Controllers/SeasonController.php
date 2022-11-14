<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewSeason;
use App\Models\Competition;
use App\Models\LeaguePlace;
use Illuminate\Http\Request;
use App\Models\Season;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SeasonController extends Controller
{



    public function currentSeason()
    {

        //$season = Season::where('from', '<=', now())->orderBy('to','desc')->first();
        $season = Season::current();
        $comps = $season->competitions()->orderBy('when')->with('hostUni')->get();

        return view('competitions.league', ['season' => $season, 'comps' => $comps]);
    }

    public function previousSeason($sid)
    {

        $slugParts = explode('-', $sid);

        $season = Season::whereYear('from', $slugParts[0])->first();
        $comps = $season->competitions()->orderBy('when')->get();

        return view('competitions.league', ['season' => $season, 'comps' => $comps]);
    }

    public function previous()
    {
        return view('competitions.previous-leagues', ['seasons' => Season::orderBy('from', 'DESC')->paginate(6)]);
    }

    public function update(Request $request, Season $season)
    {

        $validated = Validator::make($request->all(), [
            'name' => 'required|min:8',
            'from' => 'required|date',
            'to' => 'required|date|after:from'
        ], [
            'after' => 'The season must end after the start date!'
        ])->validate();


        //     $validated = $request->validate([
        //         'name' => 'required|min:8',
        //         'from' => 'required|date',
        //         'to' => 'required|date|after:from'
        //     ],
        //     [
        //         'name' => 'ro'
        //     ]
        // );




        $season->name = $validated['name'];
        $season->from = $validated['from'];
        $season->to = $validated['to'];

        $season->save();

        return redirect()->back();
    }

    public function create(CreateNewSeason $request)
    {
        $validated = $request->validated();

        $season = new Season();

        $season->name = $validated['name'];
        $season->from = $validated['from'];
        $season->to = $validated['to'];

        $season->save();

        return redirect()->route('admin.season.view', $season)->with('message', 'Season created!');
    }

    public function delete(Request $request)
    {
        $season = Season::findOrFail($request->input('id', -1));

        $season->delete();

        return redirect()->route('admin.seasons')->with('message', 'Season Deleted!');
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

    public function resultsHandler(Request $request, Season $season)
    {
        // format is res.league.uni.comp e.g. res.a.1.1

        foreach ($request->all() as $key => $val) {
            if (Str::startsWith($key, 'res')) {


                $parts = explode("_", $key);
                $league = $parts[1];
                $uni = $parts[2];
                $comp = $parts[3];

                //echo "League: " . $league . ", Uni: " . $uni . ", Comp: " . $comp . ", Pos: " . $val . "<br>";




                LeaguePlace::updateOrCreate(['uni' => $uni, 'comp' => $comp, 'league' => $league], ['pos' => $val ? $val : 0]);
            }
        }
        return redirect()->back();
    }
}
