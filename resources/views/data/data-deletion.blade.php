@extends('layout')

@section('title')
Data-deletion |
@endsection

@section('content')

<x-page-banner
  title="Data Deletion"
  :snowContainer="true"
/>

<div class="container-responsive w-[90%]">
  <h1 class="header header-large">
    Data Deletion Instructions
  </h1>
  <p>If you have a BULSCA login and would like your account or associated data removed, please contact us using the form below.</p>

  <p>
    <a href="{{ route('contact-form') }}?department=data" class="btn inline-block mt-4">Request Data Deletion</a>
  </p>

  <p>We will process your request and confirm once your data has been deleted from our systems.</p>
</div>


</div>
@endsection
