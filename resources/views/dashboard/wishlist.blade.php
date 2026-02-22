@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container text-center">
        <h1 class="fw-bold mb-0">My Wishlist</h1>
        <p class="mb-0 opacity-75">Manage products you've saved for later</p>
    </div>
</div>

<div class="container py-5">
    @if($wishlists->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body">
                <i class="bi bi-heart fs-1 text-muted mb-3 d-block"></i>
                <h3 class="fw-bold">Your wishlist is empty</h3>
                <p class="text-muted mb-4">Saved items will appear here.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-warning px-5 py-2 fw-bold">Explore Products</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($wishlists as $wishlist)
                @php $product = $wishlist->product; @endphp
                @if($product)
                    <div class="col-md-6 col-lg-4">
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
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('dashboard.wishlist.toggle', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle px-2 border-0" title="Remove from wishlist">
                                                <i class="bi bi-heart-fill"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-warning btn-sm rounded-circle shadow-sm" title="Add to cart">
                                                <i class="bi bi-cart"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
