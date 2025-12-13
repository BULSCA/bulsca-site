@extends('layouts.dashlayout')

@section('title')
Settings |
@endsection

@section('nav-extra')
nav-scrolled
@endsection

@section('content')



<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>></span>
        <p>Account Settings</p>
    </div>


    <h1 class="header">Account Settings</h1>
    <p>Edit your account settings here!</p>

    <hr class="my-8">

    <p>Settings page coming soon!</p>

    <hr class="my-8">

</div>







@endsection