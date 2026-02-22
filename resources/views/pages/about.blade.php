@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="fw-bold display-4 mb-2">Our Story</h1>
        <p class="lead opacity-75">Bringing the best shopping experience to your doorstep.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">What is ShopX?</h2>
            <p class="text-muted fs-5">ShopX is Sri Lanka's emerging premium e-commerce platform, dedicated to providing high-quality products across various categories including electronics, fashion, and home essentials.</p>
            <p class="text-muted">Founded in 2024, our mission is to simplify online shopping with a secure, fast, and user-friendly interface. We partner with trusted suppliers to ensure that every item you purchase meets our rigorous quality standards.</p>
            <div class="row g-4 mt-2">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-patch-check-fill text-warning fs-3 me-3"></i>
                        <span class="fw-bold">Quality Guaranteed</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-truck text-warning fs-3 me-3"></i>
                        <span class="fw-bold">Fast Island-wide Delivery</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-warning-subtle d-flex align-items-center justify-content-center" style="height: 350px;">
                    <i class="bi bi-shop display-1 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
