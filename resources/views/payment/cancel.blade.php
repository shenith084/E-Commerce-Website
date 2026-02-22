@extends('layouts.app')

@section('title', 'Payment Cancelled')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-6 text-center">
            <div class="bg-warning-subtle text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-exclamation-circle fs-1"></i>
            </div>
            <h2 class="fw-bold">Payment Cancelled</h2>
            <p class="text-muted fs-5 mb-5">The payment process was cancelled before completion. Your order has not been finalized.</p>

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="{{ route('checkout.index') }}" class="btn btn-warning px-4 py-2 rounded-pill fw-bold">Try Checkout Again</a>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill fw-bold">Go to Cart</a>
            </div>
        </div>
    </div>
</div>
@endsection
