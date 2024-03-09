<?php

namespace App\Http\Controllers;

use App\Models\ClubPage;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClubController extends Controller
{
    public function index()
    {

        $clubs = University::orderBy('name')->get();

        return view('get-involved.clubs', ['clubs' => $clubs]);
    }

    public function get($cid)
    {


        $club = $this->convertSlugToClub(($cid));

        return view('get-involved.view-club', ['club' => $club]);
    }

    public function edit($cid)
    {
        $club = $this->convertSlugToClub(($cid));

        if (!$club->currentUserIsClubAdmin() && auth()->user()->cannot('admin.universities.manage')) {
            return redirect()->route('view-club', ['cid' => Str::lower($club->name) . "." . $club->id]);
        }

        return view('get-involved.edit-club', ['club' => $club]);
    }

    public function update(Request $req, $cid)
    {
        $club = $this->convertSlugToClub(($cid));

        if (!$club->currentUserIsClubAdmin() && auth()->user()->cannot('admin.universities.manage')) {
            return redirect()->route('view-club', ['cid' => Str::lower($club->name) . "." . $club->id]);
        }

        $page = $club->getPage()->first();

        if ($page == null) {
            $page = new ClubPage();
            $page->uni = $club->id;
        }

        $page->content = $req->input('content', $page->content);
        $page->banner_color = $req->input('banner_color', $page->banner_color);
        $page->banner_text_color = $req->input('banner_text_color', $page->banner_text_color);

     


        $club->location = $req->input('location', $club->location);

        $club->save();

        $page->save();

        return redirect()->route('view-club', ['cid' => Str::lower($club->name) . "." . $club->id]);
    }

    private function convertSlugToClub($slug)
    {
        $split = explode('.', $slug);

        $clubId = $split[count($split) - 1];

        $club = University::find($clubId);
        return $club;
    }
}
