@extends('layouts.adminlayout')

@section('title')
{{ $organisation->name }} | Organisations | Admin |
@endsection

@php
    $orgEntity = $organisation->entity;
    $parentEntity = $orgEntity ? $orgEntity->parentMembership?->parent : null;
    $memberships = $orgEntity ? $orgEntity->childMemberships : collect();
@endphp


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.organisations') }}">Organisations</a>
        <span>></span>
        <p>{{ $organisation->name }}</p>

    </div>

    {{-- Debug Section --}}
    <hr class="my-8">
    <div style="background: #f0f0f0; padding: 1rem; margin: 1rem 0; border: 1px solid #ccc;">
        <h3>Debug Info</h3>
        <p>Organisation ID: {{ $organisation->id }}</p>
        <p>Organisation Name: {{ $organisation->name }}</p>
        <p>Has Entity: {{ $orgEntity ? 'YES' : 'NO' }}</p>
        @if($orgEntity)
            <p>Entity ID: {{ $orgEntity->id }}</p>
            <p>Entity Custom ID: {{ $orgEntity->custom_id }}</p>
            <p>Child Memberships Count: {{ $orgEntity->childMemberships->count() }}</p>
            <p>Has Parent Membership: {{ $orgEntity->parentMembership ? 'YES' : 'NO' }}</p>
            @if($orgEntity->parentMembership)
                <p>Parent Entity: {{ $orgEntity->parentMembership->parent->display_name ?? 'N/A' }}</p>
            @endif
        @endif
    </div>
    <hr class="my-8">

    @if($orgEntity)
        <x-profiles.wide-profile :member="$organisation->entity" />
    @endif

    <hr class="my-8">




    <div class=" group relative overflow-hidden rounded-md h-48 w-48 flex items-center justify-center">
        <div class="absolute top-0 left-0 w-full h-full hidden cursor-pointer bg-gray-100 bg-opacity-60 group-hover:flex items-center justify-center " onclick="openFileSelect()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <img src="{{ $organisation->image_path ? route('image', $organisation->image_path) : '/storage/logo/blogo.png' }}" class="" alt="" />
    </div>


    <hr class="my-8">


    <div>
        <h2>Members</h2>
        @if($orgEntity && $orgEntity->childMemberships->count() > 0)
        <ul>
            @foreach($memberships as $membership)
            <li>
                {{ $membership->child->display_name }} ({{ $membership->role }})
            </li>
            @endforeach
        </ul>
        @else
        <p>No child members found.</p>
        @endif

    </div>


    <hr class="my-8">


    <div>
        <h2>Delete</h2>
        @can('admin.organisations.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.organisations.delete') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $organisation->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this season, please contact the Data Manager!</p>
        @endcan
    </div>

</div>


@endsection