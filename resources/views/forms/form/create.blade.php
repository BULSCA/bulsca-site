@section('title', "My Forms | Create a Form")

@extends('layout')

@section('content')

<div class="h-[40vh] w-screen bg-gray-100  overflow-hidden  ">
    <div class="h-full w-full overflow-hidden relative">
        <div class="absolute top-0 right-0 w-full h-full  flex  items-center justify-center head-bg-3  "
            style="background-image: linear-gradient(rgba(0, 0, 0, 0.25),
                rgba(0, 0, 0, 0.25)), url('storage/photos/freshers/fresher_banner.jpeg');  ">
            <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block " alt="">
            <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
                <h1 class="md:text-6xl text-4xl font-bold text-white">Forms</h1>
                <p class="text-white">Forms Creation</p>

            </div>
        </div>
    </div>
</div>

<div class="container-responsive">
    <div class="flex items-center ">
        <div class="flex flex-col">
            <h2 class="" style='margin-bottom: -.25em !important'><span style="font-size: 0.5em !important">Hello</span></h2>
            <h2 class="   " style='margin-bottom: -.25em !important'><span
                    class="text-bulsca_red font-bold">{{ auth()->user()->name }}</span></h2>
            <small class="">
                @if (auth()->user()->getHomeUni())
                    Associated with {{ auth()->user()->getHomeUni()->name }} University
                    @if (auth()->user()->isUniAdmin(auth()->user()->getHomeUni()->id))
                        <small>(Admin)</small>
                    @endif
                @else
                    No Associated University!
                @endif
            </small>
        </div>
        <a href="{{ route('forms.index') }}" class="btn btn-thinner ml-auto">All Forms</a>
    </div>

    <hr class="my-5">
    
    <div class="panel panel-flat border-top-lg border-top-success">
        <div class="panel-heading">
            <h5 class="panel-title">Create a Form</h5>
        </div>
        <div class="panel-body">
            @include('forms.form._form', ['type' => 'create'])
        </div>
    </div>
</div>

@endsection