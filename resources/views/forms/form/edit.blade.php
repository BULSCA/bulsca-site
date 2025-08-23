@extends('layouts.dashlayout')

@section('title')
    My Forms | Edit Form
@endsection

@section('nav-extra')
    nav-scrolled
@endsection

@section('content')



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
        <a href="{{ route('forms.create') }}" class="btn btn-thinner ml-auto">Create a Form</a>
    </div>

    <hr class="my-5">

    <h3 class="">
        Edit Form
    </h3>


    

    <div class="panel panel-flat border-top-lg border-top-primary">
        <div class="panel-body">
            @include('forms.form._form', ['type' => 'edit'])
        </div>
    </div>

</div>

@endsection