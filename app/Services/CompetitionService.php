<?php 
namespace App\Services;

use App\Models\LeagueCompetition;

class CompetitionService {



    static function myCompetitions($futureOnly = true) {

        $hostUni = auth()->user()->home_uni;

        if (!$hostUni) return [];

        $comps = LeagueCompetition::where('host', $hostUni);

        if ($futureOnly) {
            $comps->where('when', '>=', now());
        }

        return $comps->orderBy('when')->get();
    }

    static function upcoming() {
        return LeagueCompetition::where('when', '>=', now())->orderBy('when')->get();
    }


}