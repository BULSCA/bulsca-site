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

<x-new-alert-banner
    :content="'
        <strong class=\'font-bold\'>Important:</strong>
        <span class=\'ml-2\'>BULSCA has introduced Single Sign-On (SSO) for enhanced security and convenience.  We recommend using SSO to access your account if it was created after 13/12/2025.</span>
    '"
    backgroundColour="rgba(220, 38, 38, 0.9)"
/>

<div class="container-responsive">
    <div class="flex flex-col items-center justify-center">
        
        @if($errors->any())
        <div class="text-bulsca_red font-semibold my-3">
            {!! implode('<br />', $errors->all('<span>:message</span>')) !!}
        </div>
        @endif

        <div class="flex flex-col w-[80%] lg:w-[50%] 2xl:w-1/3 space-y-4">
            
            <!-- Heading -->
            <div class="text-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Sign In to BULSCA</h2>
                <p class="mt-2 text-sm text-gray-600">Choose how you'd like to sign in</p>
            </div>

            <!-- SSO Login Button (Recommended) -->
            <a href="{{ route('auth.sso') }}" class="btn btn-thinner w-full text-center inline-flex items-center justify-center relative">
                <svg class="w-5 h-5 mr-2 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span class="flex-1">Sign in with BULSCA SSO</span>
                <span class="absolute right-4 px-2 py-1 text-xs bg-green-500 text-white rounded font-semibold">Recommended</span>
            </a>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">or</span>
                </div>
            </div>

            <!-- Legacy Login Button -->
            <a href="{{ route('login.legacy') }}" class="btn btn-thinner btn-secondary w-full text-center bg-white border-2 border-gray-300 text-gray-700 hover:bg-gray-50">
                Use Legacy Login
            </a>

            <!-- Register Link -->
            <div class="text-center mt-6 text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-bulsca_red hover:underline font-semibold">
                    Create one
                </a>
            </div>
        </div>
    </div>
</div>
@endsection