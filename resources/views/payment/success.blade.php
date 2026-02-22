@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-6 text-center">
            <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-check2-circle fs-1"></i>
            </div>
            <h2 class="fw-bold">Thank You for Your Order!</h2>
            <p class="text-muted fs-5 mb-4">Your payment has been processed successfully.</p>

            @if($order)
                <div class="card border-0 shadow-sm rounded-4 bg-light mb-5">
                    <div class="card-body p-4 text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Order Number:</span>
                            <span class="fw-bold">{{ $order->order_number }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Amount Paid:</span>
                            <span class="fw-bold">LKR {{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status:</span>
                            <span class="badge bg-success text-white px-2 py-1">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="{{ route('dashboard.orders') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold">View My Orders</a>
                <a href="{{ route('shop.index') }}" class="btn btn-warning px-4 py-2 rounded-pill fw-bold">Return to Shop</a>
            </div>
        </div>
    </div>
</div>
@endsection
