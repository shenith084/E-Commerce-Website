@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-2" style="width: 80px; height: 80px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>
            <div class="col">
                <h1 class="fw-bold mb-0">Hello, {{ explode(' ', $user->name)[0] }}!</h1>
                <p class="mb-0 opacity-75">Welcome to your dashboard. Manage your orders and profile here.</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('dashboard.profile') }}" class="btn btn-outline-light rounded-pill px-4">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5 mt-n4">
    <div class="row g-3 row-cols-1 row-cols-md-3">
        <!-- Stats -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning-subtle text-warning rounded-3 p-2 me-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $user->orders->count() }}</h4>
                        <small class="text-muted">Total Orders</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger-subtle text-danger rounded-3 p-2 me-3">
                        <i class="bi bi-heart-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $user->wishlists->count() }}</h4>
                        <small class="text-muted">Wishlist Items</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success-subtle text-success rounded-3 p-2 me-3">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">LKR {{ number_format($user->orders()->where('payment_status', 'paid')->sum('total'), 2) }}</h4>
                        <small class="text-muted">Direct Spending</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Orders</h5>
                    <a href="{{ route('dashboard.orders') }}" class="text-warning text-decoration-none small fw-bold">View All <i class="bi bi-chevron-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-3 py-3 small text-uppercase fw-bold text-muted">Order #</th>
                                    <th class="border-0 py-3 small text-uppercase fw-bold text-muted d-none d-md-table-cell">Date</th>
                                    <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Total</th>
                                    <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Status</th>
                                    <th class="border-0 py-3 text-end px-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="px-3 py-3"><span class="fw-bold" style="font-size: 0.85rem;">{{ $order->order_number }}</span></td>
                                        <td class="d-none d-md-table-cell small">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="fw-bold text-dark small">LKR {{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($order->status) {
                                                    'pending' => 'bg-secondary',
                                                    'processing' => 'bg-primary',
                                                    'shipped' => 'bg-info',
                                                    'delivered' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} text-white rounded-pill px-2 py-1" style="font-size: 0.65rem;">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td class="text-end px-3">
                                            <a href="{{ route('dashboard.orders.show', $order) }}" class="btn btn-outline-warning btn-sm rounded-pill p-1 px-2" style="font-size: 0.7rem;">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">No orders yet. <a href="{{ route('shop.index') }}" class="text-warning">Start shopping</a></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
