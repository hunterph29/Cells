@extends('layouts.app')

@section('bodyClass', 'dashboard-admin customers-page')
@section('hideNavbar', true)
@section('showSidebar', true)

@section('content')
<div class="customers-board">
    <div class="customers-toolbar">
        <h1 class="customers-title">
            Customers
            <span class="customers-count">({{ $totalCustomers }})</span>
        </h1>

        <form method="GET" action="{{ route('customers.index') }}" class="customers-toolbar-actions">
            <div class="customers-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.656a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
                </svg>
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search"
                    class="customers-search-input"
                >
            </div>

            <select class="customers-filter" name="filter" disabled aria-label="Filter customers">
                <option>All Customers</option>
            </select>

            @if(auth()->user()->canCreateCustomers())
                <button
                    type="button"
                    class="toolbar-add-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#addCustomerModal"
                    aria-controls="addCustomerModal"
                    title="Add customer"
                    aria-label="Add customer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>
            @endif
        </form>
    </div>

    <div class="table-responsive customers-table-wrap">
        <table class="table customers-table align-middle mb-0">
            <thead>
                <tr>
                    <th>
                        <span class="th-label">Customer Name <span class="sort-icon">&#9660;</span></span>
                    </th>
                    <th>
                        <span class="th-label">Email <span class="sort-icon">&#9660;</span></span>
                    </th>
                    <th>
                        <span class="th-label">Phone <span class="sort-icon">&#9660;</span></span>
                    </th>
                    <th>
                        <span class="th-label">Address <span class="sort-icon">&#9660;</span></span>
                    </th>
                    <th>
                        <span class="th-label">Contract <span class="sort-icon">&#9660;</span></span>
                    </th>
                    <th>
                        <span class="th-label">Last Contact <span class="sort-icon">&#9660;</span></span>
                    </th>
                    <th class="text-end" aria-label="Actions"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div class="customer-name-cell">
                                <x-customer-avatar :name="$customer->name" />
                                <span class="customer-name">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="customer-email">{{ $customer->email }}</td>
                        <td class="customer-phone">{{ $customer->phone ?: '—' }}</td>
                        <td class="customer-address">{{ $customer->formattedAddress() }}</td>
                        <td class="customer-contract">{{ $customer->contract ?: '—' }}</td>
                        <td>
                            <div class="customer-contact-cell">
                                <span class="customer-contact-date">{{ $customer->updated_at->format('d M Y') }}</span>
                                <x-customer-avatar :name="$customer->name" :size="28" class="customer-contact-avatar" />
                            </div>
                        </td>
                        <td class="text-end">
                            <x-kebab-actions
                                :edit-url="auth()->user()->canEditCustomers() ? route('customers.edit', $customer) : null"
                                :delete-url="route('customers.destroy', $customer)"
                                :can-delete="auth()->user()->canDelete()"
                                delete-confirm="Delete this customer?"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            @if(request('search'))
                                No customers match your search.
                            @else
                                No customers found.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $customers->links() }}
</div>

@include('customers.partials.modals')
@endsection

@push('scripts')
<script>
    (function () {
        var input = document.querySelector('.customers-search-input');
        if (!input || !input.form) return;
        var timer;
        input.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(function () { input.form.submit(); }, 400);
        });

        var openModal = @json(session('open_customer_modal') ?? (session('open_add_customer') ? 'add' : null));
        if (openModal === 'add') {
            var addModal = document.getElementById('addCustomerModal');
            if (addModal) bootstrap.Modal.getOrCreateInstance(addModal).show();
        }
        if (openModal === 'edit' || @json((bool) ($editCustomer ?? null))) {
            var editModal = document.getElementById('editCustomerModal');
            if (editModal) bootstrap.Modal.getOrCreateInstance(editModal).show();
        }
    })();
</script>
@endpush
