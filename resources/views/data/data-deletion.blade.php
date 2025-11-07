@extends('layout')

@section('title')
Data-deletion |
@endsection

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">Data Deletion</h2>

      </div>
    </div>

  </div>


</div>

<div class="container-responsive w-[90%]">
  <h1 class="header header-large">
    Data Deletion Instructions
  </h1>
  <p>If you have a BULSCA login and would like your account or associated data removed, please contact us using the email below.</p>

  <p>Email: <a href="mailto:data@bulsca.co.uk">data@bulsca.co.uk</a></p>

  <p>We will process your request and confirm once your data has been deleted from our systems.</p>
</div>


</div>
@endsection
