@extends('layout')

@section('title')
Previous Leagues | Competitions |
@endsection

@section('content')

<x-page-banner
    title="Previous Leagues"
    subtitle="Swimming since 2002"
    :snowContainer="true"
/>

<x-recent-results-banner />

<div class=" container-responsive ">
    <div class=" image-link-group">

        @foreach ($seasons as $season)
        <div class=" image-link " style="">
            <a href="{{ route('prev_season', $season->getDateSlug()) }}" class=" ">{{ $season->name }}</a>
        </div>
        @endforeach





    </div>
    <br>

    {{ $seasons->links() }}
    <br>

</div>











@endsection