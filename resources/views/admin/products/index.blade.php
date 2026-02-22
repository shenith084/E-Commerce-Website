@extends('layouts.app')

@section('title', 'Admin - Products')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="fw-bold mb-0">Admin: Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-warning btn-sm rounded-pill px-4 fw-bold"><i class="bi bi-plus-lg me-1"></i> New Product</a>
    </div>
</div>

<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3 small text-uppercase fw-bold text-muted">ID</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Product</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Category</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Price</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Stock</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Status</th>
                            <th class="border-0 py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="px-4 py-3 text-muted">{{ $product->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded border overflow-hidden me-3" style="width: 40px; height: 40px; flex-shrink: 0;">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                    <i class="bi bi-image text-muted small"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            @if($product->is_featured)<span class="badge bg-warning text-dark px-2" style="font-size: 0.6rem;">FEATURED</span>@endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td class="fw-bold">LKR {{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span class="fw-semibold {{ $product->stock < 5 ? 'text-danger' : 'text-dark' }}">{{ $product->stock }}</span>
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success-subtle text-success px-2 py-1">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger btn-sm p-0"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 p-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
