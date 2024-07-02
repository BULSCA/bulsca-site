<div class="form-input {{ $css }} @error($id) is-invalid @enderror {{ $type }}">
    <label for="form-link-{{ $id }}" class="flex ">{{ $title }} @if($required=='true')<span class="ml-auto text-bulsca_red">*</span>@endif</label>
    <input @if ($deny==true ) readonly @endif @if($dlist != "") list="{{ $dlist }}" @endif @if($type=="checkbox" && $defaultValue) checked @endif type="{{ $type }}" @if ($required=='true' ) required @endif id="form-link-{{ $id }}" name="{{ $id }}" value="{{ old($id) ?: $defaultValue }}" class="input">
    @error($id)
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>