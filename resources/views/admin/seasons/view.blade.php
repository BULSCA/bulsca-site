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
                @if ($comp->results_type != 'NONE')
                <span class="ml-auto mb-4 competition-status competition-status-finished"></span>
                @else
                <span class="ml-auto mb-4 competition-status"></span>
                @endif
                
            </div>
            <hr class="-mx-6 mb-4">
            <div>
                <x-badge>{{ $comp->when->format('d/m/Y') }}</x-badge>
                @if ($comp->results_type != 'NONE')
                <x-badge style="success">Results Published</x-badge>
                @else
                <x-badge style="alert">No Results</x-badge>
                @endif
              
            </div>
        </a>

        @endforeach
        <a href="{{ route('admin.competition.create', $season->id) }}" class="px-6 py-4 rounded-md border border-dashed hover:border-bulsca transition no-underline flex items-center justify-center group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-12 h-12 text-white  p-2 bg-gray-400 rounded-full group-hover:bg-gray-600 transition-colors">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
            </svg>

        </a>
    </div>

    @if ($season->competitions->count() != 0)
    <hr class="my-8">
    @endif


    <div>
        <h1 class="header">Season Details</h1>
        <form action="@can('admin.seasons.manage'){{ route('admin.season.edit', $season) }}@endcan" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <x-form-input deny="{{ auth()->user()->cannot('admin.seasons.manage') }}" id='name' title='Name' extraCss="md:col-span-2" defaultValue='{{ $season->name }}' />
            <x-form-input deny="{{ auth()->user()->cannot('admin.seasons.manage') }}" id='from' type="datetime-local" title='From' defaultValue='{{ $season->from }}' />
            <x-form-input deny="{{ auth()->user()->cannot('admin.seasons.manage') }}" id='to' type="datetime-local" title='To' defaultValue='{{ $season->to }}' />



            @can('admin.seasons.manage')
            <button type="submit" class="btn btn-thinner btn-save md:col-start-4">Save</button>
            @endcan
        </form>
    </div>

    <hr class="my-8">
    <div>
        <h1 class="header">Season Results</h1>
        <div class="alert">
            <h3>Use competition page instead</h3>
            <p>
                You should place universities from each competitions page (by selecting a competition above), <strong>not here!</strong>.
                <br>
                Only use this for <strong>ties</strong>, or <strong>advanced</strong> usage!
            </p>
        </div>
        <br>
        <p class="mb-4">Enter the position each university came at each competition in each league. Leave blank (or enter 0) if they didn't compete!
            <br>
            A - A League, B - B League, O - Overall
        </p>
        <form action="{{ route('admin.season.results', $season) }}" method="POST">
            @csrf
            <div class="table-wrapper relative">
                <table class=" table-auto" style="position: relative;">
                    <thead>
                        <tr>
                            <th>Team</th>
                            @foreach ($season->competitions()->orderBy('when')->get() as $comp)
                            <th>{{ $comp->hostUni->name }} Comp ({{ $comp->id }})</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\University::orderBy('name')->get() as $uni)
                        <tr>
                            <th>{{ $uni->name }} ({{ $uni->id }}) </th>

                            @foreach ($season->competitions()->orderBy('when')->get() as $comp)
                            <td class="">
                                <div class="flex space-x-2 items-center">
                                    <p>A</p>
                                    <input type="number" class="table-input" value="{{ App\Models\LeaguePlace::where(['uni' => $uni->id, 'comp' => $comp->id, 'league' => 'a'])->first()?->pos }}" name="res_a_{{$uni->id}}_{{$comp->id}}" id="">
                                </div>
                                <div class="flex space-x-2 items-center my-2">
                                    <p>B</p>
                                    <input type="number" class="table-input" value="{{ App\Models\LeaguePlace::where(['uni' => $uni->id, 'comp' => $comp->id, 'league' => 'b'])->first()?->pos }}" name="res_b_{{$uni->id}}_{{$comp->id}}" id="">
                                </div>
                                <div class="flex space-x-2 items-center">
                                    <p>O</p>
                                    <input type="number" class="table-input" value="{{ App\Models\LeaguePlace::where(['uni' => $uni->id, 'comp' => $comp->id, 'league' => 'o'])->first()?->pos }}" name="res_o_{{$uni->id}}_{{$comp->id}}" id="">
                                </div>



                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <br>

            <div class="flex">
                <button type="submit" class="btn btn-thinner ml-auto">Save</button>
            </div>
        </form>

    </div>
    <hr class="my-8">


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