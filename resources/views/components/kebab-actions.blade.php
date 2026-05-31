@props([
    'editUrl' => null,
    'deleteUrl' => null,
    'deleteConfirm' => 'Are you sure you want to delete this item?',
    'canDelete' => null,
])

@php
    $showDelete = $canDelete ?? auth()->user()?->canDelete() ?? false;
    $showEdit = filled($editUrl);
@endphp

@if($showEdit || ($showDelete && $deleteUrl))
    <div class="dropdown row-actions-dropdown">
        <button
            type="button"
            class="btn btn-kebab"
            data-bs-toggle="dropdown"
            data-bs-popper-config='{"strategy":"fixed","placement":"bottom-end"}'
            aria-expanded="false"
            aria-label="Row actions"
        >
            <svg class="kebab-icon" width="4" height="16" viewBox="0 0 4 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="2" cy="2" r="2" fill="currentColor"/>
                <circle cx="2" cy="8" r="2" fill="currentColor"/>
                <circle cx="2" cy="14" r="2" fill="currentColor"/>
            </svg>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            @if($showEdit)
                <li>
                    <a class="dropdown-item" href="{{ $editUrl }}">Edit</a>
                </li>
            @endif
            @if($showDelete && $deleteUrl)
                <li>
                    <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm(@json($deleteConfirm));">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
@else
    <span class="text-muted">—</span>
@endif
