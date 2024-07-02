@extends('layout')

@section('title')
SERCs | Resources |
@endsection

@section('extra-meta')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">SERCs</h2>
        <p class="text-white">{{ $count }} available</p>
      </div>
    </div>

  </div>


</div>



<div class="container-responsive" x-data="{
    sercs: [],

   

    filters: {
        when: 'all',
        author: '',
        casualties: {
            from: {{ $filterOptions['cas_min'] }},
            to: {{ $filterOptions['cas_max'] }},
            min: {{ $filterOptions['cas_min'] }},
            max: {{ $filterOptions['cas_max'] }},
        },
  

    
    },

    searchSercs() {
        fetch(`{{ route('resources.sercs.search') }}?cas_min=${this.filters.casualties.from}&cas_max=${this.filters.casualties.to}&when=${this.filters.when}&author=${this.filters.author}`).then(response => response.json()).then(data => {
            this.sercs = data
        })
    },

    handleFromRange(event) {
        event.preventDefault()
       
        let from = event.target.value * 1
        let to = this.filters.casualties.to * 1

        if (from === to) return

        if (from >= to) {
            this.filters.casualties.from = to

    
            
        } else {
            this.filters.casualties.from = event.target.value
        }

   

  
    },

    handleToRange(event) {
        event.preventDefault()
       
        let to = event.target.value * 1
        let from = this.filters.casualties.from * 1

        if (to === from) return

        if (to <= from) {
            this.filters.casualties.to = from
        
    
          
        } else {
            this.filters.casualties.to = event.target.value
        }

      
    
    },

    
}" x-init="searchSercs()">

<div class="flex space-x-4">
    <div class="min-w-56">
        <h5 class="bg-bulsca p-2 text-white">Filters</h5>

        <div class="flex flex-col space-y-1">
            <div class="mb-2">
                <label for="fromRange" class="text-sm">Casualties</label>
                <div class="w-full multi-range mt-3 ">
                    <input type="range" id="fromRange" @change="searchSercs()" @input="(e) => handleFromRange(e)" step=1 x-model:value="filters.casualties.from" x-bind:min="filters.casualties.min" x-bind:max="filters.casualties.max" value="0">
                    <input type="range" class=" " @change="searchSercs()" @input="(e) => handleToRange(e)" step=1 x-model:value="filters.casualties.to" x-bind:min="filters.casualties.min" x-bind:max="filters.casualties.max" value="100">
                </div>
                <div class="flex justify-between w-full text-sm text-gray-400">
                    <small x-text="filters.casualties.from">{{ $filterOptions['cas_min'] }}</small>
                    <small x-text="filters.casualties.to">{{ $filterOptions['cas_max'] }}</small>
                </div>
                
            </div>
    
            <div class="form-input text-sm">
                <label for="filter-author">Author</label>
                <input type="text" id="filter-author" class="input smaller" @input.debounce="searchSercs()"  x-model="filters.author">
            </div>

            <div class="form-input text-sm">
                <label for="filter-year">Year</label>
                <select id="filter-year" class="input smaller" x-model="filters.when"  @change="searchSercs()">
                    <option value="all">All</option>
                    @foreach ($filterOptions['whens'] as $when)
                        <option value="{{ $when }}">{{ $when }}</option>
                        
                    @endforeach
                </select>
            </div>
        </div>
            
        
    </div>
    <div class="w-full grid-3 flex-grow-0">

        <template x-for="serc in sercs">

            <div class="border rounded-md px-3 py-4 ">
                <h5 class="mb-0" x-text="serc.name">SERC Name</h5>
                <div class="flex justify-between text-gray-400">
                    <small x-text="serc.author ? serc.author : 'Unknown'">Author Name</small>
    
                    <div class="flex space-x-2">
                    <small class="flex items-center justify-center space-x-0" title="# Casualties"><span x-text="serc.casualties ? serc.casualties : '-'">3</span> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                          </svg>
                          
                          </small>
                    </div>
    
                   
                </div>
                
                <p class="mt-1 mb-2 line-clamp-3" x-text="serc.description ? serc.description : '-'">Description</p>
    
                
                <div class="overflow-x-auto flex flex-row whitespace-nowrap thin-scrollbar">
                    
                    <span class="badge badge-warning" x-text="new Date(serc.when).toLocaleDateString()">When</span>
                    <span class="badge badge-warning" x-text="serc.where">Where</span>
              
                    <template x-for="tag in serc.tags">
                        <span class="badge badge-info" x-text="tag.name">Tag</span>
                    </template>
                    
    
                  
    
                </div>
            </div>

        </template>


        
    </div>
</div>



  
</div>













@endsection