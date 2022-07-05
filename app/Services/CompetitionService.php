<?php 
namespace App\Services;

use App\Models\LeagueCompetition;

class CompetitionService {



    static function myCompetitions($futureOnly = true) {

        $hostUni = auth()->user()->getHomeUni();

        if (!$hostUni) return [];

        $comps = LeagueCompetition::where('host', $hostUni->id);

        if ($futureOnly) {
            $comps->where('when', '>=', now());
        }

        return $comps->orderBy('when', 'desc')->get();
    }

    static function upcoming() {
        return LeagueCompetition::where('when', '>=', now())->orderBy('when')->get();
    }

    static function checkCompetitionsForAlerts($competitions) {


        foreach ($competitions as $comp) {
            if ($comp->when <= now() && !$comp->results_resource) {
                $comp['alert'] = true;
                $comp['alert_message'] = "Please upload this competitions results!";
            }
        }

        return $competitions;


    }


}