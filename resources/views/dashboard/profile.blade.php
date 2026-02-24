@extends('layouts.app')

@section('title', 'Manage Profile')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container text-center">
        <h1 class="fw-bold mb-0">My Profile</h1>
        <p class="mb-0 opacity-75">Update your personal information and contact details</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name" class="form-label small fw-bold text-muted">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control bg-light border-0 py-3" value="{{ old('name', $user->name) }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label small fw-bold text-muted">Email Address (Read-only)</label>
                                <input type="email" id="email" class="form-control bg-light-subtle border-0 py-3" value="{{ $user->email }}" disabled>
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label small fw-bold text-muted">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control bg-light border-0 py-3" value="{{ old('phone', $user->phone) }}" placeholder="07XXXXXXXX">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label small fw-bold text-muted">Default Shipping Address</label>
                                <textarea name="address" id="address" rows="4" class="form-control bg-light border-0 py-3" placeholder="Enter your full address here...">{{ old('address', $user->address) }}</textarea>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-pill shadow-sm">Save Changes <i class="bi bi-check2-circle ms-1"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Password Change Section --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-1"><i class="bi bi-shield-lock me-2 text-warning"></i>Change Password</h5>
                    <p class="text-muted small mb-4">Leave these fields empty if you don't want to change your password.</p>
                    <form action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        {{-- Hidden fields to keep name/phone/address unchanged --}}
                        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                        <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
                        <input type="hidden" name="address" value="{{ auth()->user()->address }}">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label small fw-bold text-muted">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control bg-light border-0 py-3 @error('current_password') is-invalid @enderror" placeholder="Enter current password">
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="new_password" class="form-label small fw-bold text-muted">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control bg-light border-0 py-3" placeholder="Min. 8 characters">
                                @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label small fw-bold text-muted">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control bg-light border-0 py-3" placeholder="Repeat new password">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold">Update Password <i class="bi bi-lock ms-1"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
