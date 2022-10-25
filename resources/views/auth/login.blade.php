@extends('layout')

@section('title')
Login |
@endsection

@section('content')


<div class="h-[30vh] w-screen bg-gray-100  overflow-hidden  ">

  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center ">
      <img src="/storage/logo/blogo.png" class="w-[10%] hidden md:block" alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">Login</h2>

      </div>
    </div>

  </div>


</div>


<div class="container-responsive">
  <div class="flex flex-col items-center justify-center">

    @if($errors->any())
    <div class=" text-bulsca_red font-semibold my-3">


      {!! implode('<br />', $errors->all('<span>:message</span>')) !!}

    </div>
    @endif

    <form action="{{ route('login') }}" class="flex flex-col w-[80%] lg:w-[50%] 2xl:w-1/3" method="post">
      @csrf
      <div class="form-input">
        <label for="login-email">Email</label>
        <input id="login-email" class="input" name="email" required type="text" value="{{old('email')}}" @if(!old('email')) autofocus @endif placeholder="official@bulsca.co.uk">
      </div>
      <div class="form-input">
        <label for="login-password">Password</label>
        <input id="login-password" class="input" name="password" @if(old('email')) autofocus @endif required type="password">
      </div>
      <div class="form-checkbox">
        <input id="login-remember" name="remember" type="checkbox">
        <label for="login-remember">Remember Me</label>
      </div>

      <a href="{{ route('password.request') }}"><small>Forgot Password?</small></a>

      <button class="ml-auto btn btn-thinner">
        Login
      </button>
    </form>
  </div>
</div>


@endsection