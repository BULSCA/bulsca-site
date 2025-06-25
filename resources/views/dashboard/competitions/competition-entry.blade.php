@extends('layouts.dashlayout')

@section('title')
(Entry) {{ $comp->hostUni->name }} {{ $comp->when->format('Y') }} | Competitions |
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



<div class="container-responsive">
  <div class="flex items-center justify-center">
    <div class="flex flex-col">
      <h2 style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Competition Entry</span></h2>
      <h2 style='margin-bottom: -.15em !important'><span class="text-bulsca_red font-bold">{{ $comp->hostUni->name }} {{ $comp->when->format('Y') }}</span></h2>
      <small class="">
        {{ $comp->when->format('d/m/Y @ h:m A') }}
      </small>
    </div>
    <a href="{{ route('lc-view', Str::lower($comp->hostUni->name) . '-' . $comp->when->format('Y') . '.' . $comp->id) }}" class="btn btn-thinner ml-auto">View</a>
  </div>


  <br>
  <div class="alert">
    <h3>Important!</h3>
    <p>
      Please fill out all of the following by the time the competition entries close! <br>
      You <strong>don't need to finish</strong> it in one go. It can be amended over time!
    </p>
  </div>
  <br>

  <form action="{{ route('lc-manage-update', ['cid' => $comp->id]) }}" method="post" class="flex flex-col">


    @csrf



@endsection
