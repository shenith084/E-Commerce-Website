@extends('layouts.app')

@section('title', 'Admin - Categories')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="fw-bold mb-0">Admin: Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-warning btn-sm rounded-pill px-4 fw-bold"><i class="bi bi-plus-lg me-1"></i> New Category</a>
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
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Name</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Slug</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Products</th>
                            <th class="border-0 py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="px-4 py-3 text-muted">{{ $category->id }}</td>
                                <td class="fw-bold">{{ $category->name }}</td>
                                <td class="text-muted small">{{ $category->slug }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $category->products_count }} Products</span></td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
    </div>
</div>
@endsection
