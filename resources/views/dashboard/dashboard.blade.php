@extends('layouts.dashlayout')

@section('title')
    Dashboard |
@endsection

@section('nav-extra')
    nav-scrolled
@endsection

@section('content')



    <div class="container-responsive">
        <h2 class="" style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Hello</span></h2>
        <h2 class="   " style='margin-bottom: -.25em !important'><span
                class="text-bulsca_red font-bold">{{ auth()->user()->name }}</span></h2>
        <small class="">
            @if (auth()->user()->getHomeUni())
                Associated with {{ auth()->user()->getHomeUni()->name }} University
                @if (auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
                    <small>(Admin)</small>
                @endif
            @else
                No Associated University!
            @endif
        </small>

        <hr class="my-5">

        @if (auth()->user()->getHomeUni() &&
                auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
            <div class="flex flex-col items-center justify-center space-y-2">
                <h2 class="">
                    {{ auth()->user()->getHomeUni()->name }}
                    </h3>
                    <div class=" group relative overflow-hidden rounded-md h-48 w-48 flex items-center justify-center">
                        <div class="absolute top-0 left-0 w-full h-full hidden cursor-pointer bg-gray-100 bg-opacity-60 group-hover:flex items-center justify-center "
                            onclick="openFileSelect()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <img src="{{ auth()->user()->getHomeUni()->image_path ? route('image', auth()->user()->getHomeUni()->image_path) : '/storage/logo/blogo.png' }}"
                            class="" alt="" />



                        <form method="POST" action="{{ route('university.updatePhoto') }}" id="uni-photo-form"
                            class="hidden" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" id="uni-photo-input" onchange="submitForm()">
                            <input type="hidden" class="hidden" name="uni"
                                value="{{ auth()->user()->getHomeUni()->id }}">
                        </form>
                        <script>
                            const openFileSelect = () => {
                                document.getElementById('uni-photo-input').click()
                            }
                            const submitForm = () => {
                                document.getElementById('uni-photo-form').submit()
                            }
                        </script>

                    </div>
                    <small>Click to change University Logo</small>
                    <br>
                    <a href="{{ route('edit-club', auth()->user()->getHomeUni()->getAsSlug()) }}">Edit Club Page and
                        Socials</a>

            </div>
        @endif

        <hr class="my-5">

        @if (auth()->user()->getHomeUni() &&
                auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
            <h3 class="">
                Your Competitions
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-3">
                @forelse ($myCompetitions as $comp)
                    <div class="relative rounded-lg  border   flex justify-between items-center ">

                        <div class="flex flex-col m-4">
                            <h4>
                                {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}
                            </h4>
                            <small class="text-gray-500 -mt-2">{{ $comp->when->format('d/m/Y') }}</small>
                        </div>


                        <a href="{{ route('lc-manage', $comp->id) }}"
                            class="bg-bulsca hover:bg-bulsca_red transition-colors text-white no-underline  p-4 h-full flex items-center justify-center rounded-r-md ">
                            Manage
                        </a>

                    </div>
                @empty
                    <p>You aren't hosting any competitions!</p>
                @endforelse
            </div>


            <hr class="my-5">
        @endif

        <h3>
            Upcoming Competitions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-3">
            @forelse ($upcoming as $comp)
                <div class="rounded-lg  border overflow-hidden  flex justify-between items-center ">
                    <div class="flex flex-col m-4">
                        <h4>
                            {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}
                        </h4>
                        <small class="text-gray-500 -mt-2">{{ $comp->when->format('d/m/Y') }}</small>
                    </div>


                    <a href="{{ route('lc-view', $comp->id) }}"
                        class="bg-bulsca hover:bg-bulsca_red transition-colors text-white no-underline  p-4 h-full flex items-center justify-center ">
                        View
                    </a>

                </div>
            @empty
                <p>There are no upcoming competitions!</p>
            @endforelse
        </div>
    </div>







@endsection
