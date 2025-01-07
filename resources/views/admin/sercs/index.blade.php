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
                
              
                    <h4 class="header header-bold overflow-hidden break-words" >
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