@extends('layouts.app')

@section('title', 'Test Payment Gateway — ShopX')

@push('styles')
<style>
    .test-payment-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .test-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        overflow: hidden;
        max-width: 460px;
        width: 100%;
    }

    .test-card-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .test-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,193,7,0.2);
        border: 1px solid rgba(255,193,7,0.5);
        color: #ffc107;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 50px;
        margin-bottom: 1rem;
    }

    .test-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        background: #ffc107;
        border-radius: 50%;
        animation: pulse-dot 1.2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.4); }
    }

    .test-merchant-name {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .test-order-ref {
        color: rgba(255,255,255,0.5);
        font-size: 0.8rem;
        font-family: monospace;
        letter-spacing: 0.5px;
    }

    .test-amount-block {
        background: rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-top: 1.25rem;
        display: inline-block;
    }

    .test-amount-label {
        color: rgba(255,255,255,0.5);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .test-amount-value {
        color: #fff;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .test-amount-currency {
        font-size: 1rem;
        font-weight: 400;
        opacity: 0.7;
        margin-right: 4px;
    }

    .test-card-body {
        padding: 2rem;
    }

    .test-info-box {
        background: #fff8e1;
        border-left: 4px solid #ffc107;
        border-radius: 8px;
        padding: 0.85rem 1rem;
        font-size: 0.82rem;
        color: #856404;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }

    .test-info-box svg {
        flex-shrink: 0;
        margin-top: 1px;
    }

    .fake-card-ui {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        color: white;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .fake-card-ui::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .fake-card-chip {
        width: 36px;
        height: 28px;
        background: linear-gradient(135deg, #f5af19, #f12711);
        border-radius: 6px;
        margin-bottom: 1rem;
    }

    .fake-card-number {
        font-size: 1rem;
        letter-spacing: 3px;
        font-family: monospace;
        margin-bottom: 0.75rem;
        opacity: 0.9;
    }

    .fake-card-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.72rem;
        opacity: 0.7;
    }

    .btn-pay-success {
        width: 100%;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.9rem;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 0.75rem;
    }

    .btn-pay-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(17,153,142,0.4);
    }

    .btn-pay-cancel {
        width: 100%;
        background: #f8f9fa;
        color: #6c757d;
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 0.75rem;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-pay-cancel:hover {
        background: #fff5f5;
        border-color: #dc3545;
        color: #dc3545;
    }

    .test-footer {
        text-align: center;
        padding: 1rem 2rem 1.5rem;
        font-size: 0.72rem;
        color: #aaa;
        border-top: 1px solid #f0f0f0;
    }

    .order-summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.4rem 0;
        font-size: 0.85rem;
        color: #555;
        border-bottom: 1px solid #f5f5f5;
    }

    .order-summary-row:last-child {
        border-bottom: none;
        font-weight: 700;
        color: #222;
        font-size: 0.95rem;
        padding-top: 0.6rem;
    }
</style>
@endpush

@section('content')
<div class="test-payment-wrapper">
    <div class="test-card">

        {{-- Header --}}
        <div class="test-card-header">
            <div class="test-badge">
                🔬 Test Mode — No Real Payment
            </div>
            <div class="test-merchant-name">ShopX Demo Store</div>
            <div class="test-order-ref">Order #{{ $order->order_number }}</div>
            <div class="test-amount-block">
                <div class="test-amount-label">Amount Due</div>
                <div class="test-amount-value">
                    <span class="test-amount-currency">LKR</span>
                    {{ number_format($order->total, 2) }}
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="test-card-body">

            {{-- Warning banner --}}
            <div class="test-info-box">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.71c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span><strong>Test Gateway:</strong> No real money will be charged. Use this to simulate payment success or failure for development.</span>
            </div>

            {{-- Fake card visual --}}
            <div class="fake-card-ui">
                <div class="fake-card-chip"></div>
                <div class="fake-card-number">4242  4242  4242  4242</div>
                <div class="fake-card-meta">
                    <span>TEST CARDHOLDER</span>
                    <span>12/25 &nbsp; CVV: 123</span>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="mb-4">
                <div class="order-summary-row">
                    <span>Subtotal</span>
                    <span>LKR {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="order-summary-row">
                    <span>Shipping</span>
                    <span class="text-success">Free</span>
                </div>
                <div class="order-summary-row">
                    <span>Total</span>
                    <span>LKR {{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            {{-- Success button --}}
            <form method="POST" action="{{ route('payment.test.process', $order) }}">
                @csrf
                <input type="hidden" name="action" value="success">
                <button type="submit" class="btn-pay-success">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                    ✅ Simulate Successful Payment
                </button>
            </form>

            {{-- Cancel button --}}
            <form method="POST" action="{{ route('payment.test.process', $order) }}">
                @csrf
                <input type="hidden" name="action" value="cancel">
                <button type="submit" class="btn-pay-cancel">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    ❌ Simulate Failed / Cancel
                </button>
            </form>

        </div>

        {{-- Footer --}}
        <div class="test-footer">
            🔒 This is a sandboxed test environment &nbsp;·&nbsp; ShopX Dev Mode
        </div>

    </div>
</div>
@endsection
