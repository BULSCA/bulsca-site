<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;
use App\Models\Membership;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Entity::with('entityable', 'memberships')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parent_entity_id' => 'required|exists:entities,id',
            'child_entity_id' => 'required|exists:entities,id|unique:memberships,child_entity_id',
        ]);

        $membership = Membership::create($request->all());
        return response()->json($membership, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entity $entity)
    {
        return response()->json($entity->load('entityable', 'memberships'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entity $entity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entity $entity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entity $entity)
    {
        //
    }





    public function showView(Entity $entity)
    {
        $entity->load('entityable', 'parentMembership.parent.entityable', 'childMemberships.child.entityable');
        return view('entities.show', compact('entity'));
    }

    public function indexView()
    {
        $entities = Entity::with('entityable', 'childMemberships.child.entityable')->get();
        return view('entities.index', compact('entities'));
    }
}
