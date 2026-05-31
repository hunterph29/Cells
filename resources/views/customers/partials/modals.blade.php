<x-classroom-modal
    id="addCustomerModal"
    title="Add Customer"
    :action="route('customers.store')"
    submit-label="Save"
>
    @include('customers.partials.form-fields', ['prefix' => 'add_'])
</x-classroom-modal>

@if($editCustomer ?? null)
    <x-classroom-modal
        id="editCustomerModal"
        title="Edit Customer"
        :action="route('customers.update', $editCustomer)"
        method="PUT"
        submit-label="Save"
    >
        @include('customers.partials.form-fields', ['customer' => $editCustomer, 'prefix' => 'edit_'])
    </x-classroom-modal>
@endif
