<?php

namespace App\Http\Controllers;

use App\Services\CompetitionService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {





        return view('dashboard.dashboard', [
            'myCompetitions' => CompetitionService::myCompetitions(),
            'upcoming' => CompetitionService::upcoming()
        ]);
    }
}
