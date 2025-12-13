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

<!-- 
@php
    $MetaContentService = app(\App\Services\MetaContentService::class);
    $posts = $MetaContentService->getLatestPosts(9);
@endphp

@php
    $metaService = app(\App\Services\MetaContentService::class);
    // Will use real API if configured, otherwise uses samples
    $posts = $metaService->getPosts(9);
@endphp
-->
@php
    $metaService = app(\App\Services\MetaContentService::class);
    $posts = $metaService->getSamplePosts(6);
@endphp

<x-meta-content.image-carousel 
    title="Latest from BULSCA Instagram"
    :posts="$posts"
    backgroundOverlay="rgba(0, 0, 0, 0.5)"
/>

<!-- Rest of your demo content -->
<div class="container-responsive py-8">
    <!-- Your existing Facebook/Instagram embed examples -->
</div>

@endsection