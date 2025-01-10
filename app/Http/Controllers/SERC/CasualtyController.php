<?php

namespace App\Http\Controllers\SERC;

use App\Http\Controllers\Controller;
use App\Http\Requests\SERC\StoreCasualtyRequest;
use App\Models\Casualty\Casualty;
use App\Models\Casualty\CasualtyGroup;
use Illuminate\Http\Request;

class CasualtyController extends Controller
{
    public function index()
    {

        $casualties = null;

        if (request('s') != null) {
            $casualties = Casualty::where('name', 'LIKE', '%' . request('s') . '%')->orderBy('name');
        } else {
            $casualties = Casualty::orderBy('name');
        }

        return view('admin.sercs.casualties.index', ['casualties' => $casualties->paginate(12)]);
    }

    public function add()
    {

        $groups = CasualtyGroup::orderBy('name')->get();

        return view('admin.sercs.casualties.add', ['groups' => $groups]);
    }

    public function store(StoreCasualtyRequest $request)
    {

        $casualty = new Casualty();
        $casualty->name = $request->name;
        $casualty->description = $request->description;
        $casualty->manual_reference = $request->manual;
        $casualty->group = $request->group;

        $casualty->save();

        return redirect()->route('admin.sercs.casualties')->with('success', 'Created casualty!');
    }

    public function show(Casualty $casualty)
    {

        $groups = CasualtyGroup::orderBy('name')->get();

        return view('admin.sercs.casualties.show', ['casualty' => $casualty, 'groups' => $groups]);
    }

    public function update(Casualty $casualty, StoreCasualtyRequest $request)
    {

        $casualty->name = $request->name;
        $casualty->description = $request->description;
        $casualty->manual_reference = $request->manual;
        $casualty->group = $request->group;

        $casualty->save();

        return redirect()->back()->with('message', 'Updated Casualty!');
    }

    public function delete(Casualty $casualty)
    {

        $casualty->delete();

        return redirect()->route('admin.sercs.casualties')->with('message', 'Deleted casualty!');
    }
}
