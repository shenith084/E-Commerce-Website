@extends('layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="fw-bold mb-0 text-start">{{ isset($product) ? 'Edit Product: ' . $product->name : 'Create New Product' }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light rounded-pill btn-sm px-3">Back to List</a>
    </div>
</div>

<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 p-md-5 text-start">
            <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                <div class="row g-4">
                    <!-- Basic Info -->
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control bg-light border-0 py-2" value="{{ old('name', $product->name ?? '') }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="form-label small fw-bold text-muted text-uppercase">Category</label>
                            <select name="category_id" id="category_id" class="form-select bg-light border-0 py-2" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label small fw-bold text-muted text-uppercase">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control bg-light border-0 py-2">{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- Side Info -->
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="price" class="form-label small fw-bold text-muted text-uppercase">Price (LKR)</label>
                            <input type="number" name="price" id="price" step="0.01" class="form-control bg-light border-0 py-2" value="{{ old('price', $product->price ?? '') }}" required>
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="stock" class="form-label small fw-bold text-muted text-uppercase">Stock Quantity</label>
                            <input type="number" name="stock" id="stock" class="form-control bg-light border-0 py-2" value="{{ old('stock', $product->stock ?? '') }}" required>
                            @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label small fw-bold text-muted text-uppercase">Product Image</label>
                            @if(isset($product) && $product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" style="height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" class="form-control bg-light border-0 py-2">
                            <small class="text-muted">Max size: 2MB. Format: JPG, PNG.</small>
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="card bg-light border-0 p-3 mb-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_featured">Featured Product</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Active/Visible</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 pt-4 border-top">
                        <button type="submit" class="btn btn-warning px-5 py-3 fw-bold rounded-pill shadow-sm">
                            {{ isset($product) ? 'Update Product' : 'Save Product' }} <i class="bi bi-check2-circle ms-1"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
