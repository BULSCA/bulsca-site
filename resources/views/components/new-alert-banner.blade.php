@props([
    'content' => null,
    'backgroundColour' => 'rgba(0, 0, 0, 0)'
])

<div class="flex items-center justify-center text-white p-3
    " style="background-color: {{ $backgroundColour }}"
>
  {!! $content !!}
</div>