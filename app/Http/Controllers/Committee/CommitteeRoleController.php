<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Committee\CommitteeRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CreateNewCommitteeRole;


class CommitteeRoleController extends Controller
{
    public function update(Request $request, CommitteeRole $committee_role)
    {
        $validated = Validator::make($request->all(), [
            'label' => 'required|min:5|max:255|string',
            'order' => 'required|integer',
            'active' => 'required|boolean',
            'user_id' => 'nullable|integer|exists:users,id',
        ])->validate();

        $committee_role->label = $validated['name'];
        $committee_role->order = $validated['order'];
        $committee_role->active = $validated['active'] ?? false;
        $committee_role->user_id = $validated['user_id'] ?? null;

        $committee_role->save();

        return redirect()->back();
    }

    public function create(CreateNewCommitteeRole $request)
    {
        $validated = $request->validated();

        $committee_role = new CommitteeRole();

        $committee_role->label = $validated['label'];
        $committee_role->active = $validated['active'] ?? false;

        $committee_role->save();

        return redirect()->route('admin.committee_role.view', $committee_role)->with('message', 'CommitteeRole created!');
    }

    public function delete(Request $request)
    {
        $committee_role = CommitteeRole::findOrFail($request->input('id', -1));

        $committee_role->delete();

        return redirect()->route('admin.committee_roles')->with('message', 'CommitteeRole Deleted!');
    }

}