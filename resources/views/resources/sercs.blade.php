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
        tags: {{ $filterOptions['tags'] }},

        activeSerc: null,
        showModal: false,

        tagSearch: '',
    
        filters: {
            search: '',
            when: 'all',
            where: 'all',
            author: '',
            tags: [],
            casualties: {
                from: {{ $filterOptions['cas_min'] }},
                to: {{ $filterOptions['cas_max'] }},
                min: {{ $filterOptions['cas_min'] }},
                max: {{ $filterOptions['cas_max'] }},
            },
    
    
    
        },


    
    
    
        searchSercs() {
    
            this.updateQueryHistory()

            let queryParams = `?search=${this.filters.search}&cas_min=${this.filters.casualties.from}&cas_max=${this.filters.casualties.to}&when=${this.filters.when}&where=${this.filters.where}&author=${this.filters.author}&tags=${this.filters.tags.join(',')}&open=${this.activeSerc ? this.activeSerc.id : ''}`
    
            fetch(`{{ route('resources.sercs.search') }}${queryParams}`).then(response => response.json()).then(data => {
                this.sercs = data
            })
        },

        updateQueryHistory() {
            let queryParams = `?search=${this.filters.search}&cas_min=${this.filters.casualties.from}&cas_max=${this.filters.casualties.to}&when=${this.filters.when}&where=${this.filters.where}&author=${this.filters.author}&tags=${this.filters.tags.join(',')}&open=${this.activeSerc ? this.activeSerc.id : ''}`
    
            window.history.pushState({}, '', `{{ route('resources.sercs') }}${queryParams}`)
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
    
        toggleTag(tagId) {
    
            if (this.filters.tags.includes(tagId)) {
                this.filters.tags = this.filters.tags.filter(tag => tag !== tagId)
            } else {
                this.filters.tags.push(tagId)
            }
    
            this.searchSercs()
    
        },
    
        parseDefaultURL() {
            let url = new URL(window.location.href)
    
            let params = url.searchParams
    
            this.filters.search = params.get('search') || ''
            this.filters.when = params.get('when') || 'all'
            this.filters.where = params.get('where') || 'all'
            this.filters.author = params.get('author') || ''
    
            if (params.get('tags')) {
                params.get('tags').split(',').forEach(tag => {
                    this.filters.tags.push(tag * 1)
                })
            }
    
            this.filters.casualties.from = params.get('cas_min') || {{ $filterOptions['cas_min'] }}
            this.filters.casualties.to = params.get('cas_max') || {{ $filterOptions['cas_max'] }}
    
            this.searchSercs()

            if (params.get('open')) {
                let serc = {'id': params.get('open')}
                this.loadSerc(serc)
            }
    
        },

        loadSerc(serc) {

            fetch(`{{ route('resources.sercs.get', '') }}/${serc.id}`).then(response => response.json()).then(data => {
                this.activeSerc = data
                this.showModal = true
                this.updateQueryHistory()
            })

          
        },

        closeModal() {
            this.showModal = false
            setTimeout(() => {this.activeSerc=null; this.updateQueryHistory()}, 250)
            
        }
    
    
    }" x-init="() => { parseDefaultURL() }">

        <p>Below you can see and filter through our collection of SERCs. To view more information and download the SERC documents simply click the relevant SERC!</p>
        <br>

        <div class="flex md:flex-row flex-col md:space-x-4 relative ">
            <div class="md:min-w-56 md:w-56 w-full relative ">
                <div class="sticky top-24">
                <h5 class="bg-bulsca p-2 text-white">Filters</h5>

                <div class="flex flex-col space-y-1">
                    <div class="mb-2">
                        <label for="fromRange" class="text-sm">Casualties</label>
                        <div class="w-full multi-range mt-3 ">
                            <input type="range" id="fromRange" @change="searchSercs()" @input="(e) => handleFromRange(e)"
                                step=1 x-model:value="filters.casualties.from" x-bind:min="filters.casualties.min"
                                x-bind:max="filters.casualties.max" value="0">
                            <input type="range" class=" " @change="searchSercs()" @input="(e) => handleToRange(e)"
                                step=1 x-model:value="filters.casualties.to" x-bind:min="filters.casualties.min"
                                x-bind:max="filters.casualties.max" value="100">
                        </div>
                        <div class="flex justify-between w-full text-sm text-gray-400">
                            <small x-text="filters.casualties.from">{{ $filterOptions['cas_min'] }}</small>
                            <small x-text="filters.casualties.to">{{ $filterOptions['cas_max'] }}</small>
                        </div>

                    </div>

                    <div class="form-input text-sm">
                        <label for="filter-author">Author</label>
                        <input type="text" id="filter-author" class="input smaller" @input.debounce="searchSercs()"
                            x-model="filters.author">
                    </div>

                    <div class="form-input text-sm">
                        <label for="filter-year">Year</label>
                        <select id="filter-year" class="input smaller" x-model="filters.when" @change="searchSercs()">
                            <option value="all">All</option>
                            @foreach ($filterOptions['whens'] as $when)
                                <option value="{{ $when }}">{{ $when }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-input text-sm">
                        <label for="filter-year">Where</label>
                        <select id="filter-year" class="input smaller" x-model="filters.where" @change="searchSercs()">
                            <option value="all">All</option>
                            @foreach ($filterOptions['wheres'] as $where)
                                <option value="{{ $where->where }}">{{ $where->where }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <div class="flex items-center justify-between">
                            <p class="text-sm">Tags</p>
                            <small class=" text-[0.65rem] text-gray-400">(Click to toggle)</small>
                        </div>
                        <div class="form-search group text-xs my-1">
                            <input type="text" id="resource-search" class="input " style="padding: 0.25rem 0.5rem !important" x-model="tagSearch"
                                 placeholder="Search tags...">
                        </div>
                        <div class="flex flex-wrap max-h-60 overflow-y-scroll thin-scrollbar">
                            <template x-for="tag in tags">
                                <span class="badge mb-1 cursor-pointer" @click="toggleTag(tag.id)"
                                    :class="tag.name.toLowerCase().includes(tagSearch.toLowerCase().trim()) ? (filters.tags.includes(tag.id) ? 'badge-active' : 'badge-info') : 'hidden'"
                                    x-text="tag.name">Tag</span>
                            </template>
                        </div>

                    </div>
                </div>

            </div>
            </div>

            <div class="w-full relative ">
                <div class="md:sticky top-24">
                <div class="form-search group col-span-3 mb-3 relative">
                    
                    <input type="text" id="resource-search" class="input " x-model="filters.search"
                        @input.debounce="searchSercs()" placeholder="Search by name...">
                </div>
            </div>


                <div class="w-full grid grid-cols-1 lg:grid-cols-2 3xl:grid-cols-3 gap-4 flex-grow-0 items-start">



                    <template x-if="sercs.length == 0">
                        <div class="col-span-3 flex items-center justify-center">
                            <p>No SERCs found</p>
                        </div>
                    </template>

                    <template x-for="serc in sercs">

                        <div class="border rounded-md px-3 py-4 cursor-pointer hover:border-black hover:shadow-md group" @click="loadSerc(serc)">
                            <h5 class="mb-0 line-clamp-1 group-hover:line-clamp-none" x-text="serc.name">SERC Name</h5>
                            <div class="flex justify-between text-gray-400">
                                <small x-text="serc.author ? serc.author : 'Unknown'">Author Name</small>

                                <div class="flex space-x-2">
                                    <small class="flex items-center justify-center space-x-0" title="# Casualties"><span
                                            x-text="serc.casualties ? serc.casualties : '-'">3</span> <svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="size-4">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                        </svg>

                                    </small>
                                </div>


                            </div>

                            <p class="mt-1 mb-2 line-clamp-3" x-text="serc.description ? serc.description : '-'">Description
                            </p>


                            <div class="overflow-x-auto flex flex-row whitespace-nowrap thin-scrollbar">

                                <span class="badge badge-warning"
                                    x-text="new Date(serc.when).toLocaleDateString()">When</span>
                                <span class="badge badge-warning" x-text="serc.where">Where</span>

                                <template x-for="tag in serc.tags">
                                    <span class="badge"
                                        :class="filters.tags.includes(tag.id) ? 'badge-active' : 'badge-info'"
                                        x-text="tag.name">Tag</span>
                                </template>




                            </div>
                        </div>

                    </template>



                </div>
            </div>


        </div>


        <div class="modal" x-show="showModal" x-transition.opacity style="display: none" >
            <div @click.outside="closeModal()">
                <div class="flex items-center justify-between sticky top-0 bg-white">
                    <h3 class="mb-0 line-clamp-1 hover:line-clamp-none max-w-[90%]" x-text="activeSerc?.name">SERC Name</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 transition-transform hover:rotate-90 cursor-pointer" @click="closeModal()">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                      </svg>
                      
                </div>
   
                <div class="flex justify-between text-gray-400 relative">
                    <small x-text="activeSerc?.author ? activeSerc.author : 'Unknown'" class="sticky top-0 bg-white">Author Name</small>

                    <div class="flex space-x-2">
                        <small class="flex items-center justify-center space-x-0" title="# Casualties"><span x-text="activeSerc?.casualties">3</span> <svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                class="size-4">
                                <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                            </svg>

                        </small>
                    </div>


                </div>

                <p class="mt-1 mb-2 " x-text="activeSerc?.description ? activeSerc.description : 'No description provided'">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero, ipsa est! Accusamus odio debitis sint tempora eaque cumque repudiandae veniam, rem porro nisi, quo saepe neque dicta. Voluptas, repudiandae. Modi.Commodi quos beatae expedita unde laborum nesciunt reprehenderit explicabo quia nostrum, non harum eum corporis laboriosam consequatur dolorem consequuntur id quas error excepturi doloribus exercitationem asperiores labore. Consectetur, obcaecati ut.</p>


                <div class="overflow-x-auto flex flex-row whitespace-nowrap thin-scrollbar">
                    <span class="badge badge-warning" x-text="new Date(activeSerc?.when).toLocaleDateString()">When</span>
                    <span class="badge badge-warning" x-text="activeSerc?.where">Where</span>

                    <template x-for="tag in activeSerc?.tags">
                        <span class="badge badge-info" x-text="tag.name">Tag</span>
                    </template>

                    
                </div>
                <br>
                <h5>Files</h5>
                <div class="grid-2">

                    <template x-if="activeSerc?.resources.length == 0">
                        <p class="col-span-3">
                            No resources found!
                        </p>
                    </template>

                    <template x-for="resource in activeSerc?.resources">
                        
                    <div class="file-link" :title='resource.name'>
                        <a :href='resource.link' target='_blank' >
                            <div>
                                <h3 x-text="resource.name">File Name</h3>
                                <small>Click to download</small>
                            </div>
                    
                            <div>
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                    
                              
                           
                    
                            </div>
                        </a>
                    </div>
                    </template>

                </div>

            </div>
        </div>



    </div>
@endsection
