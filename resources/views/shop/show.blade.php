@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Shop</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden rounded-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                @else
                    <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="min-height: 400px;">
                        <i class="bi bi-image text-muted fs-1"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">{{ $product->category->name }}</span>
                    @auth
                        @php $inWishlist = auth()->user()->wishlists()->where('product_id', $product->id)->exists(); @endphp
                        <form action="{{ route('dashboard.wishlist.toggle', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle p-2 border-0" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }} fs-5"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm rounded-circle p-2 border-0" title="Login to save to wishlist">
                            <i class="bi bi-heart fs-5"></i>
                        </a>
                    @endauth
                </div>

                <h1 class="display-6 fw-bold mb-3 text-dark">{{ $product->name }}</h1>

                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning me-2">
                        @php $avgRating = $product->averageRating() ?? 0; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $avgRating ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                    <span class="text-muted small">({{ $product->reviews->count() }} Reviews)</span>
                    <span class="mx-2 text-muted">|</span>
                    <span class="badge {{ $product->stock > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>

                <h2 class="fw-bold text-dark mb-4">LKR {{ number_format($product->price, 2) }}</h2>

                <div class="mb-4">
                    <h6 class="fw-bold text-muted text-uppercase small">Description</h6>
                    <p class="text-muted lead fs-6">{{ $product->description }}</p>
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-5">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <div class="input-group" style="width: 140px;">
                                <button class="btn btn-outline-secondary border-end-0" type="button" onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                <input type="number" name="quantity" class="form-control text-center border-start-0 border-end-0 shadow-none" value="1" min="1" max="{{ $product->stock }}">
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-warning btn-lg w-100 py-3 fw-bold {{ $product->stock <= 0 ? 'disabled' : '' }}">
                                <i class="bi bi-cart-plus me-2"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>

                <div class="card bg-light border-0 p-3 mb-4 rounded-4 text-start">
                    <div class="row text-center g-3">
                        <div class="col-4">
                            <i class="bi bi-truck fs-4 text-warning d-block mb-1"></i>
                            <span class="small d-block fw-semibold">Fast Delivery</span>
                        </div>
                        <div class="col-4 border-start">
                            <i class="bi bi-shield-check fs-4 text-warning d-block mb-1"></i>
                            <span class="small d-block fw-semibold">Secure Payment</span>
                        </div>
                        <div class="col-4 border-start">
                            <i class="bi bi-arrow-repeat fs-4 text-warning d-block mb-1"></i>
                            <span class="small d-block fw-semibold">Easy Returns</span>
                        </div>
                    </div>
                </div>

                <div class="text-start">
                    <h6 class="fw-bold text-muted text-uppercase small mb-3">Share this product</h6>
                    <div class="d-flex gap-2">
                        @php $shareUrl = urlencode(url()->current()); $shareText = urlencode("Check out this amazing product: " . $product->name); @endphp
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="btn btn-outline-primary rounded-circle p-2 border-1" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" class="btn btn-outline-info rounded-circle p-2 border-1" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="btn btn-outline-success rounded-circle p-2 border-1" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => alert('Link copied!'))" class="btn btn-outline-secondary rounded-circle p-2 border-1" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="Copy Link">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-start">
                    <h4 class="fw-bold mb-4">Customer Reviews</h4>
                    @forelse($product->reviews as $review)
                        <div class="mb-4 pb-4 border-bottom last-child-border-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $review->user->name }}</h6>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted mb-0">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-chat-left-dots fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4 h-100">
                <h5 class="fw-bold mb-3">Rate this Product</h5>
                <p class="small opacity-75 mb-4">You can submit a review after purchasing this item from your dashboard.</p>
                <a href="{{ route('dashboard.orders') }}" class="btn btn-warning rounded-pill fw-bold w-100">Go to My Orders</a>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($related->isNotEmpty())
        <div class="mt-5 pt-5">
            <h3 class="fw-bold mb-4">Related Products</h3>
            <div class="row g-4">
                @foreach($related as $item)
                    <div class="col-md-3">
                        <div class="card product-card h-100 shadow-sm border-0">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="bi bi-image text-muted fs-3"></i>
                                </div>
                            @endif
                            <div class="card-body p-3">
                                <h6 class="card-title fw-semibold mb-1 text-start"><a href="{{ route('shop.show', $item) }}" class="text-dark text-decoration-none">{{ $item->name }}</a></h6>
                                <p class="fw-bold text-dark mb-0 text-start">LKR {{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
