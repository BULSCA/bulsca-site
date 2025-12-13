@extends('layouts.adminlayout')

@section('title')
Organisations | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Organisations</p>


    </div>


    <div class="flex items-center  mb-2">
        <h1 class="header">Organisations</h1>
        @can('admin.organisations.manage')<a href="{{ route('admin.organisations.create') }}" class="ml-auto btn btn-thinner">Create</a>@endcan
    </div>

    <div class="grid-2 gap-4">
        @foreach ($organisations as $org)
        <a href="{{ route('admin.organisation.view', $org) }}" class="px-6 py-4 rounded-md border hover:border-bulsca transition no-underline">
            <div class="flex items-center justify-center">
                <div class="flex flex-row items-center space-x-4">
                    <div class=" h-10 w-10 flex items-center justify-center">
                        <img src="{{ $org->image_path ? route('image', $org->image_path) : '/storage/logo/blogo.png' }}" alt="">
                    </div>
                    <h3 class="header header-bold" style="margin-bottom: 0 !important">
                        {{ $org->name }}
                    </h3>
                </div>
                <small class="ml-auto  text-black font-normal hover:underline " onclick="(e) => {e.stopPropagation(); e.preventDefault(); window.location.href='/'}"></small>
            </div>

        </a>

        @endforeach
    </div>
    <br>

    <!--{{ $organisations->links() }}-->



</div>



@endsection