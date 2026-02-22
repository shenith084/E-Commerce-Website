@extends('layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0">Order {{ $order->order_number }}</h1>
            <p class="mb-0 opacity-75">Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}</p>
        </div>
        <a href="{{ route('dashboard.orders') }}" class="btn btn-outline-light rounded-pill px-3 btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Orders</a>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Order Status Tracking -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td style="width: 80px;">
                                            <div class="rounded-3 overflow-hidden border" style="width: 60px; height: 60px;">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid" alt="{{ $item->product_name }}">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                        <i class="bi bi-image text-muted small"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="fw-bold mb-0">{{ $item->product_name }}</h6>
                                            <small class="text-muted">LKR {{ number_format($item->price, 2) }} x {{ $item->quantity }}</small>
                                        </td>
                                        <td class="text-end fw-bold">LKR {{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="2" class="text-end py-3 text-muted">Subtotal</td>
                                    <td class="text-end py-3 fw-bold">LKR {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end py-3 text-muted">Shipping</td>
                                    <td class="text-end py-3 text-success fw-bold">Free</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end py-3 fs-5 fw-bold text-dark">Total</td>
                                    <td class="text-end py-3 fs-5 fw-bold text-warning">LKR {{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Review Section -->
            @foreach($order->items as $item)
                @if($item->product)
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">Write a review for {{ $item->product_name }}</h6>
                            <form action="{{ route('dashboard.review.store', $item->product) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-flex gap-2 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="form-check form-check-inline me-0 p-0">
                                                <input class="btn-check" type="radio" name="rating" id="rating-{{ $item->id }}-{{ $i }}" value="{{ $i }}" required>
                                                <label class="btn btn-outline-warning btn-sm rounded-circle p-2" for="rating-{{ $item->id }}-{{ $i }}">{{ $i }}</label>
                                            </div>
                                        @endfor
                                    </div>
                                    <textarea name="comment" class="form-control bg-light border-0" rows="2" placeholder="Tell us what you think..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 fw-bold">Submit Review</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Order Status</h5>
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Current Status</span>
                            <span class="fw-bold text-dark">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 border-top pt-4">
                        <div class="bg-success-subtle text-success rounded-circle p-2 me-3">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Payment Status</span>
                            <span class="fw-bold text-dark">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                    </div>
                    @if($order->payment_status == 'pending')
                        <a href="{{ route('payment.pay', $order) }}" class="btn btn-warning w-100 rounded-pill py-2 fw-bold">Pay Now <i class="bi bi-credit-card ms-1"></i></a>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Shipping Address</h5>
                    <div class="d-flex mb-3">
                        <i class="bi bi-person text-muted me-3"></i>
                        <span class="text-dark">{{ $order->shipping_name }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-telephone text-muted me-3"></i>
                        <span class="text-dark">{{ $order->shipping_phone }}</span>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="bi bi-envelope text-muted me-3"></i>
                        <span class="text-dark">{{ $order->shipping_email }}</span>
                    </div>
                    <div class="d-flex">
                        <i class="bi bi-geo-alt text-muted me-3"></i>
                        <span class="text-dark">{{ $order->shipping_address }}, {{ $order->shipping_city }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
