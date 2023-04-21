@extends('layouts.adminlayout')

@section('title')
Resources | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.resources') }}">Resource Pages</a>
        <span>></span>
        <p>{{ $rp->name }}</p>


    </div>

    <div class="flex flex-row">
        <h1 class="header">Sections</h1>

    </div>



    <div class="grid grid-cols-1 gap-4">
        @foreach ($rp->getSections()->orderBy('ordering')->get() as $sec)
        <div toggle class="toggle  rounded-md border hover:border-bulsca transition no-underline">
            <div toggle-header class=" px-6 py-4 flex items-center justify-center border-b">
                <h2 class="header header-bold" style="margin-bottom: 0 !important">
                    {{ $sec->name }}
                </h2>
                <div class="ml-auto flex flex-row items-center justify-center space-x-4">
                    <small class="text-black font-normal ">{{ $sec->getResources()->count() }} Items</small>
                    <form action="{{ route('admin.resources.section.changeOrder', $sec) }}" method="post" class="h-6">
                        @csrf
                        <input type="hidden" name="direction" value="true">
                        <button class="icon chevron-up hover:scale-125 rounded-md hover:bg-gray-200 transition-all" onclick=" return changeOrder(true); "></button>
                    </form>
                    <form action="{{ route('admin.resources.section.changeOrder', $sec) }}" method="post" class="h-6">
                        @csrf
                        <input type="hidden" name="direction" value="false">
                        <button class="icon chevron-down hover:scale-125 rounded-md hover:bg-gray-200 transition-all"></button>
                    </form>
                    <form action="{{ route('admin.resources.section.delete') }}" onsubmit="return confirm('Are you sure?')" class="flex items-center justify-center" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" value="{{ $sec->id }}" class="hidden">
                        <button submit class="icon cross"></button>
                    </form>
                </div>
            </div>


            <div toggle-content>

                <div class="px-6 py-4">
                    <h3 class="header header-small">Resources</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-2 divide-x-2">
                        @forelse ( $sec->getRPSR as $res )
                        <div class="flex flex-row items-center justify-center pl-4">
                            <p>{{ $res->getResource()->first()->name }}</p>

                            <a href="{{ route('admin.resources.edit', $res->resource) }}" class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>

                            <form action="{{ route('admin.resources.resource.changeOrder', $res) }}" method="post" class="h-6">
                                @csrf
                                <input type="hidden" name="direction" value="true">
                                <button class="icon chevron-up hover:scale-125 rounded-md hover:bg-gray-200 transition-all md:-rotate-90" onclick=" return changeOrder(true); "></button>
                            </form>
                            <form action="{{ route('admin.resources.resource.changeOrder', $res) }}" method="post" class="h-6">
                                @csrf
                                <input type="hidden" name="direction" value="false">
                                <button class="icon chevron-down hover:scale-125 rounded-md hover:bg-gray-200 transition-all md:-rotate-90"></button>
                            </form>

                            <form action="{{ route('admin.resource.delete') }}" onsubmit="return confirm('Are you sure?')" method="post" class="flex items-center justify-center ">
                                @csrf
                                {{ method_field('DELETE') }}
                                <input type="hidden" class="hidden" name="id" value="{{ $res->id }}"></input>
                                <button submit class="icon cross"></button>
                            </form>
                        </div>
                        @empty
                        <small class=" font-normal">None found</small>
                        @endforelse
                    </div>
                </div>

                <div class="px-6 py-6">
                    <form action="{{ route('admin.resource.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- <div class="form-input">
                                <label for="upload-name">File Name</label>
                                <input id="upload-name" class="input" name="name" required type="text"  placeholder="File">
                            </div> -->
                        <input type="hidden" name="section" value="{{ $sec->id }}" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-input">
                                <label for="upload-file-{{ $sec->id }}">File</label>
                                <input id="upload-file-{{ $sec->id }}" class="input file" name="resource" required type="file" onchange="updateFName(this.files, {{ $sec->id }})">
                            </div>
                            <div class="form-input">
                                <label for="upload-name-{{ $sec->id }}">Name</label>
                                <input id="upload-name-{{ $sec->id }}" class="input " style="padding-bottom: 0.87rem; padding-top:0.87rem" name="name" required type="text">
                            </div>
                        </div>
                        <button class="btn btn-thinner">Upload</button>
                    </form>
                    <script>
                        function updateFName(e, target) {

                            document.getElementById(`upload-name-${target}`).value = e[0].name.split('.').slice(0, -1).join('.').replaceAll('_', " ").replaceAll('-', " ")



                        }
                    </script>
                </div>

            </div>


        </div>

        @endforeach

    </div>

    <br><br>
    <div>
        <h2 class="header">Add New Section</h2>

        <form action="{{ route('admin.resources.section.create' ) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- <div class="form-input">
                            <label for="upload-name">File Name</label>
                            <input id="upload-name" class="input" name="name" required type="text"  placeholder="File">
                        </div> -->

            <input type="hidden" name="page" value="{{ $rp->id }}" class="hidden">

            <div class="form-input">
                <label for="new-section">Section</label>
                <input id="new-section" class="input" name="name" required type="text">
            </div>
            <button class="btn btn-thinner">Create</button>
        </form>
    </div>

    <br>
    <hr>
    <br>
    <div>
        <h2 class="header">Delete Page</h2>
        <form action="{{ route('admin.resources.page.delete') }}" onsubmit="return confirm('Are you sure?')" method="post">
            <input type="hidden" name="id" value="{{ $rp->id }}" class="hidden">
            @csrf
            {{ method_field('DELETE') }}
            <button class="btn btn-thinner btn-danger">Delete</button>
        </form>
    </div>






</div>

<script src="{{ asset('js/app.js') }}"></script>


@endsection