@extends('layouts.app')

@section('title', 'Admin - Product: ' . $product->name)

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0">{{ $product->name }}</h1>
            <p class="mb-0 opacity-75">Category: {{ $product->category->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm rounded-pill px-4 fw-bold"><i class="bi bi-pencil me-1"></i>Edit</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Back to List</a>
        </div>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success rounded-4 mb-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        {{-- Product Details --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Product Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Product ID</small>
                            <span class="fw-bold">#{{ $product->id }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Slug</small>
                            <code class="text-dark">{{ $product->slug }}</code>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Price</small>
                            <span class="fw-bold fs-5 text-warning">LKR {{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Stock</small>
                            <span class="fw-bold fs-5 {{ $product->stock < 5 ? 'text-danger' : 'text-dark' }}">{{ $product->stock }} units</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Status</small>
                            @if($product->is_active)
                                <span class="badge bg-success-subtle text-success px-3 py-2">Active</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-2">Inactive</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Featured</small>
                            @if($product->is_featured)
                                <span class="badge bg-warning text-dark px-3 py-2">Featured</span>
                            @else
                                <span class="text-muted">Not Featured</span>
                            @endif
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block mb-1">Description</small>
                            <p class="mb-0">{{ $product->description ?? 'No description provided.' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Created At</small>
                            <span>{{ $product->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <span>{{ $product->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Customer Reviews --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Customer Reviews <span class="badge bg-secondary ms-2">{{ $product->reviews->count() }}</span></h5>
                    @forelse($product->reviews as $review)
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="fw-bold">{{ $review->user->name }}</span>
                                    <small class="text-muted ms-2">{{ $review->created_at->format('d M Y') }}</small>
                                </div>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="mb-0 mt-2 text-muted small">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">No reviews yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar: Image & Actions --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-3 mb-3" style="max-height: 250px; object-fit: cover; width: 100%;">
                    @else
                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <small class="text-muted">No image uploaded</small>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning rounded-pill fw-bold">
                            <i class="bi bi-pencil me-2"></i>Edit Product
                        </a>
                        <a href="{{ route('shop.show', $product) }}" target="_blank" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-eye me-2"></i>View in Shop
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">
                                <i class="bi bi-trash me-2"></i>Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
