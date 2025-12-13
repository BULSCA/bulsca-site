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
        <p>Change Password</p>
    </div>


    <h1 class="header">Change Password</h1>
    <p>Change your password here!</p>

    <br>
    <hr>
    <br>
    <h2 class="header header-smallish">
        Change Password
    </h2>
    <form action="{{ route('password.change') }}" class="grid md:grid-cols-3 grid-cols-1 gap-4" method="post">
        @csrf
        <x-form-input id="old_password" type="password" title="Old Password"></x-form-input>
        <x-form-input id="new_password" type="password" title="New Password"></x-form-input>
        <x-form-input id="new_password_conf" type="password" title="New Password Confirmation"></x-form-input>

        <div class="md:col-start-3 flex">
            <button submit class="btn btn-thinner ml-auto">Save</button>
        </div>

    </form>

</div>

@endsection