<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Season extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;


    protected $guarded = ['id'];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',

    ];

    public function competitions()
    {
        return $this->hasMany(Competition::class, 'season');
    }

    public function unis()
    {
        return $this->hasManyThrough(University::class, SeasonUni::class, 'season', 'id', 'id', 'uni');
    }

    public function getALeagueResults()
    {
        return Cache::remember($this->id . '-a-league-res', 3600, function () {
            return $this->computeALeagueResults();
        });
    }

    private function computeALeagueResults()
    {
        /*
        SELECT U.name AS SeasonUni, UU.name AS Host, LC.when, GREATEST(1,11-CUP.a_pos) AS A_Points FROM competition_uni_places AS CUP
        INNER JOIN season_unis SU ON CUP.season_uni=SU.id
        INNER JOIN universities U ON SU.uni=U.id
        INNER JOIN league_competitions LC ON LC.id = CUP.league_comp
        INNER JOIN universities UU ON LC.host = UU.id
        WHERE SU.season=1 ORDER BY SeasonUni,LC.when;
        */

        return [];

        $res = DB::select(DB::raw('SELECT U.name AS SeasonUni, UU.name AS Host, LC.when, GREATEST(1,11-CUP.a_pos) AS Points FROM competition_uni_places AS CUP INNER JOIN season_unis SU ON CUP.season_uni=SU.id INNER JOIN universities U ON SU.uni=U.id INNER JOIN competitions LC ON LC.id = CUP.league_comp INNER JOIN universities UU ON LC.host = UU.id WHERE SU.season=? ORDER BY SeasonUni,LC.when'), [1]);


        $finalUnis = [];

        $currentUni = new ResultUni($res[0]->SeasonUni);


        foreach ($res as $row) {
            if ($row->SeasonUni != $currentUni->getName()) {
                array_push($finalUnis, $currentUni);

                $currentUni = new ResultUni($row->SeasonUni);
            }
            $currentUni->addScore($row->Points);
        }
        array_push($finalUnis, $currentUni);


        usort($finalUnis, function ($a, $b) {
            return $a->getTotal() < $b->getTotal();
        });

        return $finalUnis;
    }

    public function getBLeagueResults()
    {
    }



    static function current()
    {

        $s = Season::where('from', '<', now())->orderBy('from', 'desc')->first(); // This will show the current season until the next season starts, thus a new season can be made, but not automatically shown
        //$s = Season::where('from', '>', now())->where('to', '<', now())->first();

        if (!$s) {
            $s = Season::orderBy('from', 'DESC')->first();
        }

        return $s;
    }

    public function getDateSlug()
    {
        return $this->from->format('Y') . "-" . $this->to->format('y');
    }

    private function cmp($a, $b)
    {
        return $a['points'] > $b['points'] ? -1 : 1;
    }

    public function getLeagueResults($league)
    {


        return Cache::rememberForever('league-results.' . $this->id . '.' . $league, function () use ($league) {

            $compOrderData = $this->competitions()->with('hostUni')->orderBy('when')->get();

            $compOrder = [];

            foreach ($compOrderData as $cod) {
                array_push($compOrder, $cod->hostUni->name);
            }

            $data = DB::select(DB::raw("SELECT u.name AS host, team.name AS team, lp.league, lp.pos, IF(lp.pos = 0, 0,GREATEST(11 - lp.pos, 1)) AS points FROM league_places lp INNER JOIN competitions c on c.id = lp.comp INNER JOIN universities u ON u.id=c.host INNER JOIN universities team ON team.id = lp.uni WHERE c.season = ? AND lp.league = ? ORDER BY u.name, team.name"), [$this->id, $league]);


            $readyData = [];


            foreach ($data as $row) {


                $uniData = array_key_exists($row->team, $readyData) ? $readyData[$row->team] : [];
                $positionPoints = array_key_exists("positionPoints", $uniData) ? $uniData['positionPoints'] : [];
                $points = array_key_exists("points", $uniData) ? $uniData['points'] : 0;

                $points += $row->points;


                $positionPoints[$row->host] = $row->pos;



                $uniData['team'] = $row->team;
                $uniData['points'] = $points;
                $uniData['positionPoints'] = $positionPoints;

                $readyData[$row->team] = $uniData;
            }

            // We now need to process the data to sort the rows




            usort($readyData, [Season::class, "cmp"]);




            $cols = ["Team", "Position", "Points", ...$compOrder];


            return ['data' => $readyData, 'cols' => $cols, 'comps' => $compOrder];
        });
    }
}




class ResultUni
{

    private $uni;
    private $scores = [];
    private $total = 0;

    public function __construct($uni)
    {
        $this->uni = $uni;
    }

    public function addScore($score)
    {
        $this->total += $score;
        array_push($this->scores, $score);
    }

    public function getScores()
    {
        return $this->scores;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getName()
    {
        return $this->uni;
    }
}
