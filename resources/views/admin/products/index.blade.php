@extends('layouts.app')

@section('title', 'Admin: Products')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-warning"></i>Products</h1>
            <small class="opacity-75">{{ $products->total() }} product(s) found</small>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-warning fw-bold rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i>Add Product
        </a>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Search</label>
                    <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Search product name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Category</label>
                    <select name="category" class="form-select border-0 bg-light" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Status</label>
                    <select name="status" class="form-select border-0 bg-light" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="active"        {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="inactive"      {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                        <option value="featured"      {{ request('status') === 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="low_stock"     {{ request('status') === 'low_stock' ? 'selected' : '' }}>Low Stock (&lt;5)</option>
                        <option value="out_of_stock"  {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill flex-fill"><i class="bi bi-search me-1"></i>Search</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-3" title="Reset"><i class="bi bi-x-lg"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="border-0 px-3 py-3" style="width: 50px;">Img</th>
                        <th class="border-0 py-3">Product</th>
                        <th class="border-0 py-3 d-none d-md-table-cell">Category</th>
                        <th class="border-0 py-3">Price</th>
                        <th class="border-0 py-3 text-center">Stock</th>
                        <th class="border-0 py-3 text-center d-none d-md-table-cell">Status</th>
                        <th class="border-0 py-3 text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="px-3 py-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="rounded-3" style="width: 36px; height: 36px; object-fit: cover;" alt="{{ $product->name }}">
                                @else
                                    <div class="rounded-3 bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-image text-muted small"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="fw-bold text-dark small">{{ $product->name }}</div>
                                <small class="text-muted d-none d-lg-inline">#{{ $product->id }} &bull; {{ Str::limit($product->description, 30) }}</small>
                                <div class="d-md-none small text-muted">{{ $product->category->name }}</div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.65rem;">{{ $product->category->name }}</span>
                            </td>
                            <td class="fw-bold small">LKR {{ number_format($product->price, 0) }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-2" style="font-size: 0.6rem;">{{ $product->stock }}</span>
                            </td>
                            <td class="text-center d-none d-md-table-cell">
                                @if($product->is_active)
                                    <span class="badge bg-success rounded-pill px-2" style="font-size: 0.6rem;">Active</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-2" style="font-size: 0.6rem;">Draft</span>
                                @endif
                            </td>
                            <td class="text-end px-3 py-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-dark btn-sm rounded-start-pill p-1 px-2" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-dark btn-sm p-1 px-2" title="Edit"><i class="bi bi-pencil"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-box-seam fs-1 text-muted d-block mb-3"></i>
                                <h6 class="text-muted">No products found.</h6>
                                @if(request()->anyFilled(['search','category','status']))
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill btn-sm mt-2">Clear Filters</a>
                                @else
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-warning rounded-pill btn-sm mt-2">Add your first product</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="card-footer bg-white border-top-0 p-4 d-flex justify-content-between align-items-center">
                <span class="text-muted small">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}</span>
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
