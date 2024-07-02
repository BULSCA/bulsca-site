@extends('layouts.adminlayout')

@section('title')
Universities | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Universities</p>


    </div>


    <div class="flex items-center  mb-2">
        <h1 class="header">Universities</h1>
        @can('admin.universities.manage')<a href="{{ route('admin.universities.create') }}" class="ml-auto btn btn-thinner">Create</a>@endcan
    </div>

    <div class="grid-2 gap-4">
        @foreach ($universities as $uni)
        <a href="{{ route('admin.university.view', $uni) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <div class="flex flex-row items-center space-x-4">
                    <div class=" h-10 w-10 flex items-center justify-center">
                        <img src="{{ $uni->image_path ? route('image', $uni->image_path) : '/storage/logo/blogo.png' }}" alt="">
                    </div>
                    <h3 class="header header-bold" style="margin-bottom: 0 !important">
                        {{ $uni->name }}
                    </h3>
                </div>
                <small class="ml-auto  text-black font-normal hover:underline " onclick="(e) => {e.stopPropagation(); e.preventDefault(); window.location.href='/'}"></small>
            </div>

        </a>

        @endforeach
    </div>
    <br>

    {{ $universities->links() }}



</div>



@endsection