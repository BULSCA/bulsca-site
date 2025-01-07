@extends('layouts.adminlayout')

@section('title')
Tags | SERCs | Admin |
@endsection


@section('content')

<script src="{{ asset('js/TagInput.js') }}"></script>

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.sercs') }}">SERCs</a>
        <span>></span>
        <p>Tags</p>


    </div>


    <div class="flex items-center  mb-2">
        <h1 class="header">Tags</h1>
    </div>

    <form method="GET" action="" id="search-and-filter" class="w-full relative flex-col ">
        
        <div class="form-search group w-full mb-3 relative">
            
            <input type="text" id="resource-search" name="s" class="input "
                 placeholder="Search..." value="{{ request('s') }}" x-data x-init="() => {$el.focus(); let v = $el.value; $el.value = ''; $el.value = v}">


            
        </div>   
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 3xl:grid-cols-4  gap-4">
        @foreach ($tags as $tag)
        <a href="{{ route('admin.sercs.tags.get', $tag) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex  items-center justify-between">
                
              
                    <h5 class=" overflow-hidden break-words" >
                        {{ $tag->name }}
                    </h5>

                    
                
  
            </div>
            <hr class="-mx-6 ">
            <div>
            <x-badge>{{ $tag->getTotalReferences() }} reference(s)  </x-badge>
            @if ($tag->category)
            <x-badge style="warning">Category: {{ $tag->category ?? '-' }}</x-badge>
            @endif
        </div>
            
            

        </a>

        @endforeach
    </div>
    <br>

    {{ $tags->appends($_GET)->links() }}



</div>



@endsection