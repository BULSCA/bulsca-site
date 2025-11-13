<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Http\Controllers\Committee\CommitteeController;
use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Committee\Committee;
use App\Models\Committee\CommitteeRole;
use App\Models\Committee\CommitteeMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CreateNewCommitteeMember;


class CommitteeMemberController extends Controller
{
    public function update(Request $request, CommitteeMember $committee_member)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|min:8',
            'affiliated_uni_id' => 'nullable|integer|exists:universities,id',
        ])->validate();

        $committee_member->name = $validated['name'];
        $committee_member->affiliated_uni_id = $validated['affiliated_uni_id'] ?? null;

        $committee_member->save();

        return redirect()->back();
    }

    public function updateMemberPhoto(Request $request)
    {

        $validated = $request->validate([
            'image' => 'required|file',
            'member' => 'required'
        ]);

        $member = CommitteeMember::findOrFail($validated['member']);

        // User isn't authed or user isn't a admin for this uni
        if (!auth()->user() || auth()->user()->cannot('admin.committee_members.manage')) {
            abort(403);
        }

        $photoId = ImageService::store($request, '/logos/unis');

        $member->image_path = 'logos/committee_members/' . $photoId;

        $member->save();

        return redirect()->back();
    }

    public function create(CreateNewCommitteeMember $request, Committee $committee, CommitteeRole $role)
    {
        $validated = $request->validated();

        $committee->addRole($role);

        \Log::info('Creating CommitteeMember', [
            'committee_id' => $committee->id,
            'role_id' => $role->id,
            'name' => $validated['name'],
        ]);

        // Create member
        $member = new CommitteeMember();
        $member->name = $validated['name'];

        // Retrieve role, committee and associated University and associate them
        $member->role()->associate($role);
        $member->committee()->associate($committee);

        if (isset($validated['affiliated_uni_id'])) {
            $university = University::findOrFail($validated['affiliated_uni_id']);
            $member->affiliatedUniversity()->associate($university);
        }
        
        // Add role to committee (many-to-many)
        $committee->addRole($role);
        
        $member->save();

        return redirect()->route('admin.committee.view', $committee)->with('message', 'CommitteeMember created!');
    }

    public function delete(Request $request)
    {
        $committee_member = CommitteeMember::findOrFail($request->input('id', -1));

        $committee_member->delete();

        return redirect()->route('admin.committee_members')->with('message', 'CommitteeMember Deleted!');
    }

    public function getPhoto(string $member_name)
    {
        $member = CommitteeMember::where('name', $member_name)->first();

        if (!$member) {
            abort(404);
        }

        return response()->redirectTo("img/" . $member->image_path);
    }

}