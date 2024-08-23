<?php

namespace App\Http\Controllers\Hero;

use App\Http\Controllers\Controller;
use App\Models\Components\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index() {

        return view('admin.hero.index', [
            'heroes' => Hero::paginate(12)
        ]);
    }

    public function edit(Hero $hero) {
        return view('admin.hero.edit', [
            'hero' => $hero
        ]);
    }
}
