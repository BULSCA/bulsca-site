@extends('layouts.adminlayout')

@section('title')
Committee Members | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Committee Members</p>


    </div>

    <div class="flex items-center  mb-2">
        <h1 class="header">Committee Members</h1>
    </div>

    <div class="grid-2 gap-4">
        @if ($committee_members->isEmpty())
        <p>No Committee Members found</p>
        @else
            @foreach ($committee_members as $committee_member)
            <a href="{{ route('admin.committee_member.view', $committee_member) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
                <div class="flex items-center justify-center">
                    <h3 class="header header-bold">
                        {{ $committee_member->name }}
                    </h3>
                </div>
                <hr class="-mx-6 mb-4">
                <div>
                    <x-badge>Role: {{ $committee_member->role->label }}</x-badge>
                    <x-badge>Committee: {{ $committee_member->committee->name }}</x-badge>

                </div>
            </a>

            @endforeach
        @endif
    </div>

    {{ $committee_members->links() }}



</div>


@endsection