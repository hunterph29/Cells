@extends('layouts.app')

@section('bodyClass', 'dashboard-admin')
@section('hideNavbar', true)
@section('showSidebar', true)

@php
    $firstName = old('first_name', $user->first_name);
    $lastName = old('last_name', $user->last_name);
    if (!$firstName && !$lastName && $user->name) {
        $nameParts = explode(' ', trim($user->name), 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';
    }
    $birthdateValue = old('birthdate', $user->birthdate?->format('Y-m-d'));
    $countries = [
        'Afghanistan', 'Albania', 'Algeria', 'Argentina', 'Australia', 'Austria', 'Bangladesh',
        'Belgium', 'Brazil', 'Canada', 'Chile', 'China', 'Colombia', 'Denmark', 'Egypt',
        'Finland', 'France', 'Germany', 'Greece', 'India', 'Indonesia', 'Ireland', 'Israel',
        'Italy', 'Japan', 'Kenya', 'Malaysia', 'Mexico', 'Netherlands', 'New Zealand',
        'Nigeria', 'Norway', 'Pakistan', 'Philippines', 'Poland', 'Portugal', 'Russia',
        'Saudi Arabia', 'Singapore', 'South Africa', 'South Korea', 'Spain', 'Sweden',
        'Switzerland', 'Thailand', 'Turkey', 'Ukraine', 'United Arab Emirates',
        'United Kingdom', 'United States', 'Vietnam',
    ];
@endphp

@section('content')
<div class="page-card">
    <div class="topbar mb-4">
        <div>
            <h2 class="h4 mb-1">Profile</h2>
            <p class="text-muted mb-0">Update your account details and avatar.</p>
        </div>
        <x-profile-chip :user="$user" />
    </div>

    <div class="table-card p-4 profile-page-card">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                {{-- Profile picture (saved independently) --}}
                <section class="profile-picture-section mb-5">
                    <h2 class="profile-section-title">Profile Picture</h2>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-picture-form">
                        @csrf
                        @method('PUT')

                        <div class="profile-account-picture">
                            <div class="profile-avatar-wrap mb-3" id="profilePicturePreviewWrap">
                                @if($user->profile_picture)
                                    <img
                                        src="{{ asset($user->profile_picture) }}"
                                        alt="{{ $user->name }}"
                                        class="user-avatar-img"
                                        id="profilePicturePreview"
                                        style="width: 96px; height: 96px;"
                                    >
                                @else
                                    <span
                                        class="user-avatar-fallback"
                                        id="profilePicturePreview"
                                        style="width: 96px; height: 96px; font-size: 36px;"
                                        aria-hidden="true"
                                    >{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                @endif
                            </div>
                            <label class="profile-field-label" for="profile_picture">Choose image</label>
                            <input
                                type="file"
                                name="profile_picture"
                                id="profile_picture"
                                class="form-control profile-field-input @error('profile_picture') is-invalid @enderror"
                                accept="image/*"
                                required
                            >
                            @error('profile_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn profile-btn-dark">Update Profile Picture</button>
                    </form>
                </section>

                {{-- Account section --}}
                <section class="profile-account-section mb-5">
                    <h2 class="profile-section-title">Account</h2>
                    <form method="POST" action="{{ route('profile.account.update') }}" class="profile-account-form">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="profile-field-label">First Name</label>
                                <input type="text" name="first_name" value="{{ $firstName }}" class="form-control profile-field-input @error('first_name') is-invalid @enderror" required>
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Last Name</label>
                                <input type="text" name="last_name" value="{{ $lastName }}" class="form-control profile-field-input @error('last_name') is-invalid @enderror" required>
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control profile-field-input @error('username') is-invalid @enderror" required>
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control profile-field-input @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Gender</label>
                                <select name="gender" class="form-select profile-field-input @error('gender') is-invalid @enderror">
                                    <option value="">Select gender</option>
                                    <option value="male" @selected(old('gender', $user->gender) === 'male')>Male</option>
                                    <option value="female" @selected(old('gender', $user->gender) === 'female')>Female</option>
                                    <option value="other" @selected(old('gender', $user->gender) === 'other')>Other</option>
                                    <option value="prefer_not_to_say" @selected(old('gender', $user->gender) === 'prefer_not_to_say')>Prefer not to say</option>
                                </select>
                                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control profile-field-input @error('phone') is-invalid @enderror" placeholder="+1 234 567 8900">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Birthdate</label>
                                <input type="date" name="birthdate" id="birthdate" value="{{ $birthdateValue }}" class="form-control profile-field-input @error('birthdate') is-invalid @enderror" max="{{ date('Y-m-d') }}">
                                @error('birthdate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <p class="profile-age-display mb-0 mt-2" id="ageDisplay" aria-live="polite"></p>
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Country</label>
                                <select name="country" class="form-select profile-field-input @error('country') is-invalid @enderror">
                                    <option value="">Select country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}" @selected(old('country', $user->country) === $country)>{{ $country }}</option>
                                    @endforeach
                                </select>
                                @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn profile-btn-dark">Save Change</button>
                        </div>
                    </form>
                </section>

                {{-- Password section --}}
                <section class="profile-password-section">
                    <h2 class="profile-section-title">Your Password</h2>
                    <form method="POST" action="{{ route('profile.password.update') }}" class="profile-password-form">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="profile-field-label">New Password</label>
                                <div class="profile-password-wrap">
                                    <input type="password" name="password" id="newPassword" class="form-control profile-field-input profile-password-input @error('password') is-invalid @enderror" required autocomplete="new-password">
                                    <button type="button" class="profile-password-toggle" data-target="newPassword" aria-label="Toggle password visibility">
                                        <span class="profile-eye-icon">&#128065;</span>
                                    </button>
                                </div>
                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field-label">Repeat New Password</label>
                                <div class="profile-password-wrap">
                                    <input type="password" name="password_confirmation" id="repeatPassword" class="form-control profile-field-input profile-password-input" required autocomplete="new-password">
                                    <button type="button" class="profile-password-toggle" data-target="repeatPassword" aria-label="Toggle password visibility">
                                        <span class="profile-eye-icon">&#128065;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn profile-btn-dark">Update Password</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var birthdateInput = document.getElementById('birthdate');
    var ageDisplay = document.getElementById('ageDisplay');

    function calculateAge(dateString) {
        if (!dateString) {
            return null;
        }
        var birth = new Date(dateString + 'T00:00:00');
        if (isNaN(birth.getTime())) {
            return null;
        }
        var today = new Date();
        var age = today.getFullYear() - birth.getFullYear();
        var monthDiff = today.getMonth() - birth.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        return age >= 0 ? age : null;
    }

    function updateAge() {
        if (!birthdateInput || !ageDisplay) {
            return;
        }
        var age = calculateAge(birthdateInput.value);
        ageDisplay.textContent = age !== null ? 'Age: ' + age + ' years old' : '';
    }

    if (birthdateInput) {
        birthdateInput.addEventListener('change', updateAge);
        birthdateInput.addEventListener('input', updateAge);
        updateAge();
    }

    var pictureInput = document.getElementById('profile_picture');
    var picturePreviewWrap = document.getElementById('profilePicturePreviewWrap');
    if (pictureInput && picturePreviewWrap) {
        pictureInput.addEventListener('change', function () {
            var file = pictureInput.files && pictureInput.files[0];
            if (!file || !file.type.startsWith('image/')) {
                return;
            }
            var preview = document.getElementById('profilePicturePreview');
            var url = URL.createObjectURL(file);
            if (preview && preview.tagName === 'IMG') {
                preview.src = url;
            } else {
                var img = document.createElement('img');
                img.id = 'profilePicturePreview';
                img.src = url;
                img.alt = 'Profile picture preview';
                img.className = 'user-avatar-img';
                img.style.width = '96px';
                img.style.height = '96px';
                picturePreviewWrap.innerHTML = '';
                picturePreviewWrap.appendChild(img);
            }
        });
    }

    document.querySelectorAll('.profile-password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.getAttribute('data-target'));
            if (!input) {
                return;
            }
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.classList.toggle('is-visible', isHidden);
        });
    });
})();
</script>
@endpush
@endsection
