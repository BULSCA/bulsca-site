@extends('layouts.adminlayout')

@section('title')
Resources | Admin | 
@endsection


@section('content')

<div class="container-responsive">
    <div class="breadcrumbs">
        <a href="{{ route('admin') }}">Admin</a>
        <span>></span>
        <a href="{{ route('admin.resources') }}">Resource Pages</a>
        <span>></span>
        <p>{{ $rp->name }}</p>


    </div>

    <div class="flex flex-row">
        <h1 class="header">Sections</h1>

    </div>
    

    
    <div class="grid grid-cols-1 gap-4">
    @foreach ($rp->getSections as $sec)
        <div  class="  rounded-md border hover:border-bulsca transition no-underline">
            <div class=" px-6 py-4 flex items-center justify-center border-b">
                <h1 class="header header-bold" style="margin-bottom: 0 !important">
                    {{ $sec->name }}
                </h1>
                <div class="ml-auto flex flex-row items-center justify-center space-x-4">
                    <small class="text-black font-normal ">{{ $sec->getResources()->count() }} Items</small>
                    <form action="{{ route('admin.resources.section.delete') }}" onsubmit="return confirm('Are you sure?')" class="flex items-center justify-center" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" value="{{ $sec->id }}" class="hidden">
                        <button submit class="icon cross"></button>
                    </form>
                </div>
            </div>
            

            <div class="px-6 py-4">
                <h2 class="header header-small">Resources</h2>
                <div class="grid grid-cols-3 gap-x-4 gap-y-2">
                    @forelse ( $sec->getResources() as $res )
                        <div class="flex flex-row items-center justify-center">
                            <p>{{ $res->name }}</p>
                            <form action="{{ route('admin.resource.delete') }}" onsubmit="return confirm('Are you sure?')" method="post" class="ml-auto flex items-center justify-center ">
                                @csrf
                                {{ method_field('DELETE') }}
                                <input type="hidden" class="hidden" name="id" value="{{ $res->id }}"></input>
                                <button submit class="icon cross"></button>
                            </form>
                        </div>
                    @empty
                        <small class=" font-normal">None found</small>
                    @endforelse
                </div>
            </div>

            <div class="px-6 py-6">
            <form action="{{ route('admin.resource.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
                        <!-- <div class="form-input">
                            <label for="upload-name">File Name</label>
                            <input id="upload-name" class="input" name="name" required type="text"  placeholder="File">
                        </div> -->
                        <input type="hidden" name="section" value="{{ $sec->id }}" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-input">
                                <label for="upload-file">File</label>
                                <input id="upload-file" class="input file" name="resource" required type="file" onchange="updateFName(this.files)" >
                            </div>
                            <div class="form-input">
                                <label for="upload-name">Name</label>
                                <input id="upload-name" class="input " style="padding-bottom: 0.87rem; padding-top:0.87rem" name="name" required type="text" >
                            </div>
                        </div>
                        <button class="btn btn-thinner">Upload</button>
                </form>
                <script>
                    function updateFName(e) {
                        
                        document.getElementById('upload-name').value = e[0].name.split('.').slice(0, -1).join('.').replaceAll('_', " ").replaceAll('-', " ")

                       

                    }
                </script>
            </div>
            
        
</div>
            
        @endforeach

    </div>

    <br><br>
    <div >
        <h2 class="header">Add New Section</h2>
        
        <form action="{{ route('admin.resources.section.create' ) }}" method="POST" enctype="multipart/form-data">
            @csrf
                        <!-- <div class="form-input">
                            <label for="upload-name">File Name</label>
                            <input id="upload-name" class="input" name="name" required type="text"  placeholder="File">
                        </div> -->

                        <input type="hidden" name="page" value="{{ $rp->id }}" class="hidden">
                    
                        <div class="form-input">
                            <label for="new-section">Section</label>
                            <input id="new-section" class="input" name="name" required type="text" >
                        </div>
                        <button class="btn btn-thinner">Create</button>
                </form>
    </div>

    <br>
    <hr>
    <br>
    <div>
        <h2 class="header">Delete Page</h2>
        <form action="{{ route('admin.resources.page.delete') }}" onsubmit="return confirm('Are you sure?')" method="post">
            <input type="hidden" name="id" value="{{ $rp->id }}" class="hidden">
            @csrf
            {{ method_field('DELETE') }}
            <button class="btn btn-thinner btn-danger">Delete</button>
        </form>
    </div>




   

</div>


@endsection
