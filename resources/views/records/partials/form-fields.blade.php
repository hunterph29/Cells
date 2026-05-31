@props(['record' => null, 'prefix' => ''])

<div class="mb-3">
    <input
        type="text"
        name="title"
        id="{{ $prefix }}record_title"
        value="{{ old('title', $record?->title) }}"
        class="form-control classroom-input @error('title') is-invalid @enderror"
        placeholder="Record title"
        required
    >
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-0">
    <textarea
        name="description"
        id="{{ $prefix }}record_description"
        class="form-control classroom-input @error('description') is-invalid @enderror"
        rows="4"
        placeholder="Description"
    >{{ old('description', $record?->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
