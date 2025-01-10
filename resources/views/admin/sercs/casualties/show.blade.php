@extends('layouts.adminlayout')

@section('title')
    {{ $casualty->name }} | Casualties | SERCs | Admin |
@endsection


@section('content')
    <div class="container-responsive">
        <div class="breadcrumbs">
            <a href="{{ route('admin') }}">Admin</a>
            <span>></span>
            <a href="{{ route('admin.sercs') }}">SERCs</a>
            <span>></span>
            <a href="{{ route('admin.sercs.casualties') }}">Casualties</a>
            <span>></span>
            <p>{{ $casualty->name }}</p>
        </div>

        <h1 class="header">{{ $casualty->name }}</h1>






        <div>
            <form action="@can('admin.sercs.manage'){{ route('admin.sercs.casualties.update', $casualty) }}@endcan"
                enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
                @csrf

                <x-form-input id='name' title='Name' defaultValue="{{ $casualty->name }}" />
                <x-form-input id='manual' required='false' title='Manual Reference'
                    defaultValue="{{ $casualty->manual_reference }}" />

                <x-form-select id="group" required="true" title="Group" :options="$groups"
                    defaultValue="{{ $casualty->group }}"></x-form-select>








                <div class=" row-start-2 col-span-4">


                    <div>
                        <label for="description">Description</label>
                        <div class="main-container">
                            <div class="editor-container editor-container_classic-editor editor-container_include-style"
                                id="editor-container">
                                <div class="editor-container__editor prose">
                                    <textarea name="description" id="editor" style="display: none">{!! old('description') ?: $casualty->description !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>







                <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-5">Save</button>

            </form>
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

        <br>

        <div>
            <h3>Delete</h3>
            @can('admin.sercs.delete')
                <p>This <strong>CANNOT</strong> be undone!</p>
                <form action="{{ route('admin.sercs.casualties.delete', $casualty) }}"
                    onsubmit="return confirm('Are you sure? This cannot be undone!')" class="flex" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="hidden" class="hidden" name="id" value="{{ $casualty->id }}"></input>
                    <button class="btn btn-thinner btn-danger ml-auto">Delete</button>
                </form>
            @else
                <p>You aren't able to delete this competition, please contact the Data Manager!</p>
            @endcan
        </div>
    </div>
@endsection
