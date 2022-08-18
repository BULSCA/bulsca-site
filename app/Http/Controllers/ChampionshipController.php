<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{


    public function index()
    {
        return view('competitions.championships.index', ['season' => Season::current()]);
    }
}
