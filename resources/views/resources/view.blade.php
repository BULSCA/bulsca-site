@extends('layout')

@section('title')
{{ $p->name }} | Resources |
@endsection

@section('content')

<x-page-banner
  title="{{ $p->name }}"
  subtitle="Resources"
  :snowContainer="true"
/>

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
  @can('admin.resources.manage')
  <p class="mb-4 font-bold">Shift-right click a resource to edit it</p>
  @endcan
  @forelse ($p->getSections()->orderBy('ordering')->get() as $sec)


  <h3 class="header" style="margin-bottom: 1rem">{{ $sec->name }}</h3>


  <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
    @forelse ($sec->getRPSR as $r)
    <x-resource-download :file="$r->getResource()->first()" />

    @empty
    <small>No resources found!</small>


    @endforelse
  </div>
  <br>
  <hr><br>

  @empty
  <p class="text-center">
    There doesn't appear to be anything here right now!
  </p>

  @endforelse
</div>


@endsection