@extends('layout')

@section('title')
Social Media Embed Demo |
@endsection

@section('content')

<x-page-banner
    title="BULSCA Social Media Integration"
    subtitle="This page demonstrates how BULSCA embeds Facebook and Instagram content on our website to share updates with our university lifesaving community."
    :snowContainer="true"
/>

<x-meta-content.instagram-carousel />

<!-- Rest of your demo content -->
<div class="container-responsive py-8">
    <!-- Your existing Facebook/Instagram embed examples -->
     <p>whitespace</p>
</div>

@endsection