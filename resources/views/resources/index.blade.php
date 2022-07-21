@extends('layout')

@section('title')
Championships 2022 | Competitions | 
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

    <div class="h-full w-full overflow-hidden relative">
      <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center " >
        <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
        <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
          <h2 class="md:text-6xl text-4xl font-bold text-white">Resources</h2>
          <p class="text-white">Beep boop...</p>
        </div>
      </div>

    </div>

    
  </div>

  
<div class="container-responsive">
    <div class="image-link-group">
       
        <div class=" image-link " style="background-image: url(/storage/photos/DSC_0014.jpg);">
            <a href="{{ route('governance') }}" class=" " >Governance</a>
        </div>
        <div class=" image-link " style="background-image: url(/storage/photos/DSC_0348.jpg);">
            <a href="#" class=" " >Meetings</a>
        </div>
       
    </div>
</div>

<div class="container-responsive hidden">
  <form action="/resources/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-input">
                <label for="upload-name">File Name</label>
                <input id="upload-name" class="input" name="name" required type="text"  placeholder="File">
            </div>
            <div class="form-input">
                <label for="upload-file">File</label>
                <input id="upload-file" class="input" name="fupload" required type="file" >
            </div>
            <button class="btn">Upload</button>
  </form>
</div>











@endsection