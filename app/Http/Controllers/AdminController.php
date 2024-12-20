<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Resource;
use App\Models\ResourcePage;
use App\Models\Season;
use App\Models\SERC\SERC;
use App\Models\University;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {


        $uniCount = University::count();

        $count = [
            'uni' => University::count(),
            'user' => User::count(),
            'competition' => Competition::count(),
            'serc' => SERC::count(),
            'resource' => Resource::count(),
            'season' => Season::count(),
        ];

        return view('admin.index', ['count' => $count, 'currentSeason' => Season::current()]);
    }

    public function viewSeasons()
    {
        return view('admin.seasons.index', ['seasons' => Season::orderBy('from', 'desc')->paginate(10)]);
    }

    public function viewSeason(Season $season)
    {
        return view('admin.seasons.view', ['season' => $season]);
    }

    public function viewSeasonCreate()
    {
        return view('admin.seasons.create');
    }

    public function viewCompetitions()
    {
        return view('admin.competitions.index', ['competitions' => Competition::orderBy('when', 'desc')->paginate(10)]);
    }

    public function viewCompetition(Competition $competition)
    {
        return view('admin.competitions.view', ['competition' => $competition]);
    }

    public function viewCompetitionCreate(Season $season)
    {
        return view('admin.competitions.create', ['season' => $season, 'unis' => University::orderBy('name')->get()]);
    }

    public function viewUniversities()
    {
        return view('admin.universities.index', ['universities' => University::orderBy('name')->paginate(10)]);
    }

    public function viewUniversity(University $university)
    {
        return view('admin.universities.view', ['university' => $university]);
    }

    public function viewUniversityCreate()
    {
        return view('admin.universities.create');
    }

    public function viewUsers()
    {
        return view('admin.users.index', ['users' => User::orderBy('name')->paginate(10)]);
    }

    public function viewUser(User $user)
    {
        return view('admin.users.view', ['user' => $user, 'unis' => University::orderBy('name')->get(), 'roles' => Role::where('name', '!=', 'super_admin')->get()]);
    }

    public function viewUserCreate()
    {
        return view('admin.users.create', ['unis' => University::all(), 'roles' => Role::where('name', '!=', 'super_admin')->get()]);
    }

    public function viewResources()
    {
        return view('admin.resources.index', ['resourcePages' => ResourcePage::orderBy('ordering')->get(), 'resources' => Resource::orderBy('name')->paginate(9)]);
    }

    public function viewResourcePage(ResourcePage $resourcePage)
    {
        return view('admin.resources.page', ['rp' => $resourcePage]);
    }
}
