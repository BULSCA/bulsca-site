<?php

namespace App\Http\Controllers;

use App\Services\CompetitionService;

class DashboardController extends Controller
{
    public function index()
    {

        return view('dashboard.dashboard', [
            'myCompetitions' => CompetitionService::checkCompetitionsForAlerts(CompetitionService::myCompetitions(false)),
            'upcoming' => CompetitionService::upcoming(),
        ]);
    }
}
