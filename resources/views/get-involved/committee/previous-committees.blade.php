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