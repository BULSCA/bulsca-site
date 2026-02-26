@extends('layout')

@section('title')
Contact |
@endsection

@section('content')

<x-page-banner
    title="Contact Form"
    :snowContainer="true"
/>

<div class="container-responsive w-[90%]">
    <h1 class="header header-large">
        Contact
    </h1>
    <p>
        If you've got a question or enquiry then someone at BULSCA will be happy to help. Fill out the form below and let us know who you'd like to contact. Your message will be forwarded to the relevant person, and you'll receive a confirmation email.
    </p>
    <br>
    <br>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <h4 class="font-bold mb-2">Please fix the following errors:</h4>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact-form.submit') }}" method="POST" class="flex flex-col">
        @csrf
        <div class="grid grid-cols-3 gap-4">
            <x-form-input id="name" title="Name"></x-form-input>
            <x-form-input id="email" title="Email" extraCss="col-span-2"></x-form-input>
        </div>

        <br>
        <hr>
        <br>

        <div class="mb-4">
            <label for="department" class="block font-semibold mb-2">Who would you like to contact?</label>
            <select id="department" name="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                <option value="">-- Select a department --</option>
                <option value="chair" @if(old('department') === 'chair' || request()->query('department') === 'chair') selected @endif>Chair - General inquiries & external organisations</option>
                <option value="secretary" @if(old('department') === 'secretary' || request()->query('department') === 'secretary') selected @endif>Secretary - Minutes & complaints</option>
                <option value="treasurer" @if(old('department') === 'treasurer' || request()->query('department') === 'treasurer') selected @endif>Treasurer - Finance & sponsorship</option>
                <option value="development" @if(old('department') === 'development' || request()->query('department') === 'development') selected @endif>Development Officer - Club development & training</option>
                <option value="recruitment" @if(old('department') === 'recruitment' || request()->query('department') === 'recruitment') selected @endif>Recruitment Officer - Starting a new club</option>
                <option value="data" @if(old('department') === 'data' || request()->query('department') === 'data') selected @endif>Data Manager - Website & competition data</option>
                <option value="championships" @if(old('department') === 'championships' || request()->query('department') === 'championships') selected @endif>Championships Coordinator - Annual championships</option>
                <option value="social" @if(old('department') === 'social' || request()->query('department') === 'social') selected @endif>Communication Officer - Website & social media</option>
                <option value="welfare" @if(old('department') === 'welfare' || request()->query('department') === 'welfare') selected @endif>Welfare Officer - Welfare & safeguarding</option>
                <option value="league" @if(old('department') === 'league' || request()->query('department') === 'league') selected @endif>League Team - League-related matters</option>
                <option value="judges" @if(old('department') === 'judges' || request()->query('department') === 'judges') selected @endif>Judges Panel - SERCs & competition moderation</option>
            </select>
        </div>

        <x-form-input id="subject" title="Subject"></x-form-input>

        <div class="mb-4">
            <label for="message" class="block font-semibold mb-2">Message</label>
            <textarea id="message" name="message" rows="8" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>{{ old('message') }}</textarea>
            <small class="text-gray-500 mt-1 block">Maximum 5000 characters</small>
        </div>

        <div
            class="cf-turnstile"
            data-sitekey="0x4AAAAAACiHoCPmXG0NP_Bx"
            data-action="contact"
            data-theme="light"
            data-size="flexible"
            data-appearance="always"
            data-callback="onSuccess"
        ></div>

        <br>
        <button type="submit" class="btn w-full">Send Message</button>
    </form>

</div>


<script
  src="https://challenges.cloudflare.com/turnstile/v0/api.js"
  async
  defer
></script>

@endsection
