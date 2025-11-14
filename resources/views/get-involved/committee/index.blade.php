@extends('layout')

@section('title')
    Committee | Get Involved |
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
                    <h2 class="md:text-6xl text-4xl font-bold text-white">Committee</h2>
                </div>
            </div>
        </div>
    </div>




    <div class="container-responsive">

        <h1 class="header">Meet your Committee</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-3 md:gap-y-9 pb-8 justify-items-center">

            @foreach ($members as $member)
                <a href="{{ route('committee.member.view', ['cid' => $committee->date_slug, 'nameslug' => $member->nameSlug]) }}" class="no-underline text-black">
                    <div class="flex flex-col justify-between items-center rounded-md border hover:border-bulsca transition no-underline text-center overflow-hidden min-h-80 w-56">
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
                </a>
            @endforeach

        </div>

        <h1 class="header">About the Committee</h1>
        <p class="pb-8">
            The BULSCA committee is made up entirely of volunteers, either current students or graduates from higher education institutions
        </p>

        <div>
            <a href="{{ route('committee.previous') }}"
                class="btn btn-thinner btn-bulsca">Previous Committees</a>
        </div>
    </div>
@endsection