@extends('layouts.adminlayout')

@section('title')
{{ $university->name }} | Universities | Admin | 
@endsection


@section('content')

<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.universities') }}">Universities</a>
        <span>></span>
        <p>{{ $university->name }}</p>

    </div>

    <h1 class="header" style="margin-bottom: 0 !important;">{{ $university->name }} </h1>




    <hr class="my-8">



  
    

    <div>
        <h1 class="header">University Details</h1>
        <form action="{{ route('admin.university.edit', $university) }}" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='name' type="text" title='Name' defaultValue='{{ $university->name }}' />
         


            <button type="submit" class="btn btn-thinner btn-save row-start-2 col-start-4">Save</button>
        </form>
    </div>

</div>


@endsection
