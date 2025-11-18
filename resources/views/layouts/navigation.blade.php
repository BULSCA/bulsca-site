<div class="fixed w-screen z-50 transition-all duration-100 @yield('nav-style') " id="navbar">
    <div class="nav-wrapper transition-all duration-100 flex items-center">
        <a href="/" class="nav-brand 2xl:text-2xl text-xl pr-2 md:pr-0 capitalize transition-all relative h-8 md:h-10 flex items-center"
            x-data="{ scrolled: false }"
            x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })">
            <span class="absolute left-0 top-0 w-full transition-all"
                x-show="!scrolled"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                British Universities Lifesaving Clubs' Association
                <img src="./storage/logo/blogo.png" ondblclick="ee(this)" class="md:w-[12.5%] w-[50%] h-auto"
                    alt="">
            </span>
            <span class="absolute left-0 top-1/2 w-full transition-all"
                x-show="scrolled"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                BULSCA
            </span>
        </a>

        <div class="lg:hidden block text-white font-bold ml-auto ">
            <svg id="mobile-nav-opener" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </div>

        <nav class="ml-auto mr-10 lg:block hidden">
            <ul class="flex space-x-4 xl:space-x-8 2xl:space-x-12 nav-list">

                <li><a href="{{ route('latest') }}">Latest</a></li>
                <li class="group {{ Request::is('competitions*') ? 'nav-active' : '' }}">

                    <a href="{{ route('comps') }}">Competitions</a>
                    <div
                        class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('league') }}">Current League</a></li>
                            <li><a href="{{ route('league') }}">Calender</a></li>
                            <li><a href="{{ route('champs') }}">Champs</a></li>
                        </ul>
                    </div>
                </li>
                <li class="group {{ Request::is('get-involved*') ? 'nav-active' : '' }}">
                    <a href="{{ route('get-involved') }}"
                        class=" overflow-hidden overflow-ellipsis whitespace-nowrap">Get Involved</a>
                    <div
                        class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('freshers') }}">Freshers</a></li>
                            <li><a href="{{ route('clubs') }}">Clubs</a></li>
                            <li><a href="{{ route('create-club') }}">Create a Club</a></li>
                            <li><a href="{{ route('get-involved.committee') }}">Committee</a></li>
                        </ul>
                    </div>
                </li>
                <li class="group {{ Request::is('welfare*') ? 'nav-active' : '' }}">
                    <a href="{{ route('welfare') }}"
                        class=" overflow-hidden overflow-ellipsis whitespace-nowrap">Welfare</a>
                    <div
                        class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('welfare') }}">Home</a></li>
                            <li><a href="{{ route('welfare.help-and-reporting') }}">Support and Reporting</a></li>
                            <li><a href="{{ route('welfare.inclusion-and-accessibility') }}">Inclusion and
                                    Accessibility</a></li>
                        </ul>
                    </div>
                </li>

                <li class="group {{ Request::is('resources*') ? 'nav-active' : '' }}">
                    <a href="{{ route('resources') }}"
                        class=" overflow-hidden overflow-ellipsis whitespace-nowrap">Resources</a>
                    <div
                        class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('resources') }}">All</a></li>
                            <li><a href="{{ route('resources.sercs') }}">SERCs</a></li>
                            <li><a href="{{ route('resources.casualties') }}">Casualties</a></li>
                        </ul>
                    </div>
                </li>





                <li class="group {{ Request::is('about*') ? 'nav-active' : '' }}">
                    <a href="{{ route('about') }}"
                        class=" overflow-hidden overflow-ellipsis whitespace-nowrap">About</a>
                    <div
                        class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
                        <ul>
                            <li><a href="{{ route('about.records') }}">Records</a></li>

                        </ul>
                    </div>
                </li>


                <li class="group">
                    <a href="{{ route('dashboard') }}">Account</a>
                    @auth
                        <div
                            class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
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
            <svg id="mobile-nav-closer" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </div>
    </div>
    <nav class=" ">
        <ul class="" id="mobile-nav-collapse">
            <li><a href="{{ route('latest') }}">Latest</a></li>
            <li class="group {{ Request::is('competitions*') ? 'mobile-nav-active' : '' }}">
                <div class="mobile-nav-link">
                    <a href="{{ route('comps') }}">Competitions</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
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
            <li class="group {{ Request::is('get-involved*') ? 'mobile-nav-active' : '' }}">
                <div class="mobile-nav-link">
                    <a href="{{ route('get-involved') }}">Get Involved</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                <div class="mobile-dropdown">
                    <ul>
                        <li><a href="{{ route('freshers') }}">Freshers</a></li>
                        <li><a href="{{ route('clubs') }}">Clubs</a></li>
                        <li><a href="{{ route('create-club') }}">Create a Club</a></li>
                        <li><a href="{{ route('get-involved.committee') }}">Committee</a></li>
                    </ul>
                </div>
            </li>


            <li class="group {{ Request::is('welfare*') ? 'mobile-nav-active' : '' }}">
                <div class="mobile-nav-link">
                    <a href="{{ route('welfare') }}">Welfare</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                <div class="mobile-dropdown">
                    <ul>

                        <li><a href="{{ route('welfare.help-and-reporting') }}">Support and Reporting</a></li>
                        <li><a href="{{ route('welfare.inclusion-and-accessibility') }}">Inclusion and
                                Accessibility</a></li>
                    </ul>
                </div>
            </li>



            <li class="group {{ Request::is('resources*') ? 'mobile-nav-active' : '' }}">
                <div class="mobile-nav-link">
                    <a href="{{ route('resources') }}">Resources</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                <div class="mobile-dropdown">
                    <ul>

                        <li><a href="{{ route('resources') }}">All</a></li>
                        <li><a href="{{ route('resources.sercs') }}">SERCs</a></li>
                        <li><a href="{{ route('resources.casualties') }}">Casualties</a></li>

                    </ul>
                </div>
            </li>

            <li class="group {{ Request::is('about*') ? 'mobile-nav-active' : '' }}">
                <div class="mobile-nav-link">
                    <a href="{{ route('about') }}">About</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                </div>
                <div class="mobile-dropdown">
                    <ul>

                        <li><a href="{{ route('about.records') }}">Records</a></li>

                    </ul>
                </div>
            </li>

            <li><a href="{{ route('about') }}">About</a></li>

            <li class="group {{ Request::is('dashboard*') ? 'mobile-nav-active' : '' }}">
                <div class="mobile-nav-link">
                    <a href="{{ route('dashboard') }}">Account</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
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

<script>
    document.getElementById('mobile-nav-collapse').querySelectorAll('li.group').forEach(collapsable => {

        let open = false

        collapsable.querySelector('.mobile-dropdown')?.classList.add('hidden');
        collapsable.querySelector('svg').classList.add('transition-transform')

        collapsable.querySelector('svg').onclick = () => {
            collapsable.querySelector('.mobile-dropdown').classList.toggle('hidden');

            if (open) {
                collapsable.querySelector('svg').style.transform = 'rotate(0deg)';
                open = false;
            } else {
                collapsable.querySelector('svg').style.transform = 'rotate(180deg)';
                open = true;
            }
        }

    });
</script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>