@extends('layouts.adminlayout')

@section('title')
Universities | Admin |
@endsection


@section('content')

<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <p>Universities</p>


    </div>

    <h1 class="header">Universities</h1>

    <div class="grid grid-cols-2 gap-4">
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
                <small class="ml-auto  text-black font-normal ">Club Page</small>
            </div>

        </a>

        @endforeach
    </div>

    {{ $universities->links() }}



</div>



@endsection