<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Manager\AddManagerRequest;
use App\Http\Requests\Organisation\Manager\UpdateManagerRequest;
use App\Models\Organisation;
use App\Models\User;

class OrganisationManagerController extends Controller
{
    public function index($id)
    {
        $organisation = Organisation::with('managers')->findOrFail($id);
        $this->authorize('manageManagers', $organisation);
        
        return view('organisations.managers.index', compact('organisation'));
    }
    
    public function store(AddManagerRequest $request, $id)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageManagers', $organisation);
        
        if ($organisation->isManager(User::find($request->user_id))) {
            return back()->with('error', 'User is already a manager.');
        }
        
        $organisation->managers()->attach($request->user_id, ['role' => $request->role]);
        
        return back()->with('success', 'Manager added successfully.');
    }
    
    public function update(UpdateManagerRequest $request, $id, $userId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageManagers', $organisation);
        
        // Prevent removing last owner
        if ($request->role !== 'owner') {
            $ownerCount = $organisation->managers()->wherePivot('role', 'owner')->count();
            $isCurrentlyOwner = $organisation->managers()
                ->wherePivot('user_id', $userId)
                ->wherePivot('role', 'owner')
                ->exists();
                
            if ($ownerCount <= 1 && $isCurrentlyOwner) {
                return back()->with('error', 'Cannot change role: organisation must have at least one owner.');
            }
        }
        
        $organisation->managers()->updateExistingPivot($userId, ['role' => $request->role]);
        
        return back()->with('success', 'Manager role updated successfully.');
    }
    
    public function destroy($id, $userId)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('manageManagers', $organisation);
        
        // Prevent removing last owner
        $ownerCount = $organisation->managers()->wherePivot('role', 'owner')->count();
        $isOwner = $organisation->managers()
            ->wherePivot('user_id', $userId)
            ->wherePivot('role', 'owner')
            ->exists();
            
        if ($ownerCount <= 1 && $isOwner) {
            return back()->with('error', 'Cannot remove last owner.');
        }
        
        $organisation->managers()->detach($userId);
        
        return back()->with('success', 'Manager removed successfully.');
    }
}