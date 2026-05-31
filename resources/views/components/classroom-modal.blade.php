@props([
    'id',
    'title',
    'action',
    'method' => 'POST',
    'submitLabel' => 'Save',
    'dialogClass' => '',
])

<div class="modal fade classroom-modal" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered classroom-modal-dialog {{ $dialogClass }}">
        <div class="modal-content">
            <form method="POST" action="{{ $action }}" id="{{ $id }}Form">
                @csrf
                @if($method !== 'POST')
                    @method($method)
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                </div>
                <div class="modal-body">
                    <div class="classroom-modal-fields">
                        {{ $slot }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="classroom-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="classroom-modal-submit">{{ $submitLabel }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
