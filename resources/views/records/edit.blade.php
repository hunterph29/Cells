@extends('layouts.app')

@section('bodyClass', 'dashboard-admin')
@section('hideNavbar', true)
@section('showSidebar', true)

@section('content')
<div class="page-card">
    <div class="topbar mb-4">
        <div>
            <h2 class="h4 mb-1">Edit Record</h2>
            <p class="text-muted mb-0">Update the record details.</p>
        </div>
        <x-profile-chip />
    </div>

    <div class="table-card p-4">
        <form method="POST" action="{{ route('records.update', $record) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title', $record->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $record->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-accent">Update Record</button>
            <a href="{{ route('records.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
