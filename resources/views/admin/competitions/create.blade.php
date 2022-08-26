@extends('layouts.adminlayout')

@section('title')
Create | Competitions | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.competitions') }}">Competitions</a>
        <span>></span>
        <p>Create</p>

    </div>

    <h1 class="header">Create Competition</h1>
    <small>For {{ $season->name }}</small>
    <br>
    <br>





    <div>
        <form action="{{ route('admin.competition.create.post') }}" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-select id="host" required="true" title="Host" :options=" $unis "></x-form-select>
            <x-form-input id='when' type="datetime-local" title='When' />
            <input type="hidden" class="hidden" name='season' value="{{ $season->id }}">




            <button type="submit" class="btn btn-thinner btn-save row-start-2 col-start-4">Create</button>

        </form>
    </div>

</div>


@endsection