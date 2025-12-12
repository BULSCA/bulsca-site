@extends('layout')

@section('title')
Login |
@endsection

@section('content')

<x-page-banner
    title="Login"
    height='h-[30vh]'
    :snowContainer="true"
/>


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

    @if(config('sso.enabled'))
        <div style="text-align: center; margin: 20px 0;">
            <p>- OR -</p>
        </div>
        
        <a href="{{ route('auth.sso') }}" style="text-decoration: none;">
            <button type="button" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Sign in with BULSCA SSO
            </button>
        </a>
    @endif

  </div>
</div>


@endsection