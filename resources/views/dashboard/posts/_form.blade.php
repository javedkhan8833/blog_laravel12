@php
    $post = $post ?? null;
    $categories = $categories ?? collect();
    $selectedCategory = old('category_id', $post->category_id ?? '');
@endphp

<div class="mb-3">
    <label class="form-label" for="category_id">Category</label>
    <select class="form-select @error('category_id') is-invalid @enderror"
            id="category_id"
            name="category_id">
        <option value="" disabled {{ $selectedCategory === '' ? 'selected' : '' }}>Choose a category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ (string) $selectedCategory === (string) $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="title">Title</label>
    <input class="form-control @error('title') is-invalid @enderror"
           id="title"
           name="title"
           type="text"
           value="{{ old('title', $post->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="excerpt">Excerpt (optional)</label>
    <textarea class="form-control @error('excerpt') is-invalid @enderror"
              id="excerpt"
              name="excerpt"
              rows="2">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
    @error('excerpt')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="body">Body</label>
    <textarea class="form-control @error('body') is-invalid @enderror"
              id="body"
              name="body"
              rows="8">{{ old('body', $post->body ?? '') }}</textarea>
    @error('body')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="published_at">Publish At (optional)</label>
    <input class="form-control @error('published_at') is-invalid @enderror"
           id="published_at"
           name="published_at"
           type="datetime-local"
           value="{{ old('published_at', optional($post?->published_at)->format('Y-m-d\\TH:i')) }}">
    @error('published_at')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
