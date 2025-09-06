<?php

namespace App\Http\Controllers\SERC;

use App\Http\Controllers\Controller;
use App\Http\Requests\SERC\StoreCasualtyGroupRequest;
use App\Models\Casualty\CasualtyGroup;

class CasualtyGroupController extends Controller
{
    public function index()
    {

        $groups = null;

        if (request('s') != null) {
            $groups = CasualtyGroup::where('name', 'LIKE', '%'.request('s').'%')->orderBy('name');
        } else {
            $groups = CasualtyGroup::orderBy('name');
        }

        return view('admin.sercs.casualties.groups.index', ['groups' => $groups->paginate(12)]);
    }

    public function add()
    {
        return view('admin.sercs.casualties.groups.add');
    }

    public function store(StoreCasualtyGroupRequest $storeCasualtyGroupRequest)
    {
        $group = new CasualtyGroup;
        $group->name = $storeCasualtyGroupRequest->name;
        $group->description = $storeCasualtyGroupRequest->description;
        $group->save();

        return redirect()->route('admin.sercs.casualties.groups');
    }

    public function show(CasualtyGroup $group)
    {
        return view('admin.sercs.casualties.groups.show', ['group' => $group]);
    }

    public function update(CasualtyGroup $group, StoreCasualtyGroupRequest $request)
    {
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();

        return redirect()->back()->with('message', 'Updated Casualty group!');
    }

    public function delete(CasualtyGroup $group)
    {
        $group->delete();

        return redirect()->route('admin.sercs.casualties.groups')->with('message', 'Deleted Casualty group!');
    }
}
