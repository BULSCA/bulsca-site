@extends('layouts.adminlayout')

@section('title')
    Add | Casualties | SERCs | Admin |
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
            <p>Add</p>
        </div>

        <h1 class="header">Add Casualty</h1>






        <div>
            <form action="@can('admin.sercs.manage'){{ route('admin.sercs.casualties.store') }}@endcan"
                enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
                @csrf

                <x-form-input id='name' title='Name' />
                <x-form-input id='manual' required='false' title='Manual Reference' />

                <x-form-select id="group" required="true" title="Group" :options="$groups"></x-form-select>




                <p class="row-start-2 col-span-4 text-red-500 font-semibold">You can add an image gallery after creating the
                    casualty
                </p>




                <div class=" row-start-3 col-span-4">


                    <div>
                        <label for="description">Description</label>
                        <div class="main-container">
                            <div class="editor-container editor-container_classic-editor editor-container_include-style"
                                id="editor-container">
                                <div class="editor-container__editor prose">
                                    <textarea name="description" id="editor">
                                        {!! old('description') !!}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>







                <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-5">Add</button>

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
    </div>
@endsection
