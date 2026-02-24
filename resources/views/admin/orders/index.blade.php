@extends('layouts.app')

@section('title', 'Admin - Orders')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="fw-bold mb-0"><i class="bi bi-shield-check me-2"></i>Admin: Orders</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Products</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Categories</a>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Search order # or customer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select border-0 bg-light" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="payment_status" class="form-select border-0 bg-light" onchange="this.form.submit()">
                        <option value="">All Payments</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Payment Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3">Filter</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Reset</a>
                </div>
            </form>
            <p class="text-muted small mt-2 mb-0">Showing {{ $orders->count() }} of {{ $orders->total() }} orders</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-3 py-3 small text-uppercase fw-bold text-muted">ID</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Customer</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted d-none d-md-table-cell">Total</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Payment</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Status</th>
                            <th class="border-0 py-3 text-end px-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="px-3 py-3 fw-bold small">{{ $order->order_number }}</td>
                                <td>
                                    <div class="fw-bold small">{{ Str::limit($order->user->name, 15) }}</div>
                                    <small class="text-muted d-none d-md-block">{{ $order->user->email }}</small>
                                    <div class="d-md-none small fw-bold">LKR {{ number_format($order->total, 0) }}</div>
                                </td>
                                <td class="fw-bold small d-none d-md-table-cell">LKR {{ number_format($order->total, 0) }}</td>
                                <td>
                                    <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} px-2 py-1" style="font-size: 0.6rem;">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($order->status) {
                                            'pending' => 'bg-secondary',
                                            'processing' => 'bg-primary',
                                            'shipped' => 'bg-info',
                                            'delivered' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-dark'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} text-white rounded-pill px-2 py-1" style="font-size: 0.6rem;">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end px-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-dark btn-sm rounded-pill p-1 px-2" style="font-size: 0.7rem;">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
