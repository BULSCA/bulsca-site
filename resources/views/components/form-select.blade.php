<div class="form-input {{ $css }} @error($id) is-invalid @enderror">
  <label for="form-link-{{ $id }}" class="">{{ $title }}</label>
  <select type="{{ $type }}" required id="form-link-{{ $id }}" name="{{ $id }}" value="{{ old($id) ?: $defaultValue }}" class="input">
    <option value="null">Please select an option...</option>
    @foreach ($options as $option)
    <option value="{{ $option->id }}">{{ $option->name }}</option>
    @endforeach
  </select>
  @error($id)
  <small class="text-red-600">{{ $message }}</small>
  @enderror
</div>