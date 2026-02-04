@php
    $category = $category ?? null;
@endphp

<div class="mb-3">
    <label class="form-label" for="name">Name</label>
    <input class="form-control @error('name') is-invalid @enderror"
           id="name"
           name="name"
           type="text"
           value="{{ old('name', $category->name ?? '') }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
