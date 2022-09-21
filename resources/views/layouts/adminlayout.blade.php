<!DOCTYPE html>
<html lang="en" class="">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/storage/logo/blogo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>@yield('title') BULSCA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="overflow-x-hidden flex flex-col min-h-screen">
  <div class=" w-screen z-50 transition-all duration-100 nav-scrolled-blue" id="navbar">
    <div class="nav-wrapper transition-all duration-100">
      <a href="/" class="nav-brand md:text-3xl text-xl pr-2 md:pr-0 capitalize transition-all">
        British Universities Lifesaving Clubs' Association
      </a>

      <div class="md:hidden block text-white font-bold ">
        <svg id="mobile-nav-opener" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </div>

      <nav class="ml-auto mr-10 md:block hidden">
        <ul class="flex space-x-12 nav-list">
          <li><a href="{{ route('latest') }}">Latest</a></li>
          <li class="group {{ Request::is('competitions*') ? 'nav-active' : ''}}">
            <a href="{{ route('comps') }}">Competitions</a>
            <div class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
              <ul>
                <li><a href="{{ route('league') }}">League</a></li>
                <li><a href="{{ route('champs') }}">Champs</a></li>
              </ul>
            </div>
          </li>
          <li class="group {{ Request::is('get-involved*') ? 'nav-active' : ''}}">
            <a href="{{ route('get-involved') }}">Get Involved</a>
            <div class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
              <ul>
                <li><a href="{{ route('clubs') }}">Clubs</a></li>
                <li><a href="{{  route('create-club')  }}">Create a Club</a></li>
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
          <li><a href="#">About</a></li>
          <li class="group">
            <a href="{{ route('dashboard') }}">Account</a>
            <div class="dropdown group-hover:h-auto group-focus:h-auto group-active:h-auto group-focus-within:h-auto">
              <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @hasanyrole('admin|super_admin')
                <li><a href="{{ route('admin') }}">Admin</a></li>
                @endhasanyrole
                <li><a href="{{ route('logout') }}">Logout</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <div id="mobile-nav" class="mobile-nav">
    <div>
      <a href="/" class="nav-brand md:text-3xl text-xl pr-2 md:pr-0 capitalize transition-all">
        British Universities Lifesaving Clubs' Association
      </a>
      <div class="md:hidden block text-white font-bold ">
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
        <li><a href="{{ route('resources') }}">Resources</a></li>
        <li><a href="#">About</a></li>
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



  @yield('content')



  <footer class="bg-black w-full flex flex-col items-center justify-center mt-auto">
    <div class="p-6 px-32 flex flex-row items-center justify-center space-x-4">

      <a href="https://www.facebook.com/BULSCA/" rel="noopener noreferrer" target="_blank"><img src="/storage/logo/f_logo_RGB-Blue_1024.png" loading="lazy" class="w-12 h-12" alt=""></a>
      <a href="https://www.instagram.com/bulsca" rel="noopener noreferrer" target="_blank"><img src="/storage/logo/Instagram_Glyph_Gradient_RGB.png" loading="lazy" class="w-12 h-12" alt=""></a>

    </div>
    <small class="text-white pb-4">
      Made with ☕ by Noah
    </small>
  </footer>

  @if(session('message'))
  <x-notification-sliver>{{ session('message') }}</x-notification-sliver>
  @endif
</body>

<script>
  window.onload = function() {
    initMobileNav()


  }


  function initMobileNav() {
    let mn = document.getElementById('mobile-nav');
    let mno = document.getElementById('mobile-nav-opener');
    let mnc = document.getElementById('mobile-nav-closer');


    mno.onclick = () => {
      mn.classList.add('open')
    }

    mnc.onclick = () => {
      mn.classList.remove('open')
    }
  }
</script>

</html>