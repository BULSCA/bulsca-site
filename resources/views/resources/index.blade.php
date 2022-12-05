@extends('layout')

@section('title')
Resources |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">Resources</h2>
        <p class="text-white">Beep boop...</p>
      </div>
    </div>

  </div>


</div>


<div class="container-responsive no-bottom">
  <div class="form-search group">
    <input type="text" id="resource-search" class="input" placeholder="Search...">
    <div id="resource-search-results" class="results">

    </div>
    <script>
      document.getElementById('resource-search').addEventListener('keyup', function(e) {
        update(e.target.value)
      });

      function update(search) {


        fetch(`/resources/search/${search}`).then(res => res.json()).then(data => process(data))


        function process(data) {
          let target = document.getElementById('resource-search-results')
          target.innerHTML = ""

          data.forEach(i => add(i, target))
        }


        function add(data, to) {
          let container = document.createElement('A');
          container.classList.add('result');
          container.href = `/resources/view/${data['resource']}`
          container.target = "_blank"
          let title = document.createElement('P');
          title.innerHTML = data['name'];
          let content = document.createElement('P');
          //content.innerHTML = 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aperiam odio officia id rem minus, soluta et quia architecto ut dolor.';

          container.appendChild(title);
          container.appendChild(content);

          to.appendChild(container);
        }


      }
    </script>
  </div>
</div>

<div class="container-responsive">
  <div class="image-link-group">

    @foreach ($pages as $page)
    <div class=" image-link " style="background-image: url({{ $page->image ?: '/storage/photos/DSC_0014.jpg' }});">
      <a href="{{ route('resources.page.view', Str::replace(' ', '-', Str::lower($page->name))) }}" class=" ">{{ $page->name }}</a>
    </div>
    @endforeach



  </div>
</div>

<div class="container-responsive">
  <h1 class="">Forms</h1>


  <div class="grid-3">
    <div class="file-link mt-2" title='Club Support Fund Application'>
      <a href='https://docs.google.com/forms/d/e/1FAIpQLSfJzTHAYDHY9tJ7vENXKWBeqGSP0Qg9CBjxF-CWAhUnx1uTJA/viewform' rel="noopener noreferrer" target='_blank'>
        <div>
          <h3>Club Support Fund Application</h3>

        </div>

        <div>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
          </svg>

        </div>
      </a>
    </div>
  </div>
</div>











@endsection