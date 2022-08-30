@extends('layouts.adminlayout')

@section('title')
Create | University | Admin |
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.universities') }}">Universities</a>
        <span>></span>
        <p>Create</p>

    </div>

    <h1 class="header">Create University</h1>






    <div>
        <form action="@can('admin.universities.manage'){{ route('admin.universities.create.post') }}@endcan" enctype="multipart/form-data" method="POST" class="grid grid-cols-4 gap-4">
            @csrf

            <x-form-input id='name' title='Name' extraCss="col-span-2" />



            <div class="row-start-2 ">
                <div class="form-input">
                    <label for="upload-logo">File</label>
                    <input id="upload-logo" class="input file" name="image" type="file" onchange="updatePreview(this.files[0])">
                    <small class="-mt-3 hover:underline cursor-pointer" onclick="document.getElementById('upload-logo').value=''; document.getElementById('preview').src='/storage/logo/blogo.png'">Clear</small>

                </div>

                <script>
                    function updatePreview(file) {
                        console.log(file)
                        document.getElementById('preview').src = URL.createObjectURL(file)
                    }
                </script>
            </div>
            <div class="form-input row-start-2 col-start-2">
                <label for="upload-logo">Logo Preview</label>
                <img id="preview" src="/storage/logo/blogo.png" class="m-2 h-24 w-24" alt="">

            </div>







            <button type="submit" class="btn btn-thinner btn-save col-start-4 row-start-3">Create</button>

        </form>
    </div>

</div>


@endsection