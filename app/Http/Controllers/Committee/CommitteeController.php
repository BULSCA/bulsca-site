<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Committee\Committee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CreateNewCommittee;

class CommitteeController extends Controller
{
    public function currentCommittee()
    {
        $committee = Committee::current();
        $roles = $committee->roles()->orderBy('order')->get();
        $members = $committee->members()->get();

        return view('get-involved.committee.index', ['committee' => $committee, 'roles' => $roles, 'members' => $members]);
    }

    public function previousCommittee($cid)
    {
        $slugParts = explode('-', $cid);

        $committee = committee::whereYear('start_date', $slugParts[0])->first();
        $roles = $committee->roles()->orderBy('order')->get();
        $members = $committee->members()->get();

        return view('get-involved.committee.committee', ['committee' => $committee, 'roles' => $roles, 'members' => $members]);
    }

    public function previous()
    {
        return view('get-involved.committee.previous-committees', ['committees' => Committee::orderBy('start_date', 'DESC')->paginate(6)]);
    }

    public function update(Request $request, Committee $committee)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|min:8',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'active' => 'boolean',
        ], [
            'after' => 'The committee must end after the start date!'
        ])->validate();

        $committee->name = $validated['name'];
        $committee->start_date = $validated['start_date'];
        $committee->end_date = $validated['end_date'];
        $committee->active = $validated['active'] ?? false;

        $committee->save();

        return redirect()->back();
    }

    public function create(CreateNewCommittee $request)
    {
        $validated = $request->validated();

        $committee = new Committee();

        $committee->name = $validated['name'];
        $committee->start_date = $validated['start_date'];
        $committee->end_date = $validated['end_date'];
        $committee->active = $validated['active'] ?? false;

        $committee->save();

        return redirect()->route('admin.committee.view', $committee)->with('message', 'Committee created!');
    }

    public function delete(Request $request)
    {
        $committee = Committee::findOrFail($request->input('id', -1));

        $committee->delete();

        return redirect()->route('admin.committees')->with('message', 'Committee Deleted!');
    }

}