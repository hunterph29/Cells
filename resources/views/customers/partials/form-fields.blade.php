@props(['customer' => null, 'prefix' => ''])

<div class="mb-3">
    <input
        type="text"
        name="name"
        id="{{ $prefix }}customer_name"
        value="{{ old('name', $customer?->name) }}"
        class="form-control classroom-input @error('name') is-invalid @enderror"
        placeholder="Customer name"
        required
    >
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <input
        type="email"
        name="email"
        id="{{ $prefix }}customer_email"
        value="{{ old('email', $customer?->email) }}"
        class="form-control classroom-input @error('email') is-invalid @enderror"
        placeholder="Email address"
        required
    >
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <input
        type="text"
        name="phone"
        id="{{ $prefix }}customer_phone"
        value="{{ old('phone', $customer?->phone) }}"
        class="form-control classroom-input @error('phone') is-invalid @enderror"
        placeholder="Phone number"
    >
    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <textarea
        name="address"
        id="{{ $prefix }}customer_address"
        class="form-control classroom-input @error('address') is-invalid @enderror"
        rows="2"
        placeholder="Street address"
    >{{ old('address', $customer?->address) }}</textarea>
    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <input
            type="text"
            name="city"
            id="{{ $prefix }}customer_city"
            value="{{ old('city', $customer?->city) }}"
            class="form-control classroom-input @error('city') is-invalid @enderror"
            placeholder="City"
        >
        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-sm-6">
        <input
            type="text"
            name="zip_code"
            id="{{ $prefix }}customer_zip_code"
            value="{{ old('zip_code', $customer?->zip_code) }}"
            class="form-control classroom-input @error('zip_code') is-invalid @enderror"
            placeholder="Zip code"
        >
        @error('zip_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-0">
    <input
        type="text"
        name="contract"
        id="{{ $prefix }}customer_contract"
        value="{{ old('contract', $customer?->contract) }}"
        class="form-control classroom-input @error('contract') is-invalid @enderror"
        placeholder="Contract"
    >
    @error('contract')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
