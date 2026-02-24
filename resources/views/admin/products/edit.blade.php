@extends('layouts.app')

@section('title', 'Edit Product: ' . $product->name)

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0 text-start"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Product</h1>
            <small class="opacity-75">{{ $product->name }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-light rounded-pill btn-sm px-3">
                <i class="bi bi-eye me-1"></i>View
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light rounded-pill btn-sm px-3">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
</div>

<div class="container py-5">
    @if($errors->any())
        <div class="alert alert-danger rounded-4 mb-4">
            <strong><i class="bi bi-exclamation-triangle me-1"></i>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- === LEFT COLUMN: Main Info === --}}
            <div class="col-lg-8">

                {{-- Basic Information Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark"><i class="bi bi-info-circle me-2 text-warning"></i>Basic Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control bg-light border-0 py-3 @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}"
                                required oninput="updateSlugPreview(this.value)">
                            <div class="mt-1">
                                <small class="text-muted">Slug: <code id="slug-preview" class="text-primary">/shop/{{ $product->slug }}</code></small>
                            </div>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="form-label small fw-bold text-muted text-uppercase">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id"
                                class="form-select bg-light border-0 py-3 @error('category_id') is-invalid @enderror" required>
                                <option value="">— Select a Category —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="description" class="form-label small fw-bold text-muted text-uppercase mb-0">Description</label>
                                <small class="text-muted"><span id="desc-count">{{ strlen(old('description', $product->description)) }}</span> / 2000 characters</small>
                            </div>
                            <textarea name="description" id="description" rows="6"
                                class="form-control bg-light border-0 py-3 @error('description') is-invalid @enderror"
                                maxlength="2000"
                                oninput="document.getElementById('desc-count').textContent = this.value.length">{{ old('description', $product->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Pricing & Inventory Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark"><i class="bi bi-cash-stack me-2 text-warning"></i>Pricing & Inventory</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="price" class="form-label small fw-bold text-muted text-uppercase">Price (LKR) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 fw-bold text-muted">LKR</span>
                                    <input type="number" name="price" id="price" step="0.01" min="0"
                                        class="form-control bg-light border-0 py-3 @error('price') is-invalid @enderror"
                                        value="{{ old('price', $product->price) }}" required>
                                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="stock" class="form-label small fw-bold text-muted text-uppercase">Stock Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock" min="0"
                                    class="form-control bg-light border-0 py-3 @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', $product->stock) }}" required
                                    oninput="updateStockStatus(this.value)">
                                <div class="mt-1">
                                    <small id="stock-status"></small>
                                </div>
                                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="card border-0 shadow-sm rounded-4 border border-danger-subtle">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-danger"><i class="bi bi-trash me-2"></i>Danger Zone</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold">Delete this product</div>
                                <small class="text-muted">This action is permanent and cannot be undone.</small>
                            </div>
                            <button type="button" class="btn btn-danger rounded-pill px-4"
                                onclick="if(confirm('Are you absolutely sure you want to delete \'{{ addslashes($product->name) }}\'? This cannot be undone.')) { document.getElementById('delete-form').submit(); }">
                                <i class="bi bi-trash me-1"></i>Delete Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === RIGHT COLUMN: Image & Settings === --}}
            <div class="col-lg-4">

                {{-- Image Upload Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark"><i class="bi bi-image me-2 text-warning"></i>Product Image</h5>
                    </div>
                    <div class="card-body p-4">
                        <div id="image-preview-box" class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden position-relative"
                            style="height: 220px; border: 2px dashed #dee2e6; cursor: pointer;" onclick="document.getElementById('image').click()">

                            @if($product->image)
                                <img id="image-preview" src="{{ asset('storage/' . $product->image) }}"
                                    class="img-fluid" style="max-height: 220px; object-fit: cover; width: 100%;" alt="{{ $product->name }}">
                                <div id="preview-placeholder" class="d-none"></div>
                            @else
                                <div id="preview-placeholder" class="text-center text-muted">
                                    <i class="bi bi-cloud-upload fs-1 text-muted mb-2 d-block"></i>
                                    <small class="fw-semibold">Click to upload image</small><br>
                                    <small style="font-size: 0.7rem;">JPG, PNG — Max 2MB</small>
                                </div>
                                <img id="image-preview" src="" class="img-fluid d-none" style="max-height: 220px; object-fit: cover; width: 100%;" alt="Preview">
                            @endif
                        </div>
                        <input type="file" name="image" id="image" class="d-none" accept="image/*" onchange="previewImage(event)">
                        <button type="button" class="btn btn-outline-secondary w-100 rounded-pill btn-sm mb-2" onclick="document.getElementById('image').click()">
                            <i class="bi bi-upload me-1"></i>{{ $product->image ? 'Change Image' : 'Choose Image' }}
                        </button>
                        @if($product->image)
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                <label class="form-check-label small text-danger" for="remove_image">
                                    Remove current image
                                </label>
                            </div>
                        @endif
                        @error('image') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Settings Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark"><i class="bi bi-gear me-2 text-warning"></i>Settings</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div>
                                <div class="fw-semibold">Active / Visible</div>
                                <small class="text-muted">Show this product in the shop</small>
                            </div>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                    style="width: 2.5rem; height: 1.25rem;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-semibold">Featured Product</div>
                                <small class="text-muted">Highlight on the homepage</small>
                            </div>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                    style="width: 2.5rem; height: 1.25rem;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Meta --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
                    <div class="card-body p-4">
                        <div class="small text-muted mb-2">
                            <i class="bi bi-calendar me-1"></i><strong>Created:</strong> {{ $product->created_at->format('d M Y, h:i A') }}
                        </div>
                        <div class="small text-muted mb-2">
                            <i class="bi bi-pencil me-1"></i><strong>Last Updated:</strong> {{ $product->updated_at->format('d M Y, h:i A') }}
                        </div>
                        <div class="small text-muted">
                            <i class="bi bi-tag me-1"></i><strong>Slug:</strong> <code>{{ $product->slug }}</code>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-pill shadow-sm fs-6">
                    <i class="bi bi-check2-circle me-2"></i>Save Changes
                </button>
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-link w-100 text-muted mt-2">Cancel</a>
            </div>
        </div>
    </form>
</div>

{{-- Hidden Delete Form --}}
<form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
// Initialize stock status on load
document.addEventListener('DOMContentLoaded', () => {
    updateStockStatus(document.getElementById('stock').value);
    updateSlugPreview(document.getElementById('name').value);
});

function updateSlugPreview(val) {
    const slug = val.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-').replace(/-+/g, '-');
    document.getElementById('slug-preview').textContent = '/shop/' + (slug || 'your-product-name');
}

function updateStockStatus(val) {
    const el = document.getElementById('stock-status');
    const qty = parseInt(val);
    if (isNaN(qty) || val === '') { el.textContent = ''; return; }
    if (qty === 0)      { el.innerHTML = '<i class="bi bi-x-circle me-1"></i>Out of Stock'; el.className = 'text-danger fw-semibold small'; }
    else if (qty < 5)  { el.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Low Stock Warning'; el.className = 'text-warning fw-semibold small'; }
    else               { el.innerHTML = '<i class="bi bi-check-circle me-1"></i>In Stock'; el.className = 'text-success fw-semibold small'; }
}

function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-placeholder').classList.add('d-none');
        const img = document.getElementById('image-preview');
        img.src = e.target.result;
        img.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
