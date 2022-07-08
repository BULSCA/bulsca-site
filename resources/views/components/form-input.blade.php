<div class="form-group {{ $css }} @error($id) is-invalid @enderror">
    <label for="form-link-{{ $id }}" class="">{{ $title }}</label>
    <input type="{{ $type }}" required id="form-link-{{ $id }}" name="{{ $id }}" value="{{ old($id) ?: $defaultValue }}" class="">
    @error($id)
        <small>{{ $message }}</small>
    @enderror
</div>