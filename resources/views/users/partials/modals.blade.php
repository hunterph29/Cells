@php
    use App\Models\User;

    $addTitle = auth()->user()->isAdmin() ? 'Add Staff' : 'Add User';
@endphp

<x-classroom-modal
    id="addUserModal"
    :title="$addTitle"
    :action="route('users.store')"
    submit-label="Save"
    dialog-class="classroom-modal-dialog--compact"
>
    @include('users.partials.form-fields', ['prefix' => 'add_', 'mode' => 'add'])
</x-classroom-modal>

@if($editUser ?? null)
    @php
        $editTitle = match ($editUser->role) {
            User::ROLE_SUPER_ADMIN => 'Edit Super Admin',
            User::ROLE_ADMIN => 'Edit Admin',
            default => 'Edit Staff',
        };
    @endphp
    <x-classroom-modal
        id="editUserModal"
        :title="$editTitle"
        :action="route('users.update', $editUser)"
        method="PUT"
        submit-label="Save"
        dialog-class="classroom-modal-dialog--compact"
    >
        @include('users.partials.form-fields-edit', ['user' => $editUser, 'prefix' => 'edit_'])
    </x-classroom-modal>
@endif
