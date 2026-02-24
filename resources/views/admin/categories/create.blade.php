@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-warning"></i>Create Category</h1>
            <small class="opacity-75">Add a new product category to the store.</small>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light rounded-pill btn-sm px-4">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            @if($errors->any())
                <div class="alert alert-danger rounded-4 mb-4">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-tag me-2 text-warning"></i>Category Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                class="form-control bg-light border-0 py-3 @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="e.g. Electronics, Clothing, Books..."
                                required oninput="updateSlug(this.value)">
                            <div class="mt-1">
                                <small class="text-muted">Slug: <code id="slug-preview" class="text-primary">/shop?category=your-category</code></small>
                            </div>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <label for="description" class="form-label small fw-bold text-muted text-uppercase mb-0">
                                    Description <span class="text-muted fw-normal">(Optional)</span>
                                </label>
                                <small class="text-muted"><span id="desc-count">0</span>/500</small>
                            </div>
                            <textarea name="description" id="description" rows="4"
                                class="form-control bg-light border-0 py-3"
                                placeholder="Briefly describe what this category contains..."
                                maxlength="500"
                                oninput="document.getElementById('desc-count').textContent = this.value.length">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning py-3 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i>Create Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-link text-muted">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateSlug(val) {
    const slug = val.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-').replace(/-+/g, '-');
    document.getElementById('slug-preview').textContent = '/shop?category=' + (slug || 'your-category');
}
</script>
@endpush
@endsection
