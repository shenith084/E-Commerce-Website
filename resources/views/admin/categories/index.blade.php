@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-warning"></i>Categories</h1>
            <small class="opacity-75">{{ $categories->total() }} categor{{ $categories->total() === 1 ? 'y' : 'ies' }} total</small>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-warning fw-bold rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i>Add Category
        </a>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="border-0 px-3 py-3">Category</th>
                        <th class="border-0 py-3 d-none d-lg-table-cell">Slug</th>
                        <th class="border-0 py-3 d-none d-md-table-cell">Description</th>
                        <th class="border-0 py-3 text-center">Items</th>
                        <th class="border-0 py-3 text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="px-3 py-3 fw-bold text-dark small">
                                <i class="bi bi-tag-fill text-warning me-1" style="font-size: 0.7rem;"></i>
                                {{ $category->name }}
                            </td>
                            <td class="d-none d-lg-table-cell"><code class="text-muted small">{{ $category->slug }}</code></td>
                            <td class="d-none d-md-table-cell text-muted small">{{ Str::limit($category->description, 40) ?: '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.index', ['category' => $category->id]) }}"
                                   class="badge bg-light text-dark border text-decoration-none px-2 py-1" style="font-size: 0.65rem;">
                                    {{ $category->products_count }}
                                </a>
                            </td>
                            <td class="text-end px-3 py-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-outline-dark btn-sm rounded-pill p-1 px-2" style="font-size: 0.7rem;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-tags fs-1 text-muted d-block mb-3"></i>
                                <h6 class="text-muted">No categories yet.</h6>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-warning rounded-pill btn-sm mt-2">Add your first category</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="card-footer bg-white border-top-0 p-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
