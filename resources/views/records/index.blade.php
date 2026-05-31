@extends('layouts.app')

@section('bodyClass', 'dashboard-admin')
@section('hideNavbar', true)
@section('showSidebar', true)

@section('content')
<div class="page-card">
    <div class="topbar mb-4">
        <div>
            <h2 class="h4 mb-1">Records</h2>
            <p class="text-muted mb-0">Manage your records and activity data.</p>
        </div>
        <x-profile-chip />
    </div>

    <div class="table-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="h6 mb-0">Record list</h3>
            <button
                type="button"
                class="toolbar-add-btn"
                data-bs-toggle="modal"
                data-bs-target="#addRecordModal"
                aria-controls="addRecordModal"
                title="Add record"
                aria-label="Add record"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->title }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($record->description, 80) }}</td>
                            <td>{{ $record->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <x-kebab-actions
                                    :edit-url="route('records.edit', $record)"
                                    :delete-url="route('records.destroy', $record)"
                                    :can-delete="auth()->user()->canDelete()"
                                    delete-confirm="Delete this record?"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $records->links() }}
    </div>
</div>

@include('records.partials.modals')
@endsection

@push('scripts')
<script>
    (function () {
        var openModal = @json(session('open_record_modal'));
        if (openModal === 'add') {
            var addModal = document.getElementById('addRecordModal');
            if (addModal) bootstrap.Modal.getOrCreateInstance(addModal).show();
        }
        if (openModal === 'edit' || @json((bool) ($editRecord ?? null))) {
            var editModal = document.getElementById('editRecordModal');
            if (editModal) bootstrap.Modal.getOrCreateInstance(editModal).show();
        }
    })();
</script>
@endpush
