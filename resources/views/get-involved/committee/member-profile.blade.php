@extends('layout')

@section('title')
    Member Profile | Get Involved |
@endsection

@section('meta')
    The BULSCA Committee have been running since 2002 and are responsible for keeping things in check and ensuring the
    longevity of the association.
@endsection

@section('content')
    <x-page-banner
        title="{{ $member->name }}"
        subtitle="{{ $role->label}}"
        :snowContainer="true"
    />




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