@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <h1 class="fw-bold mb-0">Shopping Cart</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    @if(empty($cart))
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body">
                <i class="bi bi-cart-x fs-1 text-muted mb-3 d-block"></i>
                <h3 class="fw-bold">Your cart is empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-warning px-5 py-2 fw-bold">Start Shopping</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">Product</th>
                                    <th class="border-0 py-3 d-none d-md-table-cell">Price</th>
                                    <th class="border-0 py-3">Qty</th>
                                    <th class="border-0 py-3 text-end px-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $item)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-3 overflow-hidden me-3" style="width: 60px; height: 60px;">
                                                    @if($item['image'])
                                                        <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid" alt="{{ $item['name'] }}">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-0"><a href="{{ route('shop.show', $item['id']) }}" class="text-dark text-decoration-none">{{ $item['name'] }}</a></h6>
                                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger p-0 small text-decoration-none">Remove</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted small">LKR {{ number_format($item['price'], 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" id="update-form-{{ $item['id'] }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" class="form-control form-control-sm text-center shadow-none border-0 bg-light" value="{{ $item['quantity'] }}" min="1" style="width: 50px;" onchange="document.getElementById('update-form-{{ $item['id'] }}').submit()">
                                            </form>
                                        </td>
                                        <td class="text-end px-4 fw-bold">LKR {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 px-4 py-3 d-flex justify-content-between">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill"><i class="bi bi-arrow-left me-1"></i> Continue Shopping</a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-muted btn-sm text-decoration-none"><i class="bi bi-trash me-1"></i> Clear Cart</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">LKR {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success small fw-bold">Free</span>
                        </div>
                        <hr class="my-4">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-5 fw-bold text-warning">LKR {{ number_format($total, 2) }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-warning w-100 py-3 fw-bold rounded-pill shadow-sm">Proceed to Checkout <i class="bi bi-credit-card ms-2"></i></a>
                        <div class="text-center mt-3">
                            <img src="https://www.payhere.lk/downloads/images/payhere_square_banner.png" alt="Payhere" height="25" class="opacity-75">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
