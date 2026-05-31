<x-classroom-modal
    id="addRecordModal"
    title="Add Record"
    :action="route('records.store')"
    submit-label="Post"
>
    @include('records.partials.form-fields', ['prefix' => 'add_'])
</x-classroom-modal>

@if($editRecord ?? null)
    <x-classroom-modal
        id="editRecordModal"
        title="Edit Record"
        :action="route('records.update', $editRecord)"
        method="PUT"
        submit-label="Save"
    >
        @include('records.partials.form-fields', ['record' => $editRecord, 'prefix' => 'edit_'])
    </x-classroom-modal>
@endif
