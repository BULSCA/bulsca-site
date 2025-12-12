@extends('layout')

@section('title')
    Casualties | Resources |
@endsection

@section('extra-meta')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
    <x-page-banner
        title="Casualties"
        subtitle="❤️‍🩹"
        :snowContainer="true"
    />



    <div class="container-responsive" x-data="{
        casualties: [],
    
    
        activeSerc: null,
        showModal: false,
    
        tagSearch: '',
    
        filters: {
            search: '',
    
            group: 'all',
    
        },
    
    
    
    
    
        searchCasualties() {
    
            this.updateQueryHistory()
    
            let queryParams = `?search=${this.filters.search}&group=${this.filters.group}`
    
            fetch(`{{ route('resources.casualties.search') }}${queryParams}`).then(response => response.json()).then(data => {
                this.casualties = data
            })
        },
    
        updateQueryHistory() {
            let queryParams = `?search=${this.filters.search}&group=${this.filters.group}`
            window.history.pushState({}, '', `{{ route('resources.casualties') }}${queryParams}`)
        },
    
    
    
    
    
        parseDefaultURL() {
            let url = new URL(window.location.href)
    
            let params = url.searchParams
    
            this.filters.search = params.get('search') || ''
            this.filters.group = params.get('group') || 'all'
    
            this.searchCasualties()
    
    
        },
    
    
    
    
    
    
    }" x-init="() => { parseDefaultURL() }">



        <div class="flex md:flex-row flex-col md:space-x-4 relative ">
            <div class="md:min-w-56 md:w-56 w-full relative ">
                <div class="sticky top-24">
                    <h5 class="bg-bulsca p-2 text-white">Filters</h5>

                    <div class="flex flex-col space-y-1">



                        <div class="form-input text-sm">
                            <label for="filter-year">Group</label>
                            <select id="filter-year" class="input smaller" x-model="filters.group"
                                @change="searchCasualties()">
                                <option value="all">All</option>
                                @foreach ($filterOptions['groups'] as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>

                </div>
            </div>

            <div class="w-full relative ">
                <div class="md:sticky top-24">
                    <div class="form-search group col-span-3 mb-3 relative">

                        <input type="text" id="resource-search" class="input " x-model="filters.search"
                            @input.debounce="searchCasualties()" placeholder="Search by name...">
                    </div>
                </div>


                <div class="w-full grid grid-cols-1 lg:grid-cols-2 3xl:grid-cols-4 gap-4 flex-grow-0 items-start">



                    <template x-if="casualties.length == 0">
                        <div class="col-span-3 flex items-center justify-center">
                            <p>No Casualties found</p>
                        </div>
                    </template>

                    <template x-for="casualty in casualties">

                        <a :href="casualty.link" target="_blank"
                            class="border rounded-md px-3 py-4 cursor-pointer hover:border-black hover:shadow-md group no-underline">

                            <div
                                class="flex items-center justify-center overflow-hidden rounded-md aspect-video relative group mb-2">
                                <img :src="casualty.images[0]" class="w-full" alt="">
                            </div>

                            <div class="flex justify-between items-center mb-1">


                                <h5 class="mb-0 line-clamp-1 group-hover:line-clamp-none" x-text="casualty.name">Casualty
                                    Name
                                </h5>






                            </div>






                            <div class="overflow-x-auto flex flex-row whitespace-nowrap thin-scrollbar">

                                <span class="badge badge-warning" x-text="casualty.group">Group</span>







                            </div>
                        </a>

                    </template>

                </div>
            </div>

        </div>

    </div>
@endsection
