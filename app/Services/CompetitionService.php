<?php 
namespace App\Services;

use App\Models\Competition;

class CompetitionService {



    static function myCompetitions($futureOnly = true) {

        $hostUni = auth()->user()->getHomeUni();

        if (!$hostUni) return [];

        $comps = Competition::where('host', $hostUni->id);

        if ($futureOnly) {
            $comps->where('when', '>=', now());
        }

        return $comps->orderBy('when', 'desc')->get();
    }

    static function upcoming() {
        return Competition::where('when', '>=', now())->orderBy('when')->get();
    }

    static function activeSignupCompetitions() {
        return Competition::where('signup_active', true)->get();
        // not sure if best method?  11/07/2025
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