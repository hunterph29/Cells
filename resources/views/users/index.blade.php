@extends('layouts.app')

@section('bodyClass', 'dashboard-admin')
@section('hideNavbar', true)
@section('showSidebar', true)

@section('content')
<div class="page-card">
    <div class="topbar mb-4">
        <div>
            <h2 class="h4 mb-1">Users</h2>
            <p class="text-muted mb-0">Manage registered users in the application.</p>
        </div>
        <x-profile-chip />
    </div>

    <div class="table-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="h6 mb-0">User list</h3>
            @if(auth()->user()->canManageUsers())
                <button
                    type="button"
                    class="toolbar-add-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#addUserModal"
                    aria-controls="addUserModal"
                    title="{{ auth()->user()->isAdmin() ? 'Add staff' : 'Add user' }}"
                    aria-label="{{ auth()->user()->isAdmin() ? 'Add staff' : 'Add user' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-pill role-pill-{{ $user->role }}">{{ $user->roleLabel() }}</span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <x-kebab-actions
                                    :edit-url="auth()->user()->canEditUser($user) ? route('users.index', ['edit' => $user->id]) : null"
                                    :delete-url="route('users.destroy', $user)"
                                    :can-delete="auth()->user()->canDeleteUser($user)"
                                    delete-confirm="Delete this user?"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>

@include('users.partials.modals')
@endsection

@push('scripts')
<script>
    (function () {
        var openModal = @json(session('open_user_modal'));
        if (openModal === 'add') {
            var addModal = document.getElementById('addUserModal');
            if (addModal) bootstrap.Modal.getOrCreateInstance(addModal).show();
        }
        if (openModal === 'edit' || @json((bool) ($editUser ?? null))) {
            var editModal = document.getElementById('editUserModal');
            if (editModal) {
                bootstrap.Modal.getOrCreateInstance(editModal).show();
                if (window.history.replaceState && window.location.search.indexOf('edit=') !== -1) {
                    window.history.replaceState({}, '', window.location.pathname);
                }
            }
        }
    })();
</script>
@endpush
