@extends('layout')

@section('title')
First Steps | Clubs |
@endsection

@section('content')

<x-page-banner
    title="Create a Club"
    subtitle="Looking to form a club at your Uni?"
    :snowContainer="true"
/>


<div class=" container-responsive ">
  <h1 class="header">Getting started </h1>
  <p>
    If you are a current university student looking to set up a new lifesaving club, then contact the Chair, {{ $chair->currentMemberName() }} at <a href="mailto:chair@bulsca.co.uk">chair@bulsca.co.uk</a>
  </p>
</div>



@endsection