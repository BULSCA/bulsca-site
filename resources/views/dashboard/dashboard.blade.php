@extends('layouts.dashlayout')

@section('title')
    Dashboard |
@endsection

@section('nav-extra')
    nav-scrolled
@endsection

@php
    $user = auth()->user();
    $entity = auth()->user()->entity;
    $profile = $entity ? $entity->profile : null;
@endphp

@section('content')



    <div class="container-responsive">
        <div class="flex items-start justify-between">
            {{-- Left side: User greeting --}}
            <div class="flex-1">
                <h2 class="" style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Hello</span></h2>
                <h2 class="   " style='margin-bottom: -.2em !important'><span
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
                <br>
                <small class="">
                    <span> {{ auth()->user()?->entity->display_name ?? 'no entity' }} </span>
                </small>
            </div>

            {{-- Right side: Settings dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-semibold">Settings</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown menu --}}
                <div x-show="open" 
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                    style="display: none;">
                    <div class="py-2">
                        <a {{--href="{{ route('profile.edit') }}"--}} class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('password.change') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Change Password
                        </a>
                        <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Account Settings
                        </a>

                        <hr class="my-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 w-full text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Debug Section --}}
        <hr class="my-8">
        <div style="background: #f0f0f0; padding: 1rem; margin: 1rem 0; border: 1px solid #ccc;">
            <h3>Debug Info</h3>
            <p>User ID: {{ $user->id }}</p>
            <p>User Name: {{ $user->name }}</p>
            <p>Has Entity: {{ $entity ? 'YES' : 'NO' }}</p>
            @if($entity)
                <p>Entity ID: {{ $entity->id }}</p>
                <p>Entity Custom ID: {{ $entity->custom_id }}</p>
                <p>Child Memberships Count: {{ $entity->childMemberships->count() }}</p>
                <p>Has Parent Membership: {{ $entity->parentMembership ? 'YES' : 'NO' }}</p>
                @if($entity->parentMembership)
                    <p>Parent Entity: {{ $entity->parentMembership->parent->display_name ?? 'N/A' }}</p>
                @endif
            @endif
        </div>

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
            <hr class="my-5">
        @endif

        @if (auth()->user()->getHomeUni() &&
                auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
            <h3 class="">
                Your Competitions
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-3">
                @forelse ($myCompetitions as $comp)
                    <div class="relative rounded-lg  border overflow-hidden  flex flex-col ">

                        <div class="flex flex-col m-4 h-full">
                            <h4>
                                {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}
                            </h4>
                            <small class="text-gray-500 -mt-2">{{ $comp->when->format('d/m/Y') }}</small>
                        </div>

                        <div class="grid grid-cols-2 w-full">
                            <a href="{{ route('lc-view', $comp->id) }}"
                                class="bg-bulsca hover:bg-bulsca_red transition-colors text-white no-underline  p-4 flex items-center justify-center  ">
                                View
                            </a>
                            <a href="{{ route('lc-manage', $comp->id) }}"
                                class="bg-green-500 hover:bg-bulsca_red transition-colors text-white no-underline  p-4 flex items-center justify-center  ">
                                Manage
                            </a>
                        </div>

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
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-3">
            @forelse ($upcoming as $comp)
                <div class="rounded-lg  border overflow-hidden  flex flex-col ">
                    <div class="flex flex-col m-4 h-full">
                        <h4>
                            {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}
                        </h4>
                        <small class="text-gray-500 -mt-2">{{ $comp->when->format('d/m/Y') }}</small>
                    </div>


                    <a href="{{ route('lc-view', $comp->id) }}"
                        class="bg-bulsca hover:bg-bulsca_red transition-colors text-white no-underline  p-4 flex items-center justify-center ">
                        View
                    </a>

                </div>
            @empty
                <p>There are no upcoming competitions!</p>
            @endforelse
        </div>
    </div>







@endsection
