<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/storage/logo/blogo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}?{{ config('version.hash') }}">
  <title>@yield('title') BULSCA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="overflow-x-hidden flex flex-col min-h-screen">

  @section('nav-style') nav-scrolled relative @endsection
  @include('layouts.navigation')



  @yield('content')

  <x-layouts.footer></x-layouts.footer>

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