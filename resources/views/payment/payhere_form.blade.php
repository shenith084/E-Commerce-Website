@extends('layouts.app')

@section('title', 'Redirecting to Payment...')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-6 text-center">
            <div class="spinner-border text-warning mb-4" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h3 class="fw-bold">Redirecting to Secure Payment</h3>
            <p class="text-muted">Please do not close this window or refresh the page.</p>
            <p class="small text-muted mb-4">You are being redirected to Payhere (Sandbox) for secure transaction processing.</p>

            <form method="POST" action="{{ $paymentUrl }}" id="payhere-form">
                @foreach($paymentData as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endforeach
                <button type="submit" class="btn btn-warning px-5 py-2 fw-bold rounded-pill">If not redirected, click here</button>
            </form>

            <div class="mt-5">
                <img src="https://www.payhere.lk/downloads/images/payhere_square_banner.png" alt="Payhere" height="30">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.onload = function() {
        document.getElementById('payhere-form').submit();
    }
</script>
@endpush
@endsection
