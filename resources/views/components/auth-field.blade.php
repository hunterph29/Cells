@props([
    'name',
    'type' => 'text',
    'label' => null,
    'placeholder' => '',
    'required' => true,
    'value' => null,
])

@php
    $fieldId = $name . '_' . uniqid();
    $inputValue = $value ?? old($name);
@endphp

<div {{ $attributes->merge(['class' => 'mb-3 auth-field']) }}>
    <div class="auth-input-wrap">
        <span class="input-icon" aria-hidden="true">
            {{ $icon }}
        </span>
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $fieldId }}"
            value="{{ $type !== 'password' ? $inputValue : '' }}"
            class="form-control auth-input @error($name) is-invalid @enderror"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            {{ $attributes->except('class') }}
        >
    </div>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
