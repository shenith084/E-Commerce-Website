<div class="row g-4" id="products-grid">
    @forelse($products as $product)
        <div class="col-md-4">
            <div class="card product-card h-100 shadow-sm border-0 position-relative overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                @else
                    <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="bi bi-image text-muted fs-1"></i>
                    </div>
                @endif
                
                @if($product->is_featured)
                    <span class="position-absolute top-0 end-0 bg-warning text-dark px-3 py-1 fw-bold rounded-start-pill opacity-90 mt-2" style="font-size: 0.7rem;">FEATURED</span>
                @endif

                <div class="card-body p-3">
                    <small class="text-warning fw-bold text-uppercase" style="font-size: 0.7rem;">{{ $product->category->name }}</small>
                    <h5 class="card-title fw-semibold mb-1" style="font-size: 1.1rem;">
                        <a href="{{ route('shop.show', $product) }}" class="text-dark text-decoration-none stretched-link">{{ $product->name }}</a>
                    </h5>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <span class="fw-bold fs-5 text-dark">LKR {{ number_format($product->price, 2) }}</span>
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="position-relative" style="z-index: 2;">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm" title="Add to Cart">
                                <i class="bi bi-cart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
            <h5 class="text-muted">No products found matching your criteria.</h5>
            <a href="{{ route('shop.index') }}" class="btn btn-link text-warning">Reset all filters</a>
        </div>
    @endforelse
</div>
