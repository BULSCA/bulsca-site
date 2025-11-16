@extends('layouts.adminlayout')

@section('title')
Committee Roles | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Committee Roles</p>


    </div>

    <div class="flex items-center  mb-2">
        <h1 class="header">Committee Roles</h1>
        @can('admin.committee_roles.manage')<a href="{{ route('admin.committee_roles.create') }}" class="ml-auto btn btn-thinner">Create</a>@endcan
    </div>

    <div class="grid-2 gap-4">
        @if ($committee_roles->isEmpty())
        <p>No Committee Roles found</p>
        @else
            @foreach ($committee_roles as $committee_role)
            <a href="{{ route('admin.committee_role.view', $committee_role) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
                <div class="flex items-center justify-center">
                    <h3 class="header header-bold">
                        {{ $committee_role->label }}
                    </h3>
                    <small class="ml-auto mb-4 text-black font-normal ">{{ $committee_role->active }}</small>
                </div>
                <hr class="-mx-6 mb-4">
                <div>
                    <x-badge>Members: {{ $committee_role->members->count() }}</x-badge>
                    @if ($committee_role->active == 1)
                        <x-badge>Status: Active</x-badge>
                    @else
                        <x-badge>Status: Retired</x-badge>
                    @endif

                </div>
            </a>

            @endforeach
        @endif
    </div>

    {{ $committee_roles->links() }}



</div>


@endsection