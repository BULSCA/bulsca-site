@extends('layouts.adminlayout')

@section('title')
{{ $committee_role->label }} | CommitteeRoles | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.committee_roles') }}">Committee Roles</a>
        <span>></span>
        <p>{{ $committee_role->label }}</p>

    </div>

    <h1 class="header">{{ $committee_role->label }} </h1>

    <hr class="my-8">


    @if ($committee_role->members->count() != 0)
    <hr class="my-8">
    @endif


    <div class="flex flex-col space-y-4">
        <h1 class="header">Committee Role Details</h1>
        <form action="@can('admin.committee_roles.manage'){{ route('admin.committee_role.edit', $committee_role) }}@endcan" method="POST" class="flex flex-col">
            @csrf

            <x-form-input deny="{{ auth()->user()->cannot('admin.committee_roles.manage') }}" id='label' title='Label' extraCss="md:col-span-2" defaultValue='{{ $committee_role->label }}' />

            <div>
                <p>Content</p>
                <div class="main-container">
                    <div class="editor-container editor-container_classic-editor editor-container_include-style"
                        id="editor-container">
                        <div class="editor-container__editor">
                            <textarea name="content" id="editor">{{ $committee_role->content }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <script type="importmap">
            {
              "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.1/"
              }
            }
            </script>
            <script type="module" src="{{ asset('js/ck.js') }}"></script>


            @can('admin.committee_roles.manage')
            <button type="submit" class="btn btn-thinner btn-save md:col-start-4">Save</button>
            @endcan
        </form>
    </div>

    <hr class="my-8">


    <div>
        <h2>Delete</h2>
        @can('admin.committee_roles.delete')
        <p>This <strong>CANNOT</strong> be undone!</p>
        <form action="{{ route('admin.committee_roles.delete') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="hidden" class="hidden" name="id" value="{{ $committee_role->id }}"></input>
            <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
        </form>
        @else
        <p>You aren't able to delete this committee_role, please contact the Data Manager!</p>
        @endcan
    </div>

</div>


@endsection