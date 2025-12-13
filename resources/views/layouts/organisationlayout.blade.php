<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" href="/storage/logo/blogo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?{{ config('version.hash') }}">
    <title>@yield('title') - {{ $organisation->name }} | BULSCA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/sort@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="overflow-x-hidden flex flex-col min-h-screen">
    @section('nav-style')
        nav-scrolled nav-scrolled-blue relative
    @endsection
    @include('layouts.navigation')

    <!-- Organisation Dashboard Container -->
    <div class="container-responsive flex flex-col md:flex-row gap-6 my-6">
        
        <!-- Sidebar Navigation -->
        <aside class="md:w-64 w-full">
            <div class="bg-white rounded-lg shadow-md p-4 sticky top-6">
                <!-- Organisation Header -->
                <div class="mb-6 pb-4 border-b">
                    @if($organisation->logo)
                        <img src="{{ $organisation->logo }}" alt="{{ $organisation->name }}" class="w-16 h-16 rounded-lg mb-3">
                    @endif
                    <h2 class="text-xl font-bold text-gray-800">{{ $organisation->name }}</h2>
                    <p class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $organisation->type) }}</p>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-1">
                    <a href="{{ route('organisations.show', $organisation->id) }}" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('organisations.show') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    @can('update', $organisation)
                    <a href="{{ route('organisations.edit', $organisation->id) }}" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('organisations.edit') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Settings
                    </a>
                    @endcan

                    @can('manageManagers', $organisation)
                    <a href="{{ route('organisations.managers.index', $organisation->id) }}" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('organisations.managers.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Managers
                    </a>
                    @endcan

                    @can('manageCommittee', $organisation)
                    <a href="{{ route('organisations.committee.index', $organisation->id) }}" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('organisations.committee.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Committee
                    </a>
                    @endcan

                    @can('viewMembers', $organisation)
                    <a href="{{ route('organisations.members.index', $organisation->id) }}" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('organisations.members.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Members
                    </a>
                    @endcan
                </nav>

                <!-- Your Role Badge -->
                <div class="mt-6 pt-4 border-t">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Your Role</p>
                    @if($organisation->isOwner(Auth::user()))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Owner
                        </span>
                    @elseif($organisation->isAdmin(Auth::user()))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Admin
                        </span>
                    @elseif($organisation->isOnCommittee(Auth::user()))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Committee
                        </span>
                    @elseif($organisation->isMember(Auth::user()))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Member
                        </span>
                    @endif
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <footer class="bg-black w-full flex flex-col items-center justify-center mt-auto">
        <div class="p-6 px-32 flex flex-row items-center justify-center space-x-4">
            <a href="https://www.facebook.com/BULSCA/" rel="noopener noreferrer" target="_blank">
                <img src="/storage/logo/f_logo_RGB-Blue_1024.png" loading="lazy" class="w-12 h-12" alt="">
            </a>
            <a href="https://www.instagram.com/bulsca" rel="noopener noreferrer" target="_blank">
                <img src="/storage/logo/Instagram_Glyph_Gradient_RGB.png" loading="lazy" class="w-12 h-12" alt="">
            </a>
        </div>
        <small class="text-white pb-4">Made with ☕ by Noah & James</small>
    </footer>

    <x-notification-sliver>{{ session('message') }}</x-notification-sliver>
</body>

</html>