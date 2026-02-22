@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="bg-primary text-white py-4">
    <div class="container text-center">
        <h1 class="fw-bold mb-0">My Orders</h1>
        <p class="mb-0 opacity-75">Track and manage your purchase history</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3 small text-uppercase fw-bold text-muted">Order #</th>
                                    <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Date</th>
                                    <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Total</th>
                                    <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Payment</th>
                                    <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Order Status</th>
                                    <th class="border-0 py-3 text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="px-4 py-3"><span class="fw-bold text-dark">{{ $order->order_number }}</span></td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="fw-bold">LKR {{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} px-2 py-1">
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
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} text-white rounded-pill px-3 py-1" style="font-size: 0.75rem;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end px-4">
                                            <a href="{{ route('dashboard.orders.show', $order) }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold">Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="bi bi-bag-x fs-1 text-muted d-block mb-3"></i>
                                            <p class="text-muted">You haven't placed any orders yet.</p>
                                            <a href="{{ route('shop.index') }}" class="btn btn-warning btn-sm rounded-pill px-4">Shop Now</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->count() > 0)
                    <div class="card-footer bg-white border-0 p-4">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
