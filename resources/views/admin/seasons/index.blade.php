@extends('layouts.adminlayout')

@section('title')
Seasons | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Seasons</p>


    </div>

    <div class="flex items-center  mb-2">
        <h1 class="header">Seasons</h1>
        @can('admin.seasons.manage')<a href="{{ route('admin.seasons.create') }}" class="ml-auto btn btn-thinner">Create</a>@endcan
    </div>

    <div class="grid-2 gap-4">
        @foreach ($seasons as $season)
        <a href="{{ route('admin.season.view', $season) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h3 class="header header-bold">
                    {{ $season->name }}
                </h3>
                <small class="ml-auto mb-4 text-black font-normal ">{{ $season->from->format('d/m/Y') }} - {{ $season->to->format('d/m/Y') }}</small>
            </div>
            <hr class="-mx-6 mb-4">
            <div>
                <x-badge>Competitions: {{ $season->competitions->count() }}</x-badge>

            </div>
        </a>

        @endforeach
    </div>

    {{ $seasons->links() }}



</div>


@endsection