@props(['name', 'size' => 40])

@php
    $parts = preg_split('/\s+/', trim($name));
    $initials = strtoupper(
        count($parts) >= 2
            ? substr($parts[0], 0, 1) . substr($parts[1], 0, 1)
            : substr($name, 0, 2)
    );
    $colors = ['#ec4899', '#f59e0b', '#22c55e', '#3b82f6', '#8b5cf6', '#14b8a6', '#f97316'];
    $color = $colors[crc32($name) % count($colors)];
@endphp

<span
    class="customer-avatar"
    style="--avatar-size: {{ $size }}px; background: {{ $color }};"
    {{ $attributes }}
>{{ $initials }}</span>
