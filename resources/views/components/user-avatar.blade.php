@props([
    'user' => null,
    'size' => 40,
])

@php
    $user = $user ?? auth()->user();
    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
@endphp

@if($user?->profile_picture)
    <img
        src="{{ asset($user->profile_picture) }}"
        alt="{{ $user->name }}"
        class="user-avatar-img {{ $attributes->get('class') }}"
        style="width: {{ $size }}px; height: {{ $size }}px;"
        {{ $attributes->except('class') }}
    >
@else
    <span
        class="user-avatar-fallback {{ $attributes->get('class') }}"
        style="width: {{ $size }}px; height: {{ $size }}px; font-size: {{ max(12, round($size * 0.38)) }}px;"
        {{ $attributes->except('class') }}
        aria-hidden="true"
    >{{ $initial }}</span>
@endif
