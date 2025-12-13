<?php

namespace App\Http\Controllers\Organisation;

use App\Helpers\OrganisationHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\StoreOrganisationRequest;
use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Models\Organisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganisationController extends Controller
{
    public function index()
    {
        $organisations = Organisation::withCount(['members', 'committeeMembers', 'managers'])
            ->orderBy('name')
            ->paginate(20);
            
        return view('organisations.index', compact('organisations'));
    }
    
    public function show($id)
    {
        $organisation = Organisation::with([
            'managers',
            'committeePositions.members',
            'members'
        ])->findOrFail($id);
        
        $user = Auth::user();
        $canManage = $organisation->isManager($user);
        
        return view('organisations.show', compact('organisation', 'canManage'));
    }
    
    public function create()
    {
        $this->authorize('create', Organisation::class);
        
        $potentialParents = Organisation::orderBy('name')->get();
        
        return view('organisations.create', compact('potentialParents'));
    }
    
    public function store(StoreOrganisationRequest $request)
    {
        $this->authorize('create', Organisation::class);
        
        DB::beginTransaction();
        try {
            $organisation = Organisation::create($request->validated());
            
            // Make creator the owner
            $organisation->managers()->attach(Auth::id(), ['role' => 'owner']);
            
            DB::commit();
            
            return redirect()
                ->route('organisations.show', $organisation->id)
                ->with('success', 'Organisation created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create organisation: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('update', $organisation);
        
        $potentialParents = Organisation::where('id', '!=', $id)
            ->orderBy('name')
            ->get();
        
        return view('organisations.edit', compact('organisation', 'potentialParents'));
    }
    
    public function update(UpdateOrganisationRequest $request, $id)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('update', $organisation);
        
        $validated = $request->validated();
        
        // Prevent circular parent relationships
        if (isset($validated['parent_id']) && $validated['parent_id']) {
            if (OrganisationHelpers::wouldCreateCircularRelationship($organisation, $validated['parent_id'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Cannot set parent: would create circular relationship.');
            }
        }
        
        $organisation->update($validated);
        
        return redirect()
            ->route('organisations.show', $organisation->id)
            ->with('success', 'Organisation updated successfully.');
    }
    
    public function destroy($id)
    {
        $organisation = Organisation::findOrFail($id);
        $this->authorize('delete', $organisation);
        
        // Check for dependencies
        if ($organisation->children()->count() > 0) {
            return back()->with('error', 'Cannot delete organisation with child organisations.');
        }
        
        if ($organisation->competitions()->count() > 0) {
            return back()->with('error', 'Cannot delete organisation with associated competitions.');
        }
        
        $organisation->delete();
        
        return redirect()
            ->route('organisations.index')
            ->with('success', 'Organisation deleted successfully.');
    }
}