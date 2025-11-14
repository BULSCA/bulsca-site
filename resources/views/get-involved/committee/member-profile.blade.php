@extends('layout')

@section('title')
    Member Profile | Get Involved |
@endsection

@section('meta')
    The BULSCA Committee have been running since 2002 and are responsible for keeping things in check and ensuring the
    longevity of the association.
@endsection

@section('content')
    <div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

        <div class="h-full w-full overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
                <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
                <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                    <h2 class="md:text-6xl text-4xl font-bold text-white">{{ $member->name }}</h2>
                    <p class="text-white">{{ $role->label}} </p>
                </div>
            </div>
        </div>
    </div>




    <div class="container-responsive">

        <h1>Member Profile</h1>
        <div class="flex flex-col md:flex-row md:space-x-8 items-center md:items-start mb-8">
            <div class="w-48 h-48 rounded-full overflow-hidden mb-4 md:mb-0">
                <img src="{{ $member->image_path ? route('image', $member->image_path) : '/storage/logo/blogo.png' }}" class="w-full h-full object-cover" alt="">
            </div>
            <div class="flex-1">
                <h2 class="header header-smallish">{{ $member->name }}</h2>
                <p class="font-semibold text-bulsca mb-2">{{ $role->label }}</p>
                <!--<p>{{ $member->bio }}</p>-->
            </div>
        </div>

    </div>
@endsection