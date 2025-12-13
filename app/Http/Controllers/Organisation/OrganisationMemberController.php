<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Member\AddMemberRequest;
use App\Http\Requests\Organisation\Member\UpdateMemberRequest;
use App\Models\Organisation\Organisation;

class OrganisationMemberController extends Controller
{
    public function index($id)
    {
        $organisation = Organisation::with('members')->findOrFail($id);
        $this->authorize('viewMembers', $organisation);
        
        return view('organisations.members.index', compact('organisation'));
    }
    
    public function store(AddMemberRequest $request, $id)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageMembers', $organisation);
        
        if ($organisation->members()->where('user_id', $request->user_id)->exists()) {
            return back()->with('error', 'User is already a member.');
        }
        
        $organisation->members()->attach($request->user_id, [
            'status' => $request->status,
            'joined_at' => now(),
        ]);
        
        return back()->with('success', 'Member added successfully.');
    }
    
    public function update(UpdateMemberRequest $request, $id, $userId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageMembers', $organisation);
        
        $organisation->members()->updateExistingPivot($userId, [
            'status' => $request->status,
        ]);
        
        return back()->with('success', 'Member status updated successfully.');
    }
    
    public function destroy($id, $userId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageMembers', $organisation);
        
        $organisation->members()->detach($userId);
        
        return back()->with('success', 'Member removed successfully.');
    }
}