<div class="form-input {{ $css }} @error($id) is-invalid @enderror">
    <label for="form-link-{{ $id }}" class="">{{ $title }}</label>
    <input type="{{ $type }}" @if ($required=='true' ) required @endif id=" form-link-{{ $id }}" name="{{ $id }}" value="{{ old($id) ?: $defaultValue }}" class="input">
    @error($id)
    <small class="text-red-600">{{ $message }}</small>
    @enderror
</div>