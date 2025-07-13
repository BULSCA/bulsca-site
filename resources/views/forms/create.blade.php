@extends('layouts.dashlayout')

@section('title')
    Signup dashboard |
@endsection

@section('nav-extra')
    nav-scrolled
@endsection

@section('content')

@section('content')
<div class="container">
    <h1>Create New Form</h1>
</div>

{{-- resources/views/forms/create.blade.php --}}
<form method="POST" action="{{ route('forms.store') }}">
    @csrf
    <input type="text" name="field1">
    <button type="submit">Submit</button>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</form>

@endsection
