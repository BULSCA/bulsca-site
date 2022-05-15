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
        'to' => 'date'
    ];

    public function competitions() {
        return $this->hasMany(LeagueCompetition::class, 'season');
    }

    public function unis() {
        return $this->hasManyThrough(University::class, SeasonUni::class, 'season', 'id', 'id', 'uni');
    }

    public function getALeagueResults() {
        return Cache::remember($this->id . '-a-league-res', 3600, function () {
            return $this->computeALeagueResults();
        });
    }

    private function computeALeagueResults() {
                /*
        SELECT U.name AS SeasonUni, UU.name AS Host, LC.when, GREATEST(1,11-CUP.a_pos) AS A_Points FROM competition_uni_places AS CUP
        INNER JOIN season_unis SU ON CUP.season_uni=SU.id
        INNER JOIN universities U ON SU.uni=U.id
        INNER JOIN league_competitions LC ON LC.id = CUP.league_comp
        INNER JOIN universities UU ON LC.host = UU.id
        WHERE SU.season=1 ORDER BY SeasonUni,LC.when;
        */

        $res = DB::select(DB::raw('SELECT U.name AS SeasonUni, UU.name AS Host, LC.when, GREATEST(1,11-CUP.a_pos) AS Points FROM competition_uni_places AS CUP INNER JOIN season_unis SU ON CUP.season_uni=SU.id INNER JOIN universities U ON SU.uni=U.id INNER JOIN league_competitions LC ON LC.id = CUP.league_comp INNER JOIN universities UU ON LC.host = UU.id WHERE SU.season=? ORDER BY SeasonUni,LC.when'), [1]);
        

        $finalUnis = [];

        $currentUni = new ResultUni($res[0]->SeasonUni);


        foreach ($res as $row){
            if ($row->SeasonUni != $currentUni->getName()) {
                array_push($finalUnis, $currentUni);
                
                $currentUni = new ResultUni($row->SeasonUni);
            }
            $currentUni->addScore($row->Points);
        }
        array_push($finalUnis, $currentUni);


        usort($finalUnis, function ($a, $b){
            return $a->getTotal() < $b->getTotal();
        });

        return $finalUnis;
    }

    public function getBLeagueResults() {
    
    }

}




class ResultUni {

    private $uni;
    private $scores = [];
    private $total = 0;

    public function __construct($uni)
    {
      $this->uni = $uni;  
    } 

    public function addScore($score){
        $this->total += $score;
        array_push($this->scores, $score);
    }

    public function getScores(){
        return $this->scores;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getName(){
        return $this->uni;
    }


}

