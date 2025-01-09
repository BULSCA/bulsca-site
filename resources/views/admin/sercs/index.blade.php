@extends('layouts.adminlayout')

@section('title')
SERCs | Admin |
@endsection


@section('content')

<script src="{{ asset('js/TagInput.js') }}"></script>

<div class="container-responsive">

    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>SERCs</p>


    </div>

    <div class="grid md:grid-cols-2 grid-cols-1 gap-6">


<a href="{{ route('admin.sercs.casualties') }}"
    class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-lime-500 ">
    <div class="flex flex-col ">
        <p class=" text-4xl font-bold ">{{ $count['casualties'] }}</p>
        <small class="text-base">Casualties</small>

    </div>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 ml-auto" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
</a>


<a href="{{ route('admin.sercs.casualties') }}"
    class="rounded-md no-underline border-2 hover:border-gray-300 cursor-pointer py-4 px-6 flex flex-row items-center text-orange-500 ">
    <div class="flex flex-col ">
        <p class=" text-4xl font-bold ">{{ $count['groups'] }}</p>
        <small class="text-base">Casualty Groups</small>

    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-12 w-12 ml-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.712 4.33a9.027 9.027 0 0 1 1.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 0 0-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 0 1 0 9.424m-4.138-5.976a3.736 3.736 0 0 0-.88-1.388 3.737 3.737 0 0 0-1.388-.88m2.268 2.268a3.765 3.765 0 0 1 0 2.528m-2.268-4.796a3.765 3.765 0 0 0-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 0 1-1.388.88m2.268-2.268 4.138 3.448m0 0a9.027 9.027 0 0 1-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0-3.448-4.138m3.448 4.138a9.014 9.014 0 0 1-9.424 0m5.976-4.138a3.765 3.765 0 0 1-2.528 0m0 0a3.736 3.736 0 0 1-1.388-.88 3.737 3.737 0 0 1-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 0 1-1.652-1.306 9.027 9.027 0 0 1-1.306-1.652m0 0 4.138-3.448M4.33 16.712a9.014 9.014 0 0 1 0-9.424m4.138 5.976a3.765 3.765 0 0 1 0-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 0 1 1.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 0 0-1.652 1.306A9.025 9.025 0 0 0 4.33 7.288" />
                    </svg>
</a>
</div>
<br>


    <div class="flex items-center  mb-2">
        <h1 class="header">SERCs</h1>
        @can('admin.sercs.manage')
        <div class="ml-auto">
            <a href="{{ route('admin.sercs.tags.list') }}" class="btn btn-thinner">Tags</a>
            <a href="{{ route('admin.sercs.add') }}" class="ml-auto btn btn-thinner">Add</a>
        </div>
        @endcan
    </div>

    <form method="GET" action="" id="search-and-filter" class="w-full relative flex-col ">

        <div class="form-search group w-full mb-3 relative">

            <input type="text" id="resource-search" name="s" class="input "
                placeholder="Search..." value="{{ request('s') }}" x-data x-init="() => {$el.focus(); let v = $el.value; $el.value = ''; $el.value = v}">



        </div>


        <div class="flex items-center space-x-2 mb-3 text-sm">
            <label for="order-by-views">Order by views</label>
            <input type="checkbox" class="" @if(request('orderByViews')) checked @endif name="orderByViews" id="order-by-views" onclick="document.getElementById('search-and-filter').submit()">
        </div>



    </form>

    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4  gap-4">
        @foreach ($sercs as $serc)
        <a href="{{ route('admin.sercs.show', $serc) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex  items-center justify-between">


                <h4 class="header header-bold overflow-hidden break-words">
                    {{ $serc->name }}
                </h4>

                <div class="flex items-center text-black space-x-1 text-sm">
                    <span>{{ $serc->views }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                </div>


            </div>
            <hr class="-mx-6 mb-4">
            <p class=" text-black text-base font-normal  line-clamp-4 mb-3">{{ $serc->description }}</p>

            <div class="overflow-x-auto flex flex-row whitespace-nowrap">

                <x-badge style="warning">{{ $serc->where }}</x-badge>
                <x-badge style="warning">{{ $serc->when->format('Y-m-d')  }}</x-badge>

                @foreach (explode(',',$serc->getTags()) as $tag)
                @if ($tag == '')
                @continue

                @endif
                <x-badge style="info">{{ $tag }}</x-badge>

                @endforeach

            </div>

        </a>

        @endforeach
    </div>
    <br>

    {{ $sercs->appends($_GET)->links() }}



</div>



@endsection