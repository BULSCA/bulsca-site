@extends('layouts.dashlayout')

@section('title')
Dashboard |
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



<div class="container-responsive">
  <h2 style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Competition Management</span></h2>
  <h2 style='margin-bottom: -.25em !important'><span class="text-bulsca_red font-bold">{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}</span></h2>
  <small class="">
    {{ $comp->when->format('d/m/Y @ h:m A') }}
  </small>



</div>

<div class="container-responsive">
  <h3>Results</h3>
  @if ($comp->getResultsResource()->first())
  <div class="flex items-center space-x-4">
    <x-resource-download :file="$comp->getResultsResource()->first()" />
    <a href="manage/remove-results" class="">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 hover:text-bulsca_red transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </a>
  </div>



  <hr class="my-5">

  @endif
  <h4>
    Upload/Change Results
  </h4>
  <form action="manage/upload-results" class="inline-block" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-input">
      <label for="upload-file">File</label>
      <input id="upload-file" class="input file:mr-4 file:py-2 file:px-0 file:pr-6 file:border-gray-200 file:border-0 file:shadow-none file:border-r cursor-pointer  file:bg-transparent" name="results" required type="file">
    </div>
    <button class="btn btn-thinner">Upload</button>
  </form>


</div>







@endsection