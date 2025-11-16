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




    <div class=" container-responsive ">
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">

            <div class="md:flex-[1] flex-1">
                <div class="flex flex-col justify-between items-center rounded-md border no-underline text-center overflow-hidden min-h-80 w-56">
                    <div class="rounded-full w-44 h-44 overflow-hidden flex items-center justify-center mt-4 mx-4">
                        <img src="{{ $member->image_path ? route('image', $member->image_path) : '/storage/logo/blogo.png' }}" class="w-full h-full" alt="">
                    </div>
                    <h3 class="header header-smallish px-4">
                        {{ $member->name }}
                    </h3>
                    <div class="bg-bulsca w-full font-semibold text-white p-2 rounded-b text-center">
                        {{ $member->role->label }}
                    </div>
                </div>
            </div>

            <div class="md:flex-[2] flex-2">
                <div class="flex flex-col justify-center p-4">
                    <h1>About me </h1>
                    @if ($member->content !== null)
                        <div class="ck-content w-full">
                            {!! $member->content !!}
                        </div>
                    @else
                        <p>This member has not added a bio yet.</p>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div class="container-boast">
        <div class="flex flex-col justify-center">
            <h1 class="text-white">What is the role of {{ $member->role->label }}?</h3>
            @if ($member->role->content !== null)
                <div class="ck-content w-full text-white">
                {!! $member->role->content !!}
                </div>
            @else
                <p class="text-white">sorry, there are no details here yet.</p>
            @endif
        </div>

    </div>
@endsection