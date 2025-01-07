@extends('layouts.adminlayout')

@section('title')
{{ $tag->name }} | Tags | SERC | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.sercs') }}">SERCs</a>
        <span>></span>
        <a href="{{ route('admin.sercs.tags.list') }}">Tags</a>
        <span>></span>
        <p>{{ $tag->name }}</p>

    </div>

    <h1 class="header">{{ $tag->name }}</h1>






    <div>
        <form action="@can('admin.sercs.manage'){{ route('admin.sercs.tags.update', $tag) }}@endcan" enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='name' title='Name' defaultValue="{{ $tag->name }}" />

            <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-5">Save</button>

        </form>
    </div>

    <br>

    <div>
        <h3>Delete</h3>
        @can('admin.sercs.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.sercs.tags.delete', $tag) }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $tag->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this serc tag, please contact the Data Manager!</p>
        @endcan
    </div>

    

</div>



<script src="{{ asset('js/TagInput.js') }}"></script>


@endsection