@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-dark text-white py-4 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="fw-bold mb-0"><i class="bi bi-speedometer2 me-2 text-warning"></i>Admin Dashboard</h1>
        <div class="text-end">
            <span class="badge bg-success py-2 px-3 rounded-pill">System Online</span>
        </div>
    </div>
</div>

<div class="container pb-5">
    {{-- Statistics Cards --}}
    <div class="row g-3 row-cols-2 row-cols-lg-5 mb-5">
        <div class="col-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-4 p-3 me-3">
                        <i class="bi bi-cart-check fs-2"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Total Orders</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_orders']) }}</h3>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 text-start">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-4 p-3 me-3">
                        <i class="bi bi-cash-stack fs-2"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Revenue</small>
                        <h3 class="fw-bold mb-0 text-dark">LKR {{ number_format($stats['total_revenue'], 0) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 text-start">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-4 p-3 me-3">
                        <i class="bi bi-people fs-2"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Customers</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_customers']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 text-start">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info rounded-4 p-3 me-3">
                        <i class="bi bi-box-seam fs-2"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Products</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_products']) }}</h3>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-6 col-lg">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-2 text-start">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-4 p-3 me-3 position-relative">
                        <i class="bi bi-chat-left-text fs-2"></i>
                        @if($stats['unread_messages'] > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.6rem;">
                                {{ $stats['unread_messages'] }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Messages</small>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_messages']) }}</h3>
                    </div>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Recent Orders --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-3 py-3 small text-uppercase text-muted">ID</th>
                                    <th class="border-0 py-3 small text-uppercase text-muted d-none d-md-table-cell">Customer</th>
                                    <th class="border-0 py-3 small text-uppercase text-muted">Total</th>
                                    <th class="border-0 py-3 small text-uppercase text-muted">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="px-3 py-3 fw-bold small">{{ $order->order_number }}</td>
                                        <td class="d-none d-md-table-cell small">{{ Str::limit($order->user->name, 20) }}</td>
                                        <td class="fw-bold small text-nowrap">LKR {{ number_format($order->total, 0) }}</td>
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
                                            <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1" style="font-size: 0.6rem;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders by Status --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <h5 class="fw-bold mb-0">Order Summary</h5>
                </div>
                <div class="card-body p-4 pt-0 text-start">
                    <div class="list-group list-group-flush border-0">
                        @foreach($ordersByStatus as $status)
                            <div class="list-group-item border-0 d-flex justify-content-between align-items-center px-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3" style="width: 10px; height: 10px; background-color: {{ 
                                        match($status->status) {
                                            'pending' => '#6c757d',
                                            'processing' => '#0d6efd',
                                            'shipped' => '#0dcaf0',
                                            'delivered' => '#198754',
                                            'cancelled' => '#dc3545',
                                            default => '#000'
                                        }
                                    }}"></div>
                                    <span class="text-capitalize">{{ $status->status }}</span>
                                </div>
                                <span class="badge bg-light text-dark border rounded-pill">{{ $status->total }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-3">System Health</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Payment Gateway</small>
                            <span class="badge bg-success-subtle text-success px-2 py-1" style="font-size: 0.6rem;">Connected</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Inventory Check</small>
                            <span class="badge bg-success-subtle text-success px-2 py-1" style="font-size: 0.6rem;">Normal</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
