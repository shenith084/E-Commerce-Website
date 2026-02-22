@extends('layouts.app')

@section('title', 'Shop - Browse Products')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <h1 class="fw-bold mb-0">Shop Catalog</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('shop.index') }}" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center {{ !request('category') ? 'text-warning fw-bold' : '' }}">
                            All Products
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('shop.index', ['category' => $category->slug, 'q' => request('q'), 'sort' => request('sort')]) }}"
                               class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center {{ request('category') == $category->slug ? 'text-warning fw-bold' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Sort By</h5>
                    <form action="{{ route('shop.index') }}" method="GET">
                        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                        @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                        <select name="sort" class="form-select border-0 bg-light" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Arrivals</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9" id="shop-container">
            <div id="active-search-indicator" class="mb-4 d-none">
                <div class="alert alert-light border shadow-sm d-flex justify-content-between align-items-center">
                    <span>Searching for: <strong id="search-query-text"></strong></span>
                    <button type="button" class="btn btn-sm btn-link text-muted" id="clear-search-btn"><i class="bi bi-x-circle me-1"></i>Clear</button>
                </div>
            </div>

            <div id="products-wrapper">
                @include('shop._products')
            </div>

            <!-- Pagination Wrapper -->
            <div class="mt-5 d-flex justify-content-center" id="pagination-wrapper">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const productsWrapper = document.getElementById('products-wrapper');
    const paginationWrapper = document.getElementById('pagination-wrapper');
    const indicator = document.getElementById('active-search-indicator');
    const queryText = document.getElementById('search-query-text');
    const clearBtn = document.getElementById('clear-search-btn');
    
    let debounceTimer;

    const performSearch = (query) => {
        const url = new URL(window.location.href);
        if (query) {
            url.searchParams.set('q', query);
            indicator.classList.remove('d-none');
            queryText.innerText = query;
        } else {
            url.searchParams.delete('q');
            indicator.classList.add('d-none');
        }

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            productsWrapper.innerHTML = data.html;
            paginationWrapper.innerHTML = data.pagination;
            window.history.pushState({}, '', url);
        })
        .catch(err => console.error('Search error:', err));
    };

    searchInput.addEventListener('input', function(e) {
        clearTimeout(debounceTimer);
        const query = e.target.value;
        debounceTimer = setTimeout(() => {
            performSearch(query);
        }, 500);
    });

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        performSearch('');
    });
});
</script>
@endpush
    </div>
</div>
@endsection
