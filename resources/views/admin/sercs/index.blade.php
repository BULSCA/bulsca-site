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
        @can('admin.sercs.manage')<a href="{{ route('admin.sercs.add') }}" class="ml-auto btn btn-thinner">Add</a>@endcan
    </div>

    <form method="GET" action="" class="w-full relative ">
        
        <div class="form-search group w-full mb-3 relative">
            
            <input type="text" id="resource-search" name="s" class="input "
                 placeholder="Search..." value="{{ request('s') }}">
        </div>

   
    </form>

    <div class="grid-4 gap-4">
        @foreach ($sercs as $serc)
        <a href="{{ route('admin.sercs.show', $serc) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex  items-center">
                
              
                    <h4 class="header header-bold" >
                        {{ $serc->name }}
                    </h4>
                
  
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