@extends('layouts.adminlayout')

@section('title')
Create | Seasons | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.seasons') }}">Seasons</a>
        <span>></span>
        <p>Create</p>

    </div>

    <h1 class="header">Create Season</h1>






    <div>
        <form action="@can('admin.seasons.create.post'){{ route('admin.seasons.create') }}@endcan" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='name' title='Name' extraCss="col-span-2" />
            <x-form-input id='from' type="datetime-local" title='From' />
            <x-form-input id='to' type="datetime-local" title='To' />




            <button type="submit" class="btn btn-thinner btn-save col-start-4">Create</button>

        </form>
    </div>

</div>


@endsection