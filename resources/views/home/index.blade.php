@extends('layouts.app')

@section('title', 'Welcome to ShopX')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container py-5">
        <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInDown">Elevate Your Shopping Experience</h1>
        <p class="lead mb-4 opacity-75 animate__animated animate__fadeInUp animate__delay-1s">Quality products, unbeatable prices, and lightning-fast delivery across Sri Lanka.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center animate__animated animate__fadeInUp animate__delay-2s">
            <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold">Shop Now <i class="bi bi-arrow-right ms-2"></i></a>
            <a href="#featured" class="btn btn-outline-light btn-lg px-4 py-3">View Featured</a>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Shop by Category</h2>
            <div class="mx-auto bg-warning" style="height: 3px; width: 50px;"></div>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-md-4 col-lg-2">
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="card h-100 text-center border-0 shadow-sm p-3 hover-lift">
                            <div class="bg-light rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-tag fs-3 text-warning"></i>
                            </div>
                            <h6 class="text-dark mb-1">{{ $category->name }}</h6>
                            <small class="text-muted">{{ $category->products_count }} Products</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="featured" class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0">Featured Products</h2>
                <p class="text-muted mb-0">Handpicked items just for you</p>
            </div>
            <a href="{{ route('shop.index') }}" class="text-warning text-decoration-none fw-semibold">View All <i class="bi bi-chevron-right"></i></a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100 shadow-sm border-0">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                        <div class="card-body p-3">
                            <small class="text-warning fw-bold text-uppercase" style="font-size: 0.7rem;">{{ $product->category->name }}</small>
                            <h5 class="card-title fw-semibold mb-1" style="font-size: 1rem;"><a href="{{ route('shop.show', $product) }}" class="text-dark text-decoration-none">{{ $product->name }}</a></h5>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fw-bold fs-5 text-dark">LKR {{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Bonus: Newsletter Section -->
<section class="py-5 bg-warning">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-1">Join Our Newsletter</h3>
                <p class="mb-0">Stay updated with the latest offers and product arrivals.</p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex mt-3 mt-lg-0">
                    <input type="email" class="form-control border-0 px-4 py-2 rounded-start" placeholder="Enter your email">
                    <button class="btn btn-dark px-4 py-2 rounded-end" type="button">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
