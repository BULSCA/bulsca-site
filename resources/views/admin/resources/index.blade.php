@extends('layouts.adminlayout')

@section('title')
Resources | Admin | 
@endsection


@section('content')

<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Resource Pages</p>


    </div>

    <div class="flex flex-row">
        <h1 class="header">Resource Pages</h1>

    </div>
    
    <div class="grid grid-cols-2 gap-4">
    @foreach ($resourcePages as $rp)
        <a href="{{ route('admin.resources.page.view', $rp) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <h1 class="header header-bold" style="margin-bottom: 0 !important">
                    {{ $rp->name }}
                </h1>
                <small class="ml-auto  text-black font-normal ">{{ $rp->getSections->count() }} Section{{ $rp->getSections->count() > 1 ? "s" : "" }}</small>
            </div>
        
        </a>
            
        @endforeach
    </div>

    Also list all resources here!




   

</div>


@endsection
