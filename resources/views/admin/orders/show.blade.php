@extends('layouts.app')

@section('title', 'Manage Order ' . $order->order_number)

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0">Manage Order {{ $order->order_number }}</h1>
            <p class="mb-0 opacity-75">Customer: {{ $order->user->name }} | Email: {{ $order->user->email }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light rounded-pill btn-sm px-3">Back to List</a>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Order Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-start">
                    <h5 class="fw-bold mb-4">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 rounded-start">Product</th>
                                    <th class="border-0">Price</th>
                                    <th class="border-0">Qty</th>
                                    <th class="border-0 text-end rounded-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $item->product_name }}</div>
                                            <small class="text-muted">ID: {{ $item->product_id }}</small>
                                        </td>
                                        <td>LKR {{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">LKR {{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="3" class="text-end py-3 text-muted">Subtotal</td>
                                    <td class="text-end py-3 fw-bold">LKR {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end py-3 text-muted">Shipping</td>
                                    <td class="text-end py-3 text-success fw-bold">Free</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end py-3 fs-5 fw-bold text-dark">Total</td>
                                    <td class="text-end py-3 fs-5 fw-bold text-warning">LKR {{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-start">
                    <h5 class="fw-bold mb-4">Shipping Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Recipient Name</small>
                            <span class="fw-bold">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Contact Phone</small>
                            <span class="fw-bold">{{ $order->shipping_phone }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">Email Address</small>
                            <span class="fw-bold">{{ $order->shipping_email }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">City</small>
                            <span class="fw-bold">{{ $order->shipping_city }}</span>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block mb-1">Shipping Address</small>
                            <span class="fw-bold">{{ $order->shipping_address }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Management Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-start">
                    <h5 class="fw-bold mb-4">Update Order Status</h5>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label small fw-bold text-muted">Order Status</label>
                            <select name="status" id="status" class="form-select bg-light border-0 py-2">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill py-2">Update Status <i class="bi bi-save ms-1"></i></button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4 text-start">
                    <h5 class="fw-bold mb-3">Payment Info</h5>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Status</small>
                        <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }} px-3 py-1">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Payhere Payment ID</small>
                        <span class="fw-bold text-dark">{{ $order->payhere_order_id ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Method</small>
                        <span class="fw-bold text-dark text-uppercase">{{ $order->payment_method }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
