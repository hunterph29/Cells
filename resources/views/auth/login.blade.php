@extends('layouts.app')

@section('bodyClass','auth-page')

@section('content')
<div class="auth-card p-5">
    <div class="text-center mb-4">
        <div class="auth-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><circle cx="32" cy="32" r="30" fill="#f8f0f6"/><path d="M32 14c6.627 0 12 5.373 12 12s-5.373 12-12 12-12-5.373-12-12 5.373-12 12-12zm0 30c-11.046 0-20 4.477-20 10v4h40v-4c0-5.523-8.954-10-20-10z" fill="#d63384"/></svg>
        </div>
        <h2 class="mb-1">Sign In</h2>
        <p class="text-muted">Welcome back! Please login to continue.</p>
    </div>
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3 position-relative">
            <span class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/><path d="M14 8s-1 0-1 1-1 4-6 4-6-3-6-4 1-1 1-1h12z"/></svg>
            </span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control auth-input @error('email') is-invalid @enderror" placeholder="Email" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3 position-relative">
            <span class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a3 3 0 0 1 3 3v2h1.5A1.5 1.5 0 0 1 14 7.5v6A1.5 1.5 0 0 1 12.5 15h-9A1.5 1.5 0 0 1 2 13.5v-6A1.5 1.5 0 0 1 3.5 6H5V4a3 3 0 0 1 3-3zm-2 5h4V4a2 2 0 1 0-4 0v2z"/></svg>
            </span>
            <input type="password" name="password" class="form-control auth-input @error('password') is-invalid @enderror" placeholder="Password" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4 text-muted small">
            <div><input type="checkbox" id="remember" class="form-check-input me-2"><label for="remember" class="form-check-label">Remember me</label></div>
            <a href="#">Forgot password?</a>
        </div>
        <button type="submit" class="btn btn-danger w-100 rounded-pill py-2">Login</button>
        <div class="text-center auth-footer mt-4">
            <span>Don't have an account? </span><a href="{{ route('register') }}">Register now</a>
        </div>
    </form>
</div>
@endsection
