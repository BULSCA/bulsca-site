<?php

namespace App\Http\Controllers\Organisation;

use App\Helpers\OrganisationHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Committee\StoreCommitteePositionRequest;
use App\Http\Requests\Organisation\Committee\UpdateCommitteePositionRequest;
use App\Http\Requests\Organisation\Committee\AssignCommitteeMemberRequest;
use App\Models\Organisation\Organisation;
use App\Models\Organisation\OrganisationCommitteePosition;
use Illuminate\Support\Facades\Auth;

class OrganisationCommitteeController extends Controller
{
    public function index($id)
    {
        $organisation = Organisation::with(['committeePositions.members'])->findOrFail($id);
        $this->authorize('manageCommittee', $organisation);
        
        $availablePermissions = OrganisationHelpers::getAvailablePermissions();
        
        return view('organisations.committee.index', compact('organisation', 'availablePermissions'));
    }
    
    public function store(StoreCommitteePositionRequest $request, $id)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageCommittee', $organisation);
        
        $position = $organisation->committeePositions()->create($request->validated());
        
        return back()->with('success', 'Committee position created successfully.');
    }
    
    public function update(UpdateCommitteePositionRequest $request, $id, $positionId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageCommittee', $organisation);
        
        $position = OrganisationCommitteePosition::where('organisation_id', $id)
            ->findOrFail($positionId);
        
        $position->update($request->validated());
        
        return back()->with('success', 'Committee position updated successfully.');
    }
    
    public function destroy($id, $positionId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageCommittee', $organisation);
        
        $position = OrganisationCommitteePosition::where('organisation_id', $id)
            ->findOrFail($positionId);
        
        if ($position->members()->count() > 0) {
            return back()->with('error', 'Cannot delete position with assigned members. Remove members first.');
        }
        
        $position->delete();
        
        return back()->with('success', 'Committee position deleted successfully.');
    }
    
    public function assignMember(AssignCommitteeMemberRequest $request, $id, $positionId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageCommittee', $organisation);
        
        $position = OrganisationCommitteePosition::where('organisation_id', $id)
            ->findOrFail($positionId);
        
        if ($position->members()->where('user_id', $request->user_id)->exists()) {
            return back()->with('error', 'User is already assigned to this position.');
        }
        
        $position->members()->attach($request->user_id, [
            'appointed_at' => now(),
        ]);
        
        return back()->with('success', 'Committee member assigned successfully.');
    }
    
    public function removeMember($id, $positionId, $userId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageCommittee', $organisation);
        
        $position = OrganisationCommitteePosition::where('organisation_id', $id)
            ->findOrFail($positionId);
        
        $position->members()->detach($userId);
        
        return back()->with('success', 'Committee member removed successfully.');
    }
}