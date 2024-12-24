@extends('layouts.adminlayout')

@section('title')
{{ $competition->getName() }} | Competitions | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.competitions') }}">Competitions</a>
        <span>></span>
        <p>{{ $competition->getName() }}</p>

    </div>

    <a href="{{ route('admin.season.view', $competition->currentSeason ?: 0) }}" class="text-gray-500 no-underline text-sm font-normal hover:underline hover:text-gray-800 hover:font-semibold">{{ $competition->currentSeason?->name }}</a>
    <h1 class="header -mt-1" style="margin-bottom: 0 !important;">{{ $competition->getName() }} </h1>
    <small class="text-bulsca_red no-underline text-sm font-semibold">{{ $competition->when->format('D dS M Y') }} </small>


    <br><br>


    @if ($competition->hasResults())
    <h3>Results</h3>
    <div class="flex items-center space-x-4">
        <x-resource-download :file="$competition->getResults()" />
        <a href="{{ route('lc-result-remove', $competition) }}?admin=true" class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 hover:text-bulsca_red transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>





    @else
    <h4>
        Upload Results
    </h4>
    <form action="{{ route('lc-result-upload', $competition) }}" class="grid grid-cols-1 md:grid-cols-3" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-input">
            <label for="upload-file">File</label>
            <input id="upload-file" class="input file" name="results" type="file">
            <input type="hidden" name="admin" value="true">
        </div>

        <div class="flex items-center justify-center">
            <strong>OR</strong>
        </div>

        <div class="form-input">
            <label for="result-link">Link</label>
            <input type="url" name="result-link" id="result-link">
        </div>

        <button class="btn btn-thinner row-start-2 col-start-3">Upload</button>
    </form>

    @endif






    <hr class="my-8">






    <div>
        <h3 class="header">Competition Details</h3>
        <p class="mb-2">See the competition page <a href="{{ route('lc-view', $competition) }}">here</a> for more info.</p>
        <form action="@can('admin.competitions.manage'){{ route('admin.competition.edit', $competition) }}@endcan" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input deny="{{ auth()->user()->cannot('admin.competitions.manage') }}" id='when' type="datetime-local" title='When' defaultValue='{{ $competition->when }}' />


            @can('admin.competitions.manage')
            <button type="submit" class="btn btn-thinner btn-save row-start-2 col-start-4">Save</button>
            @endcan
        </form>

        <hr class="my-8">

        <h3 class="header">Competition Placings</h3>
        <div x-data="{
            placed: {{ $placed }},
            unplaced: {{ json_encode($unplaced) }},
            leagues: ['a','b','o'],

            getPlacing(league) {
                let children = document.getElementById(`league-${league}`).querySelectorAll('[x-uni]')
                let unplaced = document.getElementById(`unplaced-${league}`).querySelectorAll('[x-uni]')

                let placing = []

                let place = 1
                children.forEach(child => {
                    console.log(child)
                    placing.push({
                        'uni': child.getAttribute('x-uni'),
                        'place': place
                    })
                    place++
                })

                unplaced.forEach(child => {
                    placing.push({
                        'uni': child.getAttribute('x-uni'),
                        'place': 0
                    })
                })
                
                return placing
            },

            save() {

                let placings = {}
                this.leagues.forEach(l => placings[l.toLowerCase()] = this.getPlacing(l))

                let url = '{{ route('admin.season.competition.results', [$competition->currentSeason, $competition]) }}'

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(placings)
                }).then(response => {
                    if (response.ok) {
                        showNotification('Saved placings')
                    } else {
                        alert('Error saving')
                    }
                })

            },

            
        }">

        

        <div class="grid-3" >
            <template x-for="league in leagues">
                <div>
                    <h5 class=" capitalize" x-text="league"></h3>
                    <ul x-sort.ghost :x-sort:group="league" :id="`league-${league}`" class=" list-inside list-decimal min-h-10 bg-gray-100">
                        <template x-for="uni in placed[league]" :key="uni.id">
                            <li  class="border rounded-md p-2 grow-0" x-sort:item :x-uni="uni.uni" x-text="uni.university.name"></li>
                        </template>
                    </ul>
                    <br>
               

                   
                </div>
            </template>

            <template x-for="league in leagues">
                <div>
                 
               

                    <p>Unplaced teams</p>
                    <ul class="list-inside list-none" :id="`unplaced-${league}`" x-sort.ghost :x-sort:group="league">
                        <template x-for="uni in unplaced[league]" :key="uni.id">
                            <li class="border rounded-md p-2 grow-0" x-sort:item :x-uni="uni.id" x-text="uni.name"></li>
                        </template>
                    </ul>
                </div>
            </template>

            <button type="button" @click="save()" class="btn btn-thinner btn-save row-start-3 col-start-3">Save</button>
        </div>
        
            
        </div>
    </div>

    <hr class="my-8">

    <div>
        <h3>Delete</h3>
        @can('admin.competitions.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.competitions.delete') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $competition->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this competition, please contact the Data Manager!</p>
        @endcan
    </div>

</div>


@endsection