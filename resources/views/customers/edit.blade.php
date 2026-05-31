@extends('layouts.app')

@section('bodyClass', 'dashboard-admin')
@section('hideNavbar', true)
@section('showSidebar', true)

@section('content')
<div class="page-card">
    <div class="topbar mb-4">
        <div>
            <h2 class="h4 mb-1">Edit Customer</h2>
            <p class="text-muted mb-0">Update customer details in the system.</p>
        </div>
        <x-profile-chip />
    </div>

    <div class="table-card p-4">
        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Street address">{{ old('address', $customer->address) }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" value="{{ old('city', $customer->city) }}" class="form-control @error('city') is-invalid @enderror" placeholder="City">
                    @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Zip Code</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code', $customer->zip_code) }}" class="form-control @error('zip_code') is-invalid @enderror" placeholder="Zip code">
                    @error('zip_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Contract</label>
                <input type="text" name="contract" value="{{ old('contract', $customer->contract) }}" class="form-control @error('contract') is-invalid @enderror" placeholder="Contract number or reference">
                @error('contract')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-accent">Update Customer</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
