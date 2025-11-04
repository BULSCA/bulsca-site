<?php

namespace App\Http\Controllers;

use App\Models\Season;

class ChampionshipController extends Controller
{
    public function index()
    {
        return view('competitions.championships.index', ['season' => Season::current()]);
    }
}
