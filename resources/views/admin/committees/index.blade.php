@extends('layouts.adminlayout')

@section('title')
Committees | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Committees</p>


    </div>

    <div class="flex items-center  mb-2">
        <h1 class="header">Committees</h1>
        @can('admin.committees.manage')<a href="{{ route('admin.committees.create') }}" class="ml-auto btn btn-thinner">Create</a>@endcan
    </div>

    <div class="grid-2 gap-4">
        @if ($committees->isEmpty())
        <p>No Committees found</p>
        @else
            @foreach ($committees as $committee)
            <a href="{{ route('admin.committee.view', $committee) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
                <div class="flex items-center justify-center">
                    <h3 class="header header-bold">
                        {{ $committee->name }}
                    </h3>
                    <small class="ml-auto mb-4 text-black font-normal ">{{ $committee->start_date->format('d/m/Y') }} - {{ $committee->end_date->format('d/m/Y') }}</small>
                </div>
                <hr class="-mx-6 mb-4">
                <div>
                    <x-badge>Members: {{ $committee->members->count() }}</x-badge>

                </div>
            </a>

            @endforeach
        @endif
    </div>

    {{ $committees->links() }}



</div>


@endsection