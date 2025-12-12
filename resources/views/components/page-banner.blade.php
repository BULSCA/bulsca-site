@props([
    'title' => '',
    'subtitle' => '',
    'logo' => '/storage/logo/blogo.png',
    'height' => 'h-[40vh]',
    'snowContainer' => false,
    'backgroundImage' => null,
    'backgroundOverlay' => 'rgba(0, 0, 0, 0)'
])

<div {{ $attributes->merge(['class' => $height . ' w-screen bg-gray-100 overflow-hidden']) }} @if($snowContainer) id="page-banner" data-snow-container @endif>
  <div class="h-full w-full overflow-hidden relative">
    <div class="absolute top-0 right-0 w-full h-full head-bg-3 flex items-center justify-center"
         @if($backgroundImage)
         style="background-image: linear-gradient({{ $backgroundOverlay }}, {{ $backgroundOverlay }}), url('{{ $backgroundImage }}'); background-size: cover; background-position: center;"
         @endif>
      <img src="{{ $logo }}" class="w-[10%] hidden md:block" alt="">
      <div class="md:border-l-2 border-white md:ml-12 md:pl-12 py-8">
        <h2 class="md:text-6xl text-4xl font-bold text-white">{{ $title }}</h2>
        @if($subtitle)
          <p class="text-white">{{ $subtitle }}</p>
        @endif
      </div>
    </div>
  </div>
</div>