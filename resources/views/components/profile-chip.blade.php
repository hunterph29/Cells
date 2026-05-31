@props(['user' => null])

@php
    $user = $user ?? auth()->user();
@endphp

<div {{ $attributes->merge(['class' => 'profile-chip']) }}>
    <x-user-avatar :user="$user" :size="40" />
    <div class="profile-chip-text">
        <div class="fw-semibold profile-chip-name">{{ $user->name }}</div>
        <div class="small text-muted profile-chip-email">{{ $user->email }}</div>
    </div>
</div>
