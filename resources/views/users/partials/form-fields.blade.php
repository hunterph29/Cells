@props(['user' => null, 'prefix' => '', 'mode' => 'add'])

<div class="mb-3">
    <input
        type="text"
        name="name"
        id="{{ $prefix }}user_name"
        value="{{ old('name', $user?->name) }}"
        class="form-control classroom-input @error('name') is-invalid @enderror"
        placeholder="Full name"
        required
    >
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <input
        type="email"
        name="email"
        id="{{ $prefix }}user_email"
        value="{{ old('email', $user?->email) }}"
        class="form-control classroom-input @error('email') is-invalid @enderror"
        placeholder="Email address"
        required
    >
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <input
        type="password"
        name="password"
        id="{{ $prefix }}user_password"
        class="form-control classroom-input @error('password') is-invalid @enderror"
        placeholder="{{ $mode === 'edit' ? 'New password (optional)' : 'Password' }}"
        {{ $mode === 'add' ? 'required' : '' }}
    >
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <input
        type="password"
        name="password_confirmation"
        id="{{ $prefix }}user_password_confirmation"
        class="form-control classroom-input"
        placeholder="Confirm password"
        {{ $mode === 'add' ? 'required' : '' }}
    >
</div>
@php
    $assignableRoles = \App\Models\User::assignableRolesFor(auth()->user(), $user);
@endphp
@if(count($assignableRoles) > 0)
    <div class="mb-0">
        <select
            name="role"
            id="{{ $prefix }}user_role"
            class="form-select classroom-input @error('role') is-invalid @enderror"
            required
        >
            @foreach($assignableRoles as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user?->role ?? \App\Models\User::ROLE_STAFF) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
@endif
