@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <h1 class="fw-bold mb-0">Checkout</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Shipping Info -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="bi bi-geo-alt me-2 text-warning"></i> Shipping Information</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="shipping_name" class="form-label small fw-bold text-muted">Full Name</label>
                                <input type="text" name="shipping_name" id="shipping_name" class="form-control bg-light border-0 py-2" value="{{ old('shipping_name', auth()->user()->name) }}" required>
                                @error('shipping_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="shipping_email" class="form-label small fw-bold text-muted">Email Address</label>
                                <input type="email" name="shipping_email" id="shipping_email" class="form-control bg-light border-0 py-2" value="{{ old('shipping_email', auth()->user()->email) }}" required>
                                @error('shipping_email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="shipping_phone" class="form-label small fw-bold text-muted">Phone Number</label>
                                <input type="text" name="shipping_phone" id="shipping_phone" class="form-control bg-light border-0 py-2" value="{{ old('shipping_phone', auth()->user()->phone) }}" placeholder="07XXXXXXXX" required>
                                @error('shipping_phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12">
                                <label for="shipping_address" class="form-label small fw-bold text-muted">Shipping Address</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" class="form-control bg-light border-0 py-2" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="shipping_city" class="form-label small fw-bold text-muted">City</label>
                                <input type="text" name="shipping_city" id="shipping_city" class="form-control bg-light border-0 py-2" value="{{ old('shipping_city') }}" required>
                                @error('shipping_city') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label small fw-bold text-muted">Country</label>
                                <input type="text" id="country" class="form-control bg-light border-0 py-2" value="Sri Lanka" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="bi bi-wallet2 me-2 text-warning"></i> Payment Method</h5>
                        <div class="form-check p-3 bg-light rounded-3 d-flex align-items-center">
                            <input class="form-check-input ms-0 me-3 shadow-none mt-0" type="radio" value="payhere" checked disabled>
                            <label class="form-check-label d-flex align-items-center gap-3 w-100 fw-semibold">
                                <span>Payhere (Cards, Mobile Wallets)</span>
                                <img src="https://www.payhere.lk/downloads/images/payhere_square_banner.png" alt="Payhere" height="20" class="ms-auto">
                            </label>
                        </div>
                        <p class="text-muted small mt-3 px-1 mb-0"><i class="bi bi-info-circle me-1"></i> You will be redirected to Payhere secure payment gateway to complete your transaction.</p>
                    </div>
                </div>
            </div>

            <!-- Review Items -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Your Order</h5>
                        <div class="cart-items-preview mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($cart as $item)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-3 overflow-hidden me-3 border" style="width: 50px; height: 50px; flex-shrink: 0;">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid" alt="{{ $item['name'] }}">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                <i class="bi bi-image text-muted small"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="small fw-bold mb-0 text-truncate" style="max-width: 180px;">{{ $item['name'] }}</h6>
                                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="small fw-bold">LKR {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Subtotal</span>
                            <span class="small fw-bold">LKR {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Shipping</span>
                            <span class="text-success small fw-bold">Free</span>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5 fw-bold">Total Payable</span>
                            <span class="fs-5 fw-bold text-warning">LKR {{ number_format($total, 2) }}</span>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-pill shadow-sm">Complete Order & Pay <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
