<div class="fixed w-screen z-50 transition-all duration-100 @yield('nav-style') " id="navbar">
    <div class="nav-wrapper transition-all duration-100">
        <a href="/" class="nav-brand xl:text-2xl  2xl:text-3xl text-xl pr-2 md:pr-0 capitalize transition-all">
            British Universities Lifesaving Clubs' Association
        </a>

        <div class="lg:hidden block text-white font-bold ml-auto ">
            <svg id="mobile-nav-opener" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </div>

        <nav class="ml-auto mr-10 lg:block hidden">
            <ul class="flex space-x-4 xl:space-x-8 2xl:space-x-12 nav-list">
                <li><a href="{{ route('latest') }}">Latest</a></li>
                <li class="group {{ Request::is('competitions*') ? 'nav-active' : ''}}">

                    <a href="{{ route('comps') }}">Competitions</a>
                    <div class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('league') }}">Current League</a></li>
                            <li><a href="{{ route('champs') }}">Champs</a></li>
                        </ul>
                    </div>
                </li>
                <li class="group {{ Request::is('get-involved*') ? 'nav-active' : ''}}">
                    <a href="{{ route('get-involved') }}" class=" overflow-hidden overflow-ellipsis whitespace-nowrap">Get Involved</a>
                    <div class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('clubs') }}">Clubs</a></li>
                            <li><a href="{{  route('create-club')  }}">Create a Club</a></li>
                            <li><a href="{{  route('get-involved.committee')  }}">Committee</a></li>
                        </ul>
                    </div>
                </li>
                <li class="group {{ Request::is('welfare*') ? 'nav-active' : ''}}">
                    <a href="{{ route('welfare') }}" class=" overflow-hidden overflow-ellipsis whitespace-nowrap">Welfare</a>
                    <div class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('welfare') }}">Home</a></li>
                            <li><a href="{{  route('welfare.help-and-reporting')  }}">Help and Reporting</a></li>
                            <li><a href="{{  route('welfare.inclusion-and-accessibility')  }}">Inclusion and Accessibility</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="{{ route('resources') }}">Resources</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li class="group">
                    <a href="{{ route('dashboard') }}">Account</a>
                    @auth
                    <div class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('settings') }}">Settings</a></li>
                            @can('admin')
                            <li><a href="{{ route('admin') }}">Admin</a></li>
                            @endcan
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                    @endauth
                </li>
            </ul>
        </nav>
    </div>
</div>

<div id="mobile-nav" class="mobile-nav">
    <div>
        <a href="/" class="nav-brand xl:text-2xl  2xl:text-3xl text-xl pr-2 md:pr-0 capitalize transition-all">
            British Universities Lifesaving Clubs' Association
        </a>
        <div class="lg:hidden block text-white font-bold ml-auto -mr-1 sm:-mr-4">
            <svg id="mobile-nav-closer" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </div>
    </div>
    <nav>
        <ul class="">
            <li><a href="{{ route('latest') }}">Latest</a></li>
            <li class="group {{ Request::is('competitions*') ? 'mobile-nav-active' : ''}}">
                <div class="mobile-nav-link">
                    <a href="{{ route('comps') }}">Competitions</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>

                <div class="mobile-dropdown">
                    <ul>
                        <li><a href="{{ route('league') }}">League</a></li>
                        <li><a href="{{ route('champs') }}">Champs</a></li>
                    </ul>
                </div>
            </li>
            <li class="group {{ Request::is('get-involved*') ? 'mobile-nav-active' : ''}}">
                <div class="mobile-nav-link">
                    <a href="{{ route('get-involved') }}">Get Involved</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                <div class="mobile-dropdown">
                    <ul>
                        <li><a href="{{ route('clubs') }}">Clubs</a></li>
                        <li><a href="{{ route('create-club') }}">Create a Club</a></li>
                        <li><a href="{{  route('get-involved.committee')  }}">Committee</a></li>
                    </ul>
                </div>
            </li>


            <li class="group {{ Request::is('welfare*') ? 'mobile-nav-active' : ''}}">
                <div class="mobile-nav-link">
                    <a href="{{ route('welfare') }}">Welfare</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                <div class="mobile-dropdown">
                    <ul>

                        <li><a href="{{ route('welfare.help-and-reporting') }}">Help and Reporting</a></li>
                        <li><a href="{{  route('welfare.inclusion-and-accessibility')  }}">Inclusion and Accessibility</a></li>
                    </ul>
                </div>
            </li>



            <li><a href="{{ route('resources') }}">Resources</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
            <li class="group {{ Request::is('dashboard*') ? 'mobile-nav-active' : ''}}">
                <div class="mobile-nav-link">
                    <a href="{{ route('dashboard') }}">Account</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                @auth
                <div class="mobile-dropdown">
                    <ul>

                        <li><a href="{{ route('settings') }}">Settings</a></li>
                        @can('admin')
                        <li><a href="{{ route('admin') }}">Admin</a></li>
                        @endcan
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
                @endauth
            </li>
        </ul>
    </nav>
</div>