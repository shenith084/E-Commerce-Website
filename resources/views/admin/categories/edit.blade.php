@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="fw-bold mb-0">Edit Category: {{ $category->name }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light rounded-pill btn-sm px-3">Back to List</a>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4 text-start">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control bg-light border-0 py-3" value="{{ old('name', $category->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-4 text-start">
                            <label for="description" class="form-label small fw-bold text-muted text-uppercase">Description (Optional)</label>
                            <textarea name="description" id="description" rows="4" class="form-control bg-light border-0 py-3">{{ old('description', $category->description) }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-pill shadow-sm">
                                Update Category <i class="bi bi-check2-circle ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
