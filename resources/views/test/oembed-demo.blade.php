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

<x-meta-content.carousel 
    title="Latest from BULSCA"
    :items="[
        'https://www.instagram.com/p/DPjy55CEh3F/?utm_source=ig_embed&amp;utm_campaign=loading',
        'https://www.instagram.com/p/DPeW1nEgLMY/?utm_source=ig_embed&amp;utm_campaign=loading',
        'https://www.instagram.com/p/DPEtrJBiSz1/?utm_source=ig_embed&amp;utm_campaign=loading'
    ]"
    height="h-[70vh]"
    backgroundOverlay="rgba(0, 0, 0, 0.5)"
/>


@endsection