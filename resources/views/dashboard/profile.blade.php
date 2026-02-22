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

            <div class="card border-0 shadow-sm rounded-4 mt-4 bg-light">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-1">Security Settings</h6>
                        <small class="text-muted">Need to change your password? Visit the auth settings.</small>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4">Account Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
