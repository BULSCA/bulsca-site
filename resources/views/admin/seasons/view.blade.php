@extends('layouts.adminlayout')

@section('title')
{{ $season->name }} | Seasons | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.seasons') }}">Seasons</a>
        <span>></span>
        <p>{{ $season->name }}</p>

    </div>

    <h1 class="header">{{ $season->name }} </h1>

    <div class="flex flex-row items-center  ">
        @forelse ($season->competitions()->orderBy('when')->get() as $comp)
        <div class="flex-1 flex flex-col items-center justify-center">

            <div class="mb-4">
                <p class="text-xl">{{ $comp->hostUni->name }}</p>
            </div>

            <div class="relative border-t border-gray-300 w-full ">
                <div class="absolute flex w-full bottom-full top-full group items-center justify-center">
                    <span class="competition-status {{ $comp->status->toCSSStatus() }}"></span>

                    <div class="absolute  w-full hidden group-hover:flex items-center justify-center ">
                        <div class="bg-white rounded-md p-2 border-2">
                            <p class="text-xs">{{ $comp->status->toStatusMessage() }}</p>
                        </div>
                    </div>
                </div>



            </div>

            <div class="mt-4">
                <p class="text-sm">{{ $comp->when->format('d/m/Y') }}</p>
            </div>





        </div>
        @empty
        <div class="flex-1 flex flex-col items-center justify-center">

            <div class="mb-4">
                <p class="text-xl">No Competitions found</p>
            </div>

            <div class="relative border-t border-gray-300 w-full ">
                <div class="absolute flex w-full bottom-full top-full group items-center justify-center">
                    <span class="competition-status competition-status-alert"></span>

                    <div class="absolute  w-full hidden group-hover:flex items-center justify-center">
                        <div class="bg-white rounded-md p-2 border-2">
                            <p class="text-xs">Either <a href="#">approve</a> a competition proposal or <a href="#">add</a> a new competition</p>
                        </div>
                    </div>
                </div>



            </div>

            <div class="mt-4">
                <p class="text-sm">Either <a href="#">approve</a> a competition proposal or <a href="#">add</a> a new competition</p>
            </div>





        </div>

        @endforelse

    </div>

    <hr class="my-8">

    <div class="grid grid-cols-3 gap-4">
        @foreach ($season->competitions()->orderBy('when')->get() as $comp)
        <a href="{{ route('admin.competition.view', $comp) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h3 class="">
                    {{ $comp->hostUni->name }}
                </h3>
                <span class="ml-auto mb-4 competition-status {{ $comp->status->toCSSStatus() }}"></span>
            </div>
            <hr class="-mx-6 mb-4">
            <div>
                <x-badge>{{ $comp->when->format('d/m/Y') }}</x-badge>
                <x-badge style="{{ $comp->status->toBadgeCSS() }}">{{ $comp->status->toBadgeMessage() }}</x-badge>
            </div>
        </a>

        @endforeach
    </div>

    @if ($season->competitions->count() != 0)
    <hr class="my-8">
    @endif


    <div>
        <h1 class="header">Season Details</h1>
        <form action="@can('admin.seasons.manage'){{ route('admin.season.edit', $season) }}@endcan" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input deny="{{ auth()->user()->cannot('admin.seasons.manage') }}" id='name' title='Name' extraCss="col-span-2" defaultValue='{{ $season->name }}' />
            <x-form-input deny="{{ auth()->user()->cannot('admin.seasons.manage') }}" id='from' type="datetime-local" title='From' defaultValue='{{ $season->from }}' />
            <x-form-input deny="{{ auth()->user()->cannot('admin.seasons.manage') }}" id='to' type="datetime-local" title='To' defaultValue='{{ $season->to }}' />



            @can('admin.seasons.manage')
            <button type="submit" class="btn btn-thinner btn-save col-start-4">Save</button>
            @endcan
        </form>
    </div>
    <div>
        <h2>Delete</h2>
        @can('admin.seasons.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.seasons.delete') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $season->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this season, please contact the Data Manager!</p>
        @endcan
    </div>

</div>


@endsection