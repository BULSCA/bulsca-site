@extends('layout')

@section('title')
    Casualties | Resources |
@endsection

@section('extra-meta')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl font-bold text-white">Casualties</h2>
                    <p class="text-white">❤️‍🩹</p>
                </div>
            </div>

        </div>


    </div>



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


                                <small class="flex items-center justify-center space-x-0 font-thin text-gray-400"
                                    title="# Casualties"><span>3</span> <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd"
                                            d="M19.449 8.448 16.388 11a4.52 4.52 0 0 1 0 2.002l3.061 2.55a8.275 8.275 0 0 0 0-7.103ZM15.552 19.45 13 16.388a4.52 4.52 0 0 1-2.002 0l-2.55 3.061a8.275 8.275 0 0 0 7.103 0ZM4.55 15.552 7.612 13a4.52 4.52 0 0 1 0-2.002L4.551 8.45a8.275 8.275 0 0 0 0 7.103ZM8.448 4.55 11 7.612a4.52 4.52 0 0 1 2.002 0l2.55-3.061a8.275 8.275 0 0 0-7.103 0Zm8.657-.86a9.776 9.776 0 0 1 1.79 1.415 9.776 9.776 0 0 1 1.414 1.788 9.764 9.764 0 0 1 0 10.211 9.777 9.777 0 0 1-1.415 1.79 9.777 9.777 0 0 1-1.788 1.414 9.764 9.764 0 0 1-10.212 0 9.776 9.776 0 0 1-1.788-1.415 9.776 9.776 0 0 1-1.415-1.788 9.764 9.764 0 0 1 0-10.212 9.774 9.774 0 0 1 1.415-1.788A9.774 9.774 0 0 1 6.894 3.69a9.764 9.764 0 0 1 10.211 0ZM14.121 9.88a2.985 2.985 0 0 0-1.11-.704 3.015 3.015 0 0 0-2.022 0 2.985 2.985 0 0 0-1.11.704c-.326.325-.56.705-.704 1.11a3.015 3.015 0 0 0 0 2.022c.144.405.378.785.704 1.11.325.326.705.56 1.11.704.652.233 1.37.233 2.022 0a2.985 2.985 0 0 0 1.11-.704c.326-.325.56-.705.704-1.11a3.016 3.016 0 0 0 0-2.022 2.985 2.985 0 0 0-.704-1.11Z"
                                            clip-rule="evenodd" />
                                    </svg>



                                </small>



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
