<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Season;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {


        $uniCount = University::count();

        $count = [
            'uni' => University::count(),
            'user' => User::count(),
            'competition' => Competition::count()
        ];

        return view('admin.index', ['count' => $count, 'currentSeason' => Season::current()]);


    }

    public function viewSeasons() {
        return view('admin.seasons.index', ['seasons' => Season::orderBy('from', 'desc')->paginate(10)]);
    }

    public function viewSeason(Season $season) {
        return view('admin.seasons.view', ['season' => $season]);
    }
}
