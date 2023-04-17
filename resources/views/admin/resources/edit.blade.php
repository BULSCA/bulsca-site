@extends('layouts.adminlayout')

@section('title')
{{ $resource->name }} | Resources | Admin |
@endsection


@section('content')

<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.resources') }}">Resources</a>
        <span>></span>
        <p>{{ $resource->name }}</p>


    </div>

    <div class="flex flex-col">
        <h1 class="header">{{ $resource->name }}</h1>
        <br>
        <form action="" method="post" class="grid-3">
            @csrf
            <x-form-input id="name" title="Resource Name" :defaultObject="$resource"></x-form-input>
            <button class="btn btn-thinner btn-save row-start-2 col-start-4">Save</button>
        </form>
        <br>

        <hr>
        <br>
        <h3>Re-upload</h3>
        <p>Reupload the file or another file without changing the shared link.</p>

        <form action="{{ route('admin.resource.re-upload', $resource) }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-input">
                    <label for="upload-file">File</label>
                    <input id="upload-file" class="input file" name="resource" required type="file" onchange="updateFName(this.files)">
                </div>
                <div class="form-input">
                    <label for="upload-name">Name</label>
                    <input id="upload-name" class="input " style="padding-bottom: 0.87rem; padding-top:0.87rem" name="name" required type="text">
                </div>
            </div>
            <div class="flex ">
                <button class="btn btn-thinner btn-save ml-auto">Re-upload</button>
            </div>
        </form>
        <script>
            function updateFName(e) {

                document.getElementById(`upload-name`).value = e[0].name.split('.').slice(0, -1).join('.').replaceAll('_', " ").replaceAll('-', " ")



            }
        </script>

    </div>

    <br>
    <br>
    <hr>
    <br>
    <h3>Delete Resource</h3>
    <p>This <strong>cannot</strong> be undone!</p>
    <form action="{{ route('admin.resource.delete') }}" onsubmit="return confirm('Are you sure?')" method="post" class="flex items-center justify-center ">
        @csrf
        {{ method_field('DELETE') }}
        <input type="hidden" class="hidden" name="redirect" value="admin.resources"></input>
        <input type="hidden" class="hidden" name="id" value="{{ $resource->id }}"></input>
        <button submit class="btn btn-thinner btn-danger ml-auto">Delete</button>
    </form>
    <br>
    <br>
    <hr>
    <br>
    <br>
    <a href="{{ route('view-resource', $resource) }}" target="_blank" class="w-full flex justify-end">Open in a new tab</a>
    <iframe src="{{ route('view-resource', $resource) }}" class="w-full h-[90vh]" frameborder="0"></iframe>



</div>



@endsection