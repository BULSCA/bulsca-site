@extends('layout')

@section('title')
Previous Leagues | Competitions |
@endsection

@section('content')

<x-page-banner
    title="Previous Committees"
    subtitle="Governing British Universities Lifesaving since 2002"
    :snowContainer="true"
/>

<!-- <a href="#" class="notification-stripe ns-red">
    Southampton results are now available!
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
    </svg>
  </a> -->

<div class=" container-responsive ">
    <div class=" image-link-group">

        @foreach ($committees as $committee)
        <div class=" image-link " style="">
            <a href="{{ route('prev_committee', ['cid' => $committee->date_slug]) }}" class=" ">{{ $committee->name }}</a>
        </div>
        @endforeach





    </div>
    <br>

    {{ $committees->links() }}
    <br>

</div>











@endsection