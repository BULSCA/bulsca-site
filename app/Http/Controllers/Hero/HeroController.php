<?php

namespace App\Http\Controllers\Hero;

use App\Http\Controllers\Controller;
use App\Models\Components\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {

        return view('admin.hero.index', [
            'heroes' => Hero::paginate(12)
        ]);
    }

    public function edit(Hero $hero)
    {
        return view('admin.hero.edit', [
            'hero' => $hero
        ]);
    }

    public function create()
    {

        $h = new Hero();
        $h->id = -1;
        $h->name = 'New Hero';
        $h->header_title = 'Title';
        $h->header_subtitle = 'Subtitle';
        $h->header_layout = 'vertical';
        $h->header_logo = '/storage/logo/blogo.png';
        $h->bg_type = 'image';
        $h->bg_value = 'background-image: url("/storage/logo/blogo.png");';

        $h->content = '';
        $h->activation_type = 'manual';
        $h->enabled = false;
        $h->valid_from = now();
        $h->valid_to = now();
        $h->height = '100vh';



        return view('admin.hero.edit', [
            'hero' => $h
        ]);
    }

    public function update(Request $request, Hero $hero)
    {
        $hero->update(json_decode($request->input('hero'), true));
        return response()->json(['message' => 'Hero updated successfully']);
    }

    public function store(Request $request)
    {
        $hero = Hero::create(json_decode($request->input('hero'), true));
        return response()->json(['message' => 'Hero created successfully', 'id' => $hero->id]);
    }

    public function delete(Request $request, Hero $hero)
    {

        $hero->delete();
        return redirect()->route('admin.hero');
    }
}
