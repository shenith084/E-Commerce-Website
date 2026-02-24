@extends('layouts.app')

@section('title', 'Edit Category: ' . $category->name)

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Category</h1>
            <small class="opacity-75">{{ $category->name }}</small>
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

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-tag me-2 text-warning"></i>Category Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                class="form-control bg-light border-0 py-3 @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}"
                                required oninput="updateSlug(this.value)">
                            <div class="mt-1">
                                <small class="text-muted">Slug preview: <code id="slug-preview" class="text-primary">/shop?category={{ $category->slug }}</code></small>
                            </div>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <label for="description" class="form-label small fw-bold text-muted text-uppercase mb-0">Description (Optional)</label>
                                <small class="text-muted"><span id="desc-count">{{ strlen(old('description', $category->description)) }}</span>/500</small>
                            </div>
                            <textarea name="description" id="description" rows="4"
                                class="form-control bg-light border-0 py-3"
                                maxlength="500"
                                oninput="document.getElementById('desc-count').textContent = this.value.length">{{ old('description', $category->description) }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning py-3 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i>Save Changes
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-link text-muted">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Category Stats --}}
            <div class="card border-0 shadow-sm rounded-4 bg-light mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted fw-bold">Products in this category</small>
                        <span class="badge bg-dark rounded-pill">{{ $category->products_count }}</span>
                    </div>
                    <div class="small text-muted">
                        <i class="bi bi-calendar me-1"></i>Created {{ $category->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="card border-0 shadow-sm rounded-4 border border-danger-subtle">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-danger mb-1"><i class="bi bi-trash me-1"></i>Delete Category</h6>
                    <p class="small text-muted mb-3">Products in this category will lose their category link. This cannot be undone.</p>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                          onsubmit="return confirm('Delete \'{{ addslashes($category->name) }}\'? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            <i class="bi bi-trash me-1"></i>Delete Category
                        </button>
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
